<?php

require_once(__DIR__ . "/../controllers/AuthController.php");

// Login route (GET or POST)
Route::add('/login', function() {
    $auth = new AuthController();
    $auth->login();
}, ['get','post']);

// Register route (GET or POST)
Route::add('/register', function() {
    $auth = new AuthController();
    $auth->register();
}, ['get','post']);

// Logout route
Route::add('/logout', function() {
    $auth = new AuthController();
    $auth->logout();
}, 'get');  // or 'post' if you prefer POST for logout