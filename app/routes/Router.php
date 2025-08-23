<?php

namespace app\routes;

use app\helpers\routing\Request;
use app\helpers\routing\Uri;
use Exception;

class Router
{
    public const CONTROLLER_NAMESPACE = 'app\\controllers';
    private const API_ROUTE_PREFIX = '/api';


    public static function load(string $controller, string $method)
    {
        try {
            // verificar se o controller existe
            $controllerNamespace = self::CONTROLLER_NAMESPACE . '\\' . $controller;
            if (!class_exists($controllerNamespace)) {
                throw new Exception("O Controller {$controller} não existe");
            }

            $controllerInstance = new $controllerNamespace;

            if (!method_exists($controllerInstance, $method)) {
                throw new Exception("O método {$method} não existe no Controller {$controller}");
            }

            // Captura os dados JSON corretamente (se houver)
            $inputRaw = file_get_contents('php://input');
            $contentType = $_SERVER['CONTENT_TYPE'] ?? '';

            // Se for JSON, decodifica
            if (stripos($contentType, 'application/json') !== false) {
                $inputData = json_decode($inputRaw, true);
            } else {
                // fallback para formulário
                $inputData = $_REQUEST;
            }

            $controllerInstance->$method((object) $inputData);



        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }

    public static function routes(): array
    {
        return [
            'get' => [
                '/' => fn () => self::load('catalog\\CatalogController', 'index'),
                '/admin' => fn () => self::load('HomeController', 'index'),
                '/monitoramento-filas' => fn () => self::load('config\\ConsoleController', 'indexQueue'),
                '/acompanhamento-logs' => fn () => self::load('config\\ConsoleController', 'indexLog'),
                '/acesso-marketplace' => fn () => self::load('config\\MarketplaceController', 'indexAccounts'),
                '/usuarios' => fn () => self::load('UserController', 'indexUsers'),
                
                '/produtos' => fn () => self::load('ProductController', 'indexProduct'),
                
                
                self::API_ROUTE_PREFIX.'/products/get' => fn () => self::load('api\\products\\ProductApiController', 'getProducts'),
                
            ],
            
            'post' => [
                self::API_ROUTE_PREFIX.'/products/create' => fn () => self::load('api\\products\\ProductApiController', 'createProduct'),
                self::API_ROUTE_PREFIX.'/products/img/create' => fn () => self::load('api\\products\\ProductApiController', 'createImages'),
                
            ],
            
            'put' => [
                self::API_ROUTE_PREFIX.'/products/update' => fn () => self::load('api\\products\\ProductApiController', 'updateProduct'),
                self::API_ROUTE_PREFIX.'/products/update_prices' => fn () => self::load('api\\products\\ProductApiController', 'updatePrices'),
                self::API_ROUTE_PREFIX.'/products/update_stocks' => fn () => self::load('api\\products\\ProductApiController', 'updateStocks'),
                
                self::API_ROUTE_PREFIX.'/products/img/update' => fn () => self::load('api\\products\\ProductApiController', 'updateImages'),

            ],

            'delete' => [

            ],
        ] ;
    }


    public static function execute()
    {
        try {
            $routes = self::routes();
            $request = Request::get();
            $uri = Uri::get('path');

            if (!isset($routes[$request])) {
                throw new Exception('A rota não existe');
            }

            if (!array_key_exists($uri, $routes[$request])) {
                throw new Exception('A rota não existe');
            }

            $router = $routes[$request][$uri];

            if (!is_callable($router)) {
                throw new Exception("Route {$uri} is not callable");
            }

            $router();
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }
}
