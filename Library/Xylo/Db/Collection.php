<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Collection;


use Helpers\Helpers;

final class Collection
{
    public $_table;
    public $_fields = array();
    public $_where = array();
    public $_orderBy = array();
    public $_groupBy = array();
    public $_limit;
    public $_pageSize = 100; //default it to 100
    public $_pageNo = 1; //default it to 1
    public $_selectStmt = null;
    public $_updateStmt = null;
    public $_resultSet;
    
    final public function __construct(  $table, $fields = array(), $where = array()
                                        , $orderBy = array(), $groupBy = array(), $limit = null)
    {
        $this->_table   = $table;
        $this->_fields  = $fields;
        $this->_where   = $where;
        $this->_orderBy = $orderBy;
        $this->_groupBy = $groupBy;
        $this->_limit   = $limit;
        
        parent::Connection();
    }    
    
    final public function _buildSelect($count = false)
    {
        $this->_selectStmt = 'SELECT ';
        
        
        if(!empty($this->_fields))
        {
            $this->_selectStmt .= Helpers::commaSepratedString($this->_fields);
        }
        else if($count)
        {
            $this->_selectStmt .= 'COUNT(*)';
        }
        else 
        {
            $this->_selectStmt .= '*';
        }
        
        $this->_selectStmt .= ' FROM '.$this->_table;
        
        if(!empty($this->_where))
        {
            $this->_selectStmt .= ' WHERE '.$this->_buildWhere($this->_where);
        }
        if(!empty($this->_groupBy))
        {
            $this->_selectStmt .= ' GROUP BY '.Helpers::commaSepratedString($this->_groupBy());
        }
        if(!empty($this->_orderBy))
        {
            $this->_selectStmt .= ' ORDER BY '.Helpers::commaSepratedString($this->_orderBy());
        }
        if(strlen($this->_limit) > 0)
        {
            $this->_selectStmt .= ' LIMIT '.$this->_limit;
        }
        else
        {
            $this->_selectStmt .= ' LIMIT '.$this->_buildLimit();
        }
        
        return $this->_selectStmt;
    } 
    
    final public function _buildUpdate($fields)
    {
        
        if(is_array($fields) && !empty($fields))
        {
            $this->_updateStmt = 'UPDATE '.$this->_table.' SET ';
            
            foreach($fields as $fieldName => $fieldValue)
            {
                $this->_updateStmt .= $fieldName .' = '. $fieldValue.',';
            }
            $this->_updateStmt .= substr($this->_updateStmt, 0, strlen($this->_updateStmt) - 1);
            if(!empty($this->_where))
            {
                $this->_updateStmt .= ' WHERE '.$this->_buildWhere($this->_where);
            }
        }
        return $this->_updateStmt;
    }    
    
    final public function _buildInsert($fields)
    {
        if(is_array($fields) && !empty($fields))
        {
            $this->_insertStmt = 'INSERT INTO '.$this->_table.' (';
            foreach($fields as $fieldName => $fieldValue)
            {
                $this->_insertStmt .= $fieldName.',';
            }
            $this->_insertStmt .= substr($this->_insertStmt, 0, strlen($this->_insertStmt) - 1);
            $this->_insertStmt .= ') VALUES ';
            foreach($fields as $fieldName => $fieldValue)
            {
                $this->_insertStmt .= $fieldValue.',';
            }
            $this->_insertStmt .= substr($this->_insertStmt, 0, strlen($this->_insertStmt) - 1);
            $this->_insertStmt .= ')';
                
        }
        return $this->_insertStmt;
    }
    
    final private function _buildWhere($where)
    {
        $whereArray = null;
        $whereString = null;
        if(is_array($where))
        {
            foreach($where as $key => $value)
            {
                if($key == 'OR')
                {
                    if(is_array($value))
                    {
                        foreach($value as $k => $val)
                        {
                            if(!is_array($val))
                            {
                                $whereArray[] = '('.$k.' "'.$val.'")';
                            }
                            else
                            {
                                $whereStringOr .= $this->_buildWhere($val);
                            }
                        }
                    }
                    if(!empty($whereArray))
                    {
                        $whereString .= '('.implode(' OR ', $whereArray).')';
                    }
                }
                else
                {
                    if(is_array($value))
                    {
                        foreach($value as $k => $val)
                        {
                            if(!is_array($val))
                            {
                                $whereArray[] = '('.$k.' "'.$val.'")';
                            }
                            else
                            {
                                $whereStringAnd .= $this->_buildWhere($val);
                            }
                        }
                    }
                    if(!empty($whereArray))
                    {
                        $whereString .= '('.implode(' AND ', $whereArray).')';
                    }
                }
            }
        }
        return $whereString;
    }
    final private function _buildLimit()
    {
        $offset = ($this->_pageSize * $this->_pageNo) - $this->_pageSize;
        
        $this->_limit = $offset.','.$this->_pageSize;
        
        return $this->_limit;
    }
    final public function setPageSize($pageSize)
    {
        $this->_pageSize = $pageSize;
    }
    final public function setPageNo($pageNo)
    {
        $this->_pageNo = $pageNo;
    }
}
?>
