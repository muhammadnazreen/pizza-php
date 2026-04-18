<?php
require_once 'config/session.php';
require_once 'config/database.php';
require_once 'includes/security.php';

setSecurityHeaders();

if (isset($_POST['secret_question']) && isset($_POST['secret_answer']) && isset($_POST['csrf_token'])) {

    if (!validateCsrfToken($_POST['csrf_token'])) {
        header("Location: mfa.php?error=Invalid CSRF token"); exit();
    }

    $uname           = sanitizeInput($_SESSION['user_name'] ?? '');
    $secret_question = sanitizeInput($_POST['secret_question']);
    $secret_answer   = sanitizeInput($_POST['secret_answer']);

    if (empty($uname)) {
        header("Location: mfa.php?error=User Name is required"); exit();
    } elseif (empty($secret_question)) {
        header("Location: mfa.php?error=Select secret question"); exit();
    } elseif (empty($secret_answer)) {
        header("Location: mfa.php?error=Enter secret answer"); exit();
    } else {
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

            // Try new format (IV-prefixed) first, fall back to legacy
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
                header("Location: home.php"); exit();
            } else {
                header("Location: mfa.php?error=Incorrect secret question or answer"); exit();
            }
        } else {
            header("Location: mfa.php?error=Incorrect username"); exit();
        }
    }
} else {
    header("Location: mfa.php"); exit();
}
