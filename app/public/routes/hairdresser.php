<?php

require_once(__DIR__ . "/../controllers/HairdresserController.php");

Route::add('/hairdressers', function() {
    $controller = new HairdresserController();
    $controller->listAll();
}, 'get');

Route::add('/hairdressers/([0-9]*)', function($id) {
    $controller = new HairdresserController();
    $controller->show($id);
}, 'get');