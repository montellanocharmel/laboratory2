<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/', 'Home::index');
$routes->get('/music', 'MusicController::montellano');
$routes->get('/music/(:any)', 'MusicController::music/$1');
$routes->post('/save', 'MusicController::save');