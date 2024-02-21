<?php
// Include database connection
include("connect.php");
session_start();
// Check if category ID is provided
if(isset($_GET['category_id'])) {
    $category_id = $_GET['category_id'];
    
    // Retrieve category information from the database
    $stmt = $conn->prepare("SELECT * FROM category WHERE category_id = ?");
    $stmt->bind_param("i", $category_id);
    if ($stmt->execute()) {
        $result = $stmt->get_result();

        // Check if category exists
        if($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            // Display edit form with pre-filled values
            ?>
            <h2>Edit Category</h2>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <input type="hidden" name="category_id" value="<?php echo $row["category_id"]; ?>">
                Name: <input type="text" name="category_name" value="<?php echo $row["category_name"]; ?>"><br>
                Description: <input type="text" name="category_description" value="<?php echo $row["category_description"]; ?>"><br>
                <input type="submit" name="update_category" value="Update">
            </form>
            <?php
        } else {
            echo "Category not found.";
        }
    } else {
        echo "Error retrieving category information: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Category ID not provided.";
}

$conn->close();
?>
