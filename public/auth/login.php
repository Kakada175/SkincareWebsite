<?php include '../includes/header.php'; ?>
<?php include '../includes/auth.php'; ?>

<?php
if (isLoggedIn()) {
    header('Location: /');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $user = authenticateUser($username, $password);

    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['is_admin'] = $user['is_admin'];

        if ($user['is_admin']) {
            header('Location: /admin/dashboard.php');
        } else {
            header('Location: /');
        }
        exit();
    } else {
        $error = "Invalid username or password";
    }
}
?>

<div class="auth-container">
    <h1>Log In</h1>
    <a href="register.php">Sign Up</a>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label for="username">Username or E-mail address *</label>
            <input type="text" id="username" name="username" placeholder="Enter Username / Email Address" required>
        </div>

        <div class="form-group">
            <label for="password">Password *</label>
            <input type="password" id="password" name="password" placeholder="Enter password" required>
        </div>

        <div class="form-options">
            <label>
                <input type="checkbox" name="remember"> Remember Me
            </label>
            <a href="#">Forgot Password?</a>
        </div>

        <button type="submit" class="btn btn-primary">Log In</button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>
