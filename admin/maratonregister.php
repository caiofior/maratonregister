<?php
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @version 1.2
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import joomla controller library
jimport('joomla.application.component.controller');

// Get an instance of the controller prefixed by MaratonRegister
$controller = JController::getInstance('MaratonRegister');

// Perform the Request task
$controller->execute(JRequest::getCmd('task'));

// Redirect if set by the controller
$controller->redirect();
