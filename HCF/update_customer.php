<?php
// Include database connection
include("connect.php");

// Check if form is submitted and customer ID is provided
if(isset($_POST['update_customer']) && isset($_POST['customer_id'])) {
    // Retrieve form data
    $customer_id = $_POST['customer_id'];
    $customer_name = $_POST['customer_name'];
    $email = $_POST['email'];
    $phone_no = $_POST['phone_no'];
    $address = $_POST['address'];
    
    // Update customer in the database
    $stmt = $conn->prepare("UPDATE customer SET customer_name=?, email=?, phone_no=?, address=? WHERE customer_id=?");
    $stmt->bind_param("ssssi", $customer_name, $email, $phone_no, $address, $customer_id);
    $stmt->execute();
    
    // Check if customer update was successful
    if($stmt->affected_rows > 0) {
        echo "Customer updated successfully.";
        // Redirect to customer.php
        header("Location: customer.php");
        exit(); // Ensure script execution stops after redirection
    } else {
        echo "Failed to update customer.";
    }
    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <h2 class="mb-4">Update Customer</h2>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <input type="hidden" name="update_customer" value="1">
                <div class="form-group">
                    <label for="customerName">Customer Name:</label>
                    <input type="text" id="customerName" name="customer_name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="phoneNumber">Phone Number:</label>
                    <input type="tel" id="phoneNumber" name="phone_no" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="address">Address:</label>
                    <input type="text" id="address" name="address" class="form-control" required>
                </div>
                <input type="hidden" name="customer_id" value="<?php echo $_GET['customer_id']; ?>">
                <button type="submit" class="btn btn-primary">Update Customer</button>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
