<?php
require "resources/connect.php";

// Check if the logged-in user is an admin (Permission level 3)
$sql = "SELECT * FROM logins WHERE LoginID = :id";
$query = $db->prepare($sql);
$query->execute(["id" => $_SESSION['user_id']]);
$data = $query->fetch();

if ($data["Permission"] != 3) {
    echo "You are unauthorized to access this page.";
    die();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];

    // Check if the selected user exists in the users table
    $sql = "SELECT * FROM users WHERE UserID = :id";
    $query = $db->prepare($sql);
    $query->execute(["id" => $user_id]);
    $user_data = $query->fetch();

    if (!$user_data) {
        echo "User not found. Please select a valid user.";
    } else {
        // Insert the user as an agent
        $sql = "INSERT INTO agents (LoginID, FirstName, LastName, Phone, Email)
                VALUES (:login_id, :first_name, :last_name, :Phone, :email)";
        $query = $db->prepare($sql);
        $query->execute([
            "login_id" => $user_id,
            "first_name" => $user_data['FirstName'],
            "last_name" => $user_data['LastName'],
            "Phone" => $user_data['Phone'],
            "email" => $user_data['Email']
        ]);

        // Redirect back to admin.php
        header("location: admin.php");
        exit; // Make sure to exit to prevent further script execution
    }
}

include "resources/header.php";
?>

<div class="home">
    <section class="center">

        <form method="post" action="addAgent.php">
            <h3>Add User as Agent</h3>
            <div style="display: flex; justify-content: center; border: 1px solid #000; padding: 20px;">
                <label for="user_id">Select a User:</label>
                <select name="user_id" id="user_id">
                    <?php
                    // Fetch all users
                    $sql = "SELECT * FROM users";
                    $query = $db->query($sql);

                    while ($user = $query->fetch()) {
                        echo "<option value='{$user['UserID']}'>{$user['FirstName']} {$user['LastName']}</option>";
                    }
                    ?>
                </select>
            </div>
            <br>
            <input class="btn" type="submit" value="Add User as Agent">
        </form>
    </section>
</div>

<?php include "resources/footer.php"; ?>