<?php

/**
 * Main index.php file.
 * .htaccess will forward all requests and response to here
 * Required objects are instantiated according to the requests received
 * Not a class or method
 * No Namespace required 
 * 
 * @access      Global
 * @copyright   EzeeDot Ltd. 2012
 * @return      Void
 * @author      Karthik Vasudevan
 * @global      index.php
 */

// Set global variable for application path
define("APPLICATION_PATH", realpath(dirname(__FILE__) . "/../Application/"));

// Set global variable for application environment
define("APPLICATION_ENV", "development");

set_include_path(
    realpath(dirname(__FILE__) . "/../Library/") . PATH_SEPARATOR . get_include_path()
);

require_once 'Xylo/Assembler.php';

use Assembler\Assembler;

Assembler::_getInstance();

exit();
?>
