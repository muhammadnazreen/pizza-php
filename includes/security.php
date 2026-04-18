<?php
/**
 * Security helpers — CSRF tokens, rate limiting, input sanitization.
 */

/**
 * Generate and store a CSRF token in the session.
 */
function generateCsrfToken(): string {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Validate a CSRF token against the session token.
 */
function validateCsrfToken(string $token): bool {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Regenerate the CSRF token (call after successful form submission).
 */
function regenerateCsrfToken(): string {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    return $_SESSION['csrf_token'];
}

/**
 * Sanitize input data — trim, strip slashes, escape HTML.
 */
function sanitizeInput(string $data): string {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

/**
 * Simple session-based rate limiter.
 *
 * @param string $key          Identifier for the action (e.g. 'login_attempts')
 * @param int    $maxAttempts  Maximum attempts allowed
 * @param int    $windowSecs   Time window in seconds
 * @return bool  True if rate limit exceeded
 */
function isRateLimited(string $key, int $maxAttempts = 5, int $windowSecs = 900): bool {
    $now = time();
    
    if (!isset($_SESSION['rate_limits'][$key])) {
        $_SESSION['rate_limits'][$key] = [];
    }
    
    // Clean up old entries outside the window
    $_SESSION['rate_limits'][$key] = array_filter(
        $_SESSION['rate_limits'][$key],
        function ($timestamp) use ($now, $windowSecs) {
            return ($now - $timestamp) < $windowSecs;
        }
    );
    
    return count($_SESSION['rate_limits'][$key]) >= $maxAttempts;
}

/**
 * Record an attempt for rate limiting.
 */
function recordAttempt(string $key): void {
    $_SESSION['rate_limits'][$key][] = time();
}

/**
 * Validate password strength.
 * At least 8 chars, 1 uppercase, 1 lowercase, 1 digit, 1 special character.
 */
function validatePassword(string $password): bool {
    $pattern = "/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[^A-Za-z\d\s]).{8,}$/";
    return (bool) preg_match($pattern, $password);
}

/**
 * Set common security headers.
 */
function setSecurityHeaders(): void {
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: DENY');
    header('X-XSS-Protection: 1; mode=block');
    header('Referrer-Policy: strict-origin-when-cross-origin');
}
