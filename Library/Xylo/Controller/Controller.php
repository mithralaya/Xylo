<?php

/**
 * Class Controller
 * Helps to load 
 * 
 * @package     Xylo
 * @copyright   EzeeDot Ltd. 2012
 * @author      Karthik Vasudevan
 * @name        Controller.php
 * @global      true
 * @return      void
 */
namespace Controller;

use Autoloader\Autoloader;

use Route\Route;
use Config\Config;
use Helpers\Helpers;

abstract class Controller
{
    
    public $_body;
       
    public $_route;
    
    abstract public function indexAction();
    
    final public function __construct()
    {
        $this->_body = new \stdClass();
        Autoloader::_getInstance();
                
        $this->_route = Route::_getInstance();      
        
    }
    /**
     * Singleton method for controller class
     * 
     * @method  _getInstance
     * @return  instance of controller
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
    
    public function _postDispatch()
    {
        if(!empty($this->_body))
        {  
            header('Content-type: application/json');
            
            echo json_encode($this->_body, true);
        }
    }
    
}
?>
