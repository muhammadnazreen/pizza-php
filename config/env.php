<?php
/**
 * Environment configuration loader.
 * In production, replace these with actual environment variables or a .env file parser.
 */

// Load .env variables manually for local development
$envFile = __DIR__ . '/../.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        if (strpos($line, '=') !== false) {
            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value);
            putenv(sprintf('%s=%s', $name, $value));
            $_ENV[$name] = $value;
        }
    }
}

// Database
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');
define('DB_NAME', getenv('DB_NAME') ?: 'loginsys_db');

// Encryption
define('ENCRYPTION_KEY', getenv('ENCRYPTION_KEY') ?: 'change_this_to_a_random_64_char_hex_string');
define('HMAC_KEY',       getenv('HMAC_KEY')       ?: 'change_this_to_another_random_string');

// App
define('APP_ENV', getenv('APP_ENV') ?: 'development');
define('APP_DEBUG', APP_ENV === 'development');
