<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection
include("connect.php");

// Check if customer_id is set in the URL
if (isset($_GET['customer_id'])) {
    $customer_id = $_GET['customer_id'];

    // Check if the request method is POST and if the user confirmed the deletion
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirmed'])) {
        if ($_POST['confirmed'] == 'yes') {
            // Delete the customer from the customer table using prepared statement to prevent SQL injection
            $delete_query = "DELETE FROM `customer` WHERE customer_id=?";
            $stmt = $conn->prepare($delete_query);
            $stmt->bind_param("i", $customer_id);
            if ($stmt->execute()) {
                echo "Customer deleted successfully.";
                header('Location: customer.php');
                exit();
            } else {
                echo "Error deleting customer: " . $stmt->error;
            }
        } else {
            // If user canceled the deletion, redirect to customer.php
            header('Location: customer.php');
            exit();
        }
    } else {
        // Display the confirmation form
        echo "<script>
                function confirmDelete() {
                    var confirmed = confirm('Are you sure you want to delete this customer?');
                    if (confirmed) {
                        document.getElementById('deleteForm').submit();
                    } else {
                        window.location.href = 'customer.php'; // Redirect to customer.php if canceled
                    }
                }
            </script>";
        
        echo "<form id='deleteForm' method='post' action='" . $_SERVER['PHP_SELF'] . "?customer_id=$customer_id' style='display:none;'>
                <input type='hidden' name='confirmed' value='yes'>
              </form>";

        // Trigger confirmation prompt
        echo "<script>confirmDelete();</script>";
    }
} else {
    echo "customer_id is not set in the URL.";
}

// Close the database connection
$conn->close();
?>
