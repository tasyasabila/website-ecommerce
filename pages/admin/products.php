<?php
session_start();

require '../../config/koneksi.php';

// Query untuk mengambil semua produk
$query_products = "SELECT * FROM products ORDER BY name ASC";
$result_products = $conn->query($query_products);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Admin Panel</title>
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
                <h1 class="h2 mb-4">Products</h1>
                <a href="tambah_product.php" class="btn btn-primary mb-3">Add New Product</a>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($product = $result_products->fetch_assoc()): ?>
                            <tr>
                                <td><?= $product['id'] ?></td>
                                <td><?= $product['product_name'] ?></td>
                                <td>$<?= number_format($product['price'], 2) ?></td>
                                <td><?= $product['stock'] ?></td>
                                <td>
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