<?php
require "resources/connect.php";

// Get all login data
$sql = "SELECT * FROM logins WHERE LoginID = :id";
$query = $db->prepare($sql);
$query->execute(["id" => $_SESSION['user_id']]);
$data = $query->fetch();

if ($data["Permission"] == 1) {
    echo "How did you get in here? Bad user. GO AWAY.";
    die();
}

$errorMsgs = [];
$id = "";
$fName = "";
$lName = "";
$email = "";
$phone = "";
$streetNum = "";
$streetName = "";
$city = "";
$province = "";

if (array_key_exists('user', $_GET)) {
    $sql = "SELECT * FROM users WHERE UserID = :id";
    $query = $db->prepare($sql);
    $query->execute(['id' => $_GET['user']]);
    $data = $query->fetch();
    if (!$data) {
        echo "Error 404";
        die();
    }

    $id = $data['UserID'];
    $fName = $data['FirstName'];
    $lName = $data['LastName'];
    $email = $data['Email'];
    $phone = $data['Phone'];
    $streetNum = $data['StreetNum'];
    $streetName = $data['StreetName'];
    $city = $data['City'];
    $province = $data['Province'];
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (IsEmpty($_POST, 'FirstName')) $errorMsgs['FirstName'] = "First Name is required.";
    else $fName = $_POST['FirstName'];

    if (IsEmpty($_POST, 'LastName')) $errorMsgs['LastName'] = "Last Name is required.";
    else $lName = $_POST['LastName'];

    if (IsEmpty($_POST, 'Email')) $errorMsgs['Email'] = "Email is required.";
    else if (!filter_var($_POST['Email'], FILTER_VALIDATE_EMAIL)) $errorMsgs['Email'] = "Invalid email address.";
    else $email = $_POST['Email'];

    // Add validation and handling for the new fields (Phone, Street Number, Street Name, City, Province)
    $phone = $_POST['Phone'] ?? "";
    $streetNum = $_POST['StreetNum'] ?? "";
    $streetName = $_POST['StreetName'] ?? "";
    $city = $_POST['City'] ?? "";
    $province = $_POST['Province'] ?? "";

    $id = $_POST['UserID'] ?? "";

    if (empty($errorMsgs)) {
        $data = [
            "FirstName" => $fName,
            "LastName" => $lName,
            "Email" => $email,
            "Phone" => $phone,
            "StreetNum" => $streetNum,
            "StreetName" => $streetName,
            "City" => $city,
            "Province" => $province,
        ];

        if (empty($id)) {
            $sql = "INSERT INTO users (FirstName, LastName, Email, Phone, StreetNum, StreetName, City, Province) 
                    VALUES (:FirstName, :LastName, :Email, :Phone, :StreetNum, :StreetName, :City, :Province);";
        } else {
            $sql = "UPDATE users SET FirstName = :FirstName, LastName = :LastName, Email = :Email, Phone = :Phone, StreetNum = :StreetNum, StreetName = :StreetName, City = :City, Province = :Province WHERE UserID = :UserID";
            $data['UserID'] = $id;
        }

        $query = $db->prepare($sql);
        $query->execute($data);

        if (empty($id)) $id = $db->lastInsertId();

        header("location: admin.php");
    }
}

include "resources/header.php";
?>

<div class="home">
    <section class="center">
        <form action="admin_user_edit.php" method="POST">
            <h3>User Information</h3>
            <div class="box">
                <p>First Name: </p>
                <input class="input" type="text" name="FirstName" value="<?= $fName; ?>" />
            </div>
            <p class="error" style="color: red; text-align: center;"><?= $errorMsgs['FirstName'] ?? ''; ?></p>
            <div class="box">
                <p>Last Name: </p>
                <input class="input" type="text" name="LastName" value="<?= $lName; ?>" />
            </div>
            <p class="error" style="color: red; text-align: center;"><?= $errorMsgs['LastName'] ?? ''; ?></p>
            <div class="box">
                <p>Email: </p>
                <input class="input" type="email" name="Email" value="<?= $email; ?>" />
            </div>
            <p class="error" style="color: red; text-align: center;"><?= $errorMsgs['Email'] ?? ''; ?></p>
            <div class="box">
                <p>Phone: </p>
                <input class="input" type="text" name="Phone" value="<?= $phone; ?>" /> 
            </div>
            <div class="box">
                <p>Street Number: </p>
                <input class="input" type="text" name="StreetNum" value="<?= $streetNum; ?>" /> 
            </div>
            <div class="box">
                <p>Street Name: </p>
                <input class="input" type="text" name="StreetName" value="<?= $streetName; ?>" /> 
            </div>
            <div class="box">
                <p>City: </p>
                <input class="input" type="text" name="City" value="<?= $city; ?>" /> 
            </div>
            <div class="box">
                <p>Province: </p>
                <input class="input" type="text" name="Province" value="<?= $province; ?>" /> 
            </div>
            <input type="hidden" name="UserID" value="<?= $id; ?>" />
            <input class="btn" type="submit" value="Submit" />
        </form>
    </section>
</div>

<?php include "resources/footer.php"; ?>
