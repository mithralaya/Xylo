<?php

/**
 * Class Autoloader 
 * Helps to include files which are getting instantiated as classes in other classes. 
 * 
 * @package     Xylo
 * @copyright   EzeeDot Ltd. 2012
 * @author      Karthik Vasudevan
 * @name        Autoloader.php
 * @param       $className
 * @global      true
 * @return      void
 */

namespace Autoloader;

final class Autoloader
{
    private static $_instance;
    
    private $_libraries;
    
    private function __construct(){
        $globalLibrary = explode(';', get_include_path());
        
        $files = glob($globalLibrary[0].'\\' . "*", GLOB_BRACE);
        
        $this->_libraries = self::_getDirNames($files);
        
        //Load Model
        spl_autoload_register(array($this,'_model'));
        //Load Controller
        spl_autoload_register(array($this,'_controller'));
        //Load Library
        spl_autoload_register(array($this,'_library'));
    }
    
    /**
     * Singleton method for autoloader class
     * 
     * @method  _getInstance
     * @return  instance of autoloader
     * @access  public
     * @static  true
     * @param   $fileName
     */
    public static function _getInstance($className = null, $lib = 'Xylo')
    {
        if(!self::$_instance)
        {
            self::$_instance = new Autoloader($lib, $className);            
        }
        return self::$_instance;
    }
    
    /**
     * Class loader for Library file structure
     * 
     * @method  _library
     * @return  void
     * @access  private
     * @static  false
     * @param   $class
     */
    private function _library($class)
    {
        foreach($this->_libraries as $libs)
        {
            set_include_path($libs.'/'.$class.'/');
            spl_autoload_extensions('.php');
            spl_autoload($class);
        }
    }
    
    /**
     * Class loader for Controller file structure
     * 
     * @method  _controller
     * @return  void
     * @access  private
     * @static  false
     * @param   $class //default Config.ini
     */
    private function _controller($class)
    {        
        set_include_path(APPLICATION_PATH.'/Controller/');
        spl_autoload_extensions('.php');
        spl_autoload($class);
    }
    
    /**
     * Class loader for Model file structure
     * 
     * @method  _model
     * @return  void
     * @access  private
     * @static  false
     * @param   $class
     */
    private function _model($class)
    {
        set_include_path(get_include_path().PATH_SEPARATOR.'/Application/Model/');
        spl_autoload_extensions('.php');
        spl_autoload($class);
    }
    
    /**
     * Helps to get all the directory name without full path after 
     * converting to glob
     * 
     * @method  _getDirNames
     * @return  void
     * @access  private
     * @static  true
     * @param   $array, $dirNames = array()
     */
    private static function _getDirNames($array, $dirNames = array())
    {
        //check if the given parameter is an array
        if(is_array($array))
        {
            //if yes loop through key value pair
            foreach($array as $key => $value)
            {
                //check if the given path is a directory
                if(is_dir($value))
                {
                    $explodeDirs = explode('/', $value);
                    if(count($explodeDirs) == 1)
                    {
                        $explodeDirs = explode('\\', $value);
                    }
                    
                    $dirNames[] = end($explodeDirs);
                }
                //check if the value is again a array ~multidimentional array
                else if(is_array($value, $dirNames))
                {
                    $dirNames[] = self::_getDirNames($value, $dirNames);
                }
                else 
                {
                    //do nothing
                }
            }
        }
        return $dirNames;
    }

}
?>
