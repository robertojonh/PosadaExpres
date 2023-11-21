<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
/* $routes->get('/', 'Home::index'); */
$routes->get('/', 'InicioController::index');
$routes->get('/Login', 'LoginController::index');
$routes->post('/acceder', 'LoginController::Login');
$routes->get('/Salir', 'LoginController::Salir');
$routes->get('/Inicio', 'InicioController::index');