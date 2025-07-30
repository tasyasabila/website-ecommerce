<?php
session_start();

require '../../config/koneksi.php';

// Ambil data admin dari session atau database
$admin_id = $_SESSION['admin']; // asumsi session menyimpan id admin

$query = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();

// Jika tidak ditemukan
if (!$admin) {
    die("Admin tidak ditemukan.");
}

// Handle form submit untuk update profil
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);

    $update_query = "UPDATE users SET name = ?, email = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("ssi", $name, $email, $admin_id);

    if ($update_stmt->execute()) {
        $_SESSION['success'] = "Profil berhasil diperbarui.";
        header("Location: profile.php");
        exit;
    } else {
        $error = "Gagal memperbarui profil.";
    }
}

// Handle update password
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
    $confirm_password = $_POST['confirm_password'];

    // Validasi password lama
    $check_query = "SELECT password FROM users WHERE id = ?";
    $check_stmt = $conn->prepare($check_query);
    $check_stmt->bind_param("i", $admin_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    $user = $check_result->fetch_assoc();

    if (!password_verify($current_password, $user['password'])) {
        $password_error = "Password lama salah.";
    } elseif ($new_password !== $confirm_password) {
        $password_error = "Password baru dan konfirmasi tidak cocok.";
    } else {
        $update_pass_query = "UPDATE users SET password = ? WHERE id = ?";
        $update_pass_stmt = $conn->prepare($update_pass_query);
        $update_pass_stmt->bind_param("si", $new_password, $admin_id);

        if ($update_pass_stmt->execute()) {
            $_SESSION['success'] = "Password berhasil diubah.";
            header("Location: profile.php");
            exit;
        } else {
            $password_error = "Gagal mengubah password.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile - Admin Panel</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"  rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css"> 
</head>
<body>

<!-- Sidebar & Main Content -->
<div class="container-fluid">
    <div class="row">

        <!-- Sidebar -->
        <div class="col-12 col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse" id="sidebarMenu">
            <div class="position-sticky pt-3">
                <div class="d-flex align-items-center justify-content-center mb-4">
                    <span class="fs-4 text-white fw-bold">Admin Panel</span>
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link text-white-50" href="../dashboard.php">
                            <i class="bi bi-house-door me-2"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white-50" href="../orders.php">
                            <i class="bi bi-file-earmark me-2"></i>
                            Orders
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white-50" href="../products.php">
                            <i class="bi bi-cart me-2"></i>
                            Products
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white-50" href="../customers.php">
                            <i class="bi bi-people me-2"></i>
                            Customers
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active text-white" href="#">
                            <i class="bi bi-person-circle me-2"></i>
                            Profile
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white-50" href="../settings.php">
                            <i class="bi bi-gear me-2"></i>
                            Settings
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 ms-sm-auto px-md-4">
            <h1 class="h2 my-4">Profile</h1>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success"><?= $_SESSION['success'] ?></div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <!-- Profil Info -->
            <div class="card mb-4">
                <div class="card-header">
                    My Account
                </div>
                <div class="card-body">
                    <form method="post">
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($admin['name']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($admin['email']) ?>" required>
                        </div>
                        <button type="submit" name="update_profile" class="btn btn-primary">Update Profile</button>
                    </form>
                </div>
            </div>

            <!-- Change Password -->
            <div class="card mb-4">
                <div class="card-header">
                    Change Password
                </div>
                <div class="card-body">
                    <form method="post">
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input type="password" class="form-control" id="current_password" name="current_password" required>
                        </div>
                        <div class="mb-3">
                            <label for="new_password" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        </div>
                        <?php if (isset($password_error)): ?>
                            <div class="alert alert-danger"><?= $password_error ?></div>
                        <?php endif; ?>
                        <button type="submit" name="change_password" class="btn btn-warning">Change Password</button>
                    </form>
                </div>
            </div>

            <!-- Avatar / Photo -->
            <div class="card">
                <div class="card-header">
                    Profile Picture
                </div>
                <div class="card-body">
                    <img src="https://placehold.co/150x150"  alt="Profile Picture" class="rounded-circle mb-3" width="150" height="150">
                    <p class="text-muted">You can upload a new photo using the settings page or custom form.</p>
                    <button class="btn btn-outline-secondary" disabled>Upload New Photo</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> 
</body>
</html>