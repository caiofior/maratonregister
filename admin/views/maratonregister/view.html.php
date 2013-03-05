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
                $item = $this->get('Item');
                if (key_exists('id', $_REQUEST))
                    $item->load($_REQUEST['id']);
                $this->item = $item;
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
                JToolBarHelper::title('Iscritti');
                JToolBarHelper::addNew('maratonregister.add');
                JToolBarHelper::custom('maratonregister.export','test','','Esporta',false);
        }
}
