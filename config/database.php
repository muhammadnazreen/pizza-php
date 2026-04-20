<?php
/**
 * Database connection with error reporting and charset configuration.
 */
require_once __DIR__ . '/env.php';

// Enable exception-based error reporting
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Create connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Set charset for proper UTF-8 support
$conn->set_charset('utf8mb4');
