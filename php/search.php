<?php
   require "resources/connect.php";
   include "resources/header.php";
?>
<!-- search filter section starts  -->

<section class="filters" style="padding-bottom: 0;">
   <form action="" method="post">
      <div id="close-filter"><i class="fas fa-times"></i></div>
      <h3>Filter your search</h3>         
         <div class="flex">
            <div class="box">
               <p>Location</p>
               <input type="text" name="Location" required maxlength="50" placeholder="Search by city or Postal code" class="input">
            </div>
            <div class="box">
               <p>Offer type</p>
               <select name="sellOption" class="input" required>
                  <option value="sale" selected>Sale</option>
                  <option value="resale">Resale</option>
                  <option value="leasing">Leasing</option>
               </select>
            </div>
            <div class="box">
               <p>Property type</p>
               <select name="PropertyType" class="input" required>
                  <option value="apartment" selected>Apartment</option>
                  <option value="house">House</option>
                  <option value="duplexTriplex">Duplex or Triplex</option>
                  <option value="condo">Condo</option>
                  <option value="comercialBuilding">Comercial Building</option>
               </select>
            </div>
            <div class="box">
               <p>Bedrooms</p>
               <select name="Bedrooms" class="input" required>
                  <option value="1" selected>1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6+</option>
                  
               </select>
            </div>
            <div class="box">
               <p>Minimum budget</p>
               <select name="min" class="input" required>
                  <option value="0">0</option>
                  <option value="50000" selected>50k</option>
                  <option value="100000">100k</option>
                  <option value="150000">150k</option>
                  <option value="200000">200k</option>
                  <option value="300000">300k</option>
                  <option value="400000">400k</option>
                  <option value="450000">450k</option>
                  <option value="500000">500k</option>
                  <option value="1000000">1M</option>
               </select>
            </div>
            <div class="box">
               <p>Maximum budget</p>
               <select name="max" class="input" required>
                  <option value="50000" selected>50k</option>
                  <option value="100000">100k</option>
                  <option value="150000">150k</option>
                  <option value="200000">200k</option>
                  <option value="300000">300k</option>
                  <option value="400000">400k</option>
                  <option value="450000">450k</option>
                  <option value="500000">500k</option>
                  <option value="1000000">1M+</option>
               </select>
            </div>
         </div>
         <input type="submit" value="Search Property" name="filter_search" class="btn">
   </form>
</section>

<!-- search filter section ends -->
<div id="filter-btn" class="fas fa-filter"></div>


<!-- Search Listing section starts -->
<section class="listings">   
   <?php 
      if(isset($_POST['filter_search']) or isset($_POST['h_search'])){
         echo '<h1 class="heading">Search Results</h1>';
      }else{
         echo '<h1 class="heading">Find your new Home!</h1>';
      }
   ?>
   <div class="box-container">
      <?php
         if(isset($_POST['filter_search']) or isset($_POST['h_search'])){
            $location = $_POST['Location'];
            $location = filter_var($location, FILTER_SANITIZE_STRING);
            $propertyType = $_POST['PropertyType'];
            $propertyType = filter_var($propertyType, FILTER_SANITIZE_STRING);
            if (!isset($_POST['h_search'])) {
               $sellOption = $_POST['sellOption'];
               $sellOption = filter_var($sellOption, FILTER_SANITIZE_STRING);
               $bedrooms = $_POST['Bedrooms'];
               $bedrooms = filter_var($bedrooms, FILTER_SANITIZE_STRING);
            } else {
               $sellOption = "";
               $bedrooms = "";
            }
            $min = $_POST['min'];
            $min = filter_var($min, FILTER_SANITIZE_STRING);
            $max = $_POST['max'];
            $max = filter_var($max, FILTER_SANITIZE_STRING);   
      
            $sql = "SELECT properties.*, image.*  FROM `properties` 
                  LEFT JOIN image ON properties.PropertyID = image.PropertyID 
                  WHERE image.ImageID = (
                        SELECT MIN(ImageID) 
                        FROM image 
                        WHERE image.PropertyID = properties.PropertyID ) 
                     AND city LIKE '%{$location}%' 
                     AND PropertyType LIKE '%{$propertyType}%' 
                     AND sellOption LIKE '%{$sellOption}%'
                     AND Bedrooms LIKE '%{$bedrooms}%' 
                     AND price BETWEEN $min AND $max 
                     ORDER BY properties.PropertyID DESC";
      
         $select_properties = $db->prepare($sql);
         $select_properties->execute();
         if($select_properties->rowCount() > 0){
            while($fetch_property = $select_properties->fetch(PDO::FETCH_ASSOC)){
      ?>                                        

      <form action="" method="POST">
         <div class="box">
            <input type="hidden" name="PropertyID" value="<?= $fetch_property['PropertyID']; ?>">            
            <div class="thumb">                      
               <img src="images/PropertiesImages/<?= $fetch_property['ImageFileName']; ?>" alt="Missing the property picture">
            </div>
         </div>
         <div class="box">
            <div class="price"><i class="fas fa-dollar-sign"></i><span><?= number_format($fetch_property['Price'], 2, '.', ',') ?></span></div>
            <h3 class="name"><?= $fetch_property['PropertyType']; ?></h3>
            <p class="location"><i class="fas fa-map-marker-alt"></i><span><?= $fetch_property['City']; ?></span></p>
            <div class="flex">
               <p><i class="fas fa-house"></i><span><?= $fetch_property['PropertyType']; ?></span></p>
               <p><i class="fas fa-bed"></i><span><?= $fetch_property['Bedrooms']; ?></span></p>
               <p><i class="fas fa-trowel"></i><span><?= $fetch_property['ConstructionStatus']; ?></span></p>
               <p><i class="fas fa-couch"></i><span><?php
                  if ($fetch_property['furnished'] == 1) {
                        echo "furnished";
                  } else {
                        echo "not furnished";
                  }
               ?></span></p>
               <p><i class="fas fa-maximize"></i><span><?= $fetch_property['size']; ?>sqft</span></p>
            </div>
            <div class="flex-btn">
               <a href="details.php?get_id=<?= $fetch_property['PropertyID']; ?>" class="btn">View Details</a>
               <a href="make_offer.php?get_id=<?= $fetch_property['PropertyID']; ?>" class="btn">Send Offer</a>
            </div>
         </div>
      </form>
      <?php
         }} else{
            echo '<p class="empty">no results found!</p>';
         }}
      ?>
      
   </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<script>

document.querySelector('#filter-btn').onclick = () =>{
   document.querySelector('.filters').classList.add('active');
}

document.querySelector('#close-filter').onclick = () =>{
   document.querySelector('.filters').classList.remove('active');
}

</script>
</body>
</html>

<?php include "resources/footer.php" ?>