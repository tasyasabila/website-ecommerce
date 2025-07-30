<?php
session_start();

require '../../config/koneksi.php';

// Ambil penjualan bulan ini
$startDate = date('Y-m-01');
$endDate = date('Y-m-t');

$query = "SELECT DATE(order_date) as date, SUM(amount) as total FROM orders WHERE order_date BETWEEN '$startDate' AND '$endDate' GROUP BY DATE(order_date)";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Sales Report - This Month</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"  rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Penjualan Bulan Ini</h2>
    <canvas id="salesChart" height="100"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script> 
<script>
const ctx = document.getElementById('salesChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: [
            <?php while ($row = $result->fetch_assoc()): ?>
                '<?= $row['date'] ?>',
            <?php endwhile; ?>
        ],
        datasets: [{
            label: 'Total Penjualan',
            data: [
                <?php $result->data_seek(0); while ($row = $result->fetch_assoc()): ?>
                    <?= $row['total'] ?>,
                <?php endwhile; ?>
            ],
            borderColor: 'rgb(255, 99, 132)',
            tension: 0.3
        }]
    }
});
</script>
</body>
</html>