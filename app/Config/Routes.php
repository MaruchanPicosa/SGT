<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::login');
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Auth');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();

$routes->setAutoRoute(true);

$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::login');
$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::register');
$routes->get('/dashboard', 'Auth::dashboard');
$routes->get('/logout', 'Auth::logout');
$routes->post('crear_usuario', 'Auth::crear_usuario');
$routes->get('tickets', 'Auth::tickets');
$routes->post('crear_ticket', 'Auth::crear_ticket');
$routes->get('ver_ticket/(:segment)', 'Auth::ver_ticket/$1');
$routes->post('ver_ticket/(:segment)', 'Auth::ver_ticket/$1');
$routes->get('registrar/', 'Auth::register');