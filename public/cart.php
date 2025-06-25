<?php include 'includes/header.php'; ?>
<?php include 'includes/db.php'; ?>

<?php
if (!isLoggedIn()) {
    header('Location: /auth/login.php');
    exit();
}

// Handle remove item from cart
if (isset($_GET['remove'])) {
    $cartId = $_GET['remove'];
    $stmt = $pdo->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
    $stmt->execute([$cartId, $_SESSION['user_id']]);
    header('Location: /cart.php');
    exit();
}

// Handle update quantity
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_cart'])) {
    foreach ($_POST['quantities'] as $cartId => $quantity) {
        $stmt = $pdo->prepare("UPDATE cart SET quantity = ? WHERE id = ? AND user_id = ?");
        $stmt->execute([$quantity, $cartId, $_SESSION['user_id']]);
    }
    header('Location: /cart.php');
    exit();
}

// Get cart items with product details
$stmt = $pdo->prepare("
    SELECT c.id as cart_id, c.quantity, p.id, p.name, p.price, p.image, p.stock
    FROM cart c
    JOIN products p ON c.product_id = p.id
    WHERE c.user_id = ?
");
$stmt->execute([$_SESSION['user_id']]);
$cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total = 0;
foreach ($cartItems as $item) {
    $total += $item['price'] * $item['quantity'];
}
?>

<div class="cart-page">
    <h1>Your Shopping Cart</h1>

    <?php if (empty($cartItems)): ?>
        <p>Your cart is empty. <a href="/">Continue shopping</a></p>
    <?php else: ?>
        <form method="POST">
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cartItems as $item): ?>
                        <tr>
                            <td class="product-info">
                                <img src="<?php echo $item['image'] ? '/images/' . htmlspecialchars($item['image']) : '/images/placeholder.jpg'; ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                                <div>
                                    <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                                    <p>Available: <?php echo $item['stock']; ?></p>
                                </div>
                            </td>
                            <td class="price">$<?php echo number_format($item['price'], 2); ?></td>
                            <td class="quantity">
                                <input type="number" name="quantities[<?php echo $item['cart_id']; ?>]"
                                       min="1" max="<?php echo $item['stock']; ?>"
                                       value="<?php echo $item['quantity']; ?>">
                            </td>
                            <td class="total">$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                            <td class="action">
                                <a href="?remove=<?php echo $item['cart_id']; ?>" class="btn btn-danger">Remove</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3"></td>
                        <td><strong>Subtotal:</strong></td>
                        <td>$<?php echo number_format($total, 2); ?></td>
                    </tr>
                </tfoot>
            </table>

            <div class="cart-actions">
                <a href="/" class="btn btn-secondary">Continue Shopping</a>
                <button type="submit" name="update_cart" class="btn btn-primary">Update Cart</button>
                <a href="/checkout.php" class="btn btn-success">Proceed to Checkout</a>
            </div>
        </form>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
