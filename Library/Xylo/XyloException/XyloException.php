<?php

/**
 * Overriding default php exception to XyloException
 * 
 * 
 * @access      Public
 * @author      Karthik Vasudevan
 * @package     Xylo
 * @copyright   EzeeDot Ltd.
 * 
 */
namespace XyloException;


class XyloException extends Exception
{
    
    public function __construct($message, $code = 0, Exception $previous = null) 
    {
        parent::__construct($message, $code, $previous);
    }
    public function __toString() 
    {
        
    }
    
}
?>
