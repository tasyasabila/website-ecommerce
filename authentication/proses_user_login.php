<?php
session_start();
include '../config/koneksi.php'; // koneksi ke database

// Validasi input
if (!isset($_POST['email'], $_POST['password'])) {
    echo "<script>alert('Mohon lengkapi data login!'); window.location='login_user.php';</script>";
    exit;
}

// Ambil dan amankan data
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = $_POST['password'];

// Cek apakah user ada
$query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) === 1) {
    $user = mysqli_fetch_assoc($result);

    // Verifikasi password
    if (password_verify($password, $user['password'])) {
        // Simpan data user di session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_name'] = $user['name'] ?? 'User';

        // Redirect ke dashboard user
        header("Location: ../pages/user/index_user.php");
        exit;
    } else {
        echo "<script>alert('Password salah!'); window.location='../pages/auth/login_user.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('Akun tidak ditemukan!'); window.location='../pages/auth/login_user.php';</script>";
    exit;
}
?>
