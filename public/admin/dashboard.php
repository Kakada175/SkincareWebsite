<?php include '../../includes/header.php'; ?>
<?php include '../../includes/db.php'; ?>

<?php
if (!isAdmin()) {
    header('Location: /');
    exit();
}

// Get stats for dashboard
$stmt = $pdo->query("SELECT COUNT(*) FROM products");
$productCount = $stmt->fetchColumn();

$stmt = $pdo->query("SELECT COUNT(*) FROM users WHERE is_admin = 0");
$userCount = $stmt->fetchColumn();

$stmt = $pdo->query("SELECT COUNT(*) FROM orders");
$orderCount = $stmt->fetchColumn();

$stmt = $pdo->query("SELECT SUM(total) FROM orders");
$revenue = $stmt->fetchColumn();
?>

<div class="admin-dashboard">
    <h1>Admin Dashboard</h1>

    <div class="stats-grid">
        <div class="stat-card">
            <h3>Products</h3>
            <p><?php echo $productCount; ?></p>
            <a href="products.php">Manage Products</a>
        </div>

        <div class="stat-card">
            <h3>Customers</h3>
            <p><?php echo $userCount; ?></p>
        </div>

        <div class="stat-card">
            <h3>Orders</h3>
            <p><?php echo $orderCount; ?></p>
            <a href="orders.php">View Orders</a>
        </div>

        <div class="stat-card">
            <h3>Revenue</h3>
            <p>$<?php echo number_format($revenue, 2); ?></p>
        </div>
    </div>

    <div class="recent-orders">
        <h2>Recent Orders</h2>
        <?php
        $stmt = $pdo->query("
            SELECT o.id, o.total, o.status, o.created_at, u.username
            FROM orders o
            JOIN users u ON o.user_id = u.id
            ORDER BY o.created_at DESC
            LIMIT 5
        ");
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <table class="admin-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td>#<?php echo $order['id']; ?></td>
                        <td><?php echo htmlspecialchars($order['username']); ?></td>
                        <td>$<?php echo number_format($order['total'], 2); ?></td>
                        <td><?php echo ucfirst($order['status']); ?></td>
                        <td><?php echo date('M j, Y', strtotime($order['created_at'])); ?></td>
                        <td>
                            <a href="order-detail.php?id=<?php echo $order['id']; ?>" class="btn btn-sm btn-primary">View</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
