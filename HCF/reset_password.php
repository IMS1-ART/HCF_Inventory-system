<?php
include("connect.php");

// Function to reset the password
function resetPassword($token, $password) {
    global $conn;

    // Check if the token exists in the database
    $stmt = $conn->prepare("SELECT * FROM password_resets WHERE token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Token exists, update the user's password
        $row = $result->fetch_assoc();
        $email = $row['email'];

        // Hash the new password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Update the password in the database
        $update_stmt = $conn->prepare("UPDATE admin SET password = ? WHERE email = ?");
        $update_stmt->bind_param("ss", $hashed_password, $email);
        $update_stmt->execute();

        // Delete the token from the password_resets table
        $delete_stmt = $conn->prepare("DELETE FROM password_resets WHERE token = ?");
        $delete_stmt->bind_param("s", $token);
        $delete_stmt->execute();

        return true; // Password reset successful
    } else {
        return false; // Invalid or expired token
    }
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $token = $_GET['token']; // Get the token from the URL
    $password = $_POST["password"];

    // Reset the password
    if (resetPassword($token, $password)) {
        // Password reset successful, redirect to sign-in page
        header("Location: sign_in.php");
        exit();
    } else {
        echo "Invalid or expired token.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>
<body>
    <h2>Reset Your Password</h2>
    <form action="" method="post">
        <label for="password">New Password:</label><br>
        <input type="password" id="password" name="password" required><br>
        <input type="submit" value="Reset Password">
    </form>
</body>
</html>
