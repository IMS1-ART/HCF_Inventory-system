<?php
// Include database connection
include("connect.php");

// Check if form is submitted and order ID is provided
if(isset($_POST['order_id'])) {
    // Retrieve form data
    $order_id = $_POST['order_id']; 

    // Insert voided order into void_order table
    $stmt_void = $conn->prepare("INSERT INTO void_order (order_id) VALUES (?)");
    $stmt_void->bind_param("s", $order_id);
    $stmt_void->execute();

    // Check if void_order insertion was successful
    if($stmt_void->affected_rows > 0) {
        // Remove voided order from order table
        $stmt_delete = $conn->prepare("DELETE FROM `order` WHERE order_id = ?");
        $stmt_delete->bind_param("s", $order_id);
        $stmt_delete->execute();
        
        if($stmt_delete->affected_rows > 0) {
            echo "Order voided successfully.";
        } else {
            echo "Failed to void order.";
        }
    } else {
        echo "Failed to insert void_order.";
    }

    // Close the prepared statements
    $stmt_void->close();
    $stmt_delete->close();
} else {
    // Display error message if order ID is not provided
    echo "Order ID not provided.";
}
?>
