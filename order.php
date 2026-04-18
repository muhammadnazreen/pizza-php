<?php
require_once 'config/session.php';
require_once 'includes/security.php';

setSecurityHeaders();

if (!isset($_SESSION['id']) || !isset($_SESSION['user_name'])) {
    header("Location: login.php"); exit();
}

$status = isset($_GET['status']) ? htmlspecialchars($_GET['status']) : '';
if (empty($status)) {
    header("Location: home.php"); exit();
}

$isSuccess = stripos($status, 'success') !== false;

$pageTitle = 'Order';
$pageCss = ['assets/css/app.css'];
$activePage = 'cart';

require_once 'includes/header.php';
require_once 'includes/navbar.php';
?>

<div class="app-page">
    <div class="container" style="max-width: 600px;">
        <div class="page-header">
            <h1 class="page-title"><i class="fas fa-box"></i> Order Status</h1>
        </div>

        <div class="order-status-card">
            <div class="order-icon <?php echo $isSuccess ? 'success' : 'error'; ?>">
                <i class="fas <?php echo $isSuccess ? 'fa-check-circle' : 'fa-exclamation-circle'; ?>"></i>
            </div>
            <p><?php echo $status; ?></p>
            <div class="action-row" style="justify-content: center;">
                <a href="home.php" class="btn-pill btn-pill-primary">
                    <i class="fas fa-home"></i> Back to Home
                </a>
                <?php if ($isSuccess): ?>
                <a href="home.php#menu" class="btn-pill btn-pill-outline">
                    <i class="fas fa-utensils"></i> Order More
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
