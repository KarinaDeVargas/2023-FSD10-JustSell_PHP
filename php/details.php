<?php
   require "resources/connect.php";
   include "resources/header.php";

   if(isset($_GET['get_id'])){
      $propertyID = $_GET['get_id'];
   }else{
      $propertyID = '';
      header('location:index.php');
   }
   
   if(isset($_COOKIE['user_id'])){
      $user_id = $_COOKIE['user_id'];
   }else{
      $user_id = '';
   }
?>

<body>
   <!-- view property section starts  -->
   <section class="view-property">

      <h1 class="heading">Property Details</h1>

      <?php
         $select_properties = $db->prepare("SELECT * 
                                          FROM properties
                                          WHERE PropertyID = $propertyID;");
         $select_properties->execute();
         if($select_properties->rowCount() > 0){
            while($fetch_property = $select_properties->fetch(PDO::FETCH_ASSOC)){
         ?>

      <div class="details">
      <div class="swiper images-container">
            <div class="swiper-wrapper">
               <?php 
                  $images = $db->prepare("SELECT * 
                                          FROM image
                                          WHERE PropertyID = $propertyID;");
                  $images->execute();
                  if($images->rowCount() > 0){
                     while($image = $images->fetch(PDO::FETCH_ASSOC)){
               ?>
                  <img src="images/PropertiesImages/<?= $image['ImageFileName']; ?>" alt="Missing the property picture" class="swiper-slide">
               <?php
                  }}
               ?>
            </div>
            <div class="swiper-pagination"></div>
      </div>
         <h3 class="name"><?= $fetch_property['PropertyType']; ?></h3>
         <p class="location"><i class="fas fa-map-marker-alt"></i><span><?= $fetch_property['StreetNum'] . '-' . 
                                                                           $fetch_property['StreetName'] . ' - ' . 
                                                                           $fetch_property['City'] . ' - ' . 
                                                                           $fetch_property['Province'] . ' - Postal: ' .
                                                                           $fetch_property['Postal']; ?></span></p>
         <div class="info">
            <p><i class="fas fa-dollar-sign"></i><span><?= number_format($fetch_property['Price'], 2); ?></span></p>
            <p><i class="fas fa-building"></i><span><?= $fetch_property['PropertyType']; ?></span></p>
            <p><i class="fas fa-house"></i><span><?= $fetch_property['sellOption']; ?></span></p>
            <p><i class="fas fa-calendar"></i><span><?= $fetch_property['ConstructionStatus']; ?></span></p>
         </div>
         <h3 class="title">Details</h3>
         <div class="flex">
            <div class="box">
               <p><i>Rooms :</i><span><?= $fetch_property['Bedrooms'] + $fetch_property['Bathrooms']; ?> Bedrooms</span></p>
               <p><i>Deposit Amount (10%) :</i><span><span class="fas fa-dollar-sign" style="margin-right: .5rem;"></span><?= number_format($fetch_property['Price'] / 10, 2); ?></span></p> <!-- Assuming the loan 10% of the price -->
               <p><i>Status :</i><span><?= $fetch_property['ConstructionStatus']; ?></span></p>
               <p><i>Bedroom :</i><span><?= $fetch_property['Bedrooms']; ?></span></p>
               <p><i>Bathroom :</i><span><?= $fetch_property['Bathrooms']; ?></span></p>
            </div>
            <div class="box">
               <p><i>Built in :</i><span><?=$fetch_property['YearOfBuilt']; ?></span></p>
               <p><i>Total Floors :</i><span><?= $fetch_property['Floors']; ?></span></p>
               <p><i>Furnished :</i>
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

               
               <p><i>Loan :</i><span><span class="fas fa-dollar-sign" style="margin-right: .5rem;"></span><?= number_format($fetch_property['Price'] * 0.90, 2); ?></span></p> <!-- Assuming the loan is the amount after the depoisit amount(10%) -->
            </div>
         </div>
         <h3 class="title">Amenities</h3>
         <div class="flex">
            <div class="box">
            <p><i class="fas fa-check"></i><span><?= $fetch_property['Amenities'] ?></span></p>
            </div>
            <div class="box">
               <p><i class="fas fa-check"></i><span>Parking area</span></p>
               <p><i class="fas fa-check"></i><span>Gym</span></p>
               <p><i class="fas fa-check"></i><span>Shopping Mall</span></p>
               <p><i class="fas fa-check"></i><span>Hospital</span></p>
               <p><i class="fas fa-check"></i><span>Schools</span></p>
               <p><i class="fas fa-check"></i><span>Market area</span></p>
            </div>
         </div>
         <h3 class="title">Description</h3>
         <p class="description"><?= $fetch_property['Description']; ?></p>
         <div class="flex-btn">
               <a href="make_offer.php?get_id=<?= $propertyID; ?>" class="btn">Send Offer</a>
         </div>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">property not found! <a href="post_property.php" style="margin-top:1.5rem;" class="btn">add new</a></p>';
      }
      ?>
   </section>
   <!-- view property section ends -->

<script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="js/script.js"></script>

<script>
   var swiper = new Swiper(".images-container", {
      effect: "coverflow",
      grabCursor: true,
      centeredSlides: true,
      slidesPerView: "auto",
      loop:true,
      coverflowEffect: {
         rotate: 0,
         stretch: 0,
         depth: 200,
         modifier: 3,
         slideShadows: true,
      },
      pagination: {
         el: ".swiper-pagination",
      },
   });
</script>

</body>


<?php
   include "resources/footer.php"
?>