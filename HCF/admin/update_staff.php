<?php
// Include database connection
include("connect.php");

// Check if form is submitted and staff ID is provided
if(isset($_POST['update_staff']) && isset($_POST['staff_id'])) {
    // Retrieve form data and sanitize
    $staff_id = $_POST['staff_id'];
    $staff_name = ($_POST['staff_name']);
    $email = ($_POST['email']); 
    $phone_no = $_POST['phone_no'];
    $address = $_POST['address'];
    $pin = ($_POST['pin']); 
    
    // Update staff in the database
    $stmt = $conn->prepare("UPDATE staffs SET staff_name=?, email=?, phone_no=?, address=?, pin=? WHERE staff_id=?");
    $stmt->bind_param("ssssii", $staff_name, $email, $phone_no, $address, $pin, $staff_id);
    $stmt->execute();
    
    // Check if staff update was successful
    if($stmt->affected_rows > 0) {
        echo "staff updated successfully.";
        // Redirect to staffs.php after successful update
        header("Location: staffs.php");
        exit(); // Ensure script execution stops after redirection
    } else {
        echo "Failed to update staff.";
    }
    $stmt->close();
}

$conn->close();
?>
