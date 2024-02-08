<?php

require "resources/connect.php";

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
  $agent = "";
  $stNum = "";
  $stName = "";
  $city = "";
  $prov = "";
  $postal = "";
  $desc = "";
  $price = "";
  $bath = "";
  $bed = "";
  $flr = "";
  $size = "";
  $furn = "";
  $propType = "";
  $year = "";
  $amen = "";
  $sale = "";
  $stat = "";

  if (array_key_exists('item', $_GET)){
    $sql = "SELECT * FROM properties where propertyID = :id";
    $query = $db->prepare($sql);
    $query->execute(['id' => $_GET['item']]);

    $data = $query->fetch();
    if (!$data){
      echo "error 404";
      die();
    }

    $id = $data['PropertyID'];
    $agent = $data['AgentID'];
    $stNum = $data['StreetNum'];
    $stName = $data['StreetName'];
    $city = $data['City'];
    $prov = $data['Province'];
    $postal = $data['Postal'];
    $desc = $data['Description'];
    $price = $data['Price'];
    $bath = $data['Bathrooms'];
    $bed = $data['Bedrooms'];
    $flr = $data['Floors'];
    $size = $data['size'];
    $furn = $data['furnished'];
    $propType = $data['PropertyType'];
    $year = $data['YearOfBuilt'];
    $amen = $data['Amenities'];
    $sale = $data['sellOption'];
    $stat = $data['ConstructionStatus'];
  }

  if ($_SERVER['REQUEST_METHOD'] == "POST"){
    //if post method is true validate the form data
    if (IsEmpty($_POST, 'StreetNum')) $errorMsgs['StreetNum'] = "Street Number is required.";
    else $stNum = $_POST['StreetNum'];

    if (IsEmpty($_POST, 'StreetName')) $errorMsgs['StreetName'] = "Street Name is required.";
    else $stName = $_POST['StreetName'];

    if (IsEmpty($_POST, 'City')) $errorMsgs['City'] = "City is required.";
    else $city = $_POST['City'];

    if (IsEmpty($_POST, 'Province')) $errorMsgs['Province'] = "Province is required.";
    else $prov = $_POST['Province'];

    if (IsEmpty($_POST, 'Postal')) $errorMsgs['Postal'] = "Postal code is required.";
    else $postal = $_POST['Postal'];

    if (IsEmpty($_POST, 'Description')) $errorMsgs['Description'] = "A description is required.";
    else $desc = $_POST['Description'];

    if (IsEmpty($_POST, 'Price')) {
      $errorMsgs['Price'] = "Price is required.";
    } else if ($_POST['Price'] <= 0){
      $errorMsgs['Price'] = "Invalid Price.";
    } else {
      $price = $_POST['Price'];
    }

    if (IsEmpty($_POST, 'Bathrooms') || $_POST['Bathrooms'] <= 0) $bath = 1;
    else $bath = $_POST['Bathrooms'];

    if (IsEmpty($_POST, 'Bedrooms') || $_POST['Bedrooms'] <= 0) $bed = 1;
    else $bed = $_POST['Bedrooms'];

    if (IsEmpty($_POST, 'Floors') || $_POST['Floors'] <= 0) $flr = 1;
    else $flr = $_POST['Floors'];

    if (IsEmpty($_POST, 'size') || $_POST['size'] <= 0) $size = NULL;
    else $size = $_POST['size'];
    
    $furn = $_POST['furnished'] ?? "0";

    $propType = $_POST['PropertyType'];

    if ($_POST['YearOfBuilt'] > 2025 || $_POST['YearOfBuilt'] < 1800 || IsEmpty($_POST, 'YearOfBuilt')) $year = 2020;
    else $year = $_POST['YearOfBuilt'];

    if (IsEmpty($_POST, 'Amenities')) $amen = "N/A";
    else $amen = $_POST['Amenities'];
    
    $sale = $_POST['sellOption'];

    $stat = $_POST['ConstructionStatus'];

    $id = $_POST['propertyID'] ?? "";

    if (IsEmpty($_POST, 'AgentID')){
      $errorMsgs['AgentID'] = "Agent ID is required.";
    } else {
      $sql = "SELECT AgentID FROM agents";
      $query = $db->prepare($sql);
      $query->execute();
      $results = $query->fetchall();

      if (in_array($_POST['AgentID'], array_column($results, 'AgentID'))){
        $agent = $_POST['AgentID'];
      } else {
        $errorMsgs['AgentID'] = "Agent not found.";
      }
    }
    

    if (empty($errorMsgs)){
      $data = [
        "agent" => $agent,
        "stNum" => $stNum,
        "stName" => $stName,
        "city" => $city,
        "prov" => $prov,
        "postal" => $postal,
        "desc" => $desc,
        "price" => $price,
        "bath" => $bath,
        "bed" => $bed,
        "flr" => $flr,
        "size" => $size,
        "furn" => $furn,
        "propType" => $propType,
        "year" => $year,
        "amen" => $amen,
        "sale" => $sale,
        "stat" => $stat,
      ];

      if ($id == ""){
        $sql = "INSERT INTO properties (AgentID, StreetNum, StreetName, City, Province, Postal, Description, Price, Bathrooms, Bedrooms, Floors, size, furnished, PropertyType, YearOfBuilt, Amenities, sellOption, ConstructionStatus) 
        VALUES (:agent, :stNum, :stName, :city, :prov, :postal, :desc, :price, :bath, :bed, :flr, :size, :furn, :propType, :year, :amen, :sale, :stat);";
      } else {
        $sql = "UPDATE properties SET StreetNum = :stNum, StreetName = :stName, City = :city, Province = :province, Postal = :postal, Description = :desc, Price = :price, Bathrooms = :bath, Bedrooms = :bed, Floors = :flr, Size = :size, Furnished = :furn, PropertyType = :propType, YearOfBuilt = :year, Amenities = :amen, sellOption = :sale, ConstructionStatus = :stat  WHERE PropertyID = :id";
        $data['propertyID'] = $id; 
      }
      $query = $db->prepare($sql);
      $query->execute($data);

      if ($id == "") $id = $db->lastInsertId();

      header("location: details.php?get_id={$id}");
    }
  }
  include "resources/header.php";
  ?>
  <div class="home">
  <section class="center">
    <form action="add.php" method="POST">
      <h3>Property Listing</h3>  
      <div class="box">
        <p>Agent: </p>
        <input class="input" type="number" name="AgentID" value="<?=$agent; ?>"/>
      </div>
      <p class="error" style="color: red; text-align: center;"><?=$errorMsgs['AgentID'] ?? ''; ?></p>
      <div class="box">
        <p>Street Number: </p>
        <input class="input" type="text" name="StreetNum" value="<?=$stNum; ?>"/>
      </div>
      <p class="error" style="color: red; text-align: center;"><?=$errorMsgs['StreetNum'] ?? ''; ?></p>
      <div class="box">
        <p>Street Name: </p>
        <input class="input" type="text" name="StreetName" value="<?=$stName; ?>"/>
      </div>
      <p class="error" style="color: red; text-align: center;"><?=$errorMsgs['StreetName'] ?? ''; ?></p>
      <div class="box">
        <p>City: </p>
        <input class="input" type="text" name="City" value="<?=$city; ?>"/>
      </div>
      <p class="error" style="color: red; text-align: center;"><?=$errorMsgs['City'] ?? ''; ?></p>
      <div class="box">
        <p>Province: </p>
        <input class="input" type="text" name="Province" value="<?=$prov; ?>"/>
      </div>
      <p class="error" style="color: red; text-align: center;"><?=$errorMsgs['Province'] ?? ''; ?></p>
      <div class="box">
        <p>Postal </p>
        <input class="input" type="text" name="Postal" value="<?=$postal; ?>"/>
      </div>
      <p class="error" style="color: red; text-align: center;"><?=$errorMsgs['Postal'] ?? ''; ?></p>
      <div class="box">
        <p>Description: </p>
        <input class="input" type="text" name="Description" value="<?=$desc; ?>"/>
      </div>
      <p class="error" style="color: red; text-align: center;"><?=$errorMsgs['Description'] ?? ''; ?></p>
      <div class="box">
        <p>Price: </p>
        <input class="input" type="Number" name="Price" value="<?=$price; ?>"/>
      </div>
      <p class="error" style="color: red; text-align: center;"><?=$errorMsgs['Price'] ?? ''; ?></p>
      <div class="box">
        <p>Bathroom: </p>
        <input class="input" type="Number" name="Bathrooms" value="<?=$bath; ?>"/>
      </div>
      <div class="box">
        <p>Bedrooms: </p>
        <input class="input" type="Number" name="Bedrooms" value="<?=$bed; ?>"/>
      </div>
      <div class="box">
        <p>Floors: </p>
        <input class="input" type="Number" name="Floors" value="<?=$flr; ?>"/>
      </div>
      <div class="box">
        <p>Size: </p>
        <input class="input" type="Number" name="size" value="<?=$size; ?>"/>
      </div>
      <div class="box">
        <p>Furnished: </p>
        <input class="input" type="checkbox" name="Furnished" value="<?=$furn; ?>"/>
      </div>
      <div class="box">
        <p>Property Type: </p>
        <select class="input" name="PropertyType">
          <option value="Apartment">Apartment</option>
          <option value="House">House</option>
          <option value="Duplex or Triplex">Duplex or Triplex</option>
          <option value="Condo">Condo</option>
          <option value="Comercial Building">Comercial Building</option>
        </select>
      </div>
      <div class="box">
        <p>Year built: </p>
        <input class="input" type="Number" name="YearOfBuilt" value="<?=$year; ?>"/>
      </div>
      <div class="box">
        <p>Amenities: </p>
        <input class="input" type="text" name="Amenitites" value="<?=$amen; ?>"/>
      </div>
      <div class="box">
        <p>Offer Type: </p>
        <select class="input" name="sellOption">
          <option value="Sale">Sale</option>
          <option value="Resale">Resale</option>
          <option value="Leasing">Leasing</option>
        </select>
      </div>
      <div class="box">
        <p>Construction Status: </p>
        <select class="input" name="ConstructionStatus">
          <option value="Ready to Move">Ready to Move</option>
          <option value="Under Construction">Under Construction</option>
        </select>
      </div>
      <input class="btn" type="submit" value="Submit" />
    </form>
  </section>
  </div>
<?

include "resources/footer.php"; ?>