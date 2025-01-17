<?php

require_once(__DIR__ . "/../controllers/HairdresserController.php");

Route::add('/hairdressers', function() {
    $controller = new HairdresserController();
    $controller->listAll();
}, 'get');

Route::add('/hairdressers/create', function() {
    $controller = new HairdresserController();
    $controller->create();
}, ['get','post']);

Route::add('/hairdressers/([0-9]*)', function($id) {
    $controller = new HairdresserController();
    $controller->show($id);
}, 'get');

Route::add('/hairdressers/edit/([0-9]*)', function($id) {
    $controller = new HairdresserController();
    $controller->update($id);
}, ['get','post']);

Route::add('/hairdressers/delete/([0-9]*)', function($id) {
    $controller = new HairdresserController();
    $controller->delete($id);
}, 'get');
