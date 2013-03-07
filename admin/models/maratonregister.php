<?php
/**
 * Maraton Register Model
 * @author Claudio Fior <caiofior@gmail.com>
 * @version 0.1
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
/**
 * Maraton Register Model
 * @author Claudio Fior <caiofior@gmail.com>
 * @version 0.1
 */
class MaratonRegisterModelMaratonRegister extends JModelList
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
         * Method to build an SQL query to load the list data.
         *
         * @return      string  An SQL query
         */
        protected function getListQuery()
        {
                // Create a new query object.           
                $db = JFactory::getDBO();
                $query = $db->getQuery(true);
                // Select some fields
                $query->select('id,first_name,last_name,date_of_birth,num_tes,city,registration_datetime');
                // From the hello table
                $query->from('#__atlete')->where('removed =0');
                return $query;
        }
        /**
         * Set new athlete data
         * @param array $data
         */
        public function setData($data) {
            $this->checkData($data);
            $atlete = $this->getTable();
            if(key_exists('id', $data) && $data['id']!='')
                $atlete->load($data['id']);
            if ( 
                    $data['num_tes'] == '' &&
                    !key_exists('medical_certificate',$_FILES) &&
                    $atlete->medical_certificate_fname == ''
                    ) {
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
                else if (key_exists('medical_certificate',$_FILES)) {
                    $filename = time().'_'.preg_replace('/[^a-z_0-9\.]/','_',strtolower($_FILES['medical_certificate']['name']));
                    
                    $medical_certificate_fname = JPATH_BASE.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.
                    'components'.DIRECTORY_SEPARATOR.'com_maratonregister'.DIRECTORY_SEPARATOR.'medical_certificate';
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
            if ($data['medical_certificate_confirm_datetime'] == 1)
                $data['medical_certificate_confirm_datetime']='NOW()';
            else 
                unset ($data['medical_certificate_confirm_datetime']);
            
            if ($data['payment_confirm_datetime'] == 1)
                $data['payment_confirm_datetime']='NOW()';
            else 
                unset ($data['payment_confirm_datetime']);
            
            if ($data['num_tes_datetime_confirmed'] == 1)
                $data['num_tes_datetime_confirmed']='NOW()';
            else 
                unset ($data['num_tes_datetime_confirmed']);
            
            if (sizeof($this->errors) == 0) {
                $columns = array(
                            'id',
                            'first_name' ,
                            'last_name',
                            'date_of_birth',
                            'num_tes' ,
                            'num_tes_datetime_confirmed' ,
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
                            'payment_confirm_datetime' ,
                            'medical_certificate_fname',
                            'medical_certificate_datetime',
                            'medical_certificate_confirm_datetime',
                            'pectoral'
                        );
                    $db = JFactory::getDbo();
                    $query = $db->getQuery(true);
                    if ($atlete->id == '') {
                        if ($data['num_tes'] == '')
                            $data['id']=  str_replace('-','_',$data['first_name']).'_'.str_replace ('-','_', $data['last_name']).'_'.$data['date_of_birth'];
                        else
                            $data['id']=$data['num_tes'];
                         $data['id']=  preg_replace('/[^a-z_0-9\.\-]/','_',strtolower($data['id']));
                        $data['registration_datetime']='NOW()';
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
                        $values = array();
                        foreach ($columns as $column) {
                            if (!key_exists($column, $data)) continue;
                            if (
                                    $column == 'registration_datetime' ||
                                    $column == 'medical_certificate_datetime' ||
                                    $column == 'medical_certificate_confirm_datetime' ||
                                    $column == 'num_tes_datetime_confirmed' ||
                                    $column == 'payment_confirm_datetime'
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
                    }

                } else {
                    $query->update('#__atlete');
                    foreach ($data as $column=>$value) {
                        if (!in_array($column, $columns) || $column == 'id') continue;
                        $query->set($db->quoteName($column).' = '.$db->quote($value));
                    }
                    $query->where('id='.$db->quote($atlete->id));
                    $db->setQuery($query);
                    $db->query();
                }
                    
            }
            
        }
        /**
         * Checks new athlete data
         * @param array $data
         */
        public function checkData($data) {
            $atlete = $this->getTable();
            if(key_exists('id', $data) && $data['id']!='')
                $atlete->load($data['id']);
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
                if (
                        $data['medical_certificate'] == '' &&
                        sizeof($_FILES) ==0 && 
                        $atlete->medical_certificate_fname == '' )
                  $errors['medical_certificate']=array(
                      'message'=>'Il certificato medico è richiesto'
                  );
            }
            if ($data['date_of_birth'] == '')
                  $errors['date_of_birth']=array(
                      'message'=>'La data di nascita è richiesta'
                  );
            if (
                    $data['payment_type'] == '' &&
                    $atlete->payment_confirm_datetime == ''
                    )
                  $errors['paypal']=array(
                      'message'=>'La modalità di pagamento è richiesta'
                  );
            if ($data['email'] != '') {
                if (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/', $data['email']))
                  $errors['email']=array(
                      'message'=>'La mail non è valida'
                  );  
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
