<?php

use components\Router;

define('ROOT', dirname(__FILE__));
require_once(ROOT . '/lib/Dev.php');
require_once(ROOT . '/vendor/autoload.php');

$router = new Router();
$router->run();
