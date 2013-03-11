<?php
/**
 * Fidal Model
 * @author Claudio Fior <caiofior@gmail.com>
 * @version 0.2
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
/**
 * Fidal Model
 * @author Claudio Fior <caiofior@gmail.com>
 * @version 0.2
 */
class MaratonRegisterModelFidal extends JModelList
{
            /**
         * Message errors
         * @var array
         */
	private  $errors =array();
        /**
         * Data to save
         * @var array
         */
        private $data=array();
         /**
         * Returns a reference to the a Table object, always creating it.
         *
         * @param       type    The table type to instantiate
         * @param       string  A prefix for the table class name. Optional.
         * @param       array   Configuration array for model. Optional.
         * @return      JTable  A database object
         * @since       2.5
         */
        public function getTable($type = 'Fidal', $prefix = 'MaratonRegisterTable', $config = array()) 
        {
                return JTable::getInstance($type, $prefix, $config);
        }
        /**
         * get an items
         */
        public function getItem() {
            $table = $this->getTable();
            return $table;
        }
        /**
         * Method to build an SQL query to load the list data.
         *
         * @return      string  An SQL query
         */
        protected function getListQuery()
        {
                // Create a new query object.           
                $db = JFactory::getDBO();
                $query = $db->getQuery(true);
                // Select some fields
                $query->select('num_tes,cogn,nome,dat_nas');
                // From the hello table
                $query->from('#__fidal_fella');
                return $query;
        }

        /**
         * Return form errors
         * @return array
         */
        public function getErrors() {
            return $this->errors;
        }
}
