<?php
session_start();

require '../../config/koneksi.php';

// Ambil penjualan hari ini
$startDate = date('Y-m-d');
$endDate = date('Y-m-d');

$query = "SELECT DATE(order_date) as date, SUM(amount) as total FROM orders WHERE order_date BETWEEN '$startDate' AND '$endDate' GROUP BY DATE(order_date)";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Sales Report - Today</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"  rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Penjualan Hari Ini</h2>
    <canvas id="salesChart" height="100"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script> 
<script>
const ctx = document.getElementById('salesChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: [<?= json_encode(date('Y-m-d')) ?>],
        datasets: [{
            label: 'Total Penjualan',
            data: [<?= $result->fetch_assoc()['total'] ?? 0 ?>],
            borderColor: 'rgb(75, 192, 192)',
            tension: 0.3
        }]
    }
});
</script>
</body>
</html>