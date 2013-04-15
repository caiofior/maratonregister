<?php
/**
 * Maraton Register Table
 * @author Claudio Fior <caiofior@gmail.com>
 * @version 0.5
 */
// No direct access
defined('_JEXEC') or die('Restricted access');
 
// import Joomla table library
jimport('joomla.database.table');
 
/**
 * Maraton Register Table
 * @author Claudio Fior <caiofior@gmail.com>
 * @version 0.5
 */
class MaratonRegisterTableMaratonRegister extends JTable
{
        /**
         * Constructor
         *
         * @param object Database connector object
         */
        function __construct(&$db) 
        {
                parent::__construct('#__atlete', 'id', $db);
        }
        /**
         * Gets default pectoral
         * @return Int
         */
        public function getPectoral () {
            if (is_numeric($this->pectoral))
                return $this->pectoral;
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
            $query
                ->select('MAX(pectoral)')
                ->from('#__atlete');
            $db->setQuery($query);
            $db->query();
            return max(50,intval($db->loadResult())+1); 
        }
}
