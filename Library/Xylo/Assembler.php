<?php

/**
 * Class Assembler
 * Asssembles the right controller and right action to present to the user.
 * uses route and controller classes
 * Helps to load 
 * 
 * @package     Xylo
 * @copyright   EzeeDot Ltd. 2012
 * @author      Karthik Vasudevan
 * @name        Autoloader.php
 * @global      true
 * @return      void
 */
namespace Assembler;

require_once 'Xylo\Autoloader.php';
use Autoloader\Autoloader;

use Route\Route;
use Controller\Controller;
use XyloException\XyloException;

final class Assembler
{
    private static $_instance;
    
    private function __construct()
    {
        $this->_unset();
        
        $autoloader = Autoloader::_getInstance();
        
        $route = Route::_getInstance();
        if(class_exists($route->_controllerClass))
        {
            $currentController = new $route->_controllerClass();

            $currentController->{$route->_actionMethod}();            
            
        }
        else
        {
            // throw exception
            throw new XyloExecption
            (
                    array
                    (
                        "httpStatusCode"    => "404",
                        "title"             => "Request Not Found",
                        "classMessage"      => mysql_error(),
                        "for"               => "Controller - ".$route->_controllerName." Action - ".$route->_actionName
                    )
            );
        }
        Controller::_postDispatch();
    }
    
    /**
     * Singleton method for assembler class
     * 
     * @method  _getInstance
     * @return  instance of assembler
     * @access  public
     * @static  true
     * @param   $fileName //default Config.ini
     */
    public static function _getInstance()
    {
        if(!self::$_instance)
        {
            self::$_instance = new Assembler();            
        }
        return self::$_instance;
    }
    
    private function _unset()
    {
        unset($_GET);
        unset($_SESSION);
    }
}
?>
