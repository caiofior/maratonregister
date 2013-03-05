<?php
/**
 * General Controller of MaratonRegister component
 * @author Claudio Fior <caiofior@gmail.com>
 * @version 0.1
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controlleradmin library
jimport('joomla.application.component.controlleradmin');
 
/**
 * General Controller of MaratonRegister component
 * @author Claudio Fior <caiofior@gmail.com>
 * @version 0.1
 */
class MaratonRegisterControllerMaratonRegisters extends JControllerAdmin
{
        /**
         * Proxy for getModel.
         * @since       2.5
         */
        public function getModel($name = 'MaratonRegister', $prefix = 'MaratonRegister') 
        {
                $model = parent::getModel($name, $prefix, array('ignore_request' => true));
                return $model;
        }
}
