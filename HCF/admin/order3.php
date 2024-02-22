<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Staffs</title>
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
        /* Color scheme selector button */
    .color-scheme-selector {
        margin-right: 20px;
    }

    .color-scheme-selector button {
        background-color: #fff;
        color: #333;
        border: none;
        padding: 5px 10px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .color-scheme-selector button:hover {
        background-color: #ddd;
    }

    /* Content area */
    .content {
        padding: 20px;
        background-color: #f4f4f4;
    }

    /* Dark mode */
    .dark-mode .navbar {
        background-color: #222;
    }

    .dark-mode .navbar-brand {
        color: #fff;
    }

    .dark-mode .content {
        background-color: #333;
        color: #fff;
    }

    /* Light mode */
    .light-mode .navbar {
        background-color: #f0f0f0;
        color: #333;
    }

    .light-mode .navbar-brand {
        color: #333;
    }

    .light-mode .content {
        background-color: #f4f4f4;
        color: #333;
    }

    /* Blue mode */
    .blue-mode .navbar {
        background-color: #007bff;
    }

    .blue-mode .navbar-brand {
        color: #fff;
    }

    .blue-mode .content {
        background-color: #cce5ff;
        color: #007bff;
    }
    /* Dyslexia-friendly color scheme */
    .dyslexic-mode .navbar {
        background-color: #ffdb4d; /* Yellow */
        color: #000; /* Black */
    }

    .dyslexic-mode .navbar-brand {
        color: #000; /* Black */
    }

    .dyslexic-mode .content {
        background-color: #fff; /* White */
        color: #000; /* Black */
    }
    /* Dyslexia-friendly font styles */
    @font-face {
        font-family: 'Open Dyslexic';
        src: url('https://cdn.jsdelivr.net/npm/font-open-dyslexic@2/fonts/OpenDyslexic-Regular.otf');
        font-weight: normal;
        font-style: normal;
    }

    @font-face {
        font-family: 'Open Dyslexic';
        src: url('https://cdn.jsdelivr.net/npm/font-open-dyslexic@2/fonts/OpenDyslexic-Bold.otf');
        font-weight: bold;
        font-style: normal;
    }
    .settings {
        position: relative;
    }

    .settings-content {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 200px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        padding: 10px;
        z-index: 1;
    }

    .settings-content.show {
        display: block;
    }

    .settings-content button {
        width: 100%;
        text-align: left;
    }
    
    </style>
</head>
<body>
    <div class="full-screen">
        <div>
            <!-- Top Navbar -->
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <a class="navbar-brand" href="#">Admin Dashboard</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="fas fa-user"></i> Customers</a>
                        </li>
                    </ul>
                    <div class="settings">
                        <button onclick="toggleSettings()"><i class="fas fa-cog"></i> Settings</button>
                        <div id="settingsContent" class="settings-content">
                            <div class="language-selector">
                                <label for="language-select">Language:</label>
                                <select id="language-select" onchange="changeLanguage()">
                                    <option value="en">English</option>
                                    <option value="fr">French</option>
                                </select>
                            </div>
                            <div class="color-scheme-selector">
                                <button onclick="toggleColorScheme()"><i class="fas fa-palette"></i> Color Scheme</button>
                                <div id="color-preview"></div>
                            </div>
                            <div class="font-style-selector">
                                <button onclick="toggleFontStyle()"><i class="fas fa-font"></i> Font Style</button>
                                <div id="font-preview"></div>
                            </div>
                        </div>
                    </div>

                </div>
            </nav>
        </div>
        <!-- Left Sidebar -->
        <div class="sidebar">
            <a href="http://localhost/HCF/admin/product.php"><i class="fas fa-box"></i> Inventory</a>
            <a href="http://localhost/HCF/admin/customer.php"><i class="fas fa-user"></i> Customers</a>
            <a href="http://localhost/HCF/admin/staffs.php"><i class="fas fa-users"></i> Staffs</a>
            <a href="http://localhost/HCF/admin/category.php"><i class="fas fa-tags"></i> Product Categories</a>
            <a href="http://localhost/HCF/admin/order.php"><i class="fas fa-shopping-cart"></i> Orders</a>
            <a href="http://localhost/HCF/admin/served_order.php"><i class="fas fa-utensils"></i> Served Orders</a>
            <a href="http://localhost/HCF/admin/view_void_order.php"><i class="fas fa-trash-alt"></i> Void Orders</a>
            <a href="http://localhost/HCF/admin/report.php"><i class="fas fa-chart-line"></i> Reports</a>
        </div>

        <!-- Page content -->
        <div class="content">
            <!-- Your page content goes here -->
            <h2>Welcome to the Admin Dashboard</h2>
            <p>This is where you manage your inventory and other administrative tasks.</p>

            <div class="container">
        <?php
        // Include database connection
        include("connect.php");

        // Fetch orders from the database
        $order_query = "SELECT o.order_id, c.customer_name, p.product_name, o.quantity, o.total_price, o.order_date
                                FROM `order` o 
                                JOIN customer c ON o.customer_id = c.customer_id
                                JOIN product p ON o.product_id = p.product_id";

        $order_result = $conn->query($order_query);

        // Check if there are orders
        if ($order_result->num_rows > 0) 
        // Display orders in a table
        echo "<h2>Orders</h2>";
        echo "<table class='table table-bordered table-striped'>";
        echo "<thead class='thead-dark'>";
        echo "<tr>";
        echo "<th>ID</th><th>Customer Name</th><th>Product name</th><th>Quantity</th><th>Total Price(£)</th><th>Order Date</th><th>Action</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        // Fetch and display each order row
        while ($row = $order_result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["order_id"] . "</td>";
            echo "<td>" . $row["customer_name"] . "</td>"; // Display customer_name instead of customer_id
            echo "<td>" . $row["product_name"] . "</td>";// Display product_name instead of customer_id
            echo "<td>" . $row["quantity"] . "</td>";
            echo "<td>" . $row["total_price"] . "</td>";
            echo "<td>" . $row["order_date"] . "</td>"; // Display order date
            echo "<td>";
            // Button to send order to kitchen
            echo "<button class='btn btn-primary' onclick='sendToKitchen(" . $row["order_id"] . ")'><i class='fas fa-utensils'></i> Send to Kitchen</button>";
            // Button to void order
            echo "<button class='btn btn-danger' onclick='voidOrder(" . $row["order_id"] . ")'><i class='fas fa-trash-alt'></i> Void Order</button>";
            // Button to edit order
            echo "<a class='btn btn-info' href='edit_order.php?order_id=" . $row["order_id"] . "'><i class='fas fa-edit'></i> Edit</a>";
            echo "</td>";
            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";

        if ($order_result->num_rows == 0) {
            echo "No orders found.";
        }
        // Check if the form is submitted
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            // Retrieve form data
            $customer_id = $_POST['customer_id'];
            $product_id = $_POST['product_id'];
            $quantity = $_POST['quantity'];

            // Fetch product price from the database based on the selected product_id
            $product_query = "SELECT product_price FROM product WHERE product_id = ?";
            $stmt = $conn->prepare($product_query);
            $stmt->bind_param("i", $product_id);
            $stmt->execute();
            $result = $stmt->get_result();

            // Check if product price is fetched successfully
            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                $product_price = $row['product_price'];

                // Calculate total price
                $total_price = $product_price * $quantity;

                // Insert the order into the database
                $insert_query = "INSERT INTO `order` (customer_id, product_id, quantity, total_price, order_date) VALUES (?, ?, ?, ?, NOW())";
                $stmt = $conn->prepare($insert_query);
                $stmt->bind_param("iiid", $customer_id, $product_id, $quantity, $total_price);
                if ($stmt->execute()) {
                    echo "Order created successfully.";
                } else {
                    echo "Error creating order.";
                }
            } else {
                echo "Failed to fetch product price.";
            }


            // Close the prepared statement
            $stmt->close();
        }

        ?>

