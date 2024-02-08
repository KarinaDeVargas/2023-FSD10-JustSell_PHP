<?php

require "resources/connect.php";

// Get the currently logged-in user's data
$sql = "SELECT * FROM logins WHERE LoginID = :id";
$query = $db->prepare($sql);
$query->execute(["id" => $_SESSION['user_id']]);
$data = $query->fetch();

if ($data["Permission"] == 1) {
    echo "How did you get in here? Bad user. GO AWAY.";
    die();
} else if ($data["Permission"] == 3) {
    // Admins (Permission level 3) are allowed to delete users
    if (!array_key_exists('user', $_GET)) {
        echo "Error 404";
        ?>
        <a href="index.php">Return to home</a>
        <a href="admin.php">Return to admin Panel</a>
        <?php
        die();
    }

    // Check if user exists
    $userID = $_GET['user'];
    $sql = "SELECT * FROM users WHERE UserID = :id";
    $query = $db->prepare($sql);
    $query->execute(["id" => $userID]);
    $userData = $query->fetch();

    if (!$userData) {
        echo "Error 404";
        ?>
        <a href="index.php">Return to home</a>
        <a href="admin.php">Return to admin Panel</a>
        <?php
        die();
    }

    // Delete related records in propertyoffers table
    $sql = "DELETE FROM propertyoffers WHERE UserID = :id";
    $query = $db->prepare($sql);
    $query->execute(["id" => $userID]);

    // Delete the user
    $sql = "DELETE FROM users WHERE UserID = :id";
    $query = $db->prepare($sql);
    $query->execute(["id" => $userID]);

    // Return to admin panel
    header("location: admin.php");
    die();
}
?>
