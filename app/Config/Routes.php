<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->post('sign-in', 'AuthController::signIn');
$routes->post('sign-up', 'AuthController::signUp');
$routes->get('sign-out', 'AuthController::signOut');

$routes->get('time-off/show-me', 'TimeOff::showMe');
$routes->post('time-off/request', 'TimeOff::request');
$routes->post('time-off/update', 'TimeOff::update');
$routes->post('time-off/delete', 'TimeOff::delete');
$routes->post('time-off/cancel', 'TimeOff::cancel');

$routes->post('profile/change-password', 'Profile::index');

$routes->get('verifiator/time-off', 'Verifiator::index');
$routes->post('verifiator/update-time-off', 'Verifiator::updateTimeOff');

$routes->get('admin/user', 'Admin::user');
$routes->post('admin/add-verifikator', 'Admin::addVerifikator');
$routes->post('admin/change-role', 'Admin::changeRole');
$routes->post('admin/change-password-user', 'Admin::changePasswordUser');
