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
    <nav class="sidebar">
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
              <a href="staffs.php">
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
      <p class="text ">Customers</p>
  
      <!-- <p class="text mt-5 ml-5">Categories</p> -->
       <table class="staff-table ml-8">   
                    <table class="staff-table ml-8">
                    <tbody>
                        <?php
                        // View Customers
                        $result = $conn->query("SELECT * FROM customer");

                        // Check if there are customers
                        if ($result->num_rows > 0) {
                            // Display customers in a table
                            
                            echo "<div class='table-responsive ml-8'>";
                            echo "<table class='table table-bordered table-striped ml-8'>";
                            echo "<thead class='thead-dark'>";
                            echo "<thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Phone no</th><th>Address</th><th>Action</th></tr></thead><tbody>";
                            echo "</thead>";
                            echo "<tbody>";
                            // Fetch and display each Customers row
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>".$row["customer_id"]."</td>";
                                echo "<td>".$row["customer_name"]."</td>";
                                echo "<td>".$row["email"]."</td>";
                                echo "<td>".$row["phone_no"]."</td>";
                                echo "<td>".$row["address"]."</td>";
                                // Links for editing and deleting the customer
                                echo "<td><a href='edit_customer.php?customer_id=".$row["customer_id"]."' class='btn btn-primary btn-sm bg-[dodgerblue] p-2 rounded-sm text-white''>Edit <i class='bx bx-pencil icon'></i></a>  <a href='delete_customer.php?customer_id=".$row["customer_id"]."' class='btn btn-danger btn-sm bg-[crimson] p-2 rounded-sm text-white''>Delete<i class='fas fa-trash-alt'></i></a></td>";
                                echo "</tr>";
                            }
                            echo "</tbody></table>";
                        } else {
                            echo "No Customers found.";
                        }

                        // Close the database connection
                        $conn->close();
                        ?>
                    </tbody>
                </table>

    </section>

    <script src="script.js"></script>
  </body>
</html>
