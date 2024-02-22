<?php
// Include database connection
include("connect.php");
session_start();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!----======== CSS ======== -->
    <link rel="stylesheet" href="style.css" />

    <!----===== Boxicons CSS ===== -->
    <link
      href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css"
      rel="stylesheet"
    />
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Admin Dashboard</title>
  </head>
  <body>
    <nav class="sidebar close">
      <header>
        <div class="image-text">
          <span class="image">
            <img src="logo.png" alt="" />
          </span>

          <div class="text logo-text">
            <span class="name">Username</span>
            <span class="profession">Role</span>
          </div>
        </div>

        <i class="bx bx-chevron-right toggle"></i>
      </header>

      <div class="menu-bar">
        <div class="menu">
          <li class="search-box">
            <i class="bx bx-search icon"></i>
            <input type="text" placeholder="Search..." />
          </li>

          <ul class="menu-links">
            <li class="nav-link">
              <a href="#">
                <i class="bx bx-home-alt icon"></i>
                <span class="text nav-text">Dashboard</span>
              </a>
            </li>

            <li class="nav-link">
              <a href="customer.php">
                <i class="bx bx-user icon"></i>
                <span class="text nav-text">Customers</span>
              </a>
            </li>

            <li class="nav-link">
              <a href="#">
                <i class="bx bx-group icon"></i>
                <span class="text nav-text">Staffs</span>
              </a>
            </li>

            <li class="nav-link">
              <a href="#">
                <i class="bx bx-purchase-tag-alt icon"></i>
                <span class="text nav-text">Product Categories</span>
              </a>
            </li>

            <li class="nav-link">
              <a href="#">
                <i class="bx bx-cart-alt icon"></i>
                <span class="text nav-text">Orders</span>
              </a>
            </li>

            <li class="nav-link">
              <a href="#">
                <i class="bx bx-line-chart icon"></i>
                <span class="text nav-text">Reports</span>
              </a>
            </li>
          </ul>
        </div>

        <div class="bottom-content">
          <li class="">
            <a href="#">
              <i class="bx bx-log-out icon"></i>
              <span class="text nav-text">Logout</span>
            </a>
          </li>

          <li class="mode">
            <div class="sun-moon">
              <i class="bx bx-moon icon moon"></i>
              <i class="bx bx-sun icon sun"></i>
            </div>
            <span class="mode-text text">Dark mode</span>

            <div class="toggle-switch">
              <span class="switch"></span>
            </div>
          </li>
        </div>
      </div>
    </nav>

    <section class="home">
      <p class="text ">Admin Dashboard</p>
      <p class="text-norm sm:hidden md:hidden ">
        This is where you manage your inventory and other administrative tasks.
      </p>
      <!-- <p class="text mt-5 ml-5">Categories</p> -->
       <?php
                // View category
                $result = $conn->query("SELECT * FROM category");
            
                // Check if there are categories
                    
                    // Display categories in a table
                    echo "<h2 class='ml-8 text'>Categories</h2>";
                    if ($result->num_rows > 0) {
                        echo "<div class='ml-8'>";
                        echo "<table class='table table-bordered table-striped'>";
                        echo "<thead class='thead-dark'>";
                        echo "<tr><th>ID</th><th>Name</th><th>Description</th></tr>";
                        echo "</thead>";
                        echo "<tbody>";
                        // Fetch and display each category row
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>".$row["category_id"]."</td>";
                            echo "<td>".$row["category_name"]."</td>";
                            echo "<td>".$row["category_description"]."</td>";
                            echo "</tr>";
                        }
                        echo "</tbody>";
                        echo "</table>";
                        echo "</div>";
                    } else {
                        echo "<p>No categories found.</p>";
                    }
                    // View Products
                    $result = $conn->query("SELECT p.*, c.category_name FROM product p INNER JOIN category c ON p.category_id = c.category_id");
            
                   // Check if there are products
                    if ($result->num_rows > 0) {
                        // Display products in a table
                        echo "<h2 class='ml-8 text'>Products</h2>";
                        echo "<div class='table-responsive ml-8'>";
                        echo "<table class='table table-bordered table-striped'>";
                        echo "<thead class='thead-dark'>";
                        echo "<th>ID</th><th>Name</th><th>Category</th><th>Price</th><th>Quantity</th><th>Description</th>";
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
            </div>
        
    </section>

    <script src="script.js"></script>
  </body>
</html>
