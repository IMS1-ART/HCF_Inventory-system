<?php
// Include database connection
include("connect.php");

// Function to sanitize input data
function sanitize($data) {
    return stripslashes(trim($data));
}

// Check if product ID is provided
if(isset($_GET['product_id'])) {
    $product_id = sanitize($_GET['product_id']);
    
    // Retrieve product information from database
    $stmt = $conn->prepare("SELECT p.*, c.category_name 
                            FROM product p 
                            JOIN category c ON p.category_id = c.category_id 
                            WHERE p.product_id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if product exists
    if($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        // Fetch all categories from the category table
        $category_query = "SELECT category_id, category_name FROM category";
        $category_result = $conn->query($category_query);
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
            <a href="http://localhost/HCF/admin/void_order.php"><i class="fas fa-trash-alt"></i> Void Orders</a>
            <a href="http://localhost/HCF/admin/report.php"><i class="fas fa-chart-line"></i> Reports</a>
        </div>

        <!-- Page content -->
        <div class="content">
            <!-- Your page content goes here -->
            <h2>Welcome to the Admin Dashboard</h2>
            <p>This is where you manage your inventory and other administrative tasks.</p>

            <div class="container">
                <h2>Edit Product</h2>
                <form method="post" action="update_product.php">
    <input type="hidden" name="product_id" value="<?= $row['product_id'] ?>">
    <div class="form-group">
        <label for="productName">Name:</label>
        <input type="text" class="form-control" id="productName" name="product_name" value="<?= htmlspecialchars($row['product_name']) ?>">
    </div>
    <div class="form-group">
        <label for="category">Category:</label>
        <select class="form-control" id="category" name="category_id">
            <?php
            // Display category options in the dropdown
            while ($category_row = $category_result->fetch_assoc()) {
                $selected = ($row['category_id'] == $category_row['category_id']) ? 'selected' : '';
                echo "<option value='" . $category_row['category_id'] . "' $selected>" . htmlspecialchars($category_row['category_name']) . "</option>";
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="productPrice">Price:</label>
        <input type="text" class="form-control" id="productPrice" name="product_price" value="<?= htmlspecialchars($row['product_price']) ?>">
    </div>
    <div class="form-group">
        <label for="productQuantity">Quantity:</label>
        <input type="text" class="form-control" id="productQuantity" name="product_quantity" value="<?= htmlspecialchars($row['product_quantity']) ?>">
    </div>
    <div class="form-group">
        <label for="productDescription">Description:</label>
        <input type="text" class="form-control" id="productDescription" name="product_description" value="<?= htmlspecialchars($row['product_description']) ?>">
    </div>
    <button type="submit" class="btn btn-primary" name="update_product">Update</button>
</form>

            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        </body>
        </html>
        <?php
            } else {
                echo "Product not found.";
            }

            $stmt->close();
        } else {
            echo "Product ID not provided.";
        }

        $conn->close();
        ?>
