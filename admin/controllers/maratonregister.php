<?php
/**
 * General Controller of MaratonRegister component
 * @author Claudio Fior <caiofior@gmail.com>
 * @version 1.1
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controllerform library
jimport('joomla.application.component.controllerform');
 
/**
 * General Controller of MaratonRegister component
 * @author Claudio Fior <caiofior@gmail.com>
 * @version 1.1
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
        $query->select(array(
            'atlete.*',
            'fidal_fella.denom'
        ));

        // From the hello table
        $query->from('#__atlete AS atlete')->join('LEFT', '#__fidal_fella AS fidal_fella ON (atlete.num_tes = fidal_fella.num_tes)')->where('atlete.removed=0 OR atlete.removed IS NULL');
        $db->setQuery($query);

        $atletes = $db->query();
        if (is_resource($atletes))
            $resource_type = get_resource_type($atletes);
        else if (is_object($atletes))
            $resource_type = get_class ($atletes);
	header('Content-type: application/ms-excel');
        header('Content-Disposition: attachment; filename=atletes.csv');
	switch ( $resource_type) {
		case 'mysql result':
                case 'mysql_result':
			$function_fetch = 'mysql_fetch_assoc';
		break;
		case 'mysqli result':
                case 'mysqli_result':
			$function_fetch = 'mysqli_fetch_assoc';
		break;
	}
	$c =0;
        while (is_array($atlete = $function_fetch($atletes))) {
            if ($c == 0)
                echo implode(';',array_keys($atlete))."\r\n";
            if ($atlete['num_tes'] != '') {
              $atlete['medical_certificate_datetime']=$atlete['registration_datetime'];  
              $atlete['medical_certificate_confirm_datetime']=$atlete['registration_datetime'];
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
	    $c++;
        }
        exit;
    }

}