<?php

/*
 * MySQL Connection Adaptor 
 * Helps connect to mysql using mysql driver
 * Checks for the connection else through the error
 * The class can only extended and cannot be instantiated
 * The class is intended to use only within the Xylo library
 * The __constructor returns the resource or viod according to the select, update, insert command.
 * Delete command cannot be executed as deleting records through Xylo is prohibited
 * The methods are private and cannot be accessed outside of the instantiation.
 * the methods are final and cannot be overridden 
 * 
 * @package     Xylo
 * @access      protected
 * @copyright   EzeeDot Ltd. 2012
 * @return      void/resourceId
 * @author      Karthik Vasudevan
 *  
 */
namespace Connection;

use Config\Config;
class Connection extends Config
{
    /**
     * $_connection holds the mysql connection intance
     *  
     * @var     MySql Connection 
     * @access  private
     * @name    _connection
     *  
     */
    private $_connection;
    
    final protected function __construct()
    {
        if(isset($this->{'DB_MYSQL_HOST'}) && isset($this->{'DB_MYSQL_DBUSER'}) && isset($this->{'DB_MYSQL_DBPASS'}))
        {
            $this->_connection = mysql_connect($this->{'DB_MYSQL_HOST'}, $this->{'DB_MYSQL_DBUSER'}, $this->{'DB_MYSQL_DBPASS'});

            if(!$this->_connection)
            {
                trigger_error('Cound not connect to MySQL Server. MySql Server Says:'.  mysql_error());
            }
            else
            {
                mysql_select_db($this->{'DB_MYSQL_DBNAME'}, $this->_connection);
            }
        }
    }
    
    final protected function _executeSelect($_sql)
    {
        $_result = mysql_query($_sql);
        if(!$_result)
        {            
            throw new XyloExecption
            (
                    array
                    (
                        "httpStatusCode"    => "500",
                        "title"             => "Select Query Execution Error",
                        "classMessage"      => mysql_error(),
                        "for"               => $_sql                
                    )
            );
        }
        else
        {
            return $_result;
        }        
    }
    
    final protected function _executeInsert($_sql)
    {
        $_result = mysql_query($_sql);
        if(!$_result)
        {            
            throw new XyloExecption
            (
                    array
                    (
                        "httpStatusCode"    => "500",
                        "title"             => "Insert Query Execution Error",
                        "classMessage"      => mysql_error(),
                        "for"               => $_sql                
                    )
            );
        }
        else 
        {
            return mysql_insert_id();
        }
    }   
    
    
    final protected function _executeUpdate($_sql)
    {
        $_result = mysql_query($_sql);
        if(!$_result)
        {            
            throw new XyloExecption
            (
                    array
                    (
                        "httpStatusCode"    => "500",
                        "title"             => "Update Query Execution Error",
                        "classMessage"      => mysql_error(),
                        "for"               => $_sql                
                    )
            );
        }
    }
    
    final protected function __destruct()
    {    
        mysql_close($this->_connection);
    }
}
?>
