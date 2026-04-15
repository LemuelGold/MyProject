<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::login');
$routes->get('auth/login', 'Auth::login');
$routes->post('auth/authenticate', 'Auth::authenticate');
$routes->get('auth/logout', 'Auth::logout');
$routes->get('auth/register', 'Auth::register');

// Dashboard — single route, role-aware view
$routes->get('dashboard', 'Admin::index');

// Admin & Secretary shared routes (guards inside controller)
$routes->get('admin', 'Admin::index');
$routes->get('admin/conferences', 'Admin::conferences');
$routes->post('admin/conferences/save', 'Admin::saveConference');
$routes->get('admin/conference-records', 'Admin::conferenceRecords');
$routes->get('admin/student-violation', 'Admin::studentViolation');
$routes->post('admin/student-violation/save', 'Admin::saveStudentViolation');
$routes->get('admin/violation-records', 'Admin::violationRecords');
$routes->post('admin/violation-records/update', 'Admin::updateViolationRecord');

// Admin only
$routes->get('admin/user-management', 'Admin::userManagement');
$routes->post('admin/user-management/save', 'Admin::saveUser');
$routes->post('admin/user-management/update', 'Admin::updateUser');
$routes->post('admin/user-management/delete', 'Admin::deleteUser');

$routes->get('secretary', 'Admin::index');
$routes->get('secretary/conferences', 'Admin::conferences');
$routes->post('secretary/conferences/save', 'Admin::saveConference');
$routes->get('secretary/conference-records', 'Admin::conferenceRecords');
$routes->get('secretary/student-violation', 'Admin::studentViolation');
$routes->post('secretary/student-violation/save', 'Admin::saveStudentViolation');
$routes->get('secretary/violation-records', 'Admin::violationRecords');
$routes->post('secretary/violation-records/update', 'Admin::updateViolationRecord');
