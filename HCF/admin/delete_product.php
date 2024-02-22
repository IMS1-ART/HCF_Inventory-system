<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$con = mysqli_connect("localhost", "root", "", "92donerkings");
if (mysqli_connect_error()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

// Check if ProductId is set in the URL
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Check if the request method is POST and if the user confirmed the deletion
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirmed'])) {
        if ($_POST['confirmed'] == 'yes') {
            // Delete the product from the Products table
            $delete_query = "DELETE FROM `product` WHERE product_id='$product_id'";
            if (mysqli_query($con, $delete_query)) {
                echo "Product deleted successfully.";
                header('Location: product.php');
                exit();
            } else {
                echo "Error deleting product: " . mysqli_error($con);
            }
        } else {
            // If user canceled the deletion, redirect to product.php
            header('Location: product.php');
            exit();
        }
    } else {
        // Display the confirmation form
        echo "<script>
                function confirmDelete() {
                    var confirmed = confirm('Are you sure you want to delete this product?');
                    if (confirmed) {
                        document.getElementById('deleteForm').submit();
                    } else {
                        window.location.href = 'product.php'; // Redirect to product.php if canceled
                    }
                }
            </script>";
        
        echo "<form id='deleteForm' method='post' action='" . $_SERVER['PHP_SELF'] . "?product_id=$product_id' style='display:none;'>
                <input type='hidden' name='confirmed' value='yes'>
              </form>";

        // Trigger confirmation prompt
        echo "<script>confirmDelete();</script>";
    }
} else {
    echo "product_id is not set in the URL.";
}

mysqli_close($con);
?>
