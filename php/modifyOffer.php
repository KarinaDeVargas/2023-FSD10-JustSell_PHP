<?php

require "resources/connect.php";

print_r($_GET);

//get all login data
$sql = "SELECT * FROM logins WHERE LoginID = :id";
$query = $db->prepare($sql);
$query->execute(["id"=> $_SESSION['user_id']]);
$data = $query->fetch();

if ($data["Permission"] == 1){
  echo "How did you get in here? Bad user. GO AWAY.";
  die();
} else {
  //check if item is exists in $_GET
  if (!array_key_exists('item', $_GET) ){
    Echo "error 404-1";
    ?>
    <a href="index.php">Return to home</a>
    <a href="admin.php">Return to admin Panel</a>
    <? die();
  }

  //check if item exists in DB
  $offerID = $_GET['item'];
  $sql = "SELECT * FROM propertyoffers WHERE offerID = :id";
  $query = $db->prepare($sql);
  $query->execute(["id" => $offerID]);
  $data = $query->fetch();

  if (!$data) {
    Echo "error 404-2";
    ?>
    <a href="index.php">Return to home</a>
    <a href="admin.php">Return to admin Panel</a>
    <? die();
  }
  
  //check modify method from 'set'
  $method = $_GET['set'];
  if ($method == 'App'){ // Approve Offer
    $sql = "UPDATE propertyoffers SET OfferStatus = :newStatus WHERE offerID = :id";
    $query = $db->prepare($sql);
    $query->execute(["id" => $offerID, "newStatus" => "Accepted"]);

    header("location: admin.php");

  } else if ($method == 'Rej'){ //Reject Offer
    $sql = "UPDATE propertyoffers SET OfferStatus = :newStatus WHERE offerID = :id";
    $query = $db->prepare($sql);
    $query->execute(["id" => $offerID, "newStatus" => "Rejected"]);

    header("location: admin.php");

  } else if ($method == 'Del'){ //Delete Offer
    $sql = "DELETE FROM propertyoffers WHERE offerID = :id";
    $query = $db->prepare($sql);
    $query->execute(["id" => $offerID]);

    header("location: admin.php");
  }
}
?>