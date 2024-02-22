<?php
// Include database connection
include("connect.php");
session_start();

// Insert Category
if(isset($_POST['submit_category'])) {
    // Retrieve form data
    $category_name = $_POST['category_name'];
    $category_description = $_POST['category_description'];
    
    // Prepare and execute SQL statement to insert category into the database
    $stmt = $conn->prepare("INSERT INTO category (category_name, category_description) VALUES (?, ?)");
    // Bind parameters to the prepared statement
    $stmt->bind_param("ss", $category_name, $category_description);
    // Execute the statement
    $stmt->execute();
    
    // Check if category insertion was successful
    if($stmt->affected_rows > 0) {
        echo "Category inserted successfully.";
    } else {
        echo "Failed to insert category.";
    }
    // Close the prepared statement
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!----======== CSS ======== -->
    <link rel="stylesheet" href="./style.css" />

    <!----===== Boxicons CSS ===== -->
    <link
      href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css"
      rel="stylesheet"
    />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Admin Dashboard</title>
  </head>
  <body>
    <nav class="sidebar ">
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
              <a href="category.php">
                <i class="bx bx-purchase-tag-alt icon"></i>
                <span class="text nav-text">Product Categories</span>
              </a>
            </li>

            <li class="nav-link">
              <a href="order.php">
                <i class="bx bx-cart-alt icon"></i>
                <span class="text nav-text">Orders</span>
              </a>
            </li>

            <li class="nav-link">
              <a href="report.php">
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
      <p class="text ">Orders</p>
  
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
        echo "<table class='table ml-8 table-bordered table-striped'>";
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
            echo "<button class='btn btn-primary m-1' onclick='sendToKitchen(" . $row["order_id"] . ")'><i class='fas fa-utensils'></i> Send to Kitchen</button>";
            // Button to void order
            echo "<button class='btn btn-danger m-1' onclick='voidOrder(" . $row["order_id"] . ")'><i class='fas fa-trash-alt'></i> Void Order</button>";
            // Button to edit order
            echo "<a class='btn btn-info mt-1' href='edit_order.php?order_id=" . $row["order_id"] . "'><i class='fas fa-edit'></i> Edit</a>";
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
            <!-- <div class="invalid-feedback">Please select a product.</div> -->
        </div>
        <div class="form-group">
            <label for="quantityInput">Quantity:</label>
            <input type="number" name="quantity" id="quantityInput" class="form-control" min="1" value="1" required>
            <!-- <div class="invalid-feedback">Please enter a valid quantity.</div> -->
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

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js"></script>

    <script src="script.js"></script>
  </body>
</html>
