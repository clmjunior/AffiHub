<?php

namespace app\helpers;


class ConfigHelper
{
    private static $envLoaded = false;

    public static function loadEnv()
    {
        if (self::$envLoaded) return;
        self::$envLoaded = true;

        $pathEnv = BASE_PATH . DIRECTORY_SEPARATOR . '.env';

        if (!file_exists($pathEnv)) {
            throw new \Exception(".env file not found at path: $pathEnv");
        }

        $lines = file($pathEnv, flags: FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (str_starts_with(trim($line), '#') || !str_contains($line, '=')) continue;

            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);

            if (!array_key_exists($key, $_ENV)) {
                putenv("$key=$value");
                $_ENV[$key] = $value;
                $_SERVER[$key] = $value;
            }
        }
    }

    public static function defineConstants()
    {
        // Diretorio root do programa
        define('BASE_PATH', dirname(dirname(__DIR__)));

        self::loadEnv();

        // Caminhos absolutos no servidor (para salvar os arquivos)
        define('IMG_PATH_ORIGINAL', BASE_PATH . '/' . getenv('IMG_PATH_ORIGINAL'));
        define('IMG_PATH_1300', BASE_PATH . '/' . getenv('IMG_PATH_1300'));
        define('IMG_PATH_0800', BASE_PATH . '/' . getenv('IMG_PATH_0800'));
        define('IMG_PATH_0200', BASE_PATH . '/' . getenv('IMG_PATH_0200'));

        // URLs públicas para exibir as imagens
        define('IMG_HOST_ORIGINAL', getenv('IMG_HOST_ORIGINAL'));
        define('IMG_HOST_1300', getenv('IMG_HOST_1300'));
        define('IMG_HOST_0800', getenv('IMG_HOST_0800'));
        define('IMG_HOST_0200', getenv('IMG_HOST_0200'));

        // Cria as pastas se não existirem
        self::createImageDirectories();
    }

    
    public static function createImageDirectories()
    {
        $paths = [
            BASE_PATH.DIRECTORY_SEPARATOR.getenv('IMG_PATH_ORIGINAL'),
            BASE_PATH.DIRECTORY_SEPARATOR.getenv('IMG_PATH_1300'),
            BASE_PATH.DIRECTORY_SEPARATOR.getenv('IMG_PATH_0800'),
            BASE_PATH.DIRECTORY_SEPARATOR.getenv('IMG_PATH_0200'),
        ];

        foreach ($paths as $path) {

            if (!is_dir($path)) {
                mkdir($path, 0755, true);
            }
        
        }
    }


}