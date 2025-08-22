<?php

namespace app\controllers\config;

class ConsoleController extends ConfigController
{
    public function indexQueue()
    { 
        $this->view('queue', ['title' => 'Filas', 'name' => 'queue']);
    }

    public function indexLog()
    { 
        $this->view('log', ['title' => 'Logs', 'name' => 'log']);
    }
}
