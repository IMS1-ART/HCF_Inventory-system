<?php
include("connect.php");

// Fetch data from the database
$query = "SELECT DATE(order_date) AS date, SUM(total_price) AS total_price, SUM(quantity) AS total_quantity FROM `order` WHERE WEEK(order_date) = WEEK(NOW()) GROUP BY DATE(order_date)";
$result = $conn->query($query);

// Initialize arrays to store data
$dates = [];
$totalPrices = [];
$totalQuantities = [];

// Process the fetched data
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $dates[] = date('Y-m-d', strtotime($row['date'])); // Format date
        $totalPrices[] = $row['total_price'];
        $totalQuantities[] = $row['total_quantity'];
    }
}

// Prepare data to be passed to JavaScript
$data = [
    'dates' => $dates,
    'totalPrices' => $totalPrices,
    'totalQuantities' => $totalQuantities
];

// Convert PHP array to JSON format
echo json_encode($data);

// Close the database connection
$conn->close();
?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weekly Sales Report</title>
    <!-- Include Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h2>Weekly Sales Report</h2>
    <!-- Canvas element to render the chart -->
    <canvas id="salesChart" width="800" height="400"></canvas>
    <script src="generate_report.js"></script>
</body>
</html>