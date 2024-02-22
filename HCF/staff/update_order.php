<?php
// Include database connection
include("connect.php");

// Function to sanitize input data
function sanitize($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Check if form is submitted and order ID is provided
if(isset($_POST['update_order']) && isset($_POST['order_id'])) {
    // Retrieve form data
    $order_id = sanitize($_POST['order_id']);
    $customer_id = sanitize($_POST['customer_id']);
    $product_id = sanitize($_POST['product_id']);
    $quantity = sanitize($_POST['quantity']);

    // Fetch product details based on product ID
    $product_query = "SELECT product_price FROM product WHERE product_id = ?";
    $stmt = $conn->prepare($product_query);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $stmt->bind_result($product_price);
    $stmt->fetch();
    $stmt->close();

    // Calculate total price
    $total_price = $quantity * $product_price;

    // Update order in the database
    $stmt = $conn->prepare("UPDATE `order` SET customer_id=?, product_id=?, quantity=?, total_price=?, order_date=NOW() WHERE order_id=?");
    $stmt->bind_param("iisii", $customer_id, $product_id, $quantity, $total_price, $order_id);
    $stmt->execute();
    
    // Check if order update was successful
    if($stmt->affected_rows > 0) {
        echo "Order updated successfully.";
        // Redirect to product.php after successful update
        header("Location: order.php");
        exit(); // Ensure script execution stops after redirection
    } else {
        echo "Failed to update order.";
    }
    $stmt->close();
}

$conn->close();
?>
