<?php
// query parameters - boolean is true
$is_latest_listings_only = true;

// Perform the redirection to all_listings.php with the query parameter to indicate it is just the latest_listings.
header("Location: all_listings.php?is_latest_listings_only=$is_latest_listings_only");

// Ensure that no further code is executed after the header redirect
exit; 
?>