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

// Close the database connection
$conn->close();

// Output the data in JSON format
header('Content-Type: application/json');
echo json_encode($data);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Tables</title>
    <style>
        table {
            width: 50%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        caption {
            font-weight: bold;
            font-size: 1.2em;
            margin-bottom: 10px;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <div id="tablesContainer"></div>
    <script>
        // Function to fetch data from generate_report.php
        function fetchData() {
            // Make AJAX request to generate_report.php
            fetch('generate_report.php')
                .then(response => response.json()) // Parse response as JSON
                .then(data => {
                    // Call function to render tables with fetched data
                    renderTables(data);
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        }

        // Function to render tables with fetched data
        function renderTables(data) {
            // Get the element to append tables
            const tablesContainer = document.getElementById('tablesContainer');

            // Generate table for total quantity
            const quantityTable = generateTable('Total Quantity', data.dates, data.totalQuantities);
            tablesContainer.appendChild(quantityTable);

            // Generate table for total price
            const priceTable = generateTable('Total Price', data.dates, data.totalPrices);
            tablesContainer.appendChild(priceTable);
        }

        // Function to generate a table with headers and data
        function generateTable(title, labels, data) {
            // Create table element
            const table = document.createElement('table');

            // Create table caption
            const caption = table.createCaption();
            caption.textContent = title;

            // Create table header row
            const headerRow = table.insertRow();
            headerRow.insertCell().textContent = 'Date';
            headerRow.insertCell().textContent = title;

            // Insert data rows
            for (let i = 0; i < labels.length; i++) {
                const row = table.insertRow();
                row.insertCell().textContent = labels[i];
                row.insertCell().textContent = data[i];
            }

            return table;
        }

        // Call fetchData function when the page loads
        fetchData();
    </script>
</body>
</html>
