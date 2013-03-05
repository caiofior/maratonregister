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
 * HelloWorlds View
 */
class MaratonRegisterViewMaratonRegister extends JView
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
 
                // Check for errors.
                if (count($errors = $this->get('Errors'))) 
                {
                        JError::raiseError(500, implode('<br />', $errors));
                        return false;
                }
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
                JToolBarHelper::title('Iscritti');
                JToolBarHelper::deleteList('', 'maratonregister.delete');
                JToolBarHelper::editList('maratonregister.edit');
                JToolBarHelper::addNew('maratonregister.add');
                JToolBarHelper::custom('maratonregister.export','test','','Esporta',false);
        }
}
