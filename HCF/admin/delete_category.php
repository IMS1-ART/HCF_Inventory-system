<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection
include("connect.php");

// Check if CategoryId is set in the URL
if (isset($_GET['category_id'])) {
    $category_id = $_GET['category_id'];

    // Check if the request method is POST and if the user confirmed the deletion
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirmed'])) {
        if ($_POST['confirmed'] == 'yes') {
            // Delete the category from the category table using prepared statement to prevent SQL injection
            $delete_query = "DELETE FROM `category` WHERE category_id=?";
            $stmt = $conn->prepare($delete_query);
            $stmt->bind_param("i", $category_id);
            if ($stmt->execute()) {
                echo "Category deleted successfully.";
                header('Location: category.php');
                exit();
            } else {
                echo "Error deleting category: " . $stmt->error;
            }
        } else {
            // If user canceled the deletion, redirect to category.php
            header('Location: category.php');
            exit();
        }
    } else {
        // Display the confirmation form
        echo "<script>
                function confirmDelete() {
                    var confirmed = confirm('Are you sure you want to delete this category?');
                    if (confirmed) {
                        document.getElementById('deleteForm').submit();
                    } else {
                        window.location.href = 'category.php'; // Redirect to category.php if canceled
                    }
                }
            </script>";
        
        echo "<form id='deleteForm' method='post' action='" . $_SERVER['PHP_SELF'] . "?category_id=$category_id' style='display:none;'>
                <input type='hidden' name='confirmed' value='yes'>
              </form>";

        // Trigger confirmation prompt
        echo "<script>confirmDelete();</script>";
    }
} else {
    echo "category_id is not set in the URL.";
}

// Close the database connection
$conn->close();
?>
