<?php
/**
 * Fidal View
 * @author Claudio Fior <caiofior@gmail.com>
 * @version 0.1
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * Fidal View
 * @author Claudio Fior <caiofior@gmail.com>
 * @version 0.1
 */
class MaratonRegisterViewFidal extends JView
{
        /**
         * HelloWorlds view display method
         * @return void
         */
        function display($tpl = null) 
        {
            
                // Get data from the model
                $items = $this->get('Items');
                $pagination = $this->get('Pagination');
 
                
                // Assign data to the view
                $this->items = $items;
                $this->pagination = $pagination;
                $this->addToolBar();
                // Display the template
                parent::display($tpl);
        }

        /**
         * Setting the toolbar
         */
        protected function addToolBar() 
        {
                JToolBarHelper::title('Fidal');
                JToolBarHelper::custom('fidal.import','test','','Importa',false);
        }

}
