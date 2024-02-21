<?php
include("connect.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize user input
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $password = $_POST["password"];

    // Fetch user from the database
    $sql = "SELECT admin_id, password FROM admin WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Verify password
        if (password_verify($password, $user['password'])) {
            // Password is correct, perform your login actions
            $_SESSION['username'] = $username;
            header("Location: dashboard.html");
            exit();
        } else {
            $error_message = "Invalid password";
        }
    } else {
        $error_message = "User not found";
    }

    $stmt->close();
}

$conn->close();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/chef.css">
  <title>Dashboard - 92 Doners Kabab</title>
</head>
<body>
<div class="login-container">
  <form action="" method="post">
    <h2>Welcome to the World of Food Delights</h2>
    <input type="email" name="email" id="email" placeholder="Email" value="" required>
    <input type="password" name="password" id="password" placeholder="Password" value="" required>
    <?php if (isset($error_message)) { echo "<p>$error_message</p>"; } ?>
    <a href="#">Forgot your password?</a>
    <a href="./register.html">Don't have an account? Click here.</a>
    <button type="submit" name="login-button" value="customer">Sign in</button>
  </form>
</div>
</body>
</html>
