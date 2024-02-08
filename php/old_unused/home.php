<?php /*  

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
}

*/?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Home Just Sell</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/styleHome.css">

</head>
<body>
   
<!-- home section starts  -->

<div class="home">

   <section class="center">

      <form action="search.php" method="post">
         <h3>Find Your Perfect Home</h3>
         <div class="box">
            <p>Enter Location <span>*</span></p>
            <input type="text" name="h_location" required maxlength="100" placeholder="enter city name" class="input">
         </div>
         
         <div class="box">             
               <p>property type <span>*</span></p>
               <select name="h_type" class="input" required>
                  <option value="flat">House</option>
                  <option value="house">Apartment</option>
                  <option value="shop">Comercial Building</option>
               </select>
            
            <div class="box">
               <p>Minimum Budget <span>*</span></p>
               <select name="h_min" class="input" required>
                  <option value="5000">5k</option>
                  <option value="10000">10k</option>
                  <option value="15000">15k</option>
                  <option value="20000">20k</option>
                  <option value="30000">30k</option>
                  <option value="40000">40k</option>
                  <option value="40000">40k</option>
                  <option value="50000">50k</option>
                  <option value="100000">1 lac</option>
                  <option value="500000">5 lac</option>
                  <option value="1000000">10 lac</option>
                  <option value="2000000">20 lac</option>
                  <option value="3000000">30 lac</option>
                  <option value="4000000">40 lac</option>
                  <option value="4000000">40 lac</option>
                  <option value="5000000">50 lac</option>
                  <option value="6000000">60 lac</option>
                  <option value="7000000">70 lac</option>
                  <option value="8000000">80 lac</option>
                  <option value="9000000">90 lac</option>
                  <option value="10000000">1 Cr</option>
                  <option value="20000000">2 Cr</option>
                  <option value="30000000">3 Cr</option>
                  <option value="40000000">4 Cr</option>
                  <option value="50000000">5 Cr</option>
                  <option value="60000000">6 Cr</option>
                  <option value="70000000">7 Cr</option>
                  <option value="80000000">8 Cr</option>
                  <option value="90000000">9 Cr</option>
                  <option value="100000000">10 Cr</option>
                  <option value="150000000">15 Cr</option>
                  <option value="200000000">20 Cr</option>
               </select>
            </div>
            <div class="box">
               <p>Maximum Budget <span>*</span></p>
               <select name="h_max" class="input" required>
                  <option value="5000">5k</option>
                  <option value="10000">10k</option>
                  <option value="15000">15k</option>
                  <option value="20000">20k</option>
                  <option value="30000">30k</option>
                  <option value="40000">40k</option>
                  <option value="40000">40k</option>
                  <option value="50000">50k</option>
                  <option value="100000">1 lac</option>
                  <option value="500000">5 lac</option>
                  <option value="1000000">10 lac</option>
                  <option value="2000000">20 lac</option>
                  <option value="3000000">30 lac</option>
                  <option value="4000000">40 lac</option>
                  <option value="4000000">40 lac</option>
                  <option value="5000000">50 lac</option>
                  <option value="6000000">60 lac</option>
                  <option value="7000000">70 lac</option>
                  <option value="8000000">80 lac</option>
                  <option value="9000000">90 lac</option>
                  <option value="10000000">1 Cr</option>
                  <option value="20000000">2 Cr</option>
                  <option value="30000000">3 Cr</option>
                  <option value="40000000">4 Cr</option>
                  <option value="50000000">5 Cr</option>
                  <option value="60000000">6 Cr</option>
                  <option value="70000000">7 Cr</option>
                  <option value="80000000">8 Cr</option>
                  <option value="90000000">9 Cr</option>
                  <option value="100000000">10 Cr</option>
                  <option value="150000000">15 Cr</option>
                  <option value="200000000">20 Cr</option>
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
         <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Doloremque, incidunt.</p>
      </div>

   </div>

</section>

<!-- services section ends -->

<?php
include "download_app.php";
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- custom js file link  -->
<script src="js/script.js"></script>

<?php //include 'components/message.php'; ?>

<script>

   let range = document.querySelector("#range");
   range.oninput = () =>{
      document.querySelector('#output').innerHTML = range.value;
   }

</script>

</body>
</html>



