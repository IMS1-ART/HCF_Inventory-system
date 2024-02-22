<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$con = mysqli_connect("localhost", "root", "", "npm install -D tailwindcss postcss autoprefixer
npx tailwindcss init");
if (mysqli_connect_error()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

// Check if staffId is set in the URL
if (isset($_GET['staff_id'])) {
    $staff_id = $_GET['staff_id']; // Corrected variable name

    // Check if the request method is POST and if the user confirmed the deletion
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirmed'])) {
        if ($_POST['confirmed'] == 'yes') {
            // Delete the product from the staffs table
            $delete_query = "DELETE FROM `staffs` WHERE staff_id='$staff_id'";
            if (mysqli_query($con, $delete_query)) {
                echo "Staff deleted successfully.";
                header('Location: staffs.php');
                exit();
            } else {
                echo "Error deleting staff: " . mysqli_error($con);
            }
        } else {
            // If user canceled the deletion, redirect to staffs.php
            header('Location: staffs.php');
            exit();
        }
    } else {
        // Display the confirmation form
        echo "<script>
                function confirmDelete() {
                    var confirmed = confirm('Are you sure you want to delete this staff?');
                    if (confirmed) {
                        document.getElementById('deleteForm').submit();
                    } else {
                        window.location.href = 'staffs.php'; // Redirect to staffs.php if canceled
                    }
                }
            </script>";
        
        echo "<form id='deleteForm' method='post' action='" . $_SERVER['PHP_SELF'] . "?staff_id=$staff_id' style='display:none;'>
                <input type='hidden' name='confirmed' value='yes'>
              </form>";

        // Trigger confirmation prompt
        echo "<script>confirmDelete();</script>";
    }
} else {
    echo "staff_id is not set in the URL.";
}

mysqli_close($con);
?>
