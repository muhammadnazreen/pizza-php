<?php
require_once 'config/session.php';
require_once 'includes/security.php';

$csrfToken = generateCsrfToken();
$pageTitle = 'Login';

require_once 'includes/auth_header.php';
?>

<div class="auth-page">
    <form action="login_process.php" method="post" class="auth-card">
        <div class="auth-icon"><i class="fas fa-pizza-slice"></i></div>
        <h2>Welcome back</h2>
        <p class="auth-subtitle">Sign in to your Pizza Paradizo account</p>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($_GET['error']); ?></div>
        <?php endif; ?>

        <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">

        <div class="mb-3">
            <label class="form-label">User Name</label>
            <input type="text" name="uname" class="form-control" placeholder="Enter your username" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
        </div>

        <button type="submit" class="btn-auth">Sign In</button>

        <div class="auth-links">
            <a href="recover.php"><i class="fas fa-key"></i> Forgot Password</a>
            <a href="register.php"><i class="fas fa-user-plus"></i> Create Account</a>
        </div>
    </form>
</div>

</body>
</html>