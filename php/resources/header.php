<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <link rel="stylesheet" href="resources/style.css" />
      <link rel="stylesheet" href="resources/makeOfferModal.css" />
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.css">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />
      <title>Just Sell</title>

      <!-- Favicons -->
      <link href="images/favicon.png" rel="icon">
  </head>


<!-- header section starts  -->

<header class="header"> 

   <nav class="navbar nav-2">
      <section class="flex">
         <a href="index.php"><img src="resources/logo.png" height="80" width="220" alt="Home"/></a>
      
         <div class="menu">
            <ul>               
               <li><a href="#">Listings<i class="fas fa-angle-down"></i></a>
                  <ul>
                     <li><a href="search.php">More Search</a></li>
                     <li><a href="latest_listings.php">Latest Listings</a></li>
                     <li><a href="all_listings.php">All Listings</a></li>
                  </ul>
               </li>
               <li><a href="#">Help<i class="fas fa-angle-down"></i></a>
                  <ul>
                     <li><a href="about_us.php">About Us</a></i></li>
                     <li><a href="get_in_touch.php">Contact Us</a></i></li>
                     <li><a href="about_us.php">Our Main Location</a></i></li>
                  </ul>
               </li>
            </ul>
         </div>

         <ul> 
            <?php if($IsLogIn && $_SESSION['userlvl'] == 1) : ?>
            <li><a href="user.php">User Settings<i class="far fa-user"></i></a></li>
            <?php elseif ($IsLogIn && $_SESSION['userlvl'] > 1) : ?>
            <li><a href="admin.php">Admin/Agent Panel<i class="far fa-user"></i></a></li>
            <?php endif; ?>
            <li><a href="user.php">My Account<i class="fas fa-angle-down"></i></a>
               <ul>
                  <?php if($IsLogIn) : ?>
                     <li><a href="user.php">User Settings</a></li>
                     <li><a href="resources/logout.php">Logout</a></li>
                  <?php else : ?>
                     <li><a href="login.php">Login Now</a></li>
                     <li><a href="registration.php">Register Now</a></li>
                  <?php endif; ?>
               </ul>
            </li>
         </ul>
      </section>
   </nav>

</header>

<!-- header section ends -->

