<?php
/**
 * General Controller of MaratonRegister component
 * @author Claudio Fior <caiofior@gmail.com>
 * @version 0.7
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controllerform library
jimport('joomla.application.component.controllerform');
 
/**
 * General Controller of MaratonRegister component
 * @author Claudio Fior <caiofior@gmail.com>
 * @version 0.7
 */
class MaratonRegisterControllerMaratonRegister extends JControllerForm
{
    /**
     * Managges export data
     */
    public function export () {
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);

        // Select some fields
        $query->select('*');

        // From the hello table
        $query->from('#__atlete')->where('removed=0 OR removed IS NULL');
        $db->setQuery($query);
        $atletes = $db->query();
	header('Content-type: application/ms-excel');
        header('Content-Disposition: attachment; filename=atletes.csv');
	switch ( get_resource_type($atletes)) {
		case 'mysql result':
			$function_fetch = 'mysql_fetch_assoc';
		break;
		case 'mysqli result':
			$function_fetch = 'mysqli_fetch_assoc';
		break;
	}
	$c =0;
        while (is_array($atlete = $function_fetch($atletes))) {
            if ($c == 0)
                echo implode(';',array_keys($atlete))."\r\n";
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
	    $c++;
        }
        exit;
    }

}