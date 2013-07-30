<?php
namespace Model;

use Collection\Collection;
use Connection\Connection;
use Object\Object;
use Helpers\Helpers;

class Model extends Connection
{
    public $_table;
    public $_identifierFields; // Comes as comma seprated format
    
    private $_insertRequire = true;
    private $_collection;
    
    public function __construct($table, $fields = array(), $where = array()
                                , $orderBy = array(), $groupBy = array(), $limit = null)
    {
        require_once APPLICATION_PATH.'Model/'.$this->_table.'.php';
        
        $instanceOfTable = new $this->_table();
        
        
        foreach(explode(',', $this->_identifierFields) as $identifierField)
        {
            if(isset($instanceOfTable->{$identifierField}))
            {
                $this->_insertRequire = false;
                break;
            }
        }
        
        $this->_collection = new Collection($table, $fields, $where, $orderBy, $groupBy, $limit);
    }
    
    public function getSize()
    {
        $selectStmt = $this->_collection->_buildSelect(false, true);
        return $this->_executeSelect($selectStmt);
    }
    
    public function getItems()
    {
        $selectStmt = $this->_collection->_buildSelect(false, false);
        $this->_executeSelect($selectStmt);
    }
    public function getFirstItem()
    {
        $selectStmt = $this->_collection->_buildSelect(false, false);
        $this->_executeSelect($selectStmt);
    }
    final public function save()
    {
        if($this->_insertRequire)
        {
            $insertStmt = $this->_collection->_buildInsert();
            $this->_executeInsert($insertStmt);
        }
        else
        {
            $updateStmt = $this->_collection->_buildUpdate();
            $this->_executeUpdate($insertStmt);
        }
        
    }
}
?>
