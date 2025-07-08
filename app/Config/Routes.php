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
$routes->get('/Inicio', 'Inicio::index', ['filter' => 'authGuard:admin,editor,consulta']);
$routes->get('/', 'Inicio::index', ['filter' => 'authGuard:admin,editor,consulta']);
$routes->get('/home', 'Inicio::index', ['filter' => 'authGuard:admin,editor,consulta']);

/* Habitaciones */
$routes->group('habitaciones', ['filter' => 'authGuard:admin,editor,consulta'], function ($routes) {
    $routes->get('', 'Habitacion::index');
    $routes->post('guardarHabitacion', 'Habitacion::guardarHabitacion');
    $routes->post('modificarHabitacion', 'Habitacion::modificarHabitacion');
    $routes->post('cambiarDisponibilidad', 'Habitacion::cambiarDisponibilidad');
    $routes->post('cambiarObservacion', 'Habitacion::cambiarObservacion');
    $routes->post('borrarHabitacion', 'Habitacion::borrarHabitacion');
    $routes->post('getInfo', 'Habitacion::getHabitacion');
});

/* Rentas */
$routes->group('rentas', ['filter' => 'authGuard:admin,editor,consulta,revision'], function ($routes) {
    $routes->get('', 'Rentas::index');
    $routes->post('rentarHabitacion', 'Rentas::rentarHabitacion');
    $routes->post('getRentas', 'Rentas::getRentas');
    $routes->post('continuarReservacion', 'Rentas::continuarReservacion');
});

/* Reservaciones */
$routes->group('reservaciones', ['filter' => 'authGuard:admin,editor,consulta'], function ($routes) {
    $routes->get('', 'Reservaciones::index');
    $routes->post('getReservaciones', 'Reservaciones::getReservaciones');
    $routes->post('reservar', 'Reservaciones::guardarReservacion');
    $routes->post('cancelacion', 'Reservaciones::cancelar');
    $routes->post('getInfo', 'Reservaciones::getInfo');
    $routes->post('getPorHabitacion', 'Reservaciones::getPorHabitacion');
});

/* REPORTES EXCEL Y PDF */
$routes->group('reportes', ['filter' => 'authGuard:admin,editor,consulta'], function ($routes) {
    $routes->get('reservaciones', 'Reportes::excelReservaciones');
    $routes->get('rentas', 'Reportes::excelRentas');
});

/* USUARIOS */

$routes->group('usuarios', ['filter' => 'authGuard:admin'], function ($routes) {
    $routes->get('show', 'Usuarios::show');
    $routes->post('getUsuarios', 'Usuarios::getUsuarios');
});
