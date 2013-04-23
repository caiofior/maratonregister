<?php
/**
 * Maraton Register Model
 * @author Claudio Fior <caiofior@gmail.com>
 * @version 0.6.1
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla modelitem library
jimport('joomla.application.component.modelitem');

/**
 * Maraton Register Model
 * @author Claudio Fior <caiofior@gmail.com>
 * @version 0.6.1
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
            $this->checkData($data);
            foreach ($data as $key=>$value)
                $data[$key]=  preg_replace('/[ ]+/',' ',trim ($value));
            if ( $data['num_tes'] == '' && !key_exists('medical_certificate',$_FILES)) {
                $this->errors['medical_certificate']=array(
                    'message'=>'Il certificato medico è richiesto'
                );
            } else if ($data['num_tes'] == '') {
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
            }
            
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
            
            if (sizeof($this->errors) == 0) {
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
                    $data['id']=  $this->generateKey($data);
                    $data['registration_datetime']='NOW()';
                    $db = JFactory::getDbo();
                    $query = $db->getQuery(true);
                    $query
                        ->select('COUNT(id)')
                        ->from('#__atlete')
                        ->where('removed <> 1 AND id = '. $db->Quote($data['id']));
                    $db->setQuery($query);
                    $db->query();
                    $id = intval($db->loadResult());
                    


                    if ($id > 0) {
                        $this->errors['first_name']=array(
                         'message'=>'Sei già registrato alla maratona, contatta lo staff per eventuali problemi'
                        );
                    }
                    else {
                        $query = $db->getQuery(true);
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
                            'medical_certificate_datetime'
                        );
                        $values = array();
                        $rcolumns = array_flip($columns);
                        $rcolumns = array_intersect_key($rcolumns, $data);
                        $columns = array_flip($rcolumns);
                        foreach ($columns as $column) {
                            if (!key_exists($column, $data)) 
                                continue;
                            if (
                                    $column == 'registration_datetime' ||
                                    $column == 'medical_certificate_datetime'
                                )
                                $values[$column]=$data[$column];
                            else
                                $values[$column]=$db->quote($data[$column]);
                        }
                        
                        $query
                            ->insert($db->quoteName('#__atlete'))
                            ->columns($db->quoteName($columns))
                            ->values(implode(',', $values));

                        $db->setQuery($query);
                        $db->query();
                        $mailer = JFactory::getMailer();
                        $config = JFactory::getConfig();
                        $sender = array( 
                            $config->getValue( 'config.mailfrom' ),
                            $config->getValue( 'config.fromname' )
                        );
                        $mailer->setSender($sender);
                        $mailer->addRecipient($sender);
                        $body   = <<<EOT
<p>Nuova iscrizione alla maratonia dei Borghi</p>
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
<p>Grazie per esserti iscritto alla maratonia dei Borghi, questi sono i dati da te forniti</p>
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
<p>Per errori o inesattezze contatta l'organizzazione della maratone.</p>
EOT;
                        $mailer->setSubject('Grazie per esserti iscritto alla maratonia dei Borghi');
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
            foreach ($data as $key=>$value)
                $data[$key]=  preg_replace('/[ ]+/',' ',trim ($value));
            
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
            
            if ($data['num_tes'] != '') {
                if (strlen($data['num_tes']) <> 8)
                  $errors['num_tes']=array(
                      'message'=>'Il numero tessera è errato'
                  );  
            } else if ($data['other_num_tes'] != '') {
                if ($data['other_ass_name'] == '')
                  $errors['other_ass_name']=array(
                      'message'=>'Il nome dell\'associazione è richiesto'
                  );
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
            if ($data['date_of_birth'] == '')
                  $errors['date_of_birth']=array(
                      'message'=>'La data di nascita è richiesta'
                  );
            else if (
                        $data['num_tes'] != '' &&
                        $datetime > time() - 18 * 31556926 
                    )
                        $errors['date_of_birth']=array(
                          'message'=>'Devi avere almeno 18 anni'
                        );
            else if (
                        $data['num_tes'] == '' &&
                        $datetime > time() - 23 * 31556926 
                    )
                        $errors['date_of_birth']=array(
                          'message'=>'Devi avere almeno 23 anni'
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
        
}
