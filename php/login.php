<?php
require "resources/connect.php";

if ($IsLogIn){
  // Redirect
  header("location: index.php");
  die();
}

$usernameInput = ""; // Initialize the username input variable

if ($_SERVER['REQUEST_METHOD'] == "POST"){
  $errorMsgs = array(); // Create an array for error messages

  // Add validation functions to functions.php
  if (IsEmpty($_POST, 'username')) {
    $errorMsgs['username'] = "<p style='color: red; text-align: center;'>Username is required.</p>";
  } else {
    $usernameInput = $_POST['username']; // Store the username input when it's not empty
  }

  if (IsEmpty($_POST, 'password')) {
    $errorMsgs['password'] = "<p style='color: red; text-align: center;'>Password is required.</p>";
  }

  if (empty($errorMsgs)) {
    // If no errors, attempt to log in
    $sql = "SELECT * FROM logins WHERE username = :username";
    $query = $db->prepare($sql);
    $query->execute(["username" => $_POST['username']]);
    $data = $query->fetch();

    if ($data != NULL){
      // If the username exists, verify the password
      if (password_verify($_POST['password'], $data['Password'])){
        // TBD: Add log here
        // Set the "user_id" session variable with the user's ID
        $_SESSION['login'] = true;
        $_SESSION['user_id'] = $data['LoginID'];
        $_SESSION['userlvl'] = $data['Permission'];
        // Redirect
        
        header("location: index.php");
        die();
      } else {
        $errorMsgs['password'] = "<p style='color: red; text-align: center;'>Invalid password.</p>";
      }
    } else {
      $errorMsgs['username'] = "<p style='color: red; text-align: center;'>Unknown username.</p>";
    }
  }
}

include "resources/header.php";
?>

<!-- Login box -->
<div class="home">
  <section class="center">
    <form action="login.php" method="POST">
      <div class="box">
        <p>Username: </p>
        <input class="input" id="username" name="username" type="text" value="<?= $usernameInput; ?>" />
        <?= $errorMsgs['username'] ?? ''; ?> <!-- Display username error near the input -->
      </div>
      <div class="box">
        <p>Password: </p>
        <input class="input" id="password" name="password" type="password" />
        <?= $errorMsgs['password'] ?? ''; ?> <!-- Display password error near the input -->
      </div>
      <h3>Don't have an account? <a href="registration.php"> <br> Register now!</a> </h3>
      <input class="btn" type="submit" value="Log in!" /> 
    </form>
  </section>
</div>

<?php include "resources/footer.php"; ?>
