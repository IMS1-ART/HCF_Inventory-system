<?php
// Include database connection
include("connect.php");

// Function to sanitize input data
function sanitize($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Check if form is submitted and all required fields are set
if(isset($_POST['update_product']) && isset($_POST['product_id']) && isset($_POST['product_name']) && isset($_POST['category_id']) && isset($_POST['product_price']) && isset($_POST['product_quantity']) && isset($_POST['product_description'])) {
    // Retrieve form data
    $product_id = sanitize($_POST['product_id']);
    $product_name = sanitize($_POST['product_name']);
    $category_id = sanitize($_POST['category_id']); // Change to category_id
    $product_price = sanitize($_POST['product_price']);
    $product_quantity = sanitize($_POST['product_quantity']);
    $product_description = sanitize($_POST['product_description']);
    
    // Prepare and execute SQL statement to update product in the database
    $stmt = $conn->prepare("UPDATE product SET product_name=?, category_id=?, product_price=?, product_quantity=?, product_description=? WHERE product_id=?");
    // Bind parameters to the prepared statement
    $stmt->bind_param("sidisi", $product_name, $category_id, $product_price, $product_quantity, $product_description, $product_id);
    // Execute the statement
    $stmt->execute();
    
    // Check if product update was successful
    if($stmt->affected_rows > 0) {
        echo "Product updated successfully.";
        // Redirect to product.php after successful update
        header("Location: product.php");
        exit(); // Ensure script execution stops after redirection
    } else {
        echo "Failed to update product.";
    }
    // Close the prepared statement
    $stmt->close();
} else {
    echo "All required fields not provided.";
}

$conn->close();
?>
