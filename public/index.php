<?php

use app\routes\Router;
use app\helpers\ConfigHelper;

require_once '../vendor/autoload.php';

// Define as constantes necessárias para o funcionamento do sistema
ConfigHelper::defineConstants();

Router::execute();