<?php
// Include database connection
include("connect.php");

// Check if staff ID is provided
if(isset($_GET['staff_id'])) {
    $staff_id = $_GET['staff_id'];
    
    // Retrieve staff information from database
    $stmt = $conn->prepare("SELECT * FROM staffs WHERE staff_id = ?");
    $stmt->bind_param("i", $staff_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if staff exists
    if($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        // Display edit form with pre-filled values
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Edit Staff</title>
            <!-- Bootstrap CSS -->
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
            <!-- Font Awesome CSS -->
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        </head>
        <body>
            <div class="container">
                <h2>Edit Staff</h2>
                <form method="post" action="update_staff.php">
                    <input type="hidden" name="staff_id" value="<?php echo $row["staff_id"]; ?>">
                    <div class="form-group">
                        <label for="staffName">Name:</label>
                        <input type="text" class="form-control" id="staffName" name="staff_name" value="<?php echo $row["staff_name"]; ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="text" class="form-control" id="email" name="email" value="<?php echo $row["email"]; ?>">
                    </div>
                    <div class="form-group">
                        <label for="phoneNumber">Phone Number:</label>
                        <input type="text" class="form-control" id="phoneNumber" name="phone_no" value="<?php echo $row["phone_no"]; ?>">
                    </div>
                    <div class="form-group">
                        <label for="address">Address:</label>
                        <input type="text" class="form-control" id="address" name="address" value="<?php echo $row["address"]; ?>">
                    </div>
                    <div class="form-group">
                        <label for="pin">Pin:</label>
                        <input type="text" class="form-control" id="pin" name="pin" value="<?php echo $row["pin"]; ?>">
                    </div>
                    <button type="submit" class="btn btn-primary" name="update_staff">Update</button>
                </form>
            </div>
            <!-- Bootstrap JS and Font Awesome JS -->
            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        </body>
        </html>
        <?php
    } else {
        echo "Staff not found.";
    }

    $stmt->close();
} else {
    echo "Staff ID not provided.";
}

$conn->close();
?>
