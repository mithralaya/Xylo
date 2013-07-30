<?php

use Controller\Controller;
use Helpers\Helpers;

final class IndexController extends Controller
{
    public function indexAction()
    {
        $this->_body->indexController = 'Welcome to Xylo API framework for PHP';
    }
    
}
?>
