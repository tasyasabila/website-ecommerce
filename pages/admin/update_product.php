<?php
session_start();
require '../../config/koneksi.php';

// Ambil dan filter input
$product_id = $_POST['product_id'] ?? null;
$meta_title = mysqli_real_escape_string($conn, $_POST['meta_title'] ?? '');
$meta_description = mysqli_real_escape_string($conn, $_POST['meta_description'] ?? '');
$meta_keywords = mysqli_real_escape_string($conn, $_POST['meta_keywords'] ?? '');
$product_slug = mysqli_real_escape_string($conn, $_POST['product_slug'] ?? '');

// Validasi ID produk
if (!$product_id) {
    echo "<script>alert('ID produk tidak ditemukan.'); window.history.back();</script>";
    exit;
}

// Update SEO ke database
$query = "UPDATE products SET 
            meta_title = '$meta_title',
            meta_description = '$meta_description',
            meta_keywords = '$meta_keywords',
            slug = '$product_slug'
          WHERE id = $product_id";

if (mysqli_query($conn, $query)) {
    echo "<script>alert('SEO produk berhasil diperbarui!'); window.location.href='daftar_produk.php';</script>";
} else {
    echo "<script>alert('Gagal memperbarui SEO: " . mysqli_error($conn) . "'); window.history.back();</script>";
}
?>
