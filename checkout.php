<?php
require_once 'config/session.php';
require_once 'config/env.php';
require_once 'includes/security.php';

setSecurityHeaders();

if (!isset($_SESSION['id']) || !isset($_SESSION['user_name']) || !isset($_POST['csrf_token'])) {
    header("Location: login.php");
    exit();
}

$quantity1      = isset($_POST['quantity1']) ? (int)$_POST['quantity1'] : 0;
$quantity2      = isset($_POST['quantity2']) ? (int)$_POST['quantity2'] : 0;
$quantity3      = isset($_POST['quantity3']) ? (int)$_POST['quantity3'] : 0;
$totalPrice     = isset($_POST['total_price']) ? (float)$_POST['total_price'] : 0;
$location       = isset($_POST['location']) ? htmlspecialchars($_POST['location']) : '';
$location2      = isset($_POST['location2']) ? htmlspecialchars($_POST['location2']) : '';
$deliveryDate   = isset($_POST['delivery-date']) ? htmlspecialchars($_POST['delivery-date']) : '';
$deliveryTime   = isset($_POST['delivery-time']) ? htmlspecialchars($_POST['delivery-time']) : '';
$cardNumber     = isset($_POST['card-num']) ? htmlspecialchars($_POST['card-num']) : '';
$cardExpiryDate = isset($_POST['card-expiry-date']) ? htmlspecialchars($_POST['card-expiry-date']) : '';
$cardCVV        = isset($_POST['card-cvv']) ? htmlspecialchars($_POST['card-cvv']) : '';

$state = "$quantity1|#|$quantity2|#|$quantity3|#|$totalPrice|#|$location|#|$location2|#|$deliveryDate|#|$deliveryTime|#|$cardNumber|#|$cardExpiryDate|#|$cardCVV";
$signature = hash_hmac('sha256', $state, HMAC_KEY);
$csrfToken = generateCsrfToken();

$pageTitle = 'Checkout';
$pageCss = ['assets/css/app.css'];
$activePage = 'cart';

require_once 'includes/header.php';
require_once 'includes/navbar.php';
?>

<div class="app-page">
    <div class="container" style="max-width: 720px;">
        <div class="page-header">
            <h1 class="page-title"><i class="fas fa-receipt"></i> Checkout</h1>
        </div>

        <form action="checkout_process.php" method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
            <input type="hidden" name="quantity1" value="<?php echo $quantity1; ?>">
            <input type="hidden" name="quantity2" value="<?php echo $quantity2; ?>">
            <input type="hidden" name="quantity3" value="<?php echo $quantity3; ?>">
            <input type="hidden" name="total_price" value="<?php echo $totalPrice; ?>">
            <input type="hidden" name="location" value="<?php echo $location; ?>">
            <input type="hidden" name="location2" value="<?php echo $location2; ?>">
            <input type="hidden" name="delivery-date" value="<?php echo $deliveryDate; ?>">
            <input type="hidden" name="delivery-time" value="<?php echo $deliveryTime; ?>">
            <input type="hidden" name="card-num" value="<?php echo $cardNumber; ?>">
            <input type="hidden" name="card-expiry-date" value="<?php echo $cardExpiryDate; ?>">
            <input type="hidden" name="card-cvv" value="<?php echo $cardCVV; ?>">
            <input type="hidden" name="signature" value="<?php echo $signature; ?>">

            <div class="checkout-summary">
                <h3 class="form-section-title"><i class="fas fa-list"></i> Order Summary</h3>
                <?php if ($quantity1 > 0): ?>
                    <div class="item-line"><span><?php echo $quantity1; ?>× Deluxe Cheese</span><span class="price">RM<?php echo number_format($quantity1 * 12.50, 2); ?></span></div>
                <?php endif; ?>
                <?php if ($quantity2 > 0): ?>
                    <div class="item-line"><span><?php echo $quantity2; ?>× Four of a Kind Cheese</span><span class="price">RM<?php echo number_format($quantity2 * 15.50, 2); ?></span></div>
                <?php endif; ?>
                <?php if ($quantity3 > 0): ?>
                    <div class="item-line"><span><?php echo $quantity3; ?>× Chicken Pepperoni</span><span class="price">RM<?php echo number_format($quantity3 * 20.00, 2); ?></span></div>
                <?php endif; ?>
                <div class="checkout-total">Total: RM<?php echo number_format($totalPrice, 2); ?></div>
            </div>

            <div class="checkout-summary">
                <h3 class="form-section-title"><i class="fas fa-truck"></i> Delivery Details</h3>
                <div class="item-line"><span>Location</span><span><?php echo $location; ?></span></div>
                <?php if (!empty($location2)): ?>
                    <div class="item-line"><span>Address Line 2</span><span><?php echo $location2; ?></span></div>
                <?php endif; ?>
                <div class="item-line"><span>Date</span><span><?php echo $deliveryDate; ?></span></div>
                <div class="item-line"><span>Time</span><span><?php echo $deliveryTime; ?></span></div>
            </div>

            <div class="action-row">
                <button type="submit" name="submit" value="Pay" class="btn-pill btn-pill-primary flex-fill">
                    <i class="fas fa-lock"></i> Pay Now
                </button>
                <button type="submit" name="cancel" value="Cancel" class="btn-pill btn-pill-outline flex-fill">
                    <i class="fas fa-times"></i> Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
