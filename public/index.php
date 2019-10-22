<?php
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

// Route with N get parameters
$app->get('/api[/{params:.*}]', 'Src\Controllers\ParamsController:author');

$app->run();