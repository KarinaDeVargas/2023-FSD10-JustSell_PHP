<?php
require "resources/connect.php"; 

include "resources/header.php";
?>

<!-- contact section starts  -->

<section class="contact">

   <div class="row">

      <div class="image">
         <img src="images/getInTouch_1.png" alt="GetInTouch">
      </div>
      
      <form action="resources/process_contact.php" method="post">
         <h3>get in touch</h3>
         <input type="text" name="name" required maxlength="50" placeholder="enter your name" class="box">
         <input type="email" name="email" required maxlength="50" placeholder="enter your email" class="box">
         <input type="number" name="phone" required maxlength="10" max="9999999999" min="0" placeholder="enter your number" class="box">
         <textarea name="message" placeholder="enter your message" required maxlength="1000" cols="30" rows="10" class="box"></textarea>
         <input type="submit" value="send message" name="contact_submit" class="btn">
      </form>
   </div>

</section>

<!-- contact section ends -->


<div style="padding-bottom: 100px;">

</div>

</body>
</html>

<?php
include "resources/footer.php"
?>

