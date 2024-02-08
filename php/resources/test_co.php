<?php
// This is your test_connection.php file

try {
    $type = "mysql";
    $host = "localhost";
    $dbName = "fsd10_uniform";
    $port = "3306";
    $charset = "utf8";
    $dbUsername = "fsduser";
    $dbPassword = "myDBpw";

    $DSN = "{$type}:host={$host};dbname={$dbName};port={$port};charset={$charset}";

    // Open a new database connection
    $db = new PDO($DSN, $dbUsername, $dbPassword);
    
    // Set PDO to throw exceptions on errors
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Connection successful
    echo "Database connection successful!";
} catch (PDOException $e) {
    // Connection failed, handle the error
    echo "Database connection failed: " . $e->getMessage();
}
?>
