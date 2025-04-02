<?php

require_once(__DIR__ . "/../controllers/HomeController.php");

Route::add('/', function () {
    $controller = new HomeController();
    $controller->index();
});
