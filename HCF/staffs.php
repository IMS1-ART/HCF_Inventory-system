<?php
// Include database connection
include("connect.php");
session_start();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $staff_name = $_POST["staff_name"];
    $email = $_POST["email"];
    $phone_no = $_POST["phone_no"];
    $address = $_POST["address"];
    $pin = $_POST["pin"];
    // SQL to insert data using prepared statement
    $stmt = $conn->prepare("INSERT INTO staffs (staff_name, email, phone_no, address, pin) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $staff_name, $email, $phone_no, $address, $pin);

    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

// View staffs
$result = $conn->query("SELECT * FROM staffs");

// Close the database connection
$conn->close();
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
    <link rel="stylesheet" href="styles.css">
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
        <ul class="navbar-nav mr-auto">
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
        <h2>Staffs</h2>
        <!-- Button to add new staff -->
        <button class="btn btn-primary btn-add-staff" onclick="showForm()">Add New Staff</button>

        <!-- Staff table -->
        <table class="staff-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Address</th>
                    <th>Pin</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Display staffs in a table
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>".$row["staff_id"]."</td>";
                    echo "<td>".$row["staff_name"]."</td>";
                    echo "<td>".$row["email"]."</td>";
                    echo "<td>".$row["phone_no"]."</td>";
                    echo "<td>".$row["address"]."</td>";
                    echo "<td>".$row["pin"]."</td>";
                    // Links for editing and deleting the staff
                    echo "<td><a href='edit_staff.php?staff_id=".$row["staff_id"]."'>Edit <i class='fas fa-edit'></i></a> | <a href='delete_staff.php?staff_id=".$row["staff_id"]."'>Delete <i class='fas fa-trash-alt'></i></a></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Form to insert staff (initially hidden) -->
        <div class="staff-form" id="staffForm" style="display:none;">
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <label>Staff Name:</label><br>
                <input type="text" name="staff_name"><br>
                <label>Email:</label><br>
                <input type="text" name="email"><br>
                <label>Phone Number:</label><br>
                <input type="text" name="phone_no"><br>
                <label>Address:</label><br>
                <input type="text" name="address"><br>
                <label>Pin:</label><br>
                <input type="text" name="pin"><br>
                <input type="submit" value="Submit">
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap JS and Font Awesome JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js"></script>

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
<script src="script.js"></script>
</body>
</html>
