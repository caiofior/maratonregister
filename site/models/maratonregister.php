<?php
/**
 * Maraton Register Model
 * @author Claudio Fior <caiofior@gmail.com>
 * @version 1.0.1
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla modelitem library
jimport('joomla.application.component.modelitem');

/**
 * Maraton Register Model
 * @author Claudio Fior <caiofior@gmail.com>
 * @version 1.0.1
 */
class MaratonRegisterModelMaratonRegister extends JModelItem
{
        /**
         * Message errors
         * @var array
         */
	private  $errors =array();
        /**
         * Data to save
         * @var array
         */
        private $data=array();
                 /**
         * Returns a reference to the a Table object, always creating it.
         *
         * @param       type    The table type to instantiate
         * @param       string  A prefix for the table class name. Optional.
         * @param       array   Configuration array for model. Optional.
         * @return      JTable  A database object
         * @since       2.5
         */
        public function getTable($type = 'MaratonRegister', $prefix = 'MaratonRegisterTable', $config = array()) 
        {
                return JTable::getInstance($type, $prefix, $config);
        }
        /**
         * get an items
         */
        public function getItem() {
            $table = $this->getTable();
            return $table;
        }
        /**
         * Set new athlete data
         * @param array $data
         */
        public function setData($data) {
            $marathon_name = JComponentHelper::getParams('com_maratonregister')->get('maraton_name','Maratonina dei borghi di Pordenone');
            $this->checkData($data);
            
            if ($data['type_of_check'] != 'fidal' )
                $data['num_tes'] = '';
            if ($data['type_of_check'] != 'other_ass') {
                $data['other_ass_name']='';
                $data['other_num_tes']='';
            }
            if ($data['type_of_check'] != 'group_fidal')
                unset($data['member_num_tes']);

            foreach ($data as $key=>$value) {
                if (!is_array($value))
                    $data[$key]=  preg_replace('/[ ]+/',' ',trim ($value));
            }
            if (!key_exists('member_num_tes', $data)) {
                if ( 
                      $data['num_tes'] == '' &&
                     !key_exists('medical_certificate',$_FILES)
                    ) {
                    $this->errors['medical_certificate']=array(
                        'message'=>'Il certificato medico è richiesto'
                    );
                } else if ($data['num_tes'] == '') {
                    $data = $this->addMedicalCertificate($data);
                }
            }
            
            $data = $this->addPayment($data);

            $data = $this->addgameCard($data);
            if (sizeof($this->errors) == 0) {
                    $data['date_of_birth'] = $this->parseDate($data['date_of_birth']);
                    
                    $data['id']=  $this->generateKey($data);

                    $data['registration_datetime']='NOW()';
                    $id =0;
                    if ( !key_exists('member_num_tes', $data) ) {
                        $db = JFactory::getDbo();
                        $query = $db->getQuery(true);
                        $query
                            ->select('COUNT(id)')
                            ->from('#__atlete')
                            ->where('removed <> 1 AND id = '. $db->Quote($data['id']));
                        $db->setQuery($query);
                        $db->query();
                        $id = intval($db->loadResult());
                    }
                    if ($id > 0) {
                        $this->errors['first_name']=array(
                         'message'=>'Sei già registrato alla '.$marathon_name.', contatta lo staff per eventuali problemi'
                        );
                    }
                    else {
                        
                        $columns = array(
                            'id',
                            'first_name' ,
                            'last_name',
                            'date_of_birth',
                            'num_tes' ,
                            'sex' ,
                            'citizenship' ,
                            'address' ,
                            'zip' ,
                            'city' ,
                            'phone' ,
                            'email' ,
                            'registration_datetime',
                            'other_num_tes' ,
                            'other_ass_name' ,
                            'payment_type' ,
                            'payment_fname',
                            'medical_certificate_fname',
                            'medical_certificate_datetime',
                            'game_card_fname',
                            'game_card_datetime'
                        );
                        $values = array();
                        $rcolumns = array_flip($columns);
                        $rcolumns = array_intersect_key($rcolumns, $data);
                        $columns = array_flip($rcolumns);
                        $db = JFactory::getDbo();
                        foreach ($columns as $column) {
                            
                            if (!key_exists($column, $data)) 
                                continue;
                            if (
                                    $column == 'registration_datetime' ||
                                    $column == 'medical_certificate_datetime' ||
                                    $column == 'payment_datetime' ||
                                    $column == 'game_card_datetime'
                                )
                                $values[$column]=$data[$column];
                            else if ($column == 'num_tes')
                                $values[$column]=$db->quote(strtoupper($data[$column]));
                            else
                                $values[$column]=$db->quote($data[$column]);
                        }
                        $group_reference_text = '';
                        if ( key_exists('member_num_tes', $data) ) {
                            $columns[]='group_reference_id';
                            $query = $db->getQuery(true);
                            $query
                                ->select('MAX(group_reference_id)')
                                ->from('#__atlete');
                            $db->setQuery($query);
                            $db->query();
                            $group_reference_id = intval($db->loadResult())+1;
                            $values[]=$group_reference_id;
                            $group_name = '';
                            foreach($data['member_num_tes'] as $key=>$value) {
                                $member_values = $values;
                                $member_data = $data;
                                $member_data['num_tes']=  strtoupper($value);
                                $member_values['num_tes']=$db->quote(strtoupper($value));
                                $member_values['date_of_birth']=$db->quote($this->parseDate($data['member_date_of_birth'][$key]));
                                $member_values['id']=$db->quote($this->generateKey($member_data));
                                if ($group_name == '') {
                                    
                                    $query = $db->getQuery(true);
                                    $query
                                        ->select('denom')
                                        ->from('#__fidal_fella')
                                        ->where('num_tes = '.$db->quote($value));
                                    $db->setQuery($query);
                                    $db->query();
                                    $group_name = $db->loadResult();
                                }
                                
                                $query = $db->getQuery(true);
                                $query
                                    ->select('COUNT(id)')
                                    ->from('#__atlete')
                                    ->where('removed <> 1 AND id = '. $db->quote($member_values['id']));
                                $db->setQuery($query);
                                $db->query();
                                $id = intval($db->loadResult());

                                if ($id > 0) {
                                    $this->errors['member_num_tes']=array(
                                     'message'=>'Sei già registrato alla '.$marathon_name.', contatta lo staff per eventuali problemi'
                                    );
                                }
                                $query = $db->getQuery(true);
                                $query
                                    ->insert($db->quoteName('#__atlete'))
                                    ->columns($db->quoteName($columns))
                                    ->values(implode(',', $member_values));

                                $db->setQuery($query);
                                $db->query();
                            }
                            $group_size = sizeof($data['member_num_tes']);
                            $group_reference_text = <<<EOT
                            <p>Hai registrato un gruppo di {$group_size} persone; l'identificativo del gruppo {$group_name} è {$group_reference_id} .</p>
EOT;
                                
                        }
                        else {
                            $query = $db->getQuery(true);
                            $query
                                ->insert($db->quoteName('#__atlete'))
                                ->columns($db->quoteName($columns))
                                ->values(implode(',', $values));

                            $db->setQuery($query);
                            $db->query();
                        }
                        
                        $mailer = JFactory::getMailer();
                        $config = JFactory::getConfig();
                        $sender = array( 
                            $config->getValue( 'config.mailfrom' ),
                            $config->getValue( 'config.fromname' )
                        );
                        $mailer->setSender($sender);
                        $mailer->addRecipient($config->getValue( 'config.mailfrom' ));
                        $body   = <<<EOT
<p>Nuova iscrizione alla {$marathon_name}</p>
<table>
    <tr>
        <th>Nome e cognome</th>
        <td>{$data['first_name']} {$data['first_name']}</th>
    </tr>
    <tr>
        <th>Data di nascita</th>
        <td>{$data['date_of_birth']}</th>
    </tr>
    <tr>
        <th>Sesso</th>
        <td>{$data['sex']}</th>
    </tr>
    <tr>
        <th>Cittadinanza</th>
        <td>{$data['citizenship']}</th>
    </tr>
    <tr>
        <th>Indirizzo</th>
        <td>{$data['address']} {$data['zip']} {$data['city']}</th>
    </tr>
    <tr>
        <th>Telefono</th>
        <td>{$data['phone']}</th>
    </tr>
    <tr>
        <th>Email</th>
        <td>{$data['email']}</th>
    </tr>
    <tr>
        <th>Tessera FIDAL</th>
        <td>{$data['num_tes']}</th>
    </tr>
</table>
{$group_reference_text}
<p>Accedi al sito per confermare l'iscrizione, il pagamento e il certificato medico.</p>
EOT;
                        $mailer->setSubject('Nuova iscrizione '.$data['first_name'].' '.$data['last_name']);
                        $mailer->isHTML(true);
                        $mailer->setBody($body);
                        $mailer->Send();
                        if ($data['email'] != '') {
                             $mailer = JFactory::getMailer();
                        $config = JFactory::getConfig();
                        $sender = array( 
                            $config->getValue( 'config.mailfrom' ),
                            $config->getValue( 'config.fromname' )
                        );
                        $mailer->setSender($sender);
                        $mailer->addRecipient($data['email']);
                        $body   = <<<EOT
<p>Grazie per esserti iscritto alla {$marathon_name}, questi sono i dati da te forniti</p>
<table>
    <tr>
        <th>Nome e cognome</th>
        <td>{$data['first_name']} {$data['first_name']}</th>
    </tr>
    <tr>
        <th>Data di nascita</th>
        <td>{$data['date_of_birth']}</th>
    </tr>
    <tr>
        <th>Sesso</th>
        <td>{$data['sex']}</th>
    </tr>
    <tr>
        <th>Cittadinanza</th>
        <td>{$data['citizenship']}</th>
    </tr>
    <tr>
        <th>Indirizzo</th>
        <td>{$data['address']} {$data['zip']} {$data['city']}</th>
    </tr>
    <tr>
        <th>Telefono</th>
        <td>{$data['phone']}</th>
    </tr>
    <tr>
        <th>Email</th>
        <td>{$data['email']}</th>
    </tr>
    <tr>
        <th>Tessera FIDAL</th>
        <td>{$data['num_tes']}</th>
    </tr>
</table>
{$group_reference_text}
<p>Per errori o inesattezze contatta l'organizzazione della {$marathon_name}.</p>
EOT;
                        $mailer->setSubject('Grazie per esserti iscritto alla '.$marathon_name);
                        $mailer->isHTML(true);
                        $mailer->setBody($body);
                        $mailer->Send();
                        }
                        $_REQUEST['message']='La tua registrazione è avvenuta con successo';
                    }
                    
            }
            
        }
        /**
         * Checks new athlete data
         * @param array $data
         */
        public function checkData($data) {
            
            $componentParams = JComponentHelper::getParams('com_maratonregister');
            $marathon_datetime = time();
            $config_marathon_datetime = date_parse($componentParams->get('maraton_date','2013-10-13'));
            if (is_array($config_marathon_datetime) ) {
                $marathon_datetime = mktime (
                        0,
                        0,
                        0,
                        $config_marathon_datetime['month'],
                        $config_marathon_datetime['day'],
                        $config_marathon_datetime['year']);
            }
            
            foreach ($data as $key=>$value) {
                if (!is_array($value))
                    $data[$key]=  preg_replace('/[ ]+/',' ',trim ($value));
            }
            
            $datetime = $this->getDateTime($data['date_of_birth']);
            $data['date_of_birth'] = $this->parseDate($data['date_of_birth']);
          
            if ($data['type_of_check'] != 'fidal' )
                $data['num_tes'] = '';
            if ($data['type_of_check'] != 'other_ass') {
                $data['other_ass_name']='';
                $data['other_num_tes']='';
            }
            if ($data['type_of_check'] != 'group_fidal')
                unset($data['member_num_tes']);
                
            if ($id > 0) {
                $this->errors['first_name']=array(
                 'message'=>'Sei già registrato alla '.JComponentHelper::getParams('com_maratonregister')->get('maraton_name','Maratonina dei borghi di Pordenone').', contatta lo staff per eventuali problemi'
                );
            }
            if ($data['num_tes'] != '') {
                if (!preg_match('/^[a-zA_Z0-9]{8}$/',$data['num_tes']))
                  $errors['num_tes']=array(
                      'message'=>'Il numero tessera è errato'
                  );  
            } else if ($data['other_num_tes'] != '') {
                if ($data['other_ass_name'] == '')
                  $errors['other_ass_name']=array(
                      'message'=>'Il nome dell\'associazione è richiesto'
                  );
            } else if ( key_exists('member_num_tes', $data) ) {
                if ( !is_array($data['member_num_tes']) )
                    {
                        $errors['group_fidal_container']=array(
                            'message'=>'Dati del gruppo non validi'
                          ); 
                    }
                    
                    if (sizeof($data['member_num_tes']) <1) {
                           $errors['group_fidal_container']=array(
                             'message'=>'Dev\'esserci almeno un membro nel gruppo'
                         ); 
                       }
                       
                       if ($data['first_name'] == '')
                  $errors['first_name']=array(
                      'message'=>'Il nome è richiesto'
                  );
                else if (strlen($data['first_name'])>50)
                    $errors['first_name']=array(
                      'message'=>'Il nome può avere al massimo 50 caratteri'
                  );
                if ($data['last_name'] == '')
                  $errors['last_name']=array(
                      'message'=>'Il cognome è richiesto'
                  );
                else if (strlen($data['last_name'])>50)
                    $errors['last_name']=array(
                      'message'=>'Il cognome può avere al massimo 50 caratteri'
                  );
            
                if ($data['phone'] == '')
                  $errors['phone']=array(
                      'message'=>'Il telefono è richiesto'
                  );
                else if (!preg_match('/^[ \+0-9]+$/', $data['phone']))
                    $errors['phone']=array(
                      'message'=>'Il telefono può contenere numeri, spazi e +'
                  );
                
            if ($data['payment_type'] == '')
                  $errors['paypal']=array(
                      'message'=>'La modalità di pagamento è richiesta'
                  );
            if ($data['email'] != '') {
                if (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/', $data['email']))
                  $errors['email']=array(
                      'message'=>'La mail non è valida'
                  );  
            }
                       
                        if(!key_exists('group_fidal_container', $errors)) {
                            foreach($data['member_num_tes'] as $key=>$value) {
                                if (!preg_match('/^[a-zA_Z0-9]{8}$/', $value)) {
                                    $errors['group_fidal_container']=array(
                                     'message'=>'Il numero di tessera '.$value.'non è valido.'
                                    );
                                }
                                $member_data = $data;
                                $member_data['num_tes']=$value;
                                
                                $db = JFactory::getDbo();
                                $query = $db->getQuery(true);
                                $query
                                    ->select('COUNT(id)')
                                    ->from('#__atlete')
                                    ->where('removed <> 1 AND id = '. $db->Quote($this->generateKey($member_data)));
                                $db->setQuery($query);
                                $db->query();
                                $id = intval($db->loadResult());
                                if ($id > 0) {
                                    $errors['group_fidal_container']=array(
                                     'message'=>'L\'atleta con tessera numero '.$value.' risulta già registrato.'
                                    );
                                }
                                
                        }
                }
            } else {
                if ($data['first_name'] == '')
                  $errors['first_name']=array(
                      'message'=>'Il nome è richiesto'
                  );
                else if (strlen($data['first_name'])>50)
                    $errors['first_name']=array(
                      'message'=>'Il nome può avere al massimo 50 caratteri'
                  );
                if ($data['last_name'] == '')
                  $errors['last_name']=array(
                      'message'=>'Il cognome è richiesto'
                  );
                else if (strlen($data['last_name'])>50)
                    $errors['last_name']=array(
                      'message'=>'Il cognome può avere al massimo 50 caratteri'
                  );
                if ($data['sex'] == '')
                  $errors['female']=array(
                      'message'=>'Il sesso è richiesto'
                  );
                if ($data['citizenship'] == '')
                  $errors['citizenship']=array(
                      'message'=>'La cittadinanza è richiesta'
                  );
                else if (strlen($data['citizenship'])>50)
                    $errors['citizenship']=array(
                      'message'=>'La cittadinanaza può avere al massimo 50 caratteri'
                  );
                if ($data['address'] == '')
                  $errors['address']=array(
                      'message'=>'La via è richiesta'
                  );
                else if (strlen($data['address'])>50)
                    $errors['address']=array(
                      'message'=>'L\'indirizzo può avere al massimo 50 caratteri'
                  );
                if ($data['zip'] == '')
                  $errors['zip']=array(
                      'message'=>'Il CAP è richiesto'
                  );
                else if (!preg_match('/^[0-9]{5}$/', $data['zip']))
                    $errors['zip']=array(
                      'message'=>'Il CAP è errato'
                  );
                if ($data['city'] == '')
                  $errors['city']=array(
                      'message'=>'La città è richiesta'
                  );
                else if (strlen($data['city'])>50)
                    $errors['city']=array(
                      'message'=>'La città può avere al massimo 50 caratteri'
                  );
                if ($data['phone'] == '')
                  $errors['phone']=array(
                      'message'=>'Il telefono è richiesto'
                  );
                else if (!preg_match('/^[ \+0-9]+$/', $data['phone']))
                    $errors['phone']=array(
                      'message'=>'Il telefono può contenere numeri, spazi e +'
                  );
                if ($data['medical_certificate'] == '' && sizeof($_FILES) ==0)
                  $errors['medical_certificate']=array(
                      'message'=>'Il certificato medico è richiesto'
                  );
            }
            if ( !key_exists('member_num_tes', $data) ) {
                if ( $data['date_of_birth'] == '' )
                      $errors['date_of_birth']=array(
                          'message'=>'La data di nascita è richiesta'
                      );
                else if (
                            $data['type_of_check'] == 'fidal' &&
                            $datetime > $marathon_datetime - 18 * 31556926 
                        )
                            $errors['date_of_birth']=array(
                              'message'=>'Devi avere almeno 18 anni al '.strftime('%d/%m/%Y',$marathon_datetime)
                            );
                else if (
                            $data['type_of_check'] != 'fidal' &&
                            $datetime > $marathon_datetime - 23 * 31556926 
                        )
                            $errors['date_of_birth']=array(
                              'message'=>'Devi avere almeno 23 anni al '.strftime('%d/%m/%Y',$marathon_datetime)
                            );
            }
            if ($data['payment_type'] == '')
                  $errors['paypal']=array(
                      'message'=>'La modalità di pagamento è richiesta'
                  );
            if ($data['email'] != '') {
                if (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/', $data['email']))
                  $errors['email']=array(
                      'message'=>'La mail non è valida'
                  );  
            }
            
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
            $query
                ->select('COUNT(id)')
                ->from('#__atlete')
                ->where('removed <> 1 AND id = '. $db->Quote($this->generateKey($data)));
            $db->setQuery($query);
            $db->query();
            $id = intval($db->loadResult());
            if ($id > 0) {
                $errors['first_name']=array(
                 'message'=>'Atleta già registrato'
                );
            }
            
            if (sizeof($errors) ==0) {
                $this->data = $data;
            }
            $this->errors = $errors;
        }
        /**
         * Generates a new key
         * @param type $data
         * @return type
         */
        private function generateKey($data) {
            if ($data['num_tes'] == '')
                    $id=  str_replace('-','_',$data['first_name']).'_'.str_replace ('-','_', $data['last_name']).'_'.$data['date_of_birth'];
            else
                $id=$data['num_tes'];
            return preg_replace('/[^a-z_0-9\.\-]/','_',strtolower($id));
        }
        /**
         * Return form errors
         * @return array
         */
        public function getErrors() {
            return $this->errors;
        }
        /**
         * Checks the data and return the associated atlete data
         * 
         * @param array $data
         * @return MaratonRegisterTableMaratonRegister
         */
        public function verifyAndLoad ($data) {
            
            $datetime = strptime($data['date_of_birth'], '%d/%m/%Y');
            
            $add_year = 1900;
            if ($datetime['tm_year'] < 20) 
                $add_year = 2000;

            $datetime = mktime (
                    0,
                    0,
                    0,
                    $datetime['tm_mon']+1,
                    $datetime['tm_mday'],
                    $datetime['tm_year']+$add_year);

            $data['date_of_birth'] = strftime('%Y-%m-%d',$datetime);
            
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
            $query
                    ->select('id')
                    ->from('#__atlete')
                    ->where('
                        removed <> 1 AND (
                            (
                                LOWER(first_name) = '. $db->Quote(trim(strtolower($data['first_name']))) .' AND
                                LOWER(last_name) = '. $db->Quote(trim(strtolower($data['last_name']))) .' AND
                                LOWER(date_of_birth) = '. $db->Quote(trim(strtolower($data['date_of_birth']))) .' AND
                                '. $db->Quote(trim(strtolower($data['num_tes']))).' = ""   
                            )
                            OR (
                                LOWER(num_tes) = '. $db->Quote(trim(strtolower($data['num_tes']))).' AND
                                    '. $db->Quote(trim(strtolower($data['num_tes']))).' <> ""
                                )
                        )
                        ');
                       
            $db->setQuery($query);
            $id = $db->loadResult();
            $atlete = $this->getTable();
            if ($id != '' )
                $atlete->load($id);
            return $atlete;
        }
        /**
         * Gets the uniz timestamp
         */
        private function getDateTime($date) {
            if ($date == '')
                return 0;
            $datetime = strptime($date, '%d/%m/%Y');
		$add_year = 1900;
                if ($datetime['tm_year'] < 20) 
                    $add_year = 2000;
                return mktime (
                        0,
                        0,
                        0,
                        $datetime['tm_mon']+1,
                        $datetime['tm_mday'],
                        $datetime['tm_year']+$add_year);

        } 
        /**
         * Parses date and time
         * @param string $date
         * @return string
         */
        private function parseDate ($date) {
            if ($date == '')
                return '';
            $datetime = $this->getDateTime($date);
                
                return strftime('%Y-%m-%d',$datetime);
        }
        /**
         * add Payment Data
         * @param array $data
         * @return array
         */
        public function addPayment ($data) {
            if ( key_exists('payment_fname',$_FILES) &&
                     $_FILES['payment_fname']['error'] != 4) {
                   if ( $_FILES['payment_fname']['error'] != 0 )
                    $this->errors['payment_fname']=array(
                    'message'=>'C\'è stato un\'errore nel caricare la ricevuta di pagamento, riprova in un secondo momento'
                    );
                else if (preg_match ('/^\.(pdf|jpg|jpeg|gif|png|tiff)$/i',$_FILES['payment_fname']['name']))
                    $this->errors['payment_fname']=array(
                     'message'=>'Puoi inviare la ricevuta come documento PDF o immagine in formato JPG, TIFF, PNG e GIF'
                    );
                else {
                    $filename = substr(preg_replace('/[^a-z_0-9\.]/','_',strtolower($_FILES['payment_fname']['name'])),-30);
                    $filename = time().'_'.$filename;
                    $destination = dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'payment_receipt';
                    if(!is_dir($destination)) {
                        if(!mkdir ($destination, 0777))
                        $this->errors['payment_fname']=array(
                         'message'=>'C\'è stato un\'errore nel caricare la ricevuta, riprova in un secondo momento'
                        );
                    }
                    file_put_contents($destination.DIRECTORY_SEPARATOR.'index.html','<html><body bgcolor="#FFFFFF"></body></html>');
                    $destination .= DIRECTORY_SEPARATOR.$filename;
                    if (!move_uploaded_file($_FILES['payment_fname']['tmp_name'], $destination))
                        $this->errors['payment_fname']=array(
                         'message'=>'C\'è stato un\'errore nel caricare la ricevuta, riprova in un secondo momento'
                        );
                    else
                        $data['payment_fname']=$filename;
                        $data['payment_datetime']='NOW()';
                    
                }
            }
            return $data;
        }
        /**
         * Adds gamecard data
         * @param array $data
         * @return array
         */
        public function addGameCard($data) {
            if ( key_exists('game_card_fname',$_FILES) &&
                     $_FILES['game_card_fname']['error'] != 4) {
                   if ( $_FILES['game_card_fname']['error'] != 0 )
                    $this->errors['game_card_fname']=array(
                    'message'=>'C\'è stato un\'errore nel caricare il cartellino di partecipazione, riprova in un secondo momento'
                    );
                else if (preg_match ('/^\.(pdf|jpg|jpeg|gif|png|tiff)$/i',$_FILES['payment_fname']['name']))
                    $this->errors['game_card_fname']=array(
                     'message'=>'Puoi inviare il cartellino come documento PDF o immagine in formato JPG, TIFF, PNG e GIF'
                    );
                else {
                    $filename = substr(preg_replace('/[^a-z_0-9\.]/','_',strtolower($_FILES['game_card_fname']['name'])),-30);
                    $filename = time().'_'.$filename;
                    $destination = dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'game_card';
                    if(!is_dir($destination)) {
                        if(!mkdir ($destination, 0777))
                        $this->errors['game_card_fname']=array(
                         'message'=>'C\'è stato un\'errore nel caricare il cartellino di partecipazione, riprova in un secondo momento'
                        );
                    }
                    file_put_contents($destination.DIRECTORY_SEPARATOR.'index.html','<html><body bgcolor="#FFFFFF"></body></html>');
                    $destination .= DIRECTORY_SEPARATOR.$filename;
                    if (!move_uploaded_file($_FILES['game_card_fname']['tmp_name'], $destination))
                        $this->errors['game_card_fname']=array(
                         'message'=>'C\'è stato un\'errore nel caricare il cartellino di partecipazione, riprova in un secondo momento'
                        );
                    else
                        $data['game_card_fname']=$filename;
                        $data['game_card_datetime']='NOW()';
                    
                }
            }
            return $data;
        }
        /**
         * Adds a medical certificate
         * @param array $data
         * @return array
         */
        public function addMedicalCertificate ($data) {
            if ($_FILES['medical_certificate']['error'] != 0)
                    $this->errors['medical_certificate']=array(
                    'message'=>'C\'è stato un\'errore nel caricare il certificato, riprova in un secondo momento'
                    );
                else if (preg_match ('/^\.(pdf|jpg|jpeg|gif|png|tiff)$/i',$_FILES['medical_certificate']['name']))
                    $this->errors['medical_certificate']=array(
                     'message'=>'Puoi inviare il certificato come documento PDF o immagine in formato JPG, TIFF, PNG e GIF'
                    );
                else {
                    $filename = substr(preg_replace('/[^a-z_0-9\.]/','_',strtolower($_FILES['medical_certificate']['name'])),-30);
                    $filename = time().'_'.$filename;
                    $destination = dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'medical_certificate';
                    
                    if(!is_dir($destination)) {
                        if(!mkdir ($destination, 0777))
                        $this->errors['medical_certificate']=array(
                         'message'=>'C\'è stato un\'errore nel caricare il certificato, riprova in un secondo momento'
                        );
                    }
                    
                    file_put_contents($destination.DIRECTORY_SEPARATOR.'index.html','<html><body bgcolor="#FFFFFF"></body></html>');
                    $destination .= DIRECTORY_SEPARATOR.$filename;
                    if (!move_uploaded_file($_FILES['medical_certificate']['tmp_name'], $destination))
                        $this->errors['medical_certificate']=array(
                         'message'=>'C\'è stato un\'errore nel caricare il certificato, riprova in un secondo momento'
                        );
                    else
                        $data['medical_certificate_fname']=$filename;
                        $data['medical_certificate_datetime']='NOW()';
                }
                return $data;
        }
        
}
