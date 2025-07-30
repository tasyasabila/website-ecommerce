<?php
session_start();

require '../../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_name = $_POST['product_name'] ?? '';
    $price = $_POST['price'] ?? '';
    $description = $_POST['full_description'] ?? '';
    $category = $_POST['category'] ?? '';
    $image_name = '';

    if ($product_name && $price && $category) {
        // Proses upload gambar
        if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] == 0) {
            $image_name = uniqid() . '_' . $_FILES['product_image']['name'];
            $tmp = $_FILES['product_image']['tmp_name'];
            $target = 'uploads/' . $image_name;
            move_uploaded_file($tmp, $target);
        }

        // Simpan ke database
        $stmt = $conn->prepare("INSERT INTO products (name, price, description, category_id, image_url) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sdsss", $product_name, $price, $description, $category, $image_name);
        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Produk berhasil disimpan ke database.</div>";
        } else {
            echo "<div class='alert alert-danger'>Gagal menyimpan ke database.</div>";
        }
        $stmt->close();
    } else {
        echo "<div class='alert alert-danger'>Harap lengkapi semua kolom yang wajib diisi.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Product - Admin Dashboard</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        #imagePreview {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border: 1px solid #ddd;
            border-radius: 10px;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar Navigation -->
            <div class="col-12 col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse" id="sidebarMenu">
                <div class="position-sticky pt-3">
                    <div class="d-flex align-items-center justify-content-center mb-4">
                        <span class="fs-4 text-white fw-bold">Admin Panel</span>
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link text-white-50" href="index_admin.php">
                                <i class="bi bi-house-door me-2"></i>
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white-50" href="orders.php">
                                <i class="bi bi-file-earmark me-2"></i>
                                Orders
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active text-white" href="products.php">
                                <i class="bi bi-cart me-2"></i>
                                Products
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white-50" href="customers.php">
                                <i class="bi bi-people me-2"></i>
                                Customers
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white-50" href="reports.php">
                                <i class="bi bi-bar-chart me-2"></i>
                                Reports
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white-50" href="settings.php">
                                <i class="bi bi-gear me-2"></i>
                                Settings
                            </a>
                        </li>
                    </ul>

                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        <span>Saved reports</span>
                    </h6>
                    <ul class="nav flex-column mb-2">
                        <li class="nav-item">
                            <a class="nav-link text-white-50" href="#">
                                <i class="bi bi-file-text me-2"></i>
                                Current month
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white-50" href="#">
                                <i class="bi bi-file-text me-2"></i>
                                Last quarter
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 ms-sm-auto px-md-4">
                <!-- Header -->
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <div>
                        <button class="btn btn-sm d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu">
                            <i class="bi bi-list fs-5"></i>
                        </button>
                        <h1 class="h2 d-inline-block ms-2">Add New Product</h1>
                    </div>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary position-relative">
                                <i class="bi bi-bell"></i>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    3
                                </span>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-envelope"></i>
                            </button>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle d-flex align-items-center" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown">
                                <img src="https://via.placeholder.com/32" class="rounded-circle me-2" width="32" height="32" alt="User">
                                <span>Admin User</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#">Profile</a></li>
                                <li><a class="dropdown-item" href="#">Settings</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#">Sign out</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#" class="text-decoration-none">Home</a></li>
                        <li class="breadcrumb-item"><a href="#" class="text-decoration-none">Products</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add New Product</li>
                    </ol>
                </nav>

                <!-- Product Form -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <form class="needs-validation" novalidate action="" method="POST" enctype="multipart/form-data">
                            <!-- Form Tabs -->
                            <ul class="nav nav-tabs mb-4" id="productTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="basic-tab" data-bs-toggle="tab" data-bs-target="#basic-info" type="button" role="tab" aria-controls="basic-info" aria-selected="true">Basic Info</button>
                                </li>
                            </ul>

                            <!-- Tab Content -->
                            <div class="tab-content" id="productTabContent">
                                <!-- Basic Info Tab -->
                                <div class="tab-pane fade show active" id="basic-info" role="tabpanel" aria-labelledby="basic-tab">
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label for="productName" class="form-label">Product Name <span class="text-danger">*</span></label>
                                            <input type="text" name="product_name" class="form-control" id="productName" placeholder="Enter product name" required>
                                            <div class="invalid-feedback">Please provide a product name.</div>
                                        </div>

                                        <div class="col-12">
                                            <label for="price" class="form-label">Price <span class="text-danger">*</span></label>
                                            <input type="text" name="price" class="form-control" id="price" placeholder="Enter price" required>
                                            <div class="invalid-feedback">Please provide a price.</div>
                                        </div>

                                        <div class="col-12">
                                            <label for="fullDescription" class="form-label">Full Description</label>
                                            <textarea name="full_description" class="form-control" id="fullDescription" rows="5" placeholder="Enter full product description"></textarea>
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
                                            <select class="form-select" name="category_id" id="category" required>
                                                <option value="" selected disabled>Select category</option>
                                                <?php
                                               

                                                // Ambil data kategori dari database
                                                $query = "SELECT id, name FROM categories ORDER BY name ASC";
                                                $result = $conn->query($query);

                                                while ($row = $result->fetch_assoc()) {
                                                    echo "<option value='{$row['id']}'>{$row['name']}</option>";
                                                }
                                                ?>
                                            </select>

                                            <div class="invalid-feedback">Please select a category.</div>
                                        </div>

                                        <div class="col-12">
                                            <label for="productImage" class="form-label">Upload Gambar</label>
                                            <input class="form-control" type="file" name="product_image" id="productImage" accept="image/*" onchange="previewImage(event)">
                                            <img id="imagePreview" src="#" alt="Preview Gambar" class="d-none" />
                                        </div>

                                        <div class="col-12 mt-4">
                                            <button type="submit" class="btn btn-success">Simpan Produk</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Form Actions -->
                    <div class="d-flex justify-content-between border-top mt-4 pt-4">
                        <button type="button" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle me-2"></i>Cancel
                        </button>
                        <div>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i>Publish Product
                            </button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>

            <!-- Footer -->
            <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
                <p class="col-md-4 mb-0 text-muted">&copy; 2025 Admin Dashboard</p>
                <ul class="nav col-md-4 justify-content-end">
                    <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Home</a></li>
                    <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Features</a></li>
                    <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Pricing</a></li>
                    <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">FAQs</a></li>
                    <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">About</a></li>
                </ul>
            </footer>
        </div>
    </div>
    </div>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Form Validation Script -->
    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() {
            'use strict'

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.prototype.slice.call(forms)
                .forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }

                        form.classList.add('was-validated')
                    }, false)
                })
        })()
    </script>
    <script>
        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById('imagePreview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('d-none');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>

</html>