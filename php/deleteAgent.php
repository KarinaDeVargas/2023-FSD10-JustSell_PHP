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
    // Admins (Permission level 3) are allowed to delete agents
    if (!array_key_exists('agent', $_GET)) {
        echo "Error 404";
        ?>
        <a href="index.php">Return to home</a>
        <a href="admin.php">Return to admin Panel</a>
        <?php
        die();
    }

    // Check if agent exists
    $agentID = $_GET['agent'];
    $sql = "SELECT * FROM agents WHERE AgentID = :id";
    $query = $db->prepare($sql);
    $query->execute(["id" => $agentID]);
    $agentData = $query->fetch();

    if (!$agentData) {
        echo "Error 404";
        ?>
        <a href="index.php">Return to home</a>
        <a href="admin.php">Return to admin Panel</a>
        <?php
        die();
    }

    // Delete the agent
    $sql = "DELETE FROM agents WHERE AgentID = :id";
    $query = $db->prepare($sql);
    $query->execute(["id" => $agentID]);

    // Return to admin panel
    header("location: admin.php");
    die();
}
?>
