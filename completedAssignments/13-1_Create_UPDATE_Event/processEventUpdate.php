<?php
session_start();
if ($_SESSION['validUser'] !== "valid") {
    header("Location: ../../login.php");     
}

/*
        This page is called by the updateEvent.php page
        Passing form data to this page
        This page will take the form data and UPDATE the record on teh database

        Need SQL UPDATE command

        Consider a confirmation page or this being the confirmation page after the UPDATE has processed

        redirect to display all events again
    


    */
    
//To connect to the database the following steps are required: (algorithm)
//1. Connect to the database
//2. Create your SQL query
//3. Prepare your PDO statement 
//4. Bind Variables to the PDO Statement, if any
//5. Execute the PDO Statement - run your SQL against the database
//6. Process the results from the query --instead of this we are going to process the response back to the client

//do this once for every field in the form; put each variable into PHP variable
$eventsName = $_POST['events_name'];                //get the data from the form into a variable
$eventsDescription = $_POST['events_description'];
$eventsPresenter = $_POST['events_presenter'];
$eventsDate = $_POST['events_date'];
$eventsTime = $_POST['events_time'];         //default is 24 hours for time

//need the events_id from the form  --GET FROM PREVIOUS URL OR HIDDEN FIELD IN FORM??
$eventsID = $_GET["eventsID"];      //get the valye of the GET parameter into this page from the URL

//or

//Will get from the hidden input field
$eventsIDPost = $_POST['events_id'];


//Don't need to update the Date Inserted date
//use variable as the updated date for the database
$update_date = date_format(date_create(), "Y-m-d"); //created a formatted date "YYYY-MM-DD"

try {
    //#1
    require '../../dbConnect.php';        //access to the database; required to continue processing SELECT statements

    
    //#2
    //SQL UPDATE -SET -WHERE
    $sql = "UPDATE wdv341_events 
            SET 
            events_name = :eventsName, 
            events_description = :eventsDescription, 
            events_presenter = :eventsPresenter,
            events_date = :eventsDate, 
            events_time = :eventsTime,
            events_date_updated = :eventsDateUpdated
            WHERE events_id = :eventsID";   //named parameter

    #3 Prepared statement PDO - returns statement object/value, need to catch it in variable '$stmt'
    $stmt = $conn->prepare($sql);       //$conn from dbConnect.php file

    //#4 - Bind Parameters - N/A
    //Uncaught Error: PDOStatement::bindParam(): Argument #2($var) cannot be passed by reference in  . . . means unbound parameters
    $stmt->bindParam(":eventsName", $eventsName);
    $stmt->bindParam(":eventsDescription", $eventsDescription);
    $stmt->bindParam(":eventsPresenter", $eventsPresenter);
    $stmt->bindParam(":eventsDate", $eventsDate);
    $stmt->bindParam(":eventsTime", $eventsTime);
    $stmt->bindParam(":eventsDateUpdated", $update_date);
    $stmt->bindParam(":eventsID", $eventsID);

    //#5 - Execute the PDO Statement/save results in $stmt object
    $stmt->execute();

    //#6 - Process the results from the query
    $stmt->setFetchMode(PDO::FETCH_ASSOC);    

    header("Location: ../selectEvents.php"); 

} catch (PDOException $e) {
    echo "Database Failed: " . $e->getMessage();
}

