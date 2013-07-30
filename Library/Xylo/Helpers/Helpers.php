<?php
/**
 * Class Helpers
 * Important functions helps to overall project
 * 
 * @package     Xylo
 * @copyright   EzeeDot Ltd. 2012
 * @author      Karthik Vasudevan
 * @name        Helpers.php
 * @global      true
 * @return      void
 */

namespace Helpers;

class Helpers
{
    final public function __construct()
    {
        //do nothing
    }  
    final public static function commaSepratedString(array $array)
    {
        $string = null;
        if(is_array($array))
        {
            $string = implode(',', $array);
            $string = (strlen($string) > 0)? substr($string, 0, strlen($string) - 1) : $string;
        }
        return $string;
    }
}
?>
