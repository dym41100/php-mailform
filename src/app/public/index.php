<?php

require_once dirname(__DIR__) . '/core/Router.php';
require_once dirname(__DIR__) . '/core/Session.php';
require_once dirname(__DIR__) . '/controllers/FormController.php';
require_once dirname(__DIR__) . '/models/FormModel.php';

use App\Core\Router;

$router = new Router();
$router->run();
