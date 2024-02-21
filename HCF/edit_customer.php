<?php
// Include database connection
include("connect.php");

// Check if customer ID is provided
if(isset($_GET['customer_id'])) {
    $customer_id = $_GET['customer_id'];
    
    // Retrieve customer information from database
    $stmt = $conn->prepare("SELECT * FROM customer WHERE customer_id = ?");
    $stmt->bind_param("i", $customer_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if customer exists
    if($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Edit Customer</title>
            <!-- Bootstrap CSS -->
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        </head>
        <body>
            <div class="container mt-5">
                <h2>Edit Customer</h2>
                <form method="post" action="update_customer.php">
                    <input type="hidden" name="customer_id" value="<?php echo $row["customer_id"]; ?>">
                    <div class="form-group">
                        <label for="customerName">Name:</label>
                        <input type="text" class="form-control" id="customerName" name="customer_name" value="<?php echo $row["customer_name"]; ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="text" class="form-control" id="email" name="email" value="<?php echo $row["email"]; ?>">
                    </div>
                    <div class="form-group">
                        <label for="phoneNo">Phone Number:</label>
                        <input type="text" class="form-control" id="phoneNo" name="phone_no" value="<?php echo $row["phone_no"]; ?>">
                    </div>
                    <div class="form-group">
                        <label for="address">Address:</label>
                        <input type="text" class="form-control" id="address" name="address" value="<?php echo $row["address"]; ?>">
                    </div>
                    <button type="submit" class="btn btn-primary" name="update_customer">Update</button>
                </form>
            </div>
            <!-- Bootstrap JS -->
            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        </body>
        </html>
        <?php
    } else {
        echo "Customer not found.";
    }

    $stmt->close();
} else {
    echo "Customer ID not provided.";
}

$conn->close();
?>
