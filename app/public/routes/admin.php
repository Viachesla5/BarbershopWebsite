<?php

require_once(__DIR__ . '/../controllers/AdminController.php');

// Dashboard
Route::add('/admin', function () {
    $adminController = new AdminController();
    $adminController->dashboard();
}, 'get');

// USERS
Route::add('/admin/users', function () {
    $adminController = new AdminController();
    $adminController->listUsers();
}, 'get');

Route::add('/admin/users/show/([0-9]*)', function ($id) {
    $adminController = new AdminController();
    $adminController->showUser($id);
}, 'get');

Route::add('/admin/users/create', function () {
    $adminController = new AdminController();
    $adminController->createUser();
}, ['get', 'post']);

Route::add('/admin/users/edit/([0-9]*)', function ($id) {
    $adminController = new AdminController();
    $adminController->editUser($id);
}, ['get', 'post']);

Route::add('/admin/users/uploadPicture/([0-9]*)', function ($id) {
    $adminController = new AdminController();
    $adminController->uploadUserPicture($id);
}, ['post']);

Route::add('/admin/users/delete/([0-9]*)', function ($id) {
    $adminController = new AdminController();
    $adminController->deleteUser($id);
}, 'get');

// HAIRDRESSERS
Route::add('/admin/hairdressers', function () {
    $adminController = new AdminController();
    $adminController->listHairdressers();
}, 'get');

Route::add('/admin/hairdressers/show/([0-9]*)', function ($id) {
    $adminController = new AdminController();
    $adminController->showHairdresser($id);
}, 'get');

Route::add('/admin/hairdressers/create', function () {
    $adminController = new AdminController();
    $adminController->createHairdresser();
}, ['get', 'post']);

Route::add('/admin/hairdressers/edit/([0-9]*)', function ($id) {
    $adminController = new AdminController();
    $adminController->editHairdresser($id);
}, ['get', 'post']);

Route::add('/admin/hairdressers/uploadPicture/([0-9]*)', function ($id) {
    $adminController = new AdminController();
    $adminController->uploadHairdresserPicture($id);
}, ['post']);

Route::add('/admin/hairdressers/delete/([0-9]*)', function ($id) {
    $adminController = new AdminController();
    $adminController->deleteHairdresser($id);
}, 'get');

// APPOINTMENTS
Route::add('/admin/appointments', function () {
    $adminController = new AdminController();
    $adminController->listAppointments();
}, 'get');

Route::add('/admin/appointments/edit/([0-9]*)', function ($id) {
    $adminController = new AdminController();
    $adminController->editAppointment($id);
}, ['get', 'post']);

Route::add('/admin/appointments/status/([0-9]*)', function ($id) {
    $adminController = new AdminController();
    $adminController->changeAppointmentStatus($id);
}, ['get', 'post']);

Route::add('/admin/appointments/delete/([0-9]*)', function ($id) {
    $adminController = new AdminController();
    $adminController->deleteAppointment($id);
}, 'get');