<?php

/**
 * Initialise config files and make them available throught out the application
 * Constructor takes $fileName as the input to decode the ini file.
 * Sets the parameters and return nothing
 * 
 * Default config file Config.ini
 * @package     Xylo\Config
 * @copyright   EzeeDot Ltd. 2012
 * @author      Karthik Vasudevan
 * @name        Config.php
 * @param       $fileName
 * @global      true
 * @return      void
 */

namespace Config;

final class Config
{
    private static $_instance;
    
    private $_fileName;
        
    public $_data;
    
    private static $_defaultEnv = "production";
    
    private function __construct($fileName)
    {
        $this->_fileName = $fileName;
        $filePath = APPLICATION_PATH.'/Config/'.$this->_fileName;
        
        if(file_exists($filePath))
        {
            $config = parse_ini_file($filePath, true, INI_SCANNER_NORMAL);
            
            if(!empty($config))
            {
                //Set default enviro settings
                foreach($config[self::_defaultEnv] as $configKeys => $configValues)
                {
                    $lowerKey = strtolower(trim($configKeys));
                    $this->{$lowerKey} = $configValues;
                }
                //Override the current enviro settings
                if('production' != APPLICATION_ENV)
                {
                    foreach($config[APPLICATION_ENV] as $configKeys => $configValues)
                    {
                        $lowerKey = strtolower(trim($configKeys));
                        $this->{$lowerKey} = $configValues;
                    }
                }
            }
            else 
            {
                trigger_error($this->_fileName." config file is empty", E_USER_ERROR);
            }
        }
        else
        {
            trigger_error($this->_fileName." config file cannot be found", E_USER_ERROR);
        }
    }
    /**
     * Singleton method for config class
     * 
     * @method  _getInstance
     * @return  instance of config
     * @access  public
     * @static  true
     * @param   $fileName //default Config.ini
     */
    final public static function _getInstance($fileName = 'Config.ini')
    {
        if(!self::$_instance)
        {
            self::$_instance = new Config($fileName);            
        }
        return self::$_instance;
    }
    /**
     * Overloading methods for config class
     * 
     * @method      __set
     * @return      void
     * @access      private
     * @param       $name, $value
     */
    public function __set($name, $value)
    {
        $this->_data[$name] = $value;
    }
    /**
     * Overloading methods for config class
     * @method      __get
     * @return      $_data
     * @access      public
     * @param       $name
     */
    public function __get($name)
    {
        if(array_key_exists($name, $this->_data))
        {
            return $this->_data[$name];
        }
        else
        {
            trigger_error("Could not find the config variable that you are looking for.", E_USER_WARNING);
        }
    }
    
    /**
     *  
     */
    
}

?>
