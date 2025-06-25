<?php include '../../includes/header.php'; ?>
<?php include '../../includes/db.php'; ?>

<?php
if (!isAdmin()) {
    header('Location: /');
    exit();
}

// Handle product deletion
if (isset($_GET['delete'])) {
    $productId = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$productId]);
    $_SESSION['success'] = "Product deleted successfully";
    header('Location: products.php');
    exit();
}

// Get all products
$stmt = $pdo->query("SELECT * FROM products ORDER BY created_at DESC");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="admin-products">
    <div class="admin-header">
        <h1>Manage Products</h1>
        <a href="product-add.php" class="btn btn-primary">Add New Product</a>
    </div>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Name</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Created</th>
                <th>Updated</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?php echo $product['id']; ?></td>
                    <td>
                        <img src="<?php echo $product['image'] ? '/images/' . htmlspecialchars($product['image']) : '/images/placeholder.wepb'; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" width="50">
                    </td>
                    <td><?php echo htmlspecialchars($product['name']); ?></td>
                    <td>$<?php echo number_format($product['price'], 2); ?></td>
                    <td><?php echo $product['stock']; ?></td>
                    <td><?php echo date('M j, Y', strtotime($product['created_at'])); ?></td>
                    <td><?php echo date('M j, Y', strtotime($product['updated_at'])); ?></td>
                    <td>
                        <a href="product-edit.php?id=<?php echo $product['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                        <a href="?delete=<?php echo $product['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include '../../includes/footer.php'; ?>
