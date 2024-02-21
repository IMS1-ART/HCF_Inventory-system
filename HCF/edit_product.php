<?php
// Include database connection
include("connect.php");

// Function to sanitize input data
function sanitize($data) {
    return stripslashes(trim($data));
}

// Check if product ID is provided
if(isset($_GET['product_id'])) {
    $product_id = sanitize($_GET['product_id']);
    
    // Retrieve product information from database
    $stmt = $conn->prepare("SELECT p.*, c.category_name 
                            FROM product p 
                            JOIN category c ON p.category_id = c.category_id 
                            WHERE p.product_id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if product exists
    if($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        // Fetch all categories from the category table
        $category_query = "SELECT category_id, category_name FROM category";
        $category_result = $conn->query($category_query);
        ?>
        <h2>Edit Product</h2>
        <form method="post" action="update_product.php">
            <input type="hidden" name="product_id" value="<?= $row['product_id'] ?>">
            Name: <input type="text" name="product_name" value="<?= htmlspecialchars($row['product_name']) ?>"><br>
            Category:
            <select name="category_id">
                <?php
                // Display category options in the dropdown
                while ($category_row = $category_result->fetch_assoc()) {
                    $selected = ($row['category_id'] == $category_row['category_id']) ? 'selected' : '';
                    echo "<option value='" . $category_row['category_id'] . "' $selected>" . htmlspecialchars($category_row['category_name']) . "</option>";
                }
                ?>
            </select><br>
            Price: <input type="text" name="product_price" value="<?= htmlspecialchars($row['product_price']) ?>"><br>
            Quantity: <input type="text" name="product_quantity" value="<?= htmlspecialchars($row['product_quantity']) ?>"><br>
            Description: <input type="text" name="product_description" value="<?= htmlspecialchars($row['product_description']) ?>"><br>
            <input type="submit" name="update_product" value="Update">
        </form>
        <?php
    } else {
        echo "Product not found.";
    }

    $stmt->close();
} else {
    echo "Product ID not provided.";
}

$conn->close();
?>
