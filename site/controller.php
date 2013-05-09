<?php
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @version 0.8
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla controller library
jimport('joomla.application.component.controller');

/**
 * Marathon register Component Controller
 * @author Claudio Fior <caiofior@gmail.com>
 * @version 0.8
 */
class MaratonRegisterController extends JController
{
    public function display($cachable = false, $urlparams = false) {

        
        parent::display(false, false);
    }
    
    public function verify ($cachable = false, $urlparams = false) {
            
            parent::display(false, false);
    }
}
