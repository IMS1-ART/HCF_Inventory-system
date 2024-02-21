<?php
// Include database connection
include("connect.php");
session_start();

// Insert Product
if(isset($_POST['submit_product'])) {
    // Retrieve form data
    $product_name = $_POST['product_name'];
    $category_name = $_POST['category_name']; // Change to category_name
    $product_price = $_POST['product_price'];
    $product_quantity = $_POST['product_quantity'];
    $product_description = $_POST['product_description'];
    
    // Retrieve category_id based on selected category_name
    $category_query = "SELECT category_id FROM category WHERE category_name = ?";
    $stmt = $conn->prepare($category_query);
    $stmt->bind_param("s", $category_name);
    $stmt->execute();
    $stmt->bind_result($category_id);
    $stmt->fetch();
    $stmt->close();

    // Prepare and execute SQL statement to insert product into database
    $stmt = $conn->prepare("INSERT INTO product (product_name, category_id, product_price, product_quantity, product_description) VALUES (?, ?, ?, ?, ?)");
    // Bind parameters to the prepared statement
    $stmt->bind_param("sidis", $product_name, $category_id, $product_price, $product_quantity, $product_description); // Use $category_id
    // Execute the statement
    $stmt->execute();
    
    // Check if product insertion was successful
    if($stmt->affected_rows > 0) {
        echo "Product inserted successfully.";
    } else {
        echo "Failed to insert product.";
    }
    // Close the prepared statement
    $stmt->close();
}
?>
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
        .product-table {
        width: 100%;
        border-collapse: collapse;
        }

        .product-table th,
        .product-table td {
            padding: 8px;
            border: 1px solid #dddddd;
            text-align: left;
        }

        .product-table th {
            background-color: #f2f2f2;
        }

        .product-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .product-table tr:hover {
            background-color: #f2f2f2;
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
    <div class="content">
    <!-- Your page content goes here -->
        <h2>Welcome to the Admin Dashboard</h2>
        <p>This is where you manage your inventory and other administrative tasks.</p>
        <div class="container">
            
                
            <?php
            // View Products
            $result = $conn->query("SELECT p.*, c.category_name FROM product p INNER JOIN category c ON p.category_id = c.category_id");

           // Check if there are products
            if ($result->num_rows > 0) {
                // Display products in a table
                echo "<h2>Products</h2>";
                echo "<table class='product-table'>";
                echo "<thead>";
                echo "<tr>";
                echo "<th>ID</th><th>Name</th><th>Category</th><th>Price</th><th>Quantity</th><th>Description</th><th>Action</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                // Fetch and display each product row
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>".$row["product_id"]."</td>";
                    echo "<td>".$row["product_name"]."</td>";
                    echo "<td>".$row["category_name"]."</td>"; // Display category_name
                    echo "<td>$".$row["product_price"]."</td>"; // Add currency symbol
                    echo "<td>".$row["product_quantity"]."</td>";
                    echo "<td>".$row["product_description"]."</td>";
                    // Links for editing and deleting the product
                    echo "<td><a href='edit_product.php?product_id=".$row["product_id"]."'>Edit<i class='fas fa-edit'></i></a> | <a href='delete_product.php?product_id=".$row["product_id"]."'>Delete<i class='fas fa-trash-alt'></i></a></td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
            } else {
                echo "<p>No products found.</p>";
            }



            // Fetch product categories for the form
            $product_result = $conn->query("SELECT category_id, category_name FROM category");

            ?>

            <!-- Button to add new Product -->
            <button onclick="showForm()">Add New Product</button>
            <!-- Form to insert product -->
            <div class="staff-form" id="productForm" style="display:none;">
                <form method="post" action="">
                    <label>Product Name:</label><br>
                    <input type="text" name="product_name"><br>
                    <label>Product Category:</label>
                    <select name="category_name"> <!-- Change to category_name -->
                        <?php
                        // Display category as options in the dropdown
                        while ($category_row = $product_result->fetch_assoc()) { // Change to category_row
                            echo "<option value='" . $category_row['category_name'] . "'>" . $category_row['category_name'] . "</option>";
                        }
                        ?>
                    </select>
                    <br>
                    <label>Product Price:</label><br>
                    <input type="text" name="product_price"><br>
                    <label>Product Quantity:</label><br>
                    <input type="text" name="product_quantity"><br>
                    <label>Product Description:</label><br>
                    <input type="text" name="product_description"><br>
                    <input type="submit" name="submit_product" value="Submit">
                </form>
            </div>
        </div>
    </div>
</body>
<script>
function showForm() {
    var form = document.getElementById("productForm");
    if (form.style.display === "none") {
        form.style.display = "block";
    } else {
        form.style.display = "none";
    }
}
</script>

