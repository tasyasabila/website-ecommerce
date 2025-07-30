<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>User Login Page</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css"/>
</head>
<body class="bg-light">
  <div class="container py-5">
    <div class="row justify-content-center min-vh-100 align-items-center">
      <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">
        <!-- Login Card -->
        <div class="card border-0 shadow-lg rounded-4 p-3 p-md-4 bg-white">
          <!-- Card Header -->
          <div class="card-header bg-transparent border-0 text-center py-4">
            <img src="https://placehold.co/80x80" alt="Logo" class="mb-4 rounded-circle">
            <h2 class="fw-bold">Login User</h2>
            <p class="text-muted">Login to access your account</p>
          </div>

          <!-- Card Body -->
          <div class="card-body">
            <form action="../../authentication/proses_user_login.php" method="POST">
              <!-- Email Input -->
              <div class="mb-4">
                <label for="email" class="form-label">Email address</label>
                <div class="input-group">
                  <span class="input-group-text bg-light">
                    <i class="bi bi-envelope"></i>
                  </span>
                  <input type="email" class="form-control py-2" id="email" name="email" placeholder="name@example.com" required>
                </div>
              </div>

              <!-- Password Input -->
              <div class="mb-4">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                  <span class="input-group-text bg-light">
                    <i class="bi bi-lock"></i>
                  </span>
                  <input type="password" class="form-control py-2" id="password" name="password" placeholder="Enter your password" required>
                </div>
              </div>

              <!-- Remember Me & Forgot Password -->
              <div class="d-flex justify-content-between mb-4">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="rememberMe" name="remember">
                  <label class="form-check-label" for="rememberMe">Remember me</label>
                </div>
                <a href="#" class="text-decoration-none">Forgot password?</a>
              </div>

              <!-- Login Button -->
              <button type="submit" class="btn btn-primary w-100 py-2 mb-4 fw-semibold">Login</button>
            </form>

            <!-- Divider -->
            <div class="position-relative my-4">
              <hr>
              <p class="small position-absolute top-50 start-50 translate-middle bg-white px-3 text-muted">OR CONTINUE WITH</p>
            </div>

            <!-- Social Login -->
            <div class="d-flex justify-content-center gap-3 mb-4">
              <button class="btn btn-outline-secondary rounded-circle p-2">
                <i class="bi bi-facebook fs-5"></i>
              </button>
              <button class="btn btn-outline-secondary rounded-circle p-2">
                <i class="bi bi-google fs-5"></i>
              </button>
              <button class="btn btn-outline-secondary rounded-circle p-2">
                <i class="bi bi-twitter fs-5"></i>
              </button>
            </div>

            <!-- Register Link -->
            <div class="text-center mt-4">
              <p class="mb-0">Don't have an account? 
                <a href="register.php" class="text-decoration-none fw-semibold">Register as User</a>
              </p>
            </div>
          </div>
        </div>

        <!-- Footer -->
        <div class="text-center text-muted mt-4">
          <small>&copy; 2025 Your Company. All rights reserved.</small>
        </div>

        <!-- Link ke Login Admin -->
        <div class="text-center mt-2">
          <p>Admin? <a href="login_admin.php">Login as Admin</a></p>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap 5 JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
