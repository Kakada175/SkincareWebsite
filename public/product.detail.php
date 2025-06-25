<?php include 'includes/header.php'; ?>
<?php include 'includes/db.php'; ?>

<?php
if (!isset($_GET['id'])) {
    header('Location: /');
    exit();
}

$productId = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$productId]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    header('Location: /');
    exit();
}
?>

<div class="product-detail">
    <div class="product-images">
        <img src="<?php echo $product['image'] ? '/images/' . htmlspecialchars($product['image']) : '/images/placeholder.jpg'; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
    </div>

    <div class="product-info">
        <h1><?php echo htmlspecialchars($product['name']); ?></h1>
        <p class="price">$<?php echo number_format($product['price'], 2); ?></p>
        <p class="stock"><?php echo $product['stock'] > 0 ? 'In Stock' : 'Out of Stock'; ?></p>

        <div class="product-description">
            <h3>Description</h3>
            <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
        </div>

        <?php if (isLoggedIn() && $product['stock'] > 0): ?>
            <form class="add-to-cart-form" method="POST" action="/cart.php">
                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                <div class="quantity-selector">
                    <label for="quantity">Quantity:</label>
                    <input type="number" id="quantity" name="quantity" min="1" max="<?php echo $product['stock']; ?>" value="1">
                </div>
                <button type="submit" class="btn btn-primary">Add to Cart</button>
            </form>
        <?php elseif (!isLoggedIn()): ?>
            <a href="/auth/login.php" class="btn btn-primary">Login to Purchase</a>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
