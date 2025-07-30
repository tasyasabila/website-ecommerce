<?php
session_start();

require '../../config/koneksi.php';

// Ambil penjualan minggu ini
$startDate = date('Y-m-d', strtotime('monday this week'));
$endDate = date('Y-m-d', strtotime('sunday this week'));

$query = "SELECT DATE(order_date) as date, SUM(amount) as total FROM orders WHERE order_date BETWEEN '$startDate' AND '$endDate' GROUP BY DATE(order_date)";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Sales Report - This Week</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"  rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Penjualan Minggu Ini</h2>
    <canvas id="salesChart" height="100"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script> 
<script>
const ctx = document.getElementById('salesChart').getContext('2d');
new Chart(ctx, {
    type: 'bar',
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
            backgroundColor: 'rgba(75, 192, 192, 0.6)'
        }]
    }
});
</script>
</body>
</html>