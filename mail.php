<?php
$errors = [];
$errorMessage = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $message = htmlspecialchars($_POST['message']);

    // Validate inputs
    if (empty($name)) {
        $errors[] = 'Name is required';
    }

    if (empty($email)) {
        $errors[] = 'Email is required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Email is invalid';
    }

    if (empty($message)) {
        $errors[] = 'Message is required';
    }

    if (empty($errors)) {
        // Send email
        $toEmail = 'michellana.garcia@gmail.com'; // Replace with your email address
        $emailSubject = 'New email from your contact form';
        $headers = "From: $email\r\nReply-To: $email\r\nContent-type: text/html; charset=utf-8";
        $body = "Name: $name<br>Email: $email<br>Message: $message";

        if (mail($toEmail, $emailSubject, $body, $headers)) {
            header('Location: thank-you.html');
            exit(); // Always exit after header redirect
        } else {
            $errorMessage = 'Oops, something went wrong. Please try again later';
        }
    } else {
        $errorMessage = "<div style='color: red;'>";
        $errorMessage .= "<p>Please correct the following errors:</p><ul>";
        foreach ($errors as $error) {
            $errorMessage .= "<li>$error</li>";
        }
        $errorMessage .= "</ul></div>";
    }
}
?>
