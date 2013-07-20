<?php
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @version 1.0
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

/**
 * HTML View class for the MaratonRegister Component
 */
class MaratonRegisterViewMaratonRegister extends JView
{
	// Overwriting JView display method
	function display($tpl = null) 
	{
               if (JRequest::getCmd('task') == 'verify') {
                    
                    $this->setLayout ('verify');
                    $this->atlete = null;
                    if (sizeof($_FILES) > 0) {
                        $model = $this->getModel();
                        $this->atlete = $model->getItem();
                        $this->atlete->load($_REQUEST['atlete_id']);
                        $data = $this->atlete->getProperties();
                        if (key_exists('payment_fname', $_FILES)) {
                            $data = $model->addPayment($data);
                        }
                        if (key_exists('medical_certificate', $_FILES)) {
                            $data = $model->addMedicalCertificate($data);
                        }
                        if (key_exists('game_card_fname', $_FILES)) {
                            $data = $model->addGameCard($data);
                        }
                        if (key_exists('payment_type', $_REQUEST))
                                $data['payment_type']=$_REQUEST['payment_type'];
                        $db = JFactory::getDbo();
                        $query = $db->getQuery(true);
                        $columns = array(
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
                            'payment_datetime',
                            'medical_certificate_fname',
                            'medical_certificate_datetime',
                            'game_card_fname',
                            'game_card_datetime'
                        );
                        
                        $query->update('#__atlete');
                        foreach ($data as $column=>$value) {
                            if (!in_array($column, $columns) ) continue;
                            if (
                                        $data[$column] == 'NOW()' ||
                                        $data[$column] == 'NULL'
                                    )
                                $query->set($db->quoteName($column).' = '.$value);
                            else
                                $query->set($db->quoteName($column).' = '.$db->quote($value));
                        }
                        $query->where('removed <> 1 AND id='.$db->quote($data['id']));
                        $db->setQuery($query);
                        $db->query();
                        $this->atlete->load($_REQUEST['atlete_id']);
                    }
                    if(key_exists('submit',$_REQUEST)) {
                        $model = $this->getModel();
                        if (is_null($this->atlete))
                            $this->atlete = $model->verifyAndLoad($_REQUEST);
                    }
                }
                else if(key_exists('submit',$_REQUEST)) {
                    $model = $this->getModel();
                    if (key_exists('xhr', $_REQUEST)) {
                        $model->checkData($_REQUEST);
                        header('Cache-Control: no-cache, must-revalidate');
                        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
                        header('Content-type: application/json');
                        echo json_encode($model->getErrors());
                        exit;
                    } else {
                        $model->setData($_REQUEST);
                    }
                }
                
		// Display the view
		parent::display($tpl);
	}

}
