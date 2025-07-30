<?php
require '../../config/koneksi.php';

$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM users WHERE id=$id");
$data = mysqli_fetch_assoc($query);

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];

    mysqli_query($conn, "UPDATE users SET name='$name', email='$email' WHERE id=$id");
    header("Location: customers.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Customer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container p-5">
    <h3>Edit Customer</h3>
    <form method="POST">
        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="name" value="<?= $data['name'] ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" value="<?= $data['email'] ?>" class="form-control" required>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
        <a href="customers.php" class="btn btn-secondary">Batal</a>
    </form>
</body>
</html>
