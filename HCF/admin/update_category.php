<?php
// Include database connection
include("connect.php");
session_start();

// Check if form is submitted and category ID is provided
if(isset($_POST['update_category']) && isset($_POST['category_id'])) {
    // Retrieve form data and sanitize
    $category_id = $_POST['category_id'];
    $category_name = htmlspecialchars($_POST['category_name']); // Example of sanitization
    $category_description = htmlspecialchars($_POST['category_description']); // Example of sanitization
    
    // Update category in the database
    $stmt = $conn->prepare("UPDATE category SET category_name=?, category_description=? WHERE category_id=?");
    $stmt->bind_param("ssi", $category_name, $category_description, $category_id);
    if ($stmt->execute()) {
        // Check if category update was successful
        if($stmt->affected_rows > 0) {
            echo "Category updated successfully.";
            // Redirect to category.php after successful update
            header("Location: category.php");
            exit(); // Ensure script execution stops after redirection
        } else {
            echo "No changes were made to the category.";
        }
    } else {
        echo "Failed to update category: " . $stmt->error;
    }
    $stmt->close();
} else {
    // If the form is not submitted or category ID is not provided, redirect to category.php
    header("Location: category.php");
    exit();
}

$conn->close();
?>
