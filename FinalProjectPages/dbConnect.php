<?php   

$servername = 'localhost';      
$database = "micromanager";           //the name of the database you wish to access
$username = "root";              //username to sign into your MySQL database on your localhost
$password ="";      

$errMessage = null;
// $servername = getenv("MYSQL_HOST");
// $database = "micromanager";         
// $username = getenv("MYSQL_USER");             
// $password = getenv("MYSQL_PASSWORD");                 
try {
    
    $conn = new PDO("mysql:host=$servername; dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   
    // echo "Connected successfully";
}
catch(PDOException $e){
    echo "Connection Failed: " . $e->getMessage(); 
    $errMessage = "Unable to connect to the database. Try again later.";
}

catch(Exception $e){
    $errMessage = "Unable to connect to the database. Try again later.";
}

?>