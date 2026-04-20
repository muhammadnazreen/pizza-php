<?php
require_once 'config/session.php';
require_once 'config/database.php';
require_once 'config/env.php';
require_once 'includes/security.php';

setSecurityHeaders();

if (isset($_POST['uname']) && isset($_POST['password'])
    && isset($_POST['name']) && isset($_POST['re_password'])
    && isset($_POST['secret_question']) && isset($_POST['secret_answer'])
    && isset($_POST['csrf_token'])) {

    if (!validateCsrfToken($_POST['csrf_token'])) {
        header("Location: register.php?error=Invalid CSRF token");
        exit();
    }

    $uname          = sanitizeInput($_POST['uname']);
    $pass           = sanitizeInput($_POST['password']);
    $re_pass        = sanitizeInput($_POST['re_password']);
    $name           = sanitizeInput($_POST['name']);
    $secretQuestion = sanitizeInput($_POST['secret_question']);
    $secretAnswer   = sanitizeInput($_POST['secret_answer']);
    $user_data = 'uname=' . $uname . '&name=' . $name;

    if (empty($uname)) {
        header("Location: register.php?error=User Name is required&$user_data"); exit();
    } elseif (empty($pass)) {
        header("Location: register.php?error=Password is required&$user_data"); exit();
    } elseif (empty($re_pass)) {
        header("Location: register.php?error=Confirmation Password is required&$user_data"); exit();
    } elseif (empty($name)) {
        header("Location: register.php?error=Name is required&$user_data"); exit();
    } elseif ($pass !== $re_pass) {
        header("Location: register.php?error=The confirmation password does not match&$user_data"); exit();
    } else {
        if (!validatePassword($pass)) {
            header("Location: register.php?error=Invalid password. Must be 8+ chars with uppercase, lowercase, number, and special character&$user_data");
            exit();
        }

        $hashedPassword = password_hash($pass, PASSWORD_BCRYPT);

        $encryptionKey = bin2hex(random_bytes(32));
        $ciphering_value = 'AES-256-CBC';
        $ivLength = openssl_cipher_iv_length($ciphering_value);
        $iv = openssl_random_pseudo_bytes($ivLength);
        $encryptedSecretAnswer = base64_encode($iv . openssl_encrypt($secretAnswer, $ciphering_value, $encryptionKey, OPENSSL_RAW_DATA, $iv));

        $stmt = $conn->prepare("SELECT * FROM users WHERE user_name=?");
        $stmt->bind_param("s", $uname);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            header("Location: register.php?error=The username is taken, try another&$user_data"); exit();
        } else {
            $stmt2 = $conn->prepare("INSERT INTO users(user_name, password, name, secret_question, secret_answer, encryption_key) VALUES(?, ?, ?, ?, ?, ?)");
            $stmt2->bind_param("ssssss", $uname, $hashedPassword, $name, $secretQuestion, $encryptedSecretAnswer, $encryptionKey);
            $result2 = $stmt2->execute();

            if ($result2) {
                header("Location: register.php?success=Your account has been created successfully"); exit();
            } else {
                header("Location: register.php?error=Unknown error occurred&$user_data"); exit();
            }
        }
    }
} else {
    header("Location: register.php"); exit();
}
