<?php

require_once(__DIR__ . "/../controllers/UserController.php");

// any request for the /users route will be handled by this function
Route::add('/users', function() {
    $userController = new UserController();
    $userController->getAll(); 
}, 'get');

// any request for /user/2 would be handled here, capturing '2' as $userId
Route::add('/user/([0-9]*)', function ($userId) {
    $userController = new UserController();
    $userController->get($userId);
}, 'get');

// API endpoint for deleting users
Route::add('/api/users/([0-9]*)', function ($userId) {
    $userController = new UserController();
    $userController->deleteUser($userId);
}, 'delete');
