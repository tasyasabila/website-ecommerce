<?php
session_start();

require '../../config/koneksi.php';

// Ambil parameter periode dari URL
$period = isset($_GET['period']) ? $_GET['period'] : 'current_month';

// Query default: bulan ini
$startDate = date('Y-m-01');
$endDate = date('Y-m-t');

if ($period == 'last_quarter') {
    // Ambil data dari 3 bulan terakhir
    $startDate = date('Y-m-01', strtotime("-3 months"));
    $endDate = date('Y-m-t');
}

// Query penjualan berdasarkan periode
$query_sales = "
    SELECT 
        DATE(created_at) as date, 
        SUM(total_price) as total 
    FROM 
        orders 
    WHERE 
        created_at BETWEEN '$startDate' AND '$endDate'
    GROUP BY 
        DATE(created_at)
    ORDER BY 
        created_at ASC;
";

$result_sales = $conn->query($query_sales);

// Persiapkan data untuk chart
$labels = [];
$data = [];

while ($row = $result_sales->fetch_assoc()) {
    $labels[] = $row['date'];
    $data[] = $row['total'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reports - Admin Panel</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"  rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css"> 
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> 
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
                        <a class="nav-link text-white-50" href="products.php">
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
                        <a class="nav-link active text-white" href="#">
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

                <!-- Saved Reports -->
                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span>Saved reports</span>
                </h6>
                <ul class="nav flex-column mb-2">
                    <li class="nav-item">
                        <a class="nav-link text-white-50 <?= $period === 'current_month' ? 'active' : '' ?>" href="?period=current_month">
                            <i class="bi bi-file-text me-2"></i>
                            Current month
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white-50 <?= $period === 'last_quarter' ? 'active' : '' ?>" href="?period=last_quarter">
                            <i class="bi bi-file-text me-2"></i>
                            Last quarter
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 ms-sm-auto px-md-4">
            <h1 class="h2 my-4">Sales Reports</h1>

            <!-- Chart -->
            <div class="card mb-4">
                <div class="card-body">
                    <canvas id="salesChart" height="100"></canvas>
                </div>
            </div>

            <!-- Table -->
            <div class="card">
                <div class="card-header">
                    Sales Data
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Total Sales</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($labels)): ?>
                                    <?php foreach ($labels as $index => $date): ?>
                                        <tr>
                                            <td><?= $date ?></td>
                                            <td>$<?= number_format($data[$index], 2) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="2" class="text-center">No sales data found for this period.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart Script -->
<script>
const ctx = document.getElementById('salesChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?= json_encode($labels) ?>,
        datasets: [{
            label: 'Daily Sales',
            data: <?= json_encode($data) ?>,
            borderColor: 'rgb(75, 192, 192)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            tension: 0.3,
            fill: true,
            pointRadius: 4,
            pointBackgroundColor: 'rgb(75, 192, 192)'
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return '$' + value.toFixed(2);
                    }
                }
            }
        },
        plugins: {
            legend: {
                display: true
            }
        }
    }
});
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> 
</body>
</html>