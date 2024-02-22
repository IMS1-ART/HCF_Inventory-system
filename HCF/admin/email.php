<?php
include("connect.php");
// Include the PHPMailer Autoload file
require 'PHPMailerAutoload.php';

// Instantiate a new PHPMailer object
$mail = new PHPMailer(true);

try {
    // Enable SMTP debugging (optional)
    $mail->SMTPDebug = 0; // Set to 2 for more detailed debug output

    // Set mailer to use SMTP
    $mail->isSMTP();

    // Specify the SMTP server credentials
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'dozieiwuji@gmail.com'; // Your Gmail address
    $mail->Password = 'Godistoofaithful23'; // Your Gmail password
    $mail->SMTPSecure = 'ssl'; // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 465; // TCP port to connect to

    // Sender and recipient details
    $email_from = 'dozieiwuji@gmail.com';
    $name_from = 'Peter';
    $email_to = 'djvepeee@gmail.com';
    $name_to = 'Ali';

    // Set sender and recipient
    $mail->setFrom($email_from, $name_from);
    $mail->addAddress($email_to, $name_to);

    // Email subject and body
    $mail->Subject = 'My Subject';
    $mail->Body = 'Mail contents';

    // Send email
    $mail->send();
    echo 'Email sent successfully!';
} catch (Exception $e) {
    // Error handling
    echo 'Email could not be sent. Error: ', $mail->ErrorInfo;
}
?>
