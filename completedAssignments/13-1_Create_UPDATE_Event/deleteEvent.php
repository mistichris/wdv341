<?php

//protect page from unwanted activity
session_start();
if ($_SESSION['validUser'] !== "valid") {
    header("Location: ../login.php");     
}

$eventsID = $_GET["eventsID"];

try {
    //#1 Connect to the database
    require '../dbConnect.php';        

    //#2 Create your SQL query
    $sql = "DELETE FROM wdv341_events WHERE events_id = :eventsID";
    
    #3 Prepared statement PDO - returns statement object/value, need to catch it in variable '$stmt'
    $stmt = $conn->prepare($sql);      

    //#4 - Bind Variables to the PDO Statement, if any
    $stmt ->bindParam(":eventsID", $eventsID);

    //#5 - Execute the PDO Statement/save results in $stmt object
    $stmt->execute(); 

    //#6 - Process the results from the query
    $stmt->setFetchMode(PDO::FETCH_ASSOC);        

} catch (PDOException $e) {
    echo "Database Failed: " . $e->getMessage();
}

header("Location: selectEvents.php");

?>