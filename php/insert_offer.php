<?php
    require "resources/connect.php";

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Retrieve data from the AJAX request
        $propertyID = $_POST["propertyID"];
        $offerAmount = floatval($_POST["offerAmount"]);

        error_log("checking value of propertyID: " . $propertyID, 3, "logs/checking.log");
        error_log("checking value of offerAmount: " . $offerAmount, 3, "logs/checking.log");


        // Insert the data into the propertyoffers table
        $sqlInsertOffer = $db->prepare("INSERT INTO propertyoffers (UserID, PropertyID, OfferAmount, OfferStatus) VALUES (1, :propertyID, :offerAmount, 'Pending')");
        // Example from our DB => INSERT INTO `propertyoffers`(`UserID`, `PropertyID`, `OfferAmount`, `OfferStatus`) VALUES (7,1,111111,'Pending');

        $sqlInsertOffer->bindParam(':propertyID', $propertyID, PDO::PARAM_INT);
        $sqlInsertOffer->bindParam(':offerAmount', $offerAmount, PDO::PARAM_STR);

        if ($sqlInsertOffer->execute()) {
            // Offer insertion was successful
            echo "Offer submitted successfully.";
        } else {
            $errorInfo = $sqlInsertOffer->errorInfo();
            echo 'Error: ' . $errorInfo[2];
        }
    }
?>