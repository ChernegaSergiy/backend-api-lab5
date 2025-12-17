<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once __DIR__ . '/../src/Router/Router.php';
require_once __DIR__ . '/../src/Controller/CountryController.php';

use App\Router\Router;
use App\Controller\CountryController;

$router = new Router();

$router->get('/mycountries/v1.1/getcountrieslist', [CountryController::class, 'list']);
$router->get('/mycountries/v1.1/getcountry/{alias}', [CountryController::class, 'show']);

$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);

