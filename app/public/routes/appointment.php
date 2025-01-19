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



// 1. Route to display the FullCalendar view
Route::add('/appointments/calendar', function() {
    $controller = new AppointmentController();
    $controller->calendar();
}, 'get');

// 2. Route to fetch appointment events as JSON
Route::add('/appointments/events', function() {
    $controller = new AppointmentController();
    $controller->getCalendarEvents();
}, 'get');

// 3. Route to create a new appointment from calendar selection
Route::add('/appointments/createFromCalendar', function() {
    $controller = new AppointmentController();
    $controller->createFromCalendar();
}, 'post');


// Route to display a confirmation page before deletion
Route::add('/appointments/delete/([0-9]*)', function($id) {
    $controller = new AppointmentController();
    $controller->deleteConfirm($id);
}, 'get');

// Route to handle the actual deletion after confirmation
Route::add('/appointments/deleteConfirm/([0-9]*)', function($id) {
    $controller = new AppointmentController();
    $controller->deleteAppointment($id);
}, 'post');

// Ajax route to delete appointment from FullCalendar
Route::add('/appointments/deleteFromCalendar', function() {
    $controller = new AppointmentController();
    $controller->deleteFromCalendar();
}, 'post');