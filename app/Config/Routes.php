<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
/* $routes->get('/', 'Home::index'); */

/* Home */


/* Inicio de sesion */
$routes->get('/Login', 'Login::index');
$routes->post('/acceder', 'Login::Login');
$routes->get('/Salir', 'Login::Salir');

/* Home */
$routes->get('/Inicio', 'Inicio::index');
$routes->get('/', 'Inicio::index');
$routes->get('/home', 'Inicio::index');

/* Habitaciones */
$routes->get('/habitaciones', 'Habitacion::index');
$routes->post('/habitaciones/guardarHabitacion', 'Habitacion::guardarHabitacion');
$routes->post('/habitaciones/modificarHabitacion', 'Habitacion::modificarHabitacion');
$routes->post('/habitaciones/cambiarDisponibilidad', 'Habitacion::cambiarDisponibilidad');
$routes->post('/habitaciones/cambiarObservacion', 'Habitacion::cambiarObservacion');
$routes->post('/habitaciones/borrarHabitacion', 'Habitacion::borrarHabitacion');
$routes->post('/habitaciones/getInfo', 'Habitacion::getHabitacion');

/* Rentas */
$routes->post('rentas/rentarHabitacion', 'Rentas::rentarHabitacion');