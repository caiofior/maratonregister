<?php
/**
 * General Controller of Fidal component
 * @author Claudio Fior <caiofior@gmail.com>
 * @version 0.8
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controllerform library
jimport('joomla.application.component.controllerform');
 
/**
 * General Controller of Fidal component
 * @author Claudio Fior <caiofior@gmail.com>
 * @version 0.8
 */
class MaratonRegisterControllerFidal extends JControllerForm
{
    public function import () {
                // set default view if not set
                $input = JFactory::getApplication()->input;
                $input->set('view', 'import');
                // call parent behavior
                parent::display(false,false);
    }
    
}