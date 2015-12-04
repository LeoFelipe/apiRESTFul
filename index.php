<?php
// Habilitando erros
ini_set('display_errors', 'on');

// Constantes
define('DS', DIRECTORY_SEPARATOR);
define('RESOURCES', DS .'resources');
define('CONFIG', DS .'src/config');

/* Autoload Composer */
require_once 'vendor/autoload.php';

// Doctrine & Serializer
require_once 'bootstrap.php';

$URIFull = !empty($_SERVER['REQUEST_URI']) ? str_replace("/apiRESTFul/", '', $_SERVER['REQUEST_URI']) : 'classificados';
\Api\Helpers\URIHelper::run($URIFull);

if (file_exists(__DIR__ . RESOURCES . DS . \Api\Helpers\URIHelper::$resource . '.php')) {
    require_once RESOURCES . DS . \Api\Helpers\URIHelper::$resource . '.php';
    $app->run();
} else
    echo '<hr>Oopsss! Servico nao encontrado.';