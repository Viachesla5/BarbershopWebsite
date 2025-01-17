<?php

require_once(__DIR__ . "/../controllers/AppointmentController.php");

Route::add('/appointments', function() {
    $controller = new AppointmentController();
    $controller->listAll();
}, 'get');

Route::add('/appointments/create', function() {
    $controller = new AppointmentController();
    $controller->createAppointment();
}, ['get','post']);

Route::add('/appointments/edit/([0-9]*)', function($id) {
    $controller = new AppointmentController();
    $controller->editAppointment($id);
}, ['get','post']);

Route::add('/appointments/delete/([0-9]*)', function($id) {
    $controller = new AppointmentController();
    $controller->deleteAppointment($id);
}, 'get');
