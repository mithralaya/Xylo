<?php

use Controller\Controller;
use Helpers\Helpers;

final class ErrorController extends Controller
{
    public function indexAction()
    {
        var_dump(headers_list());
    }
}
?>
