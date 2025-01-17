<?php

require_once(__DIR__ . '/../controllers/ProfileController.php');

Route::add('/profile', function() {
    $controller = new ProfileController();
    $controller->profile(); // Single method to show & edit
}, ['get','post']);
