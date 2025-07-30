<?php
session_start();
require '../../config/koneksi.php';

$query_customers = "SELECT * FROM users ORDER BY name ASC";
$result_customers = $conn->query($query_customers);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customers - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"  rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css"> 
    <style>
        body {
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
        }
        .sidebar {
            width: 250px;
            background-color: #212529;
            color: white;
            height: 100vh;
        }
        .main-content {
            flex: 1;
            padding: 30px;
            background-color: #f8f9fa;
        }
        .nav-link.active {
            background-color: #0d6efd;
            color: #fff !important;
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar d-flex flex-column p-3">
    <h3 class="text-center fw-bold mb-4">Admin Panel</h3>
    <ul class="nav nav-pills flex-column">
        <li class="nav-item"><a href="index_admin.php" class="nav-link text-white-50"><i class="bi bi-house me-2"></i>Dashboard</a></li>
        <li class="nav-item"><a href="orders.php" class="nav-link text-white-50"><i class="bi bi-file-earmark me-2"></i>Orders</a></li>
        <li class="nav-item"><a href="products.php" class="nav-link text-white-50"><i class="bi bi-cart me-2"></i>Products</a></li>
        <li class="nav-item"><a href="customers.php" class="nav-link active"><i class="bi bi-people me-2"></i>Customers</a></li>
        <li class="nav-item"><a href="reports.php" class="nav-link text-white-50"><i class="bi bi-bar-chart me-2"></i>Reports</a></li>
        <li class="nav-item"><a href="settings.php" class="nav-link text-white-50"><i class="bi bi-gear me-2"></i>Settings</a></li>
    </ul>
</div>

<!-- Main Content -->
<div class="main-content">
    <h2 class="mb-4">Customers</h2>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th><th>Name</th><th>Email</th><th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($customer = $result_customers->fetch_assoc()): ?>
            <tr>
                <td><?= $customer['id'] ?></td>
                <td><?= $customer['name'] ?></td>
                <td><?= $customer['email'] ?></td>
                <td>
                    <a href="edit_cus.php?id=<?= $customer['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="delete_cus.php?id=<?= $customer['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
