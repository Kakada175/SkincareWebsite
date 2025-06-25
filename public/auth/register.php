<?php include '../includes/header.php'; ?>
<?php include '../includes/auth.php'; ?>

<?php
if (isLoggedIn()) {
    header('Location: /');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $repassword = $_POST['repassword'] ?? '';

    // Validate inputs
    $errors = [];

    if (empty($username)) {
        $errors[] = "Username is required";
    }

    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }

    if (empty($password)) {
        $errors[] = "Password is required";
    } elseif (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters";
    }

    if ($password !== $repassword) {
        $errors[] = "Passwords do not match";
    }

    // Check if username or email already exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$username, $email]);
    if ($stmt->fetch()) {
        $errors[] = "Username or email already exists";
    }

    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        if ($stmt->execute([$username, $email, $hashedPassword])) {
            $_SESSION['success'] = "Registration successful. Please log in.";
            header('Location: login.php');
            exit();
        } else {
            $errors[] = "Registration failed. Please try again.";
        }
    }
}
?>

<div class="auth-container">
    <h1>Sign Up</h1>
    <a href="login.php">Log In</a>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $error): ?>
                <p><?php echo $error; ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label for="username">Username *</label>
            <input type="text" id="username" name="username" placeholder="Your Username" required>
        </div>

        <div class="form-group">
            <label for="email">E-mail Address *</label>
            <input type="email" id="email" name="email" placeholder="Your email address" required>
        </div>

        <div class="form-group">
            <label for="password">Password *</label>
            <input type="password" id="password" name="password" placeholder="Set your password" required>
        </div>

        <div class="form-group">
            <label for="repassword">Re-Password *</label>
            <input type="password" id="repassword" name="repassword" placeholder="Retype your password" required>
        </div>

        <div class="form-check">
            <input type="checkbox" id="terms" name="terms" required>
            <label for="terms">Accept all Terms & Conditions</label>
        </div>

        <button type="submit" class="btn btn-primary">Sign Up</button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>
