<?php
session_start();

require '../../config/koneksi.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Help & Support - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"  rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h1 class="mb-4">Help & Support</h1>
    <p>Selamat datang di pusat bantuan Admin Dashboard.</p>
    
    <h5>Frequently Asked Questions (FAQ)</h5>
    <ul>
        <li><strong>Q:</strong> Bagaimana cara menambah produk?</li>
        <li><strong>A:</strong> Gunakan menu <em>Add New Product</em> di Quick Actions.</li>

        <li><strong>Q:</strong> Di mana saya bisa melihat pesanan?</li>
        <li><strong>A:</strong> Lihat di menu <em>Orders</em> pada sidebar navigasi.</li>
    </ul>

    <hr>
    <a href="dashboard.php" class="btn btn-secondary">Kembali ke Dashboard</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> 
</body>
</html>