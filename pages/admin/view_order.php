<?php
session_start();

require '../../config/koneksi.php';

// Ambil order_id dari URL
$order_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Query data pesanan beserta informasi pelanggan dan produk
$query = "
    SELECT 
        o.order_id, 
        u.name AS customer_name, 
        u.email AS customer_email,
        p.product_name,
        o.quantity,
        o.amount,
        o.status,
        o.order_date
    FROM orders o
    LEFT JOIN users u ON o.user_id = u.id
    LEFT JOIN products p ON o.product_id = p.id
    WHERE o.order_id = ?
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Pesanan tidak ditemukan.");
}

$order = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Order #<?= $order['order_id'] ?></title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"  rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css"> 
</head>
<body>

<div class="container mt-4">

    <h2>Detail Pesanan #<?= $order['order_id'] ?></h2>
    <hr>

    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            Informasi Pesanan
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>ID Pesanan</th>
                    <td><?= $order['order_id'] ?></td>
                </tr>
                <tr>
                    <th>Nama Pelanggan</th>
                    <td><?= htmlspecialchars($order['customer_name']) ?></td>
                </tr>
                <tr>
                    <th>Email Pelanggan</th>
                    <td><?= htmlspecialchars($order['customer_email']) ?></td>
                </tr>
                <tr>
                    <th>Nama Produk</th>
                    <td><?= htmlspecialchars($order['product_name']) ?></td>
                </tr>
                <tr>
                    <th>Jumlah</th>
                    <td><?= $order['quantity'] ?></td>
                </tr>
                <tr>
                    <th>Total Harga</th>
                    <td>$<?= number_format($order['amount'], 2) ?></td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        <span class="badge bg-<?php
                            switch ($order['status']) {
                                case 'Completed':
                                    echo 'success';
                                    break;
                                case 'Pending':
                                    echo 'warning';
                                    break;
                                case 'Cancelled':
                                    echo 'danger';
                                    break;
                                case 'Shipped':
                                    echo 'info';
                                    break;
                                default:
                                    echo 'secondary';
                            }
                        ?>">
                            <?= $order['status'] ?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>Tanggal Pesan</th>
                    <td><?= $order['order_date'] ?></td>
                </tr>
            </table>
        </div>
        <div class="card-footer">
            <a href="orders.php" class="btn btn-secondary">Kembali ke Daftar Pesanan</a>
        </div>
    </div>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> 
</body>
</html>