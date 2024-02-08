<?php
require "resources/connect.php";
include "resources/header.php";
?>

<!-- home section starts  -->

<div class="home">

   <section class="center">

      <form action="search.php" method="post">
         <h3>Find Your Perfect Home</h3>
         <div class="box">
            <p>Enter Location <span>*</span></p>
            <input type="text" name="Location" required maxlength="100" placeholder="enter city name" class="input">
         </div>
         
         <div class="box">             
               <p>Property Type <span>*</span></p>
               <select name="PropertyType" class="input" required>
                  <option value="flat">House</option>
                  <option value="house">Apartment</option>
                  <option value="shop">Comercial Building</option>
               </select>
            
            <div class="box">
               <p>Minimum Budget <span>*</span></p>
               <select name="min" class="input" required>
                  <option value="50000">50k</option>
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
               <p>Maximum Budget <span>*</span></p>
               <select name="max" class="input" required>
               <option value="50000">50k</option>
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
         </div>
         <input type="submit" value="Search Property" name="h_search" class="btn">
      </form>

   </section>

</div>

<!-- home section ends -->

<!-- services section starts  -->

<section class="services">

   <h1 class="heading">Our Services</h1>

   <div class="box-container">

      <div class="box">
         <img src="images/buyHouse.png" alt="Buy House">
         <h3>Buy House</h3>
         <p>A luxury consumer marketplace connecting discerning buyers with the world's finest homes and the agents representing them.</p>
      </div>

      <div class="box">
         <img src="images/buyApartment.png" alt="Buy Apartment">
         <h3>Buy Apartment</h3>
         <p>Are you looking for an apartment to buy? <Br> We have a fine selected list of current properties, check our portfolio.</p>
      </div>

      <div class="box">
         <img src="images/buyComercial.png" alt="Buy Comercial">
         <h3>Buy Comercial Building</h3>
         <p>We help companies purchase their real estate. Whatever your company is looking to accomplish with real estate, we can help.</p>
      </div>

      <div class="box">
         <img src="images/consultSpecialist.jpg" alt="Consult Specialist">
         <h3>Consult Specialist</h3>
         <p>Need the best realtor to help you buy a property? We are here to help. Contact one of our specilized agents. </p>
      </div>

      <div class="box">
         <img src="images/sellYourProperty.png" alt="Sell Your Property">
         <h3>Sell Your Property</h3>
         <p>Just Sell understands that every property is unique and we are happy to discuss the best strategy for a sucessful sale.</p>
      </div>

      <div class="box">
         <img src="images/247Service.png" alt="24/7 Service">
         <h3>24/7 Service</h3>
         <p>We offer dependable, on-demand support, 24/7 technical and remote support in over 100 countries worldwide.</p>
      </div>

   </div>

</section>

<!-- services section ends -->


<!-- download app starts -->

<div class="download-app-image">
    <img src="images/download_app02.jpg" alt="Download the App" class="responsive-image">
</div>

<!-- download app ends -->


</body>
</html>


<?php
include "resources/footer.php"
?>