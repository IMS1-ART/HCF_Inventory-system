<?php
include("connect.php");

// Retrieve products from the database
$query = "SELECT * FROM products";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "ID: " . $row["id"] . "<br>";
        echo "Name: " . $row["name"] . "<br>";
        echo "Description: " . $row["description"] . "<br>";
        echo "Price: " . $row["price"] . "<br>";
        echo '<button onclick="openEditPopup(' . $row["id"] . ')">Edit</button>';
        echo '<button onclick="deleteProduct(' . $row["id"] . ')">Delete</button>';
        echo "<hr>";
    }
} else {
    echo "0 results";
}

$conn->close();
?>
