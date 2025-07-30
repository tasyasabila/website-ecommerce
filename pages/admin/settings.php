<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - Admin Panel</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"  rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css"> 
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar Navigation -->
            <div class="col-12 col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse" id="sidebarMenu">
                <!-- Sidebar content here -->
            </div>
            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 ms-sm-auto px-md-4">
                <h1 class="h2 mb-4">Settings</h1>
                <form>
                    <div class="mb-3">
                        <label for="siteName" class="form-label">Site Name</label>
                        <input type="text" class="form-control" id="siteName" value="My Store">
                    </div>
                    <div class="mb-3">
                        <label for="siteEmail" class="form-label">Site Email</label>
                        <input type="email" class="form-control" id="siteEmail" value="admin@example.com">
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> 
</body>
</html>