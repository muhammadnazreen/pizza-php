<?php
require_once 'config/session.php';
require_once 'config/database.php';
require_once 'config/env.php';
require_once 'includes/security.php';

setSecurityHeaders();

if (!isset($_SESSION['id']) || !isset($_SESSION['user_name'])) {
    header("Location: login.php"); exit();
}

if (!isset($_POST['csrf_token']) || !validateCsrfToken($_POST['csrf_token'])) {
    header("Location: order.php?status=Invalid CSRF token"); exit();
}

if (isset($_POST['submit'])) {
    $quantity1      = (int)$_POST['quantity1'];
    $quantity2      = (int)$_POST['quantity2'];
    $quantity3      = (int)$_POST['quantity3'];
    $totalPrice     = (float)$_POST['total_price'];
    $location       = htmlspecialchars($_POST['location']);
    $location2      = htmlspecialchars($_POST['location2']);
    $deliveryDate   = htmlspecialchars($_POST['delivery-date']);
    $deliveryTime   = htmlspecialchars($_POST['delivery-time']);
    $cardNumber     = htmlspecialchars($_POST['card-num']);
    $cardExpiryDate = htmlspecialchars($_POST['card-expiry-date']);
    $cardCVV        = htmlspecialchars($_POST['card-cvv']);

    $state = "$quantity1|#|$quantity2|#|$quantity3|#|$totalPrice|#|$location|#|$location2|#|$deliveryDate|#|$deliveryTime|#|$cardNumber|#|$cardExpiryDate|#|$cardCVV";
    $signature_check = hash_hmac('sha256', $state, HMAC_KEY);

    if (hash_equals($signature_check, $_POST['signature'])) {
        $ciphering = 'AES-256-CBC';
        $ivLength = openssl_cipher_iv_length($ciphering);
        $iv = openssl_random_pseudo_bytes($ivLength);

        $encryptedCardNumber     = base64_encode($iv . openssl_encrypt($cardNumber, $ciphering, ENCRYPTION_KEY, OPENSSL_RAW_DATA, $iv));
        $encryptedCardExpiryDate = base64_encode($iv . openssl_encrypt($cardExpiryDate, $ciphering, ENCRYPTION_KEY, OPENSSL_RAW_DATA, $iv));
        $encryptedCardCVV        = base64_encode($iv . openssl_encrypt($cardCVV, $ciphering, ENCRYPTION_KEY, OPENSSL_RAW_DATA, $iv));

        $user_id = $_SESSION['id'];
        $stmt = $conn->prepare("INSERT INTO cart (user_id, product_1, product_2, product_3, total_price, line_address1, line_address2, delivery_date, delivery_time, card_num, card_expired, cvv) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iiiidsssssss", $user_id, $quantity1, $quantity2, $quantity3, $totalPrice, $location, $location2, $deliveryDate, $deliveryTime, $encryptedCardNumber, $encryptedCardExpiryDate, $encryptedCardCVV);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            header("Location: order.php?status=Order processed successfully"); exit();
        } else {
            header("Location: order.php?status=Unable to process your order, Please try again"); exit();
        }
    } else {
        header("Location: order.php?status=Order failed due to unauthorized tampering!"); exit();
    }
} elseif (isset($_POST['cancel'])) {
    header("Location: order.php?status=Order has been cancelled."); exit();
} else {
    header("Location: order.php?status=Unknown error, please try again later."); exit();
}
