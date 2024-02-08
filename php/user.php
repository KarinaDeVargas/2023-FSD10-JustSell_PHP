<?php
require "resources/connect.php";
include "resources/header.php";

// Check if the user is logged in and if "user_id" session variable is set
if ($IsLogIn && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Fetch user information from the database
    $select_user = $db->prepare("SELECT u.*, l.Username, l.Permission FROM `users` u
JOIN `logins` l ON u.LoginID = l.LoginID
WHERE u.LoginID = :login_id");
    if ($select_user->execute(['login_id' => $user_id])) {
        $user_data = $select_user->fetch(PDO::FETCH_ASSOC);
    } else {
        echo "Query execution failed. Error: " . implode(" ", $select_user->errorInfo()) . "<br>";
    }
} else {
    header("location: login.php"); // Redirect to the login page
    die();
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle the form submission for editing user information
    $newEmail = $_POST["newEmail"];
    $newFirstName = $_POST["newFirstName"];
    $newLastName = $_POST["newLastName"];
    $newPhone = $_POST["newPhone"];
    $newStreetNum = empty($_POST["newStreetNum"]) ? null : $_POST["newStreetNum"];
    $newStreetName = $_POST["newStreetName"];
    $newCity = $_POST["newCity"];
    $newProvince = $_POST["newProvince"];
    $newPostal = $_POST["newPostal"];

    // Update user information in the database
    $update_user = $db->prepare("UPDATE `users` SET Email = :newEmail, FirstName = :newFirstName, LastName = :newLastName, Phone = :newPhone, StreetNum = :newStreetNum, StreetName = :newStreetName, City = :newCity, Province = :newProvince, Postal = :newPostal WHERE UserID = :user_id");
    if (
        $update_user->execute([
            'newEmail' => $newEmail,
            'newFirstName' => $newFirstName,
            'newLastName' => $newLastName,
            'newPhone' => $newPhone,
            'newStreetNum' => $newStreetNum,
            'newStreetName' => $newStreetName,
            'newCity' => $newCity,
            'newProvince' => $newProvince,
            'newPostal' => $newPostal,
            'user_id' => $user_data['UserID']
        ])
    ) {
        // Successfully updated user information
        header("location: user.php"); // Redirect to the user profile page
        die();
    } else {
        echo "Update failed. Error: " . implode(" ", $update_user->errorInfo()) . "<br>";
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <style>
        .user-profile {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .edit-profile {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Style for user details */
        .user-details {
            font-size: 18px;
        }

        /* Style for user details labels */
        .user-details label {
            font-weight: bold;
            display: inline-block;
            width: 150px;
            /* Adjust the width as needed to align labels */
        }

        /* Style for user details values */
        .user-details p {
            margin: 5px 0;
            display: inline;
        }

        /* Style for user not found message */
        .user-not-found {
            font-size: 18px;
            color: #ff0000;
        }

        .heading {
            font-size: 24px;
            margin-bottom: 20px;
        }

        h2 {
            font-size: 20px;
            margin-top: 20px;
            margin-bottom: 10px;
        }

        form label {
            font-weight: bold;
        }

        form input[type="text"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        form input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
    </style>

</head>

<body>

    <section class="user-profile">
        <h1 class="heading">User Profile Dashboard</h1>

        <?php
        if ($user_data) {
            ?>
            <!-- User details -->
            <div class="user-details">
                <label>User ID:</label>
                <p>
                    <?= $user_data['UserID'] ?>
                </p>
                <br>
                <br>
                <label>Username:</label>
                <p>
                    <?= $user_data['Username'] ?>
                </p>
                <br>
                <br>
                <label>Email:</label>
                <p>
                    <?= $user_data['Email'] ?>
                </p>
                <br>
                <br>
                <label>First Name:</label>
                <p>
                    <?= $user_data['FirstName'] ?>
                </p>
                <br>
                <br>
                <label>Last Name:</label>
                <p>
                    <?= $user_data['LastName'] ?>
                </p>
                <br>
                <br>
                <label>Phone:</label>
                <p>
                    <?= !empty($user_data['Phone']) ? $user_data['Phone'] : "N/A" ?>
                </p>
                <br>
                <br>
                <label>Street Number:</label>
                <p>
                    <?= !empty($user_data['StreetNum']) ? $user_data['StreetNum'] : "N/A" ?>
                </p>
                <br>
                <br>
                <label>Street Name:</label>
                <p>
                    <?= !empty($user_data['StreetName']) ? $user_data['StreetName'] : "N/A" ?>
                </p>
                <br>
                <br>
                <label>City:</label>
                <p>
                    <?= !empty($user_data['City']) ? $user_data['City'] : "N/A" ?>
                </p>
                <br>
                <br>
                <label>Province:</label>
                <p>
                    <?= !empty($user_data['Province']) ? $user_data['Province'] : "N/A" ?>
                </p>
                <br>
                <br>
                <label>Postal Code:</label>
                <p>
                    <?= !empty($user_data['Postal']) ? $user_data['Postal'] : "N/A" ?>
                </p>
            </div>
            <?php
        } else {
            echo '<p class="user-not-found">No user found.</p>';
        }
        ?>
    </section>

    <section class="edit-profile">
        <h2>Edit Profile information</h2>

        <form method="post">
            <label for="newEmail">New Email:</label>
            <input type="text" name="newEmail" value="<?= $user_data['Email'] ?>"><br>

            <label for="newFirstName">New First Name:</label>
            <input type="text" name="newFirstName" value="<?= $user_data['FirstName'] ?>"><br>

            <label for="newLastName">New Last Name:</label>
            <input type="text" name="newLastName" value="<?= $user_data['LastName'] ?>"><br>

            <label for="newPhone">New Phone:</label>
            <input type="text" name="newPhone" value="<?= $user_data['Phone'] ?>"><br>

            <label for="newStreetNum">New Street Number:</label>
            <input type="text" name="newStreetNum" value="<?= $user_data['StreetNum'] ?>"><br>

            <label for="newStreetName">New Street Name:</label>
            <input type="text" name="newStreetName" value="<?= $user_data['StreetName'] ?>"><br>

            <label for="newCity">New City:</label>
            <input type="text" name="newCity" value="<?= $user_data['City'] ?>"><br>

            <label for="newProvince">New Province:</label>
            <input type="text" name="newProvince" value="<?= $user_data['Province'] ?>"><br>

            <label for="newPostal">New Postal Code:</label>
            <input type="text" name="newPostal" value="<?= $user_data['Postal'] ?>"><br>
            <br>
            <input type="submit" value="Save Changes">
        </form>
    </section>

    <?php
    if ($user_data) {
        // Debug: Display user_data
        echo "<pre>";
        print_r($user_data);
        echo "</pre>";
    } ?>

    <!-- Admin Button -->
    <?php if ($user_data['Permission'] == 3) { ?>
        <button class=inline-btn type="submit" onclick="location.href='admin.php'">Admin Panel</button>
    <?php } ?>

    <!-- Admin Button -->
    <?php if ($user_data['Permission'] == 2) { ?>
        <button class=inline-btn type="submit" onclick="location.href='agent_panel.php'">Agent Panel</button>
    <?php } ?>

</body>

</html>

<?php
include "resources/footer.php";
?>