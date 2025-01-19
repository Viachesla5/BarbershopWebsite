<?php

/**
 * Set env variables and enable error reporting in local environment
 */
require_once(__DIR__ . "/lib/env.php"); // sets global env variables (database configuration)
require_once(__DIR__ . "/lib/error_reporting.php"); // enables error reporting locally

/**
 * Start user session
 */
session_start();

/**
 * Require routing library
 *  allows handling request for different URL routes, i.e. /users, /products, etc.
 */
require_once(__DIR__ . "/lib/Route.php");

/**
 * Require routes
 *  Defines the routes that our application will need
 */
require_once(__DIR__ . "/routes/index.php");
require_once(__DIR__ . "/routes/user.php");
require_once(__DIR__ . "/routes/appointment.php");
require_once(__DIR__ . "/routes/hairdresser.php");
require_once(__DIR__ . "/routes/auth.php");
require_once(__DIR__ . "/routes/profile.php");
require_once(__DIR__ . "/routes/admin.php");
require_once(__DIR__ . '/lib/Auth.php');

// Start the router, enabling handling requests
Route::run();
