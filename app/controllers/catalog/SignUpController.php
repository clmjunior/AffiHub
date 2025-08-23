<?php

namespace app\controllers\catalog;

use app\controllers\Controller;

class SignUpController extends Controller
{
    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
                
        $this->view('catalog/signup', ['title' => 'Registre-se', 'name' => 'signup']);
    }
}
