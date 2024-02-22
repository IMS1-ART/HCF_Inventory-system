<?php
include("connect.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Something was posted
    $username = $_POST["name"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $email = $_POST["email"];
    $phone_no = $_POST["phone_no"];
    $address = $_POST["address"];
    
    // Validation (add more as needed)
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format!";
        exit();
    }

    // Generate verification code
    $verification_code = bin2hex(random_bytes(16));

    // Save user data and verification code to database
    $stmt = $conn->prepare("INSERT INTO admin (admin_name, password, email, phone_no, address, verification_code) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $username, $password, $email, $phone_no, $address, $verification_code);
    $stmt->execute();
    
    // Check if the query was successful
    $to = $email;
    $subject = 'Email Verification';
    $message = 'Click the following link to verify your email: http://localhost/HCF/verify.php?verification_code=' . $verification_code;
    $headers = 'From: intercumy@gmail.com'; // Replace with your Gmail address
    // SMTP configuration
    ini_set('smtp_port', '587');
    ini_set('smtp_host', 'smtp.gmail.com');
    ini_set('smtp_user', 'intercumy.com');
    ini_set('smtp_pass', 'hmtpgfqwoisrwsso');
    ini_set('smtp_auth', 'true');
    ini_set('smtp_secure', 'tls');
    if (mail($to, $subject, $message, $headers)) {
        echo "Verification email sent. Please check your inbox.";
    } else {
        echo "Failed to send verification email.";
    }
    

    // Close the statement
    $stmt->close();
}
?>



<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible"
        content="IE=edge">
  <meta name="viewport"
        content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet"
        href="../css/chef.css">
  <title>Admin Portal &#8211; 92 Doner Kings</title>
</head>

<body>

<div class="login-container">
  <form action="sign_up.php"
        method="post">
    <!--    <h2>Welcome to Black Ash's Culinary Realm</h2>-->
    <h2>Experience Culinary Excellence</h2>
      <h3> Welcome</h3>
        <input type="text"
               name="name"
               id="name"
               placeholder="Username"
               required>
        <input type="email"
               name="email"
               id="email"
               placeholder="Email"
               required>
        <input type="password"
               name="password"
               id="password"
               placeholder="Password"
               required>
        <input type="phone_no"
               name="phone_no"
               id="phone_no"
               placeholder="Phone No"
               required>
        <input type="address"
               name="address"
               id="address"
               placeholder="Address"
               required>
        <a href="./sign_in.php">Have an Account? Login Here.</a>
        <a href="forgot_password.php">Forgotten Password? Click Here.</a>
        <button type="submit"
                id="login-button">Register Account
        </button>
  </form>
</div>


</body>

</html>