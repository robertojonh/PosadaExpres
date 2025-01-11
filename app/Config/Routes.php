<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
/* $routes->get('/', 'Home::index'); */

/* Home */
$routes->get('/', 'InicioController::index');
$routes->get('/home', 'InicioController::index');

/* Inicio de sesion */
$routes->get('/Login', 'LoginController::index');
$routes->post('/acceder', 'LoginController::Login');
$routes->get('/Salir', 'LoginController::Salir');
$routes->get('/Inicio', 'InicioController::index');

/* Habitaciones */
$routes->get('/habitaciones', 'HabitacionController::index');
$routes->post('/habitaciones/guardarHabitacion', 'HabitacionController::guardarHabitacion');
$routes->post('/habitaciones/modificarHabitacion', 'HabitacionController::modificarHabitacion');
$routes->post('/habitaciones/cambiarDisponibilidad', 'HabitacionController::cambiarDisponibilidad');
$routes->post('/habitaciones/cambiarObservacion', 'HabitacionController::cambiarObservacion');
$routes->post('/habitaciones/borrarHabitacion', 'HabitacionController::borrarHabitacion');
$routes->post('/habitaciones/getInfo', 'HabitacionController::getHabitacion');