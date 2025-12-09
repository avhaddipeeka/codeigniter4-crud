<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// List users
$routes->get('/', 'Users::index');
$routes->get('users', 'Users::index');

// Create form
$routes->get('users/create', 'Users::create');

// Store (POST)
$routes->post('users/store', 'Users::store');

// Edit
$routes->get('users/edit/(:num)', 'Users::edit/$1');

// Update (POST or PUT)
$routes->post('users/update/(:num)', 'Users::update/$1');

// Delete
$routes->post('users/delete/(:num)', 'Users::delete/$1');
