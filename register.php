<?php
require_once 'config/session.php';
require_once 'includes/security.php';

$csrfToken = generateCsrfToken();
$pageTitle = 'Sign Up';

require_once 'includes/auth_header.php';
?>

<div class="auth-page">
    <form action="register_process.php" method="post" class="auth-card">
        <div class="auth-icon"><i class="fas fa-user-plus"></i></div>
        <h2>Create Account</h2>
        <p class="auth-subtitle">Join Pizza Paradizo today</p>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($_GET['error']); ?></div>
        <?php endif; ?>
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($_GET['success']); ?></div>
        <?php endif; ?>

        <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">

        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" placeholder="Full Name"
                   value="<?php echo isset($_GET['name']) ? htmlspecialchars($_GET['name']) : ''; ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">User Name</label>
            <input type="text" name="uname" class="form-control" placeholder="Choose a username"
                   value="<?php echo isset($_GET['uname']) ? htmlspecialchars($_GET['uname']) : ''; ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Min 8 chars, uppercase, lowercase, number, special" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Confirm Password</label>
            <input type="password" name="re_password" class="form-control" placeholder="Confirm your password" required>
        </div>

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
            <input type="text" name="secret_answer" class="form-control" placeholder="Your secret answer" required>
        </div>

        <button type="submit" class="btn-auth">Create Account</button>

        <div class="auth-links">
            <a href="login.php"><i class="fas fa-sign-in-alt"></i> Already have an account? Login</a>
        </div>
    </form>
</div>

</body>
</html>