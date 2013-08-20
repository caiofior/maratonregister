<?php
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @version 1.2
 */
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controller library
jimport('joomla.application.component.controller');
 
/**
 * General Controller of MaratonRegister component
 * @author Claudio Fior <caiofior@gmail.com>
 * @version 1.2
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
                if (
                        key_exists('task', $_REQUEST) &&
                        $_REQUEST['task']=='cancel'
                        ) {
                            unset($_REQUEST['layout']);
                            $input = JFactory::getApplication()->input;
                            $input->set('view', 'MaratonRegister');
                            
                        }
                $input = JFactory::getApplication()->input;
                $input->set('view', $input->getCmd('view', 'MaratonRegister'));
                
                // call parent behavior
                parent::display(false,false);
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
                parent::display(false,false);
        }
         /**
         * Manages fidal_deleteall task
         * @param type $cachable
         */
        public function fidal_deleteall($cachable = false)  {
                $fidal = $this->getModel("fidal");
                $fidal->deleteAll();
               // set default view if not set
                $input = JFactory::getApplication()->input;
                $input->set('view', 'fidal');
                // call parent behavior
                parent::display(false,false);
        }
        /**
         * Manages fidal task
         * @param type $cachable
         */
        public function statistics($cachable = false)  {
               // set default view if not set
                $input = JFactory::getApplication()->input;
                $input->set('view', 'statistics');

                // call parent behavior
                parent::display($cachable);
        }
        /**
         * Manages import task
         * @param type $cachable
         */
        public function import () {
                            
                // set default view if not set
                $input = JFactory::getApplication()->input;
                $input->set('view', 'import');
                // call parent behavior
                parent::display(false,false);
        }
        /**
         * Gets the new pectoral number
         */
        public function generate_pectoral() {
            $model = $this->getModel();
            $table = $model->getTable();
            header('Cache-Control: no-cache, must-revalidate');
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
            header('Content-type: application/json');
            echo json_encode($table->getPectoral());
            exit;
        }
}
