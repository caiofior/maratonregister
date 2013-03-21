<?php
/**
 * Fidal Table
 * @author Claudio Fior <caiofior@gmail.com>
 * @version 0.4
 */
// No direct access
defined('_JEXEC') or die('Restricted access');
 
// import Joomla table library
jimport('joomla.database.table');
 
/**
 * Fidal Table
 * @author Claudio Fior <caiofior@gmail.com>
 * @version 0.4
 */
class MaratonRegisterTableFidal extends JTable
{
        /**
         * Constructor
         *
         * @param object Database connector object
         */
        function __construct(&$db) 
        {
                parent::__construct('#__fidal_fella', 'num_tes', $db);
        }
        
}
