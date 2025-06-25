<?php include '../../includes/header.php'; ?>
<?php include '../../includes/db.php'; ?>

<?php
if (!isAdmin()) {
    header('Location: /');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';
    $price = $_POST['price'] ?? 0;
    $stock = $_POST['stock'] ?? 0;

    // Handle file upload
    $image = '';
    if (isset($_FILES['image'])) {
        $uploadDir = '../../images/';
        $uploadFile = $uploadDir . basename($_FILES['image']['name']);

        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
            $image = $_FILES['image']['name'];
        }
    }

    $stmt = $pdo->prepare("
        INSERT INTO products (name, description, price, stock, image)
        VALUES (?, ?, ?, ?, ?)
    ");

    if ($stmt->execute([$name, $description, $price, $stock, $image])) {
        $_SESSION['success'] = "Product added successfully";
        header('Location: products.php');
        exit();
    } else {
        $error = "Failed to add product";
    }
}
?>

<div class="admin-product-form">
    <h1>Add New Product</h1>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Product Name</label>
            <input type="text" id="name" name="name" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" required></textarea>
        </div>

        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" id="price" name="price" step="0.01" min="0" required>
        </div>

        <div class="form-group">
            <label for="stock">Stock</label>
            <input type="number" id="stock" name="stock" min="0" required>
        </div>

        <div class="form-group">
            <label for="image">Product Image</label>
            <input type="file" id="image" name="image">
        </div>

        <button type="submit" class="btn btn-primary">Add Product</button>
        <a href="products.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php include '../../includes/footer.php'; ?>
