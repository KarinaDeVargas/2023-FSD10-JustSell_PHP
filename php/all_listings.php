<?php
require "resources/connect.php";
include "resources/header.php";

// Latest listings limited to 6. If we want to change the limit of the number of the houses, we just need to change from 6 to another number.
if (isset($_GET['is_latest_listings_only']) && $_GET['is_latest_listings_only'] == '1') {
   $sqlLimit = "LIMIT 3";
   $pageTitle = "Latest Listings";
   $pageDescription = "Please see here Just Sell latest listing:";

} else {
   $sqlLimit = "";  
   $pageTitle = "All Listings";
   $pageDescription = "Please see here Just Sell all listing:";
}
?>

<!-- all listings section starts  -->

<section class="listings">

   <h1 class="heading"><?php echo($pageTitle)?></h1>
   <p class="heading"><?php echo($pageDescription) ?></p>

   <div class="box-container">
      <?php
         $select_properties = $db->prepare("SELECT properties.*, image.* 
            FROM properties
            LEFT JOIN image ON properties.PropertyID = image.PropertyID
            WHERE image.ImageID = (
               SELECT MIN(ImageID) 
               FROM image 
               WHERE image.PropertyID = properties.PropertyID
            )
            ORDER BY properties.PropertyID DESC $sqlLimit;");
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
               <p><i class="fas fa-couch"></i>
                                             <span>
                                                <?php
                                                if ($fetch_property['furnished'] == 1) {
                                                      echo "Furnished";
                                                } else {
                                                      echo "Not Furnished";
                                                }
                                                ?>
                                             </span>
                                          </p>
               <p><i class="fas fa-maximize"></i><span><?= $fetch_property['size']; ?>sqft</span></p>
            </div>
            <div class="flex-btn">
               <a href="details.php?get_id=<?= $fetch_property['PropertyID']; ?>" class="btn">View Details</a>
               <a href="make_offer.php?get_id=<?= $fetch_property['PropertyID']; ?>" class="btn">Send Offer</a>
            </div>
         </div>
      </form>
      <?php
         }}
      ?>
      
   </div>

</section>

<!-- all listings section ends -->

<?php include "resources/footer.php" ?>

</body>
</html>