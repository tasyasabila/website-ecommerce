<?php
session_start();
include('../../config/koneksi.php');
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Hapus item dari keranjang
if (isset($_GET['hapus'])) {
    $item_id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM carts WHERE id = $item_id AND user_id = $user_id");
}

// Update quantity
if (isset($_POST['update'])) {
    $item_id = $_POST['cart_id'];
    $qty = $_POST['quantity'];
    mysqli_query($conn, "UPDATE carts SET quantity = $qty WHERE id = $item_id AND user_id = $user_id");
}

// Ambil data keranjang
$result = mysqli_query($conn, "SELECT c.id, p.name, p.price, c.quantity 
    FROM carts c 
    JOIN products p ON c.product_id = p.id 
    WHERE c.user_id = $user_id");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Keranjang Saya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h3>Keranjang Anda</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Produk</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Total</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
            <tr>
                <td><?= $row['name']; ?></td>
                <td>Rp<?= number_format($row['price'], 0, ',', '.'); ?></td>
                <td>
                    <form method="post" style="display:flex; gap:5px;">
                        <input type="hidden" name="cart_id" value="<?= $row['id']; ?>">
                        <input type="number" name="quantity" value="<?= $row['quantity']; ?>" min="1" class="form-control" style="width:80px;">
                        <button name="update" class="btn btn-sm btn-success">Ubah</button>
                    </form>
                </td>
                <td>Rp<?= number_format($row['price'] * $row['quantity'], 0, ',', '.'); ?></td>
                <td><a href="?hapus=<?= $row['id']; ?>" class="btn btn-sm btn-danger">Hapus</a></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <a href="index_user.php" class="btn btn-primary">Kembali ke Dashboard</a>
</div>
</body>
</html>
