<?php

namespace app\controllers\catalog;

use app\controllers\Controller;

class LoginController extends Controller
{
    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
                
        $this->view('catalog/login', ['title' => 'Entrar', 'name' => 'login']);
    }
}
