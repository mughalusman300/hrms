<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * ------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Login::index');
$routes->get('my',  'Api::myview');
$routes->get('d2m', 'Api::server_to_mob');
$routes->get('m2d', 'Api::mob_to_server');
$routes->get('m2u', 'Api::update');
$routes->post('create', 'User::store');
$routes->post('User/update/(:id)', 'User::update/$1');
$routes->get('users', 'User::index');
// $routes->get('login', 'Login::index');
$routes->post('create', 'User::store');
$routes->get('addemployee', 'Employee::add');
$routes->get('detail/(:num)', 'Employee::detail/$1');
$routes->get('update/(:num)', 'Employee::updateview/$1');
$routes->get('getAllEmployees', 'Employee::getAllEmployees');

$routes->get('getEmployee/(:num)', 'Employee::getEmployee/$1');
$routes->post('updateEmployee', 'Employee::updateEmployee');
$routes->get('search', 'Employee::search');
$routes->get('employee', 'Employee::index');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
