<?php
// Include database connection
include("connect.php");

// Function to sanitize input data
function sanitize($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Check if order ID is provided
if(isset($_GET['order_id'])) {
    $order_id = sanitize($_GET['order_id']);
    
    // Retrieve order information from database
    $stmt = $conn->prepare("SELECT o.order_id, c.customer_id, c.customer_name, o.product_id, o.quantity, o.total_price, o.order_date
                            FROM `order` o
                            JOIN customer c ON o.customer_id = c.customer_id
                            WHERE o.order_id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if order exists
    if($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        // Display edit form with pre-filled values
        ?>
        <h2>Edit Order</h2>
        <form method="post" action="update_order.php">
            <input type="hidden" name="order_id" value="<?= $row['order_id'] ?>">
            Customer Name: 
            <select name="customer_id">
                <?php
                // Fetch customer names from the database
                $customer_query = "SELECT customer_id, customer_name FROM customer";
                $customer_result = $conn->query($customer_query);
                // Populate dropdown options
                while ($customer_row = $customer_result->fetch_assoc()) {
                    $selected = ($customer_row['customer_id'] == $row['customer_id']) ? 'selected' : '';
                    echo "<option value='" . $customer_row['customer_id'] . "' $selected>" . $customer_row['customer_name'] . "</option>";
                }
                ?>
            </select><br>
            Product ID: <input type="text" name="product_id" value="<?= htmlspecialchars($row['product_id']) ?>"><br>
            Quantity: <input type="text" name="quantity" value="<?= htmlspecialchars($row['quantity']) ?>"><br>
            Total Price: <input type="text" name="total_price" value="<?= htmlspecialchars($row['total_price']) ?>"><br>
            Order Date: <input type="text" name="order_date" value="<?= htmlspecialchars($row['order_date']) ?>"><br>
            <input type="submit" name="update_order" value="Update">
        </form>
        <?php
    } else {
        echo "Order not found.";
    }

    $stmt->close();
} else {
    echo "Order ID not provided.";
}

$conn->close();
?>
