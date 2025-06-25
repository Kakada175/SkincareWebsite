<?php include '../../includes/header.php'; ?>
<?php include '../../includes/db.php'; ?>

<?php
if (!isAdmin()) {
    header('Location: /');
    exit();
}

if (!isset($_GET['id'])) {
    header('Location: products.php');
    exit();
}

$productId = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$productId]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    header('Location: products.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';
    $price = $_POST['price'] ?? 0;
    $stock = $_POST['stock'] ?? 0;

    // Handle file upload
    $image = $product['image'];
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../../images/';
        $uploadFile = $uploadDir . basename($_FILES['image']['name']);

        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
            // Delete old image if it exists
            if ($image && file_exists($uploadDir . $image)) {
                unlink($uploadDir . $image);
            }
            $image = $_FILES['image']['name'];
        }
    }

    $stmt = $pdo->prepare("
        UPDATE products
        SET name = ?, description = ?, price = ?, stock = ?, image = ?
        WHERE id = ?
    ");

    if ($stmt->execute([$name, $description, $price, $stock, $image, $productId])) {
        $_SESSION['success'] = "Product updated successfully";
        header('Location: products.php');
        exit();
    } else {
        $error = "Failed to update product";
    }
}
?>

<div class="admin-product-form">
    <h1>Edit Product</h1>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Product Name</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" required><?php echo htmlspecialchars($product['description']); ?></textarea>
        </div>

        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" id="price" name="price" step="0.01" min="0" value="<?php echo $product['price']; ?>" required>
        </div>

        <div class="form-group">
            <label for="stock">Stock</label>
            <input type="number" id="stock" name="stock" min="0" value="<?php echo $product['stock']; ?>" required>
        </div>

        <div class="form-group">
            <label for="image">Product Image</label>
            <?php if ($product['image']): ?>
                <img src="/images/<?php echo htmlspecialchars($product['image']); ?>" width="100" class="current-image">
            <?php endif; ?>
            <input type="file" id="image" name="image">
        </div>

        <button type="submit" class="btn btn-primary">Update Product</button>
        <a href="products.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php include '../../includes/footer.php'; ?>
