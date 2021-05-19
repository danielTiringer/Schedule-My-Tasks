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
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

// HomeController
$routes->get('/home', 'Home::index', ['filter' => 'auth']);

// UsersController
$routes->match(['GET', 'POST'], '/login', 'UsersController::login', ['filter' => 'noauth']);
$routes->get('/logout', 'UsersController::logout');
$routes->match(['GET', 'POST'], '/register', 'UsersController::register', ['filter' => 'noauth']);
$routes->match(['GET', 'POST'], '/profile', 'UsersController::profile', ['filter' => 'auth']);

// TodosController
$routes->group('todos', ['filter' => 'auth'], function($routes)
{
	$routes->match(['GET', 'POST'], '/', 'TodosController::index');
	$routes->match(['GET', 'PUT'], '(:num)', 'TodosController::edit/$1');
	$routes->delete('(:num)', 'TodosController::destroy/$1');
});

// DailyTasksController
$routes->get('/', 'DailyTasksController::index', ['filter' => 'auth']);
$routes->group('tasks', ['filter' => 'auth'], function($routes)
{
	$routes->put('(:num)/progress', 'DailyTasksController::progress');
	$routes->put('(:num)/complete', 'DailyTasksController::complete');
	$routes->delete('(:num)', 'DailyTasksController::delete');
});
$routes->cli('/dailytasks/generate', 'DailyTasksController::generate');

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
