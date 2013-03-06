<?php
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @version 0.1
 */
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controller library
jimport('joomla.application.component.controller');
 
/**
 * General Controller of MaratonRegister component
 * @author Claudio Fior <caiofior@gmail.com>
 * @version 0.1
 */
class MaratonRegisterController extends JController
{
        /**
         * display task
         *
         * @return void
         */
        public function display($cachable = false) 
        {
                // set default view if not set
                $input = JFactory::getApplication()->input;
                $input->set('view', $input->getCmd('view', 'MaratonRegister'));
                
                // call parent behavior
                parent::display($cachable);
        }
        /**
         * Manages fidal task
         * @param type $cachable
         */
        public function fidal($cachable = false)  {
               // set default view if not set
                $input = JFactory::getApplication()->input;
                $input->set('view', 'fidal');

                // call parent behavior
                parent::display($cachable);
        }

        public function import () {
                            
                // set default view if not set
                $input = JFactory::getApplication()->input;
                $input->set('view', 'import');
                // call parent behavior
                parent::display($cachable);
        }
        public function stats($cachable = false)  {
            die('HI');
        }
}
