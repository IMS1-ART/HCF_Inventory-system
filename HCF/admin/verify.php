<?php
include("connect.php");

if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['verification_code'])) {
    // Retrieve verification code from URL parameter
    $verification_code = $_GET['verification_code'];

    // Check if verification code exists in the database
    $stmt = $conn->prepare("SELECT * FROM admin WHERE verification_code = ?");
    $stmt->bind_param("s", $verification_code);
    $stmt->execute();
    $result = $stmt->get_result();

    // If verification code is found, update the user's status to verified
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $admin_id = $row['admin_id'];
        $stmt = $conn->prepare("UPDATE admin SET verified = 1 WHERE admin_id = ?");
        $stmt->bind_param("i", $admin_id);
        $stmt->execute();

        echo "Email verification successful. You can now <a href='./sign_in.php'>login</a>.";
    } else {
        echo "Invalid verification code.";
    }
} else {
    echo "Verification code not provided.";
}
?>
