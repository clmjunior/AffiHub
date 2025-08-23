<?php

namespace app\controllers\catalog;

use app\controllers\Controller;

class CatalogController extends Controller
{
    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
                
        $this->view('catalog', ['title' => 'Catálogo', 'name' => 'catalog']);
    }
}
