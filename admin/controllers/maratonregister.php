<?php
/**
 * General Controller of MaratonRegister component
 * @author Claudio Fior <caiofior@gmail.com>
 * @version 0.1
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controllerform library
jimport('joomla.application.component.controllerform');
 
/**
 * General Controller of MaratonRegister component
 * @author Claudio Fior <caiofior@gmail.com>
 * @version 0.1
 */
class MaratonRegisterControllerMaratonRegister extends JControllerForm
{
    public function export () {
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);

        // Select some fields
        $query->select('*');

        // From the hello table
        $query->from('#__atlete');
        $db->setQuery($query);
        $atletes = $db->query();
        header('Content-type: application/ms-excel');
        header('Content-Disposition: attachment; filename=atletes.csv');
        while (is_array($atlete = mysqli_fetch_assoc($atletes))) {
            if (mysqli_field_tell($atletes) == 0) {
                echo implode(';',array_keys($atlete))."\r\n";
            }
            foreach ($atlete as $key=>$value) {
                if (
                    $key == 'date_of_birth' 
                ) {
                    if ($value != '')
                        $atlete[$key]=date('d/m/y', strtotime($value));
                }
                else if ($key == 'registration_datetime' ||
                    $key == 'payment_datetime' ||
                    $key == 'payment_datetime' ||
                    $key == 'medical_certificate_datetime' ||
                    $key == 'medical_certificate_confirm_datetime'    
                ) {
                    if ($value != '')
                        $atlete[$key]=date('d/m/y H:i:s', strtotime($value));
                }
                else
                $atlete[$key]='"'.addslashes ($value).'"';
            }
            echo implode(';',$atlete)."\r\n";
        }
        exit;
    }
}