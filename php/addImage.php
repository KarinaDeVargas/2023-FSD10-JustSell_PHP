<?php

require "resources/connect.php";

//i've used this so often it should probably be a function
//get all login data
$sql = "SELECT * FROM logins WHERE LoginID = :id";
$query = $db->prepare($sql);
$query->execute(["id"=> $_SESSION['user_id']]);
$data = $query->fetch();

if ($data["Permission"] == 1){
  echo "How did you get in here? Bad user. GO AWAY.";
  die();
}

$errorMsgs = [];
$id = "";
$fName = "";
$desc = "";
$image = "";

if (array_key_exists('id', $_GET)){
  $id = $_GET['id'];

}

if ($_SERVER['REQUEST_METHOD'] == "POST"){
  if (IsEmpty($_POST, 'Description')) $errorMsgs['Description'] = "Description is required.";
  else $desc = $_POST['Description'];

  if (IsEmpty($_POST, 'ImageFileName')) $errorMsgs['ImageFileName'] = "File name is required.";
  else $fName = $_POST['ImageFileName'];

  if (IsEmpty($_POST, 'PropertyID')) {
    $errorMsgs['PropertyID'] = "Property ID is required.";
  } else {
    $sql = "SELECT PropertyID FROM Properties";
    $query = $db->prepare($sql);
    $query->execute();
    $results = $query->fetchall();
    
    if (in_array($_POST['PropertyID'], array_column($results, 'PropertyID'))){
      $id = $_POST['PropertyID'];
    } else {
      $errorMsgs['PropertyID'] = "Property not found.";
    }
  }

  if (empty($errorMsgs)){
    
    if ($_FILES['ImagePath']['error'] == 0){
      $source = $_FILES['ImagePath']['tmp_name'];
      $desto = "images/PropertiesImages/" . $_FILES['ImagePath']['name'];

      if (move_uploaded_file($source, $desto)){
        $image = $desto;
      } else {
        Echo "ERROR: File was not moved.";
        die();
      }

    }


    $data = [
      "PropertyID" => $id,
      "ImageFileName" => $fName,
      "Description" => $desc,
      "ImagePath" => $image,
    ];

    $sql = "INSERT INTO image (PropertyID, ImagePath, ImageFileName, Description) VALUES (:PropertyID, :ImagePath, :ImageFileName, :Description);";
    $query = $db->prepare($sql);
    $query->execute($data);

    //image was added? return to admin? or return to addImage?
  }
}

include "resources/header.php"; ?>

<div class="home">
  <section class="center">
    <form action="addImage.php" method="POST" enctype="multipart/form-data">
      <h3>Attach Image to Property</h3>  
      <div class="box">
        <p>Property ID: </p>
        <input class="input" type="number" name="PropertyID" value="<?=$id; ?>"/>
      </div>
      <p class="error" style="color: red; text-align: center;"><?=$errorMsgs['PropertyID'] ?? ''; ?></p>
      <div class="box">
        <p>File Name: </p>
        <input class="input" type="text" name="ImageFileName" value="<?=$fName; ?>"/>
      </div>
      <p class="error" style="color: red; text-align: center;"><?=$errorMsgs['ImageFileName'] ?? ''; ?></p>
      <div class="box">
        <p>Image: </p>
        <input class="input" type="file" name="ImagePath"/>
      </div>
      <p class="error" style="color: red; text-align: center;"><?=$errorMsgs['ImagePath'] ?? ''; ?></p>
      <div class="box">
        <p>Description: </p>
        <input class="input" type="text" name="Description" value="<?=$desc; ?>"/>
      </div>
      <p class="error" style="color: red; text-align: center;"><?=$errorMsgs['Description'] ?? ''; ?></p>
      <input class="btn" type="submit" value="Submit" />
    </form>
  </section>
</div>

<? include "resources/footer.php"; ?>
