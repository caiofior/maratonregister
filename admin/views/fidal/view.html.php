<?php
/**
 * Fidal View
 * @author Claudio Fior <caiofior@gmail.com>
 * @version 0.2
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * Fidal View
 * @author Claudio Fior <caiofior@gmail.com>
 * @version 0.2
 */
class MaratonRegisterViewFidal extends JView
{
        /**
         * Fidal view display method
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
                JToolBarHelper::title('Fidal');
                JToolBarHelper::custom('fidal.import','test','','Importa',false);
                // Display the template
                parent::display($tpl);
        }


}
