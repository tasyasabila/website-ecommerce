<?php
session_start();
include '../../config/koneksi.php';

$query = "SELECT p.id, p.name, p.price, pi.image_path 
          FROM products p 
          LEFT JOIN product_images pi ON p.id = pi.product_id 
          GROUP BY p.id";

$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {
    echo '
    <div class="product-card">
        <img src="assets/uploads/' . htmlspecialchars($row['image_path']) . '" width="200">
        <h5>' . htmlspecialchars($row['name']) . '</h5>
        <p>Rp ' . number_format($row['price']) . '</p>
    </div>';
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard User - KlikFashion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="#">KlikFashion</a>
    <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link active" href="#">Beranda</a></li>
        <li class="nav-item"><a class="nav-link" href="cart.php">Keranjang</a></li>
        <li class="nav-item"><a class="nav-link text-danger" href="../../authentication/logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Hero Section -->
<section class="bg-light text-center py-5 mb-4">
  <div class="container">
    <h1 class="display-5 fw-bold">Selamat Datang di KlikFashion</h1>
    <p class="lead">Temukan koleksi pakaian terbaik dengan harga terjangkau!</p>
  </div>
</section>

<!-- Filter dan Search -->
<div class="container mb-4">
  <div class="row g-2 align-items-center">
    <div class="col-md-6">
      <form method="GET" action="">
        <div class="input-group">
          <input type="text" name="search" class="form-control" placeholder="Cari produk...">
          <button class="btn btn-outline-secondary" type="submit">Cari</button>
        </div>
      </form>
    </div>
    <div class="col-md-6 text-end">
      <form method="GET" action="">
        <select name="category" class="form-select" onchange="this.form.submit()">
          <option value="">Semua Kategori</option>
          <option value="1">Atasan</option>
          <option value="2">Celana</option>
          <option value="3">Jaket</option>
          <option value="4">Dress</option>
        </select>
      </form>
    </div>
  </div>
</div>

<!-- Produk -->
<div class="container" id="produk">
  <div class="row">
    <?php
    $where = "";
    if (isset($_GET['search'])) {
        $search = mysqli_real_escape_string($conn, $_GET['search']);
        $where = "WHERE name LIKE '%$search%'";
    } elseif (isset($_GET['category']) && $_GET['category'] != "") {
        $cat = intval($_GET['category']);
        $where = "WHERE category_id = $cat";
    }

    $query = "SELECT * FROM products $where ORDER BY id DESC";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
    ?>
      <div class="col-md-4 mb-4">
        <div class="card h-100">
          <img src="../uploads/<?= $row['image'] ?>" class="card-img-top" alt="<?= $row['name'] ?>" style="height:300px;object-fit:cover;">
          <div class="card-body">
            <h5 class="card-title"><?= $row['name'] ?></h5>
            <p class="card-text text-muted">Rp<?= number_format($row['price'], 0, ',', '.') ?></p>
            <a href="add_to_cart.php?id=<?= $row['id'] ?>" class="btn btn-success w-100">Tambah ke Keranjang</a>
          </div>
        </div>
      </div>
    <?php 
        }
    } else {
        echo "<div class='col-12'><p class='text-center'>Produk tidak ditemukan.</p></div>";
    }
    ?>
  </div>
</div>

<!-- Footer -->
<footer class="bg-dark text-white text-center py-3 mt-4">
  <div class="container">
    <p class="mb-0">&copy; <?= date('Y') ?> KlikFashion. All rights reserved.</p>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
