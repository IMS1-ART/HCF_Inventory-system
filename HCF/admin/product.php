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
            <table class="staff-table"> 
                <tbody>
                
                    <?php
                    // View Products
                    $result = $conn->query("SELECT p.*, c.category_name FROM product p INNER JOIN category c ON p.category_id = c.category_id");

                // Check if there are products
                    if ($result->num_rows > 0) {
                        // Display products in a table
                        echo "<h2>Products</h2>";
                        echo "<div class='table-responsive'>";
                        echo "<table class='table table-bordered table-striped'>";
                        echo "<thead class='thead-dark'>";
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
                            echo "<td>£".$row["product_price"]."</td>"; // Add currency symbol
                            echo "<td>".$row["product_quantity"]."</td>";
                            echo "<td>".$row["product_description"]."</td>";
                            // Links for editing and deleting the product
                            echo "<td><a href='edit_product.php?product_id=".$row["product_id"]."' class='btn btn-primary btn-sm''>Edit<i class='fas fa-edit'></i></a> | <a href='delete_product.php?product_id=".$row["product_id"]."' class='btn btn-danger btn-sm''>Delete<i class='fas fa-trash-alt'></i></a></td>";
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
                </tbody>
            </table>
            <!-- Button to add new Product -->
            <button class="btn btn-primary btn-add-staff" onclick="showForm()">Add New Product</button>
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

