<?php
require_once 'config/session.php';
require_once 'includes/security.php';

$csrfToken = generateCsrfToken();
$pageTitle = 'Recover Password';

require_once 'includes/auth_header.php';
?>

<div class="auth-page">
    <form action="recover_process.php" method="post" class="auth-card">
        <div class="auth-icon"><i class="fas fa-key"></i></div>
        <h2>Recover Password</h2>
        <p class="auth-subtitle">Reset your password using your secret question</p>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($_GET['error']); ?></div>
        <?php endif; ?>
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($_GET['success']); ?></div>
        <?php endif; ?>

        <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">

        <div class="mb-3">
            <label class="form-label">User Name</label>
            <input type="text" name="uname" class="form-control" placeholder="Enter your username" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Secret Question</label>
            <select name="secret_question" class="form-select" required>
                <option value="">Select a secret question</option>
                <option value="What is your pet name?">What is your pet's name?</option>
                <option value="What is your mother maiden name?">What is your mother's maiden name?</option>
                <option value="What is your favorite movie?">What is your favorite movie?</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Secret Answer</label>
            <input type="text" name="secret_answer" class="form-control" placeholder="Your secret answer" required>
        </div>

        <div class="mb-3">
            <label class="form-label">New Password</label>
            <input type="password" name="np" class="form-control" placeholder="New password" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Confirm New Password</label>
            <input type="password" name="c_np" class="form-control" placeholder="Confirm new password" required>
        </div>

        <button type="submit" class="btn-auth">Reset Password</button>

        <div class="auth-links">
            <a href="login.php"><i class="fas fa-arrow-left"></i> Back to Login</a>
        </div>
    </form>
</div>

</body>
</html>