<!-- Button to add new Order -->
<button class="btn btn-primary btn-add-staff" onclick="showForm()">Add New Order</button>
<!-- Form to create an order -->
<div id="orderForm" style="display:none;">
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="needs-validation" novalidate>
        <div class="form-group">
            <label for="customerSelect">Select Customer:</label>
            <select name="customer_id" id="customerSelect" class="form-control" required>
                <?php
                // Fetch customers from the database
                $customer_query = "SELECT * FROM customer";
                $customer_result = $conn->query($customer_query);
                if ($customer_result->num_rows > 0) {
                    while ($customer_row = $customer_result->fetch_assoc()) {
                        echo "<option value='" . $customer_row['customer_id'] . "'>" . $customer_row['customer_name'] . "</option>";
                    }
                }
                ?>
            </select>
            <div class="invalid-feedback">Please select a customer.</div>
        </div>
        <div class="form-group">
            <label for="productSelect">Select Product:</label>
            <select name="product_id" id="productSelect" class="form-control" required>
                <?php
                // Fetch products from the database
                $product_query = "SELECT * FROM product";
                $product_result = $conn->query($product_query);
                if ($product_result->num_rows > 0) {
                    while ($product_row = $product_result->fetch_assoc()) {
                        echo "<option value='" . $product_row['product_id'] . "'>" . $product_row['product_name'] . " ($" . $product_row['product_price'] . ")" . "</option>";
                    }
                }
                ?>
            </select>
            <div class="invalid-feedback">Please select a product.</div>
        </div>
        <div class="form-group">
            <label for="quantityInput">Quantity:</label>
            <input type="number" name="quantity" id="quantityInput" class="form-control" min="1" value="1" required>
            <div class="invalid-feedback">Please enter a valid quantity.</div>
        </div>
        <button type="submit" class="btn btn-primary">Create Order</button>
    </form>
</div>


<script>
function showForm() {
    var form = document.getElementById("orderForm");
    if (form.style.display === "none") {
        form.style.display = "block";
    } else {
        form.style.display = "none";
    }
}

function sendToKitchen(orderId) {
    var confirmSend = confirm("Are you sure you want to send this order to the kitchen?");
    if (confirmSend) {
        // Here you can perform AJAX request to update order status to "Sent to Kitchen"
        // For demonstration, I'm just displaying a message
        alert("Order successfully sent to the kitchen.");

        // Now, insert the served order into the served_order table using AJAX
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "served_order.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Handle response if needed
                console.log(xhr.responseText);
            }
        };
        xhr.send("order_id=" + orderId);
    }
}

function voidOrder(orderId) {
    var confirmVoid = confirm("Are you sure you want to void this order?");
    if (confirmVoid) {
        // Here you can perform AJAX request to void the order
        // For demonstration, I'm just displaying a message
        alert("Order successfully voided.");

        // Now, insert the voided order into the void_order table using AJAX
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "void_order_insert.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Handle response if needed
                console.log(xhr.responseText);
            }
        };
        xhr.send("order_id=" + orderId);
    }
}
</script>
