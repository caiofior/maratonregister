<?php
/**
 * Maraton Register Table
 * @author Claudio Fior <caiofior@gmail.com>
 * @version 0.10
 */
// No direct access
defined('_JEXEC') or die('Restricted access');
 
// import Joomla table library
jimport('joomla.database.table');
 
/**
 * Maraton Register Table
 * @author Claudio Fior <caiofior@gmail.com>
 * @version 0.10
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
}
