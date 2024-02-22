<?php
// Include database connection
include("connect.php");

// Check if form is submitted
if(isset($_POST['order_id'])) {
    // Retrieve form data
    $order_id = $_POST['order_id']; 

    // Insert voided order into void_order table
    $stmt_void = $conn->prepare("INSERT INTO void_order (order_id) VALUES (?)");
    $stmt_void->bind_param("s", $order_id);
    $stmt_void->execute();

    // Check if void_order insertion was successful


    // Close the prepared statements
    $stmt_void->close();
    $stmt_delete->close();
}
?>
