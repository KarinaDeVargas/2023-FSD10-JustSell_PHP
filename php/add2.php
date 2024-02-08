<?php
//This file is the form action for editAgent.php
require "resources/connect.php";

// Get the currently logged-in user's data
$sql = "SELECT * FROM logins WHERE LoginID = :id";
$query = $db->prepare($sql);
$query->execute(["id" => $_SESSION['user_id']]);
$data = $query->fetch();

if ($data["Permission"] != 3) {
    echo "You are unauthorized to access this page.";
    die();
}

$errorMsgs = [];
$id = "";
$fName = "";
$lName = "";
$phone = "";
$email = "";

if (array_key_exists('agent', $_GET)) {
    $sql = "SELECT * FROM agents WHERE AgentID = :id";
    $query = $db->prepare($sql);
    $query->execute(['id' => $_GET['agent']]);
    $data = $query->fetch();
    if (!$data) {
        echo "Error 404";
        die();
    }

    $id = $data['AgentID'];
    $fName = $data['FirstName'];
    $lName = $data['LastName'];
    $phone = $data['Phone'];
    $email = $data['Email'];
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (IsEmpty($_POST, 'FirstName'))
        $errorMsgs['FirstName'] = "First Name is required.";
    else
        $fName = $_POST['FirstName'];

    if (IsEmpty($_POST, 'LastName'))
        $errorMsgs['LastName'] = "Last Name is required.";
    else
        $lName = $_POST['LastName'];

    if (IsEmpty($_POST, 'Phone'))
        $errorMsgs['Phone'] = "Phone is required.";
    else
        $phone = $_POST['Phone'];

    if (IsEmpty($_POST, 'Email'))
        $errorMsgs['Email'] = "Email is required.";
    else if (!filter_var($_POST['Email'], FILTER_VALIDATE_EMAIL))
        $errorMsgs['Email'] = "Invalid email address.";
    else
        $email = $_POST['Email'];

    $id = $_POST['AgentID'] ?? "";

    if (empty($errorMsgs)) {
        $data = [
            "FirstName" => $fName,
            "LastName" => $lName,
            "Phone" => $phone,
            "Email" => $email,
        ];

        if (empty($id)) {
            $sql = "INSERT INTO agents (FirstName, LastName, Phone, Email) 
                    VALUES (:FirstName, :LastName, :Phone, :Email);";
        } else {
            $sql = "UPDATE agents SET FirstName = :FirstName, LastName = :LastName, Phone = :Phone, Email = :Email WHERE AgentID = :AgentID";
            $data['AgentID'] = $id;
        }

        $query = $db->prepare($sql);
        $query->execute($data);

        if (empty($id))
            $id = $db->lastInsertId();

        header("location: admin.php");
    }
}

include "resources/header.php";
?>

<div class="home">
    <section class="center">
        <form action="add2.php" method="POST">
            <h3>Edit Agent Information</h3>
            <div class="box">
                <p>First Name: </p>
                <input class="input" type="text" name="FirstName" value="<?= $fName; ?>" />
            </div>
            <p class="error" style="color: red; text-align: center;">
                <?= $errorMsgs['FirstName'] ?? ''; ?>
            </p>
            <div class="box">
                <p>Last Name: </p>
                <input class="input" type="text" name="LastName" value="<?= $lName; ?>" />
            </div>
            <p class="error" style="color: red; text-align: center;">
                <?= $errorMsgs['LastName'] ?? ''; ?>
            </p>
            <div class="box">
                <p>Phone: </p>
                <input class="input" type="text" name="Phone" value="<?= $phone; ?>" />
            </div>
            <p class="error" style="color: red; text-align: center;">
                <?= $errorMsgs['Phone'] ?? ''; ?>
            </p>
            <div class="box">
                <p>Email: </p>
                <input class="input" type="email" name="Email" value="<?= $email; ?>" />
            </div>
            <p class="error" style="color: red; text-align: center;">
                <?= $errorMsgs['Email'] ?? ''; ?>
            </p>
            <input type="hidden" name="AgentID" value="<?= $id; ?>" />
            <input class="btn" type="submit" value="Submit" />
        </form>
    </section>
</div>

<?php include "resources/footer.php"; ?>
