<?php
require_once 'auth.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Floria Store</title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="<https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css>">
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="logo">
                <a href="/">Floria</a>
            </div>

            <div class="search-bar">
                <form action="/" method="GET">
                    <input type="text" name="search" placeholder="Search products...">
                    <button type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>

            <nav class="nav">
                <ul>
                    <li><a href="/">Home</a></li>
                    <li><a href="#">Products</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Contact</a></li>

                    <?php if (isLoggedIn()): ?>
                        <li>
                            <a href="/cart.php" class="cart-icon">
                                <i class="fas fa-shopping-cart"></i>
                                <?php
                                $stmt = $pdo->prepare("SELECT SUM(quantity) FROM cart WHERE user_id = ?");
                                $stmt->execute([$_SESSION['user_id']]);
                                $count = $stmt->fetchColumn();
                                if ($count > 0): ?>
                                    <span class="cart-count"><?php echo $count; ?></span>
                                <?php endif; ?>
                            </a>
                        </li>
                        <li class="dropdown">
                            <a href="#"><i class="fas fa-user"></i> <?php echo htmlspecialchars($_SESSION['username']); ?></a>
                            <ul class="dropdown-menu">
                                <?php if (isAdmin()): ?>
                                    <li><a href="/admin/dashboard.php">Admin Dashboard</a></li>
                                <?php endif; ?>
                                <li><a href="#">My Account</a></li>
                                <li><a href="?logout=1">Logout</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li><a href="/auth/login.php"><i class="fas fa-user"></i> Login</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container">
