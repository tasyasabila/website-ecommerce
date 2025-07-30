<?php
session_start();

require '../../config/koneksi.php';

// Ambil penjualan tahun ini
$startDate = date('Y-01-01');
$endDate = date('Y-12-31');

$query = "SELECT MONTH(order_date) as month, SUM(amount) as total FROM orders WHERE order_date BETWEEN '$startDate' AND '$endDate' GROUP BY MONTH(order_date)";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Sales Report - This Year</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"  rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Penjualan Tahun Ini</h2>
    <canvas id="salesChart" height="100"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script> 
<script>
const ctx = document.getElementById('salesChart').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        datasets: [{
            label: 'Total Penjualan',
            data: [
                <?php for ($i=1; $i<=12; $i++): 
                    $result->data_seek(0);
                    $found = false;
                    while ($row = $result->fetch_assoc()):
                        if ($row['month'] == $i):
                            echo $row['total'];
                            $found = true;
                            break;
                        endif;
                    endwhile;
                    if (!$found) echo 0;
                    echo ',';
                endfor; ?>
            ],
            backgroundColor: 'rgba(255, 99, 132, 0.6)'
        }]
    }
});
</script>
</body>
</html>