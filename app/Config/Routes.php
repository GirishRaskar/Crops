<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'CropController::index');

$routes->get('/api', 'CropController::test_upag_api');
