<?php
// Include database connection
include("connect.php");
session_start();
$result = $conn->query("SELECT * FROM category");

// Insert Category
if(isset($_POST['submit_category'])) {
    // Retrieve form data
    $category_name = $_POST['category_name'];
    $category_description = $_POST['category_description'];
    
    // Prepare and execute SQL statement to insert category into the database
    $stmt = $conn->prepare("INSERT INTO category (category_name, category_description) VALUES (?, ?)");
    // Bind parameters to the prepared statement
    $stmt->bind_param("ssss", $category_name, $category_description);
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
      <p class="text ">Category</p>
  
      <!-- <p class="text mt-5 ml-5">Categories</p> -->
       <table class="staff-table ml-8">   
                    <table class="staff-table ml-8">
                     <tbody>
                        <?php
                // $result = $conn->query("SELECT * FROM category");        
               if ($result->num_rows > 0) {
          echo "<div class='table-responsive ml-8'>";
                            echo "<table class='table table-bordered ml-8 table-striped'>";
                            echo "<thead class='thead-dark'>";
        echo "<tr><th>ID</th><th>Name</th><th>Description</th><th>Action</th></tr>";
        echo "</thead>";
        echo "<tbody>";
        // Fetch and display each category row
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$row["category_id"]."</td>";
            echo "<td>".$row["category_name"]."</td>";
            echo "<td>".$row["category_description"]."</td>";
            // Links for editing and deleting the category
            echo "<td><a href='edit_category.php?category_id=".$row["category_id"]."' class='btn btn-primary btn-sm'><i class='fas fa-edit'></i> Edit</a> | <a href='delete_category.php?category_id=".$row["category_id"]."' class='btn btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Delete</a></td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        echo "</div>";
    } else {
        echo "<p>No categories found.</p>";
    }
    ?>
    ?>
                    </tbody>
                </table>
                <!-- Button to add new staff -->
                <button class="btn btn-primary ml-8 bg-[dodgerblue] rounded-sm p-2 m-2 text-white btn-add-staff" onclick="showForm()">Add New Category</button>
                <!-- Form to insert staff (initially hidden) -->
                <div class="staff-form ml-8" id="staffForm" style="display:none;">
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                         <label for="categoryName">Category Name:</label> <br>
            <input type="text" class="p-2 mt-1 rounded-sm" id="categoryName" name="category_name">
        <br>
                            <label for="categoryDescription">Category Description:</label>
  <br>     <input type="text" class="p-2 mt-1 rounded-sm"name="staff_name" class="form-control" id="categoryDescription" name="category_description">
       <input type="submit" class='bg-[lightgreen] p-2 rounded-sm mt-2 mb-2 text-white' value="Submit">
                    </form>
                </div>

    </section>
<script>
    function showForm() {
        var form = document.getElementById("staffForm");
        if (form.style.display === "none") {
            form.style.display = "block";
        } else {
            form.style.display = "none";
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
