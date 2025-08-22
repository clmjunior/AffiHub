<?php

namespace app\controllers;

use League\Plates\Engine;
use app\database\DBQuery;

abstract class Controller
{
     public $db;

    public function __construct()
    {
        $this->db = new DBQuery;
    }


    protected function view(string $view, array $data = [])
    {
        $pathViews = dirname(__FILE__, 2) . DIRECTORY_SEPARATOR . 'views' ;
        $templates = new Engine($pathViews);
        echo $templates->render($view, $data);
    }
}
