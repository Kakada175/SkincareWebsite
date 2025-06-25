<?php include 'includes/header.php'; ?>
<?php include 'includes/db.php'; ?>

<?php
$search = $_GET['search'] ?? '';
$page = $_GET['page'] ?? 1;
$perPage = 12;
$offset = ($page - 1) * $perPage;

$query = "SELECT * FROM products";
$params = [];

if (!empty($search)) {
    $query .= " WHERE name LIKE ? OR description LIKE ?";
    $params = ["%$search%", "%$search%"];
}

$query .= " LIMIT $perPage OFFSET $offset";

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get total count for pagination
$countQuery = "SELECT COUNT(*) FROM products";
if (!empty($search)) {
    $countQuery .= " WHERE name LIKE ? OR description LIKE ?";
}
$stmt = $pdo->prepare($countQuery);
$stmt->execute($params);
$totalProducts = $stmt->fetchColumn();
$totalPages = ceil($totalProducts / $perPage);
?>

<div class="product-catalog">
    <h1>Our Products</h1>

    <div class="products-grid">
        <?php foreach ($products as $product): ?>
            <div class="product-card">
                <div class="product-image">
                    <img src="<?php echo $product['image'] ? '/images/' . htmlspecialchars($product['image']) : '/images/placeholder.jpg'; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                </div>
                <div class="product-info">
                    <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                    <p class="price">$<?php echo number_format($product['price'], 2); ?></p>
                    <p><?php echo htmlspecialchars(substr($product['description'], 0, 100)); ?>...</p>
                    <div class="product-actions">
                        <a href="/product-detail.php?id=<?php echo $product['id']; ?>" class="btn btn-primary">View Details</a>
                        <?php if (isLoggedIn()): ?>
                            <button class="btn btn-secondary add-to-cart" data-product-id="<?php echo $product['id']; ?>">Add to Cart</button>
                        <?php else: ?>
                            <a href="/auth/login.php" class="btn btn-secondary">Login to Purchase</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if ($totalPages > 1): ?>
        <div class="pagination">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?page=<?php echo $i; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>" class="<?php echo $i == $page ? 'active' : ''; ?>"><?php echo $i; ?></a>
            <?php endfor; ?>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
