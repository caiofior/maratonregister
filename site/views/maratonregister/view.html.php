<?php
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @version 0.1
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
                if(key_exists('submit',$_REQUEST)) {
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
