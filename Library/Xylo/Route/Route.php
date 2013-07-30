<?php

/**
 * Class Route
 * Helps to decode the url and sets module, controller, action 
 * 
 * @package     Xylo
 * @copyright   EzeeDot Ltd. 2012
 * @author      Karthik Vasudevan
 * @name        Route.php
 * @global      true
 * @return      void
 */
namespace Route;

final class Route
{
    
    private static $_instance;
    
    public $_actionName = 'index';
    
    public $_controllerName = 'index';
    
    public $_controllerClass = 'IndexController';
    
    public $_actionMethod = 'indexAction';


    private function __construct()
    {
        $this->_setLoaders();
    }
    
    /**
     * Singleton method for route class
     * 
     * @method  _getInstance
     * @return  instance of route
     * @access  public
     * @static  true
     */
    public static function _getInstance()
    {
        if(!self::$_instance)
        {
            self::$_instance = new Route();            
        }
        return self::$_instance;
    }
    
    
    /**
     * Break REQUEST_URI to find the controller and action
     * 
     * @method  _setLoaders
     * @return  Void
     * @access  private
     * @static  true  
     */
    
    private function _setLoaders()
    {
        // get and clean $_SERVER['REQUEST_URI']
        $requestUri = trim(strtolower(urldecode($_SERVER['REQUEST_URI'])));
        // remove slashes
        $slashRemovedRequestUri = str_replace('/', '', $requestUri);
        // if it is not root
        if(strlen($slashRemovedRequestUri) > 0) 
        {
            // check for valid characters in url
            if(preg_match('/^[a-z]+$/', $slashRemovedRequestUri))
            {
                // explode by /
                $explodeUri = explode('/', $requestUri);
                // if not empty
                if(!empty($explodeUri))
                {
                    // trim the array
                    $explodeUri = self::_trimArray($explodeUri);

                    // set controller and action
                    $this->_controllerName = $explodeUri[0];

                    $this->_actionName = $explodeUri[1];

                    $this->_controllerClass = ucfirst($explodeUri[0]).'Controller';

                    $this->_actionMethod = $explodeUri[1].'Action';
                    
                }
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
                            "for"               => "Controller"             
                        )
                );
            }
        }
    }    
    
    
    /**
     * Trim array for empty keys.
     * 
     * @method  _trimArray
     * @return  $trimmedArray
     * @access  private
     * @static  true  
     */
    private static function _trimArray($array, $trimmedArray = array())
    {
        //check if the given parameter is an array
        if(is_array($array))
        {
            //if yes loop through key value pair
            foreach($array as $key => $value)
            {
                //check if the value is again a array ~multidimentional array
                if(is_array($value))
                {
                    //if yes ittarate the value
                    $trimmedArray[] = self::_trimArray($value, $trimmedArray);
                }
                else 
                {
                    //if no check the value length is greater than 0
                    if(strlen($value) > 0)
                    {
                        //store it in a new array
                        $trimmedArray[] = trim($value);
                    }
                }
            }
        }        
        
        return $trimmedArray;
    }
}
?>
