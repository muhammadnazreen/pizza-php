<?php
/**
 * Session configuration with security hardening.
 */

// Output buffering for performance
if (!ob_get_level()) {
    ob_start();
}

// Session cookie parameters
session_set_cookie_params([
    'lifetime' => 1800,           // 30 minutes
    'path'     => '/',
    'secure'   => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on',
    'httponly' => true,
    'samesite' => 'Strict'
]);

// Strict session mode — reject uninitialized session IDs
ini_set('session.use_strict_mode', '1');
ini_set('session.gc_maxlifetime', '1800');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
