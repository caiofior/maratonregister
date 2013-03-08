<?php
/**
 * Maraton Register Model
 * @author Claudio Fior <caiofior@gmail.com>
 * @version 0.1
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla modelitem library
jimport('joomla.application.component.modelitem');

/**
 * Maraton Register Model
 * @author Claudio Fior <caiofior@gmail.com>
 * @version 0.1
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
         * Set new athlete data
         * @param array $data
         */
        public function setData($data) {
            $this->checkData($data);
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
                    $filename = time().'_'.preg_replace('/[^a-z_0-9\.]/','_',strtolower($_FILES['medical_certificate']['name']));
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
            if (sizeof($this->errors) == 0) {
                    if ($data['num_tes'] == '')
                        $data['id']=  str_replace('-','_',$data['first_name']).'_'.str_replace ('-','_', $data['last_name']).'_'.$data['date_of_birth'];
                    else
                        $data['id']=$data['num_tes'];
                    $data['id']=  preg_replace('/[^a-z_0-9\.\-]/','_',strtolower($data['id']));
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
                            'medical_certificate_fname',
                            'medical_certificate_datetime'
                        );
                        $values = array();
                        foreach ($columns as $column) {
                            if (!key_exists($column, $data)) continue;
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
        <th>Tessera FIDAS</th>
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
        <th>Tessera FIDAS</th>
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
            if ($data['num_tes'] != '') {
                $db = JFactory::getDbo();
                $query = $db->getQuery(true);
                    $query
                    ->select('COUNT(id)')
                    ->from('#__atlete')
                    ->where('removed <> 1 AND num_tes = '. $db->Quote($data['num_tes']));
                    $db->setQuery($query);
                    $db->query();
                    if (intval($db->loadResult()) > 0) {
                        $errors['num_tes']=array(
                            'message'=>'Risulti gà iscritto'
                        ); 
                        }
            }
            if (sizeof($errors) ==0) {
                $this->data = $data;
            }
            $this->errors = $errors;
        }
        /**
         * Return form errors
         * @return array
         */
        public function getErrors() {
            return $this->errors;
        }
}
