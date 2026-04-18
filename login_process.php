<?php
require_once 'config/session.php';
require_once 'config/database.php';
require_once 'includes/security.php';

setSecurityHeaders();

if (isset($_POST['uname']) && isset($_POST['password']) && isset($_POST['csrf_token'])) {

    if (!validateCsrfToken($_POST['csrf_token'])) {
        header("Location: login.php?error=Invalid CSRF token");
        exit();
    }

    if (isRateLimited('login_attempts', 5, 900)) {
        header("Location: login.php?error=Too many login attempts. Please try again in 15 minutes.");
        exit();
    }

    $uname = sanitizeInput($_POST['uname']);
    $pass  = sanitizeInput($_POST['password']);

    if (empty($uname)) {
        header("Location: login.php?error=User Name is required");
        exit();
    } elseif (empty($pass)) {
        header("Location: login.php?error=Password is required");
        exit();
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE user_name=?");
        $stmt->bind_param("s", $uname);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();

            // Support both legacy MD5 and new bcrypt hashes
            $passwordMatch = false;
            if (password_get_info($row['password'])['algo'] !== null && password_get_info($row['password'])['algo'] !== 0) {
                $passwordMatch = password_verify($pass, $row['password']);
            } else {
                $passwordMatch = (md5($pass) === $row['password']);
                if ($passwordMatch) {
                    $newHash = password_hash($pass, PASSWORD_BCRYPT);
                    $updateStmt = $conn->prepare("UPDATE users SET password=? WHERE id=?");
                    $updateStmt->bind_param("si", $newHash, $row['id']);
                    $updateStmt->execute();
                }
            }

            if ($passwordMatch) {
                $_SESSION['user_name'] = $row['user_name'];
                $_SESSION['name'] = $row['name'];
                $_SESSION['id'] = $row['id'];
                session_regenerate_id(true);
                header("Location: mfa.php");
                exit();
            } else {
                recordAttempt('login_attempts');
                header("Location: login.php?error=Incorrect User name or password");
                exit();
            }
        } else {
            recordAttempt('login_attempts');
            header("Location: login.php?error=Incorrect User name or password");
            exit();
        }
    }
} else {
    header("Location: login.php");
    exit();
}
