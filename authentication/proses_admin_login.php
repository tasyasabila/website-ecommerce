<?php
ob_start();
session_start();
include '../config/koneksi.php';

if (!isset($_POST['email'], $_POST['password'])) {
    echo "<script>alert('Mohon lengkapi data login!'); window.location='../pages/auth/login_admin.php';</script>";
    exit;
}

$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = $_POST['password'];

$query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) === 1) {
    $user = mysqli_fetch_assoc($result);

    // Cek apakah dia admin
    if ($user['role'] !== 'admin') {
        echo "<script>alert('Anda bukan admin!'); window.location='../pages/auth/login_admin.php';</script>";
        exit;
    }

    if (password_verify($password, $user['password'])) {
        $_SESSION['admin_id'] = $user['id'];
        $_SESSION['admin_email'] = $user['email'];
        $_SESSION['admin_name'] = $user['name'];
        $_SESSION['role'] = 'admin';

        header("Location: /project-latihanlive/pages/admin/index_admin.php");
        echo "Redirecting...";
        exit;
    } else {
        echo "<script>alert('Password salah!'); window.location='../pages/auth/login_admin.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('Akun tidak ditemukan!'); window.location='../pages/auth/login_admin.php';</script>";
    exit;
}
?>
