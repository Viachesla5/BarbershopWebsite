<?php

require_once(__DIR__ . '/../controllers/ProfileController.php');

// Profile page (show/edit)
Route::add('/profile', function() {
    $controller = new ProfileController();
    $controller->profile();
}, ['get','post']);

// NEW: route for AJAX upload
Route::add('/profile/uploadPicture', function() {
    $controller = new ProfileController();
    $controller->uploadPicture();
}, 'post');