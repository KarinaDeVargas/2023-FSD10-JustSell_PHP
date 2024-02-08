<?php
require "resources/connect.php";

if ($IsLogIn){
  // Redirect
  header("location: index.php");
  die();
}

$fName = "";
$lName = "";
$email = "";
$username = "";
$errorMsgs = [];

if ($_SERVER['REQUEST_METHOD'] == "POST"){
  // If a form was submitted

  // Validate first name, last name, and email
  if (IsEmpty($_POST, 'fName')) {
    $errorMsgs['fName'] = "First name is missing.";
  } else {
    $fName = $_POST['fName'];
  }

  if (IsEmpty($_POST, 'lName')) {
    $errorMsgs['lName'] = "Last name is missing.";
  } else {
    $lName = $_POST['lName'];
  }

  if (IsEmpty($_POST, 'email')) {
    $errorMsgs['email'] = "Email is missing.";
  } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $errorMsgs['email'] = "Invalid email address.";
  } else {
    $email = $_POST['email'];
  }

  // Validate username
  if (IsEmpty($_POST, 'username')) {
    $errorMsgs['username'] = "Username is missing.";
  } else {
    // Query the database to see if the username is already in use
    $sql = "SELECT * FROM logins WHERE Username=:username";
    $query = $db->prepare($sql);
    $query->execute(['username' => $_POST['username']]);
    $result = $query->fetch();
    if ($result != null) {
      // If the username already exists, return an error
      $errorMsgs['username'] = "Username is already in use.";
    } else {
      $username = $_POST['username'];
    }
  }

  // Validate password
  if (IsEmpty($_POST, 'password')) {
    $errorMsgs['password'] = "Password is missing.";
  } else if (strlen($_POST['password']) < 7) {
    $errorMsgs['password'] = "That password is too short.";
  } else if ($_POST['password'] != $_POST['passcomf']) {
    $errorMsgs['password'] = "Passwords do not match.";
  }

  if (empty($errorMsgs)) {
    // If no errors, create a login
    $data = [
      'username' => $username,
      'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
    ];

    $sql = "INSERT INTO logins (Username, Password) VALUES (:username, :password)";
    $query = $db->prepare($sql);
    $query->execute($data);

    // Take loginID from the created login
    $sql = "SELECT LoginID FROM logins WHERE Username=:username";
    $query = $db->prepare($sql);
    $query->execute(['username' => $username]);
    $result = $query->fetch();

    // Create a user
    $data = [
      'LoginID' => $result['LoginID'],
      'FirstName' => $fName,
      'LastName' => $lName,
      'Email' => $email,
    ];

    $sql = "INSERT INTO users (LoginID, FirstName, LastName, Email) VALUES (:LoginID, :FirstName, :LastName, :Email)";
    $query = $db->prepare($sql);
    $query->execute($data);

    // Log in and send users to index.php
    // TBD: Add log here
    $_SESSION['login'] = true;
    $_SESSION['user_id'] = $data['LoginID'];
    header("location: index.php");
    die();
  }
}

include "resources/header.php";
?>

<!-- Registration box -->
<div class="home">
  <section class="center">
    <form action="registration.php" method="POST">
      <h3>Create An Account!</h3>
      <div class="box">
        <p>First Name: </p>
        <input class="input" type="text" name="fName" id="fName" value="<?=$fName; ?>"/>
      </div>
      <p class="error" style="color: red; text-align: center;"><?=$errorMsgs['fName'] ?? ''; ?></p> <!-- Display first name error inline -->
      <div class="box">
        <p>Last Name: </p>
        <input class="input" type="text" name="lName" id="lName" value="<?=$lName; ?>"/>
      </div>
      <p class="error" style="color: red; text-align: center;"><?=$errorMsgs['lName'] ?? ''; ?></p> <!-- Display last name error inline -->
      <div class="box">
        <p>Email: </p>
        <input class="input" type="email" name="email" id="email" value="<?=$email; ?>"/>
      </div>
      <p class="error" style="color: red; text-align: center;"><?= $errorMsgs['email'] ?? ''; ?></p> <!-- Display email error inline -->
      <div class="box">
        <p>Username: </p>
        <input class="input" type="text" name="username" id="username" value="<?=$username; ?>"/>
      </div>
      <p class="error" style="color: red; text-align: center;"><?= $errorMsgs['username'] ?? ''; ?></p> <!-- Display username error inline -->
      <div class="box">
        <p>Password: </p>
        <input class="input" type="password" name="password" id="password"/>
      </div>
      <p class="error" style="color: red; text-align: center;"><?=$errorMsgs['password'] ?? ''; ?></p> <!-- Display password error inline -->
      <div class="box">
        <p>Confirm Password: </p>
        <input class="input" type="password" name="passcomf" id="passcomf"/>
      </div>
      <br>
      <h3>Already have an account? <br> <a href="login.php">Log in here!</a></h3>
      <input class="btn" type="submit" value="Register Now" />
    </form>
  </section>
</div>


<?php
include "resources/footer.php";
?>
