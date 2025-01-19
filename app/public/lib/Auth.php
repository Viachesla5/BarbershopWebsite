<?php

function requireUser() {
    if (empty($_SESSION['user_id'])) {
        header("Location: /login");
        exit;
    }
}

function requireHairdresser() {
    if (empty($_SESSION['hairdresser_id'])) {
        header("Location: /login");
        exit;
    }
}

function requireAdmin() {
    // For admin, we check user_id + is_admin
    if (empty($_SESSION['user_id']) || empty($_SESSION['is_admin'])) {
        header("Location: /login");
        exit;
    }
}

function requireProfileAccess() {
    if (empty($_SESSION['user_id']) && empty($_SESSION['hairdresser_id']) && empty($_SESSION['is_admin'])) {
        // Redirect to login if none of the roles are authenticated
        header("Location: /login");
        exit;
    }
}

function requireHairdresserAndUser() {
    if (empty($_SESSION['user_id']) && empty($_SESSION['hairdresser_id'])) {
        // Redirect to login if none of the roles are authenticated
        header("Location: /login");
        exit;
    }
}

function requireHairdresserAndAdmin() {
    if (empty($_SESSION['user_id']) && empty($_SESSION['is_admin'])) {
        // Redirect to login if none of the roles are authenticated
        header("Location: /login");
        exit;
    }
}