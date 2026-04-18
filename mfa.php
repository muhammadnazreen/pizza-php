<?php
require_once 'config/session.php';
require_once 'includes/security.php';

$csrfToken = generateCsrfToken();
$pageTitle = 'Two-Factor Authentication';

require_once 'includes/auth_header.php';
?>

<div class="auth-page">
    <form action="mfa_process.php" method="post" class="auth-card">
        <div class="auth-icon"><i class="fas fa-shield-halved"></i></div>
        <h2>Verify Identity</h2>
        <p class="auth-subtitle">Answer your secret question to continue</p>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($_GET['error']); ?></div>
        <?php endif; ?>

        <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">

        <div class="mb-3">
            <label class="form-label">Secret Question</label>
            <select name="secret_question" class="form-select" required>
                <option value="" selected disabled>Select your secret question</option>
                <option value="What is your pet name?">What is your pet's name?</option>
                <option value="What is your mother maiden name?">What is your mother's maiden name?</option>
                <option value="What is your favorite movie?">What is your favorite movie?</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Secret Answer</label>
            <input type="text" name="secret_answer" class="form-control" placeholder="Enter your secret answer" required>
        </div>

        <button type="submit" class="btn-auth">Verify</button>

        <div class="auth-links">
            <a href="login.php"><i class="fas fa-arrow-left"></i> Back to Login</a>
        </div>
    </form>
</div>

</body>
</html>