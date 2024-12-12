<?php
session_start();
if ($_SESSION['validUser'] !== "valid") {
    header("Location: ../../login.php");     
}

try {
    //#1 Connect to the database
    require '../../dbConnect.php';

    //do this once for every field in the form; put each variable into PHP variable
    $eventsName = $_POST['events_name'];                //get the data from the form into a variable
    $eventsDescription = $_POST['events_description'];
    $eventsPresenter = $_POST['events_presenter'];
    $eventsDate = $_POST['events_date'];
    $eventsTime = $_POST['events_time'];      //default is 24 hours for time
    $honeypotname = $_POST['name'];
    $honeypotemail = $_POST['email'];

    $err_message = "";

    $today = date_format(date_create(), "d-m-y");

    $eventsDateInserted = ""; //needs to be formatted YYY-MM-DD
 
    if (($honeypotemail !== "") or ($honeypotname !== "")) {
        $err_message = "Error encountered while processing form, please try again.";
    } else {

        //#2 Create your SQL query
        $sql = "INSERT INTO wdv341_events (
            events_name, 
            events_description, 
            events_presenter,
            events_date, 
            events_time,
            events_date_inserted,
            events_date_updated
            )";


        $sql .= "VALUES (
            :eventsName, 
            :eventsDescription,
            :eventsPresenter,
            :eventsDate, 
            :eventsTime,
            :eventsDateInserted,
            :eventsDateUpdated
            )";                 //named parameter

        #3 Prepared statement PDO - returns statement object/value, need to catch it in variable '$stmt'
        $stmt = $conn->prepare($sql);

        //#4 - Bind Parameters
        $stmt->bindParam(":eventsName", $eventsName);
        $stmt->bindParam(":eventsDescription", $eventsDescription);
        $stmt->bindParam(":eventsPresenter", $eventsPresenter);
        $stmt->bindParam(":eventsDate", $eventsDate);
        $stmt->bindParam(":eventsTime", $eventsTime);
        $stmt->bindParam(":eventsDateInserted", $today);
        $stmt->bindParam(":eventsDateUpdated", $today);

        //#5 - Execute the PDO Statement/save results in $stmt object
        $stmt->execute();

        //#6 - Process the results from the query
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
    }
} catch (PDOException $e) {
    echo "Database Failed: " . $e->getMessage();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="../../styles/stylesheet_flex_responsive.css">
    <style>
        .errorMsgFormat {
            color: red;
            font-style: italic;
        }
    </style>
</head>

<!--    mac keyboard:  shift + option + f  == format page
        thinkpad keyboard:      shift + alt + f  == format page   
-->

<div class="wrapper">
    <header>
        <h1>WDV341 Intro PHP</h1>
        <h2>9-1: Events Input Form // INSERT into Database</h2>
    </header>
    <nav class="spaced">
        <li><a href="eventInputForm.php">Add New Event</a></li>
        <li><a href="../selectEvents.php">Display Events</a></li>
        <li><a href="../../logout.php">Logout</a></li>
    </nav>
    <section class="frame">
        <?php
        if ($err_message !== "") {
            echo "<p class = errorMsgFormat>" . $err_message . "</p>";
        } else {
        ?>
            <h3>Your form to add event '<?php echo $eventsName ?>' has been successfully submitted!</h3>

        <?php
        }
        ?>
    </section>
    <div class="footer">
    <a class="" href="../../../wdv341Homework.php">WDV341 Homework Page</a>
        <a href="https://github.com/mistichris/wdv341.git">Git Hub Link</a>
        <a class="" href="../../../../index.html">Christianson Home Page</a>
    </div>

    <p>&nbsp;</p>
</div>
</body>

</html>