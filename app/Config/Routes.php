<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::login');
$routes->get('auth/login', 'Auth::login');
$routes->post('auth/authenticate', 'Auth::authenticate');
$routes->get('auth/register', 'Auth::register');

// Admin routes
$routes->get('admin', 'Admin::index');
$routes->get('admin/conferences', 'Admin::conferences');
$routes->get('admin/conference-records', 'Admin::conferenceRecords');
$routes->get('admin/student-violation', 'Admin::studentViolation');
$routes->get('admin/violation-records', 'Admin::violationRecords');
