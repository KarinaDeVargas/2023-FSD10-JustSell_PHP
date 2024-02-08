<?php

//setup Logs TBD ?monolog?

session_start();

$IsLogIn = $_SESSION['login'] ?? false;

//require functions TBD

//variables
$type = "mysql";
$host = "localhost";
$dbName = "fsd10_uniform";
$port ="3306"; //Benjamins port: 8889 //Karinas port: 3306
$charset = "utf8";
$dbUsername = "fsduser";
$dbPassword = "myDBpw";

//connection string (data source name)
$DSN = "{$type}:host={$host};dbname={$dbName};port={$port};charset={$charset}";

//open new database connection
$db = new PDO($DSN, $dbUsername, $dbPassword);

require "resources/functions.php";

?>