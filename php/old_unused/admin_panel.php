<?php
require "resources/connect.php";
include "resources/header.php";

// Check if the user is logged in and if they have admin permissions
if ($IsLogIn && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Fetch user information, including permissions, from the database
    $select_user = $db->prepare("SELECT u.*, l.Username, l.Permission FROM `users` u
    JOIN `logins` l ON u.LoginID = l.LoginID
    WHERE u.LoginID = :login_id");
    if ($select_user->execute(['login_id' => $user_id])) {
        $user_data = $select_user->fetch(PDO::FETCH_ASSOC);

        // Check if the user has admin permissions (Permission level 3)
        if ($user_data['Permission'] == 3) {
            // User has admin permissions, display admin panel content
            ?>
            <!DOCTYPE html>
            <html>

            <head>
                <title>Admin Panel</title>
                <!-- Add your admin panel styles and scripts here -->
            </head>

            <body>
                <h1>Welcome to the Admin Panel,
                    <?= $user_data['Username'] ?>!
                </h1>
                <!-- Add your admin panel content here -->

                <?php
                if ($user_data) {
                    // Debug: Display user_data
                    echo "<pre>";
                    print_r($user_data);
                    echo "</pre>";
                } ?>

            </body>

            </html>
            <?php
        } else {
            // User does not have admin permissions, show an access denied message or redirect
            echo "Access Denied. You do not have admin permissions.";
        }
    } else {
        echo "Query execution failed. Error: " . implode(" ", $select_user->errorInfo()) . "<br>";
    }
} else {
    header("location: login.php"); // Redirect to the login page if the user is not logged in
    die();
}
?>