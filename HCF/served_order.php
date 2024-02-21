<?php
// Include database connection
include("connect.php");

// Check if form is submitted
if(isset($_POST['order_id'])) {
    // Retrieve form data
    $order_id = $_POST['order_id']; 

    // Insert voided order into served_order table
    $stmt_void = $conn->prepare("INSERT INTO served_order (order_id) VALUES (?)");
    $stmt_void->bind_param("i", $order_id);
    $stmt_void->execute();

    // Check if served_order insertion was successful
    if($stmt_void->affected_rows > 0) {
        // Remove served order from order table
        $stmt_delete = $conn->prepare("DELETE FROM `order` WHERE order_id = ?");
        $stmt_delete->bind_param("i", $order_id);
        $stmt_delete->execute();
        
        if($stmt_delete->affected_rows > 0) {
            echo "Order has been sent to the kitchen";
        } else {
            echo "Failed to send order.";
        }
    } else {
        echo "Failed to insert served_order.";
    }

    // Close the prepared statements
    $stmt_void->close();
    $stmt_delete->close();
}

// View served order
$served_order_query = "SELECT o.served_order_id,  o.order_id
            FROM `served_order` o 
            JOIN `order` c ON o.order_id = c.order_id";
$served_order_result = $conn->query($served_order_query);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Served Order</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Sidebar */
        .sidebar {
            height: 100%;
            width: 200px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #343a40;
            padding-top: 60px;
        }
        .sidebar a {
            padding: 10px;
            text-decoration: none;
            color: #f8f9fa;
            display: block;
               /* Hover effect to make words bigger */
            transition: font-size 0.3s;
        }
        .sidebar a:hover {
            background-color: #495057;
            font-size: 18px; /* Increase font size on hover */
        }
        /* Content */
        .content {
            margin-left: 250px;
            padding: 20px;
        }
        .container {
            margin-top: 20px;
        }
        .btn-add-staff {
            margin-bottom: 20px;
        }
        .staff-table th, .staff-table td {
            padding: 10px;
            border: 1px solid #dee2e6;
        }
        .staff-table th {
            background-color: #f8f9fa;
            font-weight: bold;
            text-align: left;
        }
        .staff-table tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .staff-table tr:nth-child(odd) {
            background-color: #ffffff;
        }
        .staff-form {
            margin-top: 20px;
        }
        .staff-form label {
            display: block;
            margin-bottom: 5px;
        }
        .staff-form input[type="text"] {
            width: 100%;
            padding: 5px;
            margin-bottom: 10px;
        }
        .staff-form input[type="submit"] {
            padding: 10px 20px;
            background-color: #007bff;
            color: #ffffff;
            border: none;
            cursor: pointer;
        }
        .staff-form input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <!-- Top Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Admin Dashboard</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="#"><i class="fas fa-user"></i> Customers</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"><i class="fas fa-users"></i> Staffs</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"><i class="fas fa-tags"></i> Product Categories</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"><i class="fas fa-shopping-cart"></i> Orders</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"><i class="fas fa-utensils"></i> Served Orders</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"><i class="fas fa-trash-alt"></i> Void Orders</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"><i class="fas fa-chart-line"></i> Reports</a>
            </li>
        </ul>
    </div>
</nav>

<!-- Left Sidebar -->
<div class="sidebar">
    <a href="http://localhost/HCF/product.php"><i class="fas fa-box"></i> Inventory</a>
    <a href="http://localhost/HCF/customer.php"><i class="fas fa-user"></i> Customers</a>
    <a href="http://localhost/HCF/staffs.php"><i class="fas fa-users"></i> Staffs</a>
    <a href="http://localhost/HCF/category.php"><i class="fas fa-tags"></i> Product Categories</a>
    <a href="http://localhost/HCF/order.php"><i class="fas fa-shopping-cart"></i> Orders</a>
    <a href="http://localhost/HCF/served_order.php"><i class="fas fa-utensils"></i> Served Orders</a>
    <a href="http://localhost/HCF/void_order.php"><i class="fas fa-trash-alt"></i> Void Orders</a>
    <a href="http://localhost/HCF/report.php"><i class="fas fa-chart-line"></i> Reports</a>
</div>

<!-- Page content -->
<div class="content">
    <!-- Your page content goes here -->
    <h2>Welcome to the Admin Dashboard</h2>
    <p>This is where you manage your inventory and other administrative tasks.</p>

    <div class="container">
        <h2>Served Order</h2>

        <!-- Served_order table -->
        <table class="served_order-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Customer Name</th>
                </tr>
            </thead>
            <tbody>
            <tbody>
            <tbody>
                <?php
                // Display served_order in a table
                while($row = $served_order_result->fetch_assoc()) {
                    // Fetch additional details from order table
                    $order_details_query = "SELECT c.customer_name, p.product_name, o.total_price, o.date
                                            FROM `order` o
                                            JOIN customer c ON o.customer_id = c.customer_id
                                            JOIN product p ON o.product_id = p.product_id
                                            WHERE o.order_id = " . $row['order_id'];
                    $order_details_result = $conn->query($order_details_query);
                    $order_details = $order_details_result->fetch_assoc();
                    
                    echo "<tr>";
                    echo "<td>".$row["served_order_id"]."</td>";
                    echo "<td>".$order_details["customer_name"]."</td>";
                    echo "<td>".$order_details["product_name"]."</td>";
                    echo "<td>".$order_details["total_price"]."</td>";
                    echo "<td>".$order_details["date"]."</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>

            </tbody>

            </tbody>
        </table>

    </div>
</div>

<!-- Bootstrap JS and Font Awesome JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js"></script>

</body>
</html>