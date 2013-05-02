<?php
/**
 * Maraton Register View
 * @author Claudio Fior <caiofior@gmail.com>
 * @version 0.7
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * Maraton Register View
 * @author Claudio Fior <caiofior@gmail.com>
 * @version 0.7
 */
class MaratonRegisterViewMaratonRegister extends JView
{
        /**
         * Maraton Register view display method
         * @return void
         */
        function display($tpl = null) 
        {
                if(
                        key_exists('submit',$_REQUEST) || (
                        key_exists('task', $_REQUEST) &&
                        $_REQUEST['task']=='save'
                        )) {
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
                        $this->setLayout('default');

                    }
                }
                $item = $this->get('Item');
                if (
                        key_exists('task', $_REQUEST) &&
                        $_REQUEST['task']=='trash' && 
                        key_exists('cid', $_REQUEST)
                        ) {
                    if (!is_array($_REQUEST['cid']))
                        $_REQUEST['cid']=array($_REQUEST['cid']);
                    foreach($_REQUEST['cid'] as $id) {
                        $db = JFactory::getDbo();
                        $query = $db->getQuery(true);
                        $query->delete('#__atlete')->where(' id='.$db->quote($id).' AND removed = 1');
                        $db->setQuery($query);
                        $db->query();
                        $query = $db->getQuery(true);
                        $query->update('#__atlete')
                                ->set('removed=1')
                                ->where('id='.$db->quote($id).' AND removed <> 1');
                        $db->setQuery($query);
                        $db->query();
                    }

                }
                
                if (key_exists('id', $_REQUEST)) {
                    $item->load($_REQUEST['id']);
                }
                if (
                        key_exists('layout',$_REQUEST) &&
                        $_REQUEST['layout'] == 'edit'
                 ){
                    JToolBarHelper::title('Iscritti');
                    JToolBarHelper::save('save');
                    JToolBarHelper::cancel('cancel');
                    
                } else {
                    JToolBarHelper::title('Iscritti');
                    JToolBarHelper::addNew('maratonregister.add');
                    JToolBarHelper::trash('maratonregister.trash');
                    JToolBarHelper::custom('maratonregister.export','excel','','Esporta',false);
                }
                $this->item = $item;
 
                
                // Assign data to the view
                $this->items = $this->get('Items');
                $this->pagination = $this->get('Pagination');
                $this->state	= $this->get('State');
                
                
                
                // Display the template
                parent::display($tpl);
        }


}
