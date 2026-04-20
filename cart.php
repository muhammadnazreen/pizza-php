<?php
require_once 'config/session.php';
require_once 'includes/security.php';

setSecurityHeaders();

if (!isset($_SESSION['id']) || !isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['quantity1']) && isset($_GET['quantity2']) && isset($_GET['quantity3'])) {
    $quantity1 = (int) $_GET['quantity1'];
    $quantity2 = (int) $_GET['quantity2'];
    $quantity3 = (int) $_GET['quantity3'];
    $item1Price = $quantity1 * 12.50;
    $item2Price = $quantity2 * 15.50;
    $item3Price = $quantity3 * 20.00;
    $totalPrice = $item1Price + $item2Price + $item3Price;
}

$csrfToken = generateCsrfToken();
$pageTitle = 'Cart';
$pageCss = ['assets/css/app.css'];
$activePage = 'cart';

require_once 'includes/header.php';
require_once 'includes/navbar.php';
?>

<div class="app-page">
    <div class="container" style="max-width: 720px;">
        <div class="page-header">
            <h1 class="page-title"><i class="fas fa-shopping-cart"></i> Your Cart</h1>
        </div>

        <form action="checkout.php" method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
            <input type="hidden" name="quantity1" value="<?php echo $quantity1 ?? 0; ?>">
            <input type="hidden" name="quantity2" value="<?php echo $quantity2 ?? 0; ?>">
            <input type="hidden" name="quantity3" value="<?php echo $quantity3 ?? 0; ?>">
            <input type="hidden" name="total_price" value="<?php echo $totalPrice ?? 0; ?>">

            <?php if (isset($quantity1) && ($quantity1 > 0 || $quantity2 > 0 || $quantity3 > 0)): ?>
                <table class="cart-table">
                    <thead>
                        <tr><th>Item</th><th>Qty</th><th>Price</th></tr>
                    </thead>
                    <tbody>
                        <?php if ($quantity1 > 0): ?>
                        <tr><td>Deluxe Cheese</td><td><?php echo $quantity1; ?></td><td>RM<?php echo number_format($item1Price, 2); ?></td></tr>
                        <?php endif; ?>
                        <?php if ($quantity2 > 0): ?>
                        <tr><td>Four of a Kind Cheese</td><td><?php echo $quantity2; ?></td><td>RM<?php echo number_format($item2Price, 2); ?></td></tr>
                        <?php endif; ?>
                        <?php if ($quantity3 > 0): ?>
                        <tr><td>Chicken Pepperoni</td><td><?php echo $quantity3; ?></td><td>RM<?php echo number_format($item3Price, 2); ?></td></tr>
                        <?php endif; ?>
                    </tbody>
                    <tfoot>
                        <tr><td colspan="2">Total</td><td>RM<?php echo number_format($totalPrice, 2); ?></td></tr>
                    </tfoot>
                </table>

                <div class="form-section">
                    <h3 class="form-section-title"><i class="fas fa-truck"></i> Delivery Details</h3>
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Address Line 1</label>
                            <input type="text" name="location" class="form-control" placeholder="Enter your address" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Address Line 2</label>
                            <input type="text" name="location2" class="form-control" placeholder="Apt, suite, etc. (optional)">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Delivery Date</label>
                            <input type="date" name="delivery-date" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Delivery Time</label>
                            <input type="time" name="delivery-time" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h3 class="form-section-title"><i class="fas fa-credit-card"></i> Payment</h3>
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Card Number</label>
                            <input type="text" name="card-num" class="form-control" pattern="[0-9]{16}" title="16-digit card number" placeholder="•••• •••• •••• ••••" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Expiry Date</label>
                            <input type="text" name="card-expiry-date" class="form-control" pattern="^(0[1-9]|1[0-2])\/?([0-9]{2})$" title="MM/YY" placeholder="MM/YY" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">CVV</label>
                            <input type="text" name="card-cvv" class="form-control" pattern="[0-9]{3}" title="3-digit CVV" placeholder="•••" required>
                        </div>
                    </div>
                </div>

                <div class="action-row">
                    <button type="submit" class="btn-pill btn-pill-primary flex-fill">
                        <i class="fas fa-lock"></i> Proceed to Checkout
                    </button>
                </div>

            <?php else: ?>
                <div class="cart-empty">
                    <i class="fas fa-shopping-basket d-block"></i>
                    <h3>Your cart is empty</h3>
                    <p>Go to the menu and add some delicious pizzas!</p>
                    <a href="home.php#menu" class="btn-pill btn-pill-primary">
                        <i class="fas fa-utensils"></i> View Menu
                    </a>
                </div>
            <?php endif; ?>
        </form>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>