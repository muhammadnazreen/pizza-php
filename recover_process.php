<?php
require_once 'config/session.php';
require_once 'config/database.php';
require_once 'includes/security.php';

setSecurityHeaders();

if (isset($_POST['uname']) && isset($_POST['np']) && isset($_POST['c_np']) && isset($_POST['csrf_token'])) {

    if (!validateCsrfToken($_POST['csrf_token'])) {
        header("Location: recover.php?error=Invalid CSRF token"); exit();
    }

    $uname = sanitizeInput($_POST['uname']);
    $np    = sanitizeInput($_POST['np']);
    $c_np  = sanitizeInput($_POST['c_np']);

    if (empty($uname)) {
        header("Location: recover.php?error=User Name is required"); exit();
    } elseif (empty($np)) {
        header("Location: recover.php?error=New Password is required"); exit();
    } elseif ($np !== $c_np) {
        header("Location: recover.php?error=The confirmation password does not match"); exit();
    } else {
        if (!validatePassword($np)) {
            header("Location: recover.php?error=Invalid password. Must be 8+ chars with uppercase, lowercase, number, and special character");
            exit();
        }

        $hashedPassword = password_hash($np, PASSWORD_BCRYPT);

        $stmt = $conn->prepare("SELECT * FROM users WHERE user_name=?");
        $stmt->bind_param("s", $uname);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $secretQuestion        = $row['secret_question'];
            $encryptedSecretAnswer = $row['secret_answer'];
            $encryptionKey         = $row['encryption_key'];
            $ciphering_value       = 'AES-256-CBC';

            $secretAnswer_db = '';
            $decoded = base64_decode($encryptedSecretAnswer);
            $ivLength = openssl_cipher_iv_length($ciphering_value);

            if (strlen($decoded) > $ivLength) {
                $iv = substr($decoded, 0, $ivLength);
                $encrypted = substr($decoded, $ivLength);
                $secretAnswer_db = openssl_decrypt($encrypted, $ciphering_value, $encryptionKey, OPENSSL_RAW_DATA, $iv);
            }

            if (empty($secretAnswer_db)) {
                $secretAnswer_db = openssl_decrypt($encryptedSecretAnswer, $ciphering_value, $encryptionKey);
            }

            if ($_POST['secret_question'] === $secretQuestion && $_POST['secret_answer'] === $secretAnswer_db) {
                $updateStmt = $conn->prepare("UPDATE users SET password=? WHERE user_name=?");
                $updateStmt->bind_param("ss", $hashedPassword, $uname);
                $updateStmt->execute();
                header("Location: recover.php?success=Your password has been changed successfully"); exit();
            } else {
                header("Location: recover.php?error=Incorrect secret question or answer"); exit();
            }
        } else {
            header("Location: recover.php?error=Incorrect username"); exit();
        }
    }
} else {
    header("Location: recover.php"); exit();
}
