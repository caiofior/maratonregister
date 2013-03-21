<?php
/**
 * Fidal View
 * @author Claudio Fior <caiofior@gmail.com>
 * @version 0.4
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * Fidal View
 * @author Claudio Fior <caiofior@gmail.com>
 * @version 0.4
 */
class MaratonRegisterViewFidal extends JView
{
        /**
         * Fidal view display method
         * @return void
         */
        function display($tpl = null) 
        {
            
                // Assign data to the view
                $item = $this->get('Item');
                if (key_exists('num_tes', $_REQUEST)) {
                    $item->load($_REQUEST['num_tes']);
                }
                
                $this->item = $item;
                $this->items = $this->get('Items');
                
                $this->pagination = $this->get('Pagination');
                $this->state	= $this->get('State');
                JToolBarHelper::title('Fidal');
                
                if (key_exists('num_tes', $_REQUEST))
                    JToolBarHelper::back ();
                else {
                    JToolBarHelper::custom('fidal_deleteall','icon-32-trash','','Cancella tutti',false);
                    JToolBarHelper::custom('fidal.import','test','','Importa',false);
                }
                
                // Display the template
                parent::display($tpl);
        }


}
