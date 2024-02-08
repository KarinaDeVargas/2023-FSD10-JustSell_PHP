<?php
/* Temporary mail function until we deploy the website to the server. */
?>

<?php
if (isset($_POST['contact_submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];

    $to = 'teamuniformFSD10@GMAIL.COM'; // Replace with email address
    $subject = 'New Contact Form Submission';
    $messageBody = "Name: $name\nEmail: $email\nPhone: $phone\n\n$message";

    $headers = "From: $email";


    if (mail($to, $subject, $messageBody, $headers)) {
        echo '<script>alert("Message sent successfully. We will get back to you soon.");</script>';


        header('Refresh: 1; URL=/index.php'); 

        exit;
    } else {

        echo '<script>alert("Message could not be sent. Please try again later.");</script>';

        header('location: ../index.php');

        exit;
    }
}
?>

