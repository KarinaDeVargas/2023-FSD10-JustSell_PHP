<?php
   require "resources/connect.php";   
   include "resources/header.php";
   
   //verify if the user is logged in to send the offer
   $IsLogIn = $_SESSION['login'] ?? false;

   if (isset($_GET['get_id'])) {
      $propertyID = $_GET['get_id'];
   } else {
      $propertyID = 0;
   }  
?>


<style>
  #confirmation {
    display: none;
  }
</style>

<!-- send offer section starts  -->
<div class="home">
   <section class="center">
      <form action="" method="POST">
         
         <div class="box">
            <h3>Send Offer</h3>
            <?php
               $sql_selected_property = $db->prepare("SELECT * FROM `properties` WHERE PropertyID = $propertyID");
               if ($sql_selected_property->execute()) {
                  $selected_property = $sql_selected_property->fetch(PDO::FETCH_ASSOC);
               } else {
                  $errorInfo = $sql_selected_property->errorInfo();
                  echo 'Error: ' . $errorInfo[2];
               }
            ?>
         </div>

         <div class="box">
            <p name="lblPropertyid">Property ID:  <?= $selected_property['PropertyID'] ?></p>
         </div>

         <div class="box">
            <p name="lblAskingprice"><br>Asking Price:  $<?= number_format($selected_property['Price'], 2, '.', ',') ?></p>
         </div>

         <div class="box">
            <p style="font-weight: bold;"><br>Your offer:</p>
            <input type="text" name="txtOffer" required placeholder="0.00" class="input">
         </div>        

         <input type="submit" value="Submit offer" name="btnSubmitoffer" class="btn" id="submitOfferButton">
      </form>
   </section>
</div>


<!-- Modal HTML structure -->
<div id="confirmationModal" class="modal">
  <div class="modal-content">
    <p name="lblmessage1" style="font-weight: bold; font-size: 25px; padding-top:20px;"></p>
    <p name="lblmessage2" style="font-weight: bold; font-size: 25px; padding: 25px 0 45px 0;">Would you like to continue?</p>
    <button id="yesButton" class="btn" style="width: 150px; display: inline-block;">Yes</button>
    <button id="noButton" class="btn" style="width: 150px; display: inline-block;">No</button>
  </div>
</div>

</body>
</html>


<!-- JavaScript to handle the form submission and display the confirmation section -->
<script>
  document.addEventListener("DOMContentLoaded", function () {
    var confirmationModal = document.getElementById("confirmationModal");
    
    // When the "Submit Offer" button is clicked
    document.querySelector("#submitOfferButton").addEventListener("click", function (e) {
      e.preventDefault();
      
      // Display the modal
      confirmationModal.style.display = 'flex'; // Show the modal using 'flex' display

      // Set the message and button actions
      var selectedPropertyPrice = <?= $selected_property['Price'] ?>; // Set the selected property price
         var txtOfferValue = parseFloat(document.querySelector("input[name='txtOffer']").value);

         if (!isNaN(txtOfferValue)) {
            var difference = txtOfferValue - selectedPropertyPrice;
            if (difference < 0) {
               document.querySelector("p[name='lblmessage1']").textContent = "Your offer is $" + Math.abs(difference).toFixed(2) + " below the asking price.";
            } else if (difference > 0) {
               document.querySelector("p[name='lblmessage1']").textContent = "Your offer is $" + difference.toFixed(2) + " above the asking price.";
            } else {
               document.querySelector("p[name='lblmessage1']").textContent = "Your offer matches the asking price.";
            }
         } else {
            document.querySelector("p[name='lblmessage1']").textContent = "Please enter a valid numeric offer.";
            document.querySelector("p[name='lblmessage2']").textContent = "";
         }
    });

    // When the "Yes" button in the modal is clicked
    document.getElementById("yesButton").addEventListener("click", function () {
      // Send an AJAX request to insert the data into the database
      var propertyID = <?= $propertyID ?>;
      var txtOfferValue = parseFloat(document.querySelector("input[name='txtOffer']").value);

      if (!isNaN(txtOfferValue)) {
        // Make an AJAX request
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "insert_offer.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
          if (xhr.readyState == 4) {
            if (xhr.status == 200) {
              error_log("Offer submitted successfully.", 3, "logs/make_offer.log");
            } else {
               error_log("Failed to submit the offer. Please try again.", 3, "logs/make_offer.log");
              alert("An error occurred.");
            }
          }
        };
        xhr.send("propertyID=" + propertyID + "&offerAmount=" + txtOfferValue);
      }
      // Hide the modal
      confirmationModal.style.display = 'none';

      // Redirect to index.php
      window.location.href = "index.php";
    });

    document.getElementById("noButton").addEventListener("click", function () {      
      // Hide the modal
      confirmationModal.style.display = 'none';
    });
  });
</script>


<?php include "resources/footer.php" ?>
