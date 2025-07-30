<?php
session_start();

require '../../config/koneksi.php';
function getStatusColor($status) {
    switch ($status) {
        case 'Completed':
            return 'success';
        case 'Pending':
            return 'warning';
        case 'Cancelled':
            return 'danger';
        case 'Shipped':
            return 'info';
        default:
            return 'secondary';
    }
}

// Query untuk mengambil semua pesanan
$query_orders = "
    SELECT 
        o.id AS order_id, 
        u.name AS customer, 
        p.name AS product_name, 
        o.created_at AS order_date, 
        o.total_price, 
        o.status 
    FROM 
        orders o 
    LEFT JOIN users u ON o.user_id = u.id 
    LEFT JOIN order_items oi ON oi.order_id = o.id 
    LEFT JOIN products p ON oi.product_id = p.id 
    GROUP BY o.id 
    ORDER BY o.created_at DESC;
";
$result_orders = $conn->query($query_orders);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders - Admin Panel</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"  rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css"> 
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar Navigation -->
            <div class="col-12 col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse" id="sidebarMenu">
                <!-- Sidebar content here -->
            </div>
            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 ms-sm-auto px-md-4">
                <h1 class="h2 mb-4">Orders</h1>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Product</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($order = $result_orders->fetch_assoc()): ?>
                            <tr>
                                <td><?= $order['order_id'] ?></td>
                                <td><?= $order['customer'] ?></td>
                                <td><?= $order['product_name'] ?></td>
                                <td><?= $order['order_date'] ?></td>
                                <td>$<?= number_format($order['amount'], 2) ?></td>
                                <td><span class="badge bg-<?php echo getStatusColor($order['status']); ?>"><?= $order['status'] ?></span></td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-primary">View</a>
                                    <a href="#" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="#" class="btn btn-sm btn-danger">Delete</a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> 
</body>
</html>