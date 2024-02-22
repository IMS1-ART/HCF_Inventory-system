<?php
include("connect.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = $_POST['email'];

    // Check if the email exists in the database
    $stmt = $conn->prepare("SELECT * FROM admin WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Generate a unique token
        $token = bin2hex(random_bytes(16));

        // Store the token in the database
        $stmt = $conn->prepare("INSERT INTO password_resets (email, token) VALUES (?, ?)");
        $stmt->bind_param("ss", $email, $token);
        $stmt->execute();

        // Send the password reset link to the user's email
        $reset_link = "http://localhost/HCF/reset_password.php?token=$token";

        // Send email with reset link
        $to = $email;
        $subject = "Password Reset Link";
        $message = "Click the following link to reset your password: $reset_link";
        $headers = "From: intercumy@gmail.com"; // Replace with your email address

        if (mail($to, $subject, $message, $headers)) {
            echo "Password reset link sent to your email.";
        } else {
            echo "Failed to send password reset link.";
        }
    } else {
        echo "Email not found in our records.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
</head>
<body>
    <h2>Forgot Password</h2>
    <form action="" method="post">
        <label for="email">Enter your email:</label><br>
        <input type="email" id="email" name="email" required><br>
        <input type="submit" value="Reset Password">
    </form>
</body>
</html>
