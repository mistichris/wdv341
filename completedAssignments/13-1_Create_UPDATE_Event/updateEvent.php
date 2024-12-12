<?php
session_start();
if ($_SESSION['validUser'] !== "valid") {
    header("Location: ../../login.php");     
}
$eventsID = $_GET["eventsID"];      //get the value of the GET parameter into this page

try {
    //#1
    require '../../dbConnect.php';        

    //#2
    $sql = "SELECT * FROM wdv341_events WHERE events_id = :eventsID";
    
    #3 Prepared statement PDO - returns statement object/value, need to catch it in variable '$stmt'
    $stmt = $conn->prepare($sql);

    //#4 - Bind Parameters - N/A
    $stmt ->bindParam(":eventsID", $eventsID);

    //#5 - Execute the PDO Statement/save results in $stmt object
    $stmt->execute(); 

    //#6 - Process the results from the query
    $stmt->setFetchMode(PDO::FETCH_ASSOC);    //tells it that everytime it runs $stmt to return values as an ASSOC array
    //returns name/value pairs and the information stored in the column

    //get the record from the result set/$stmt object
    $eventRow = $stmt->fetch();
    
    $eventName = $eventRow['events_name'];
    // $eventDate = date_format($eventRow['events_date'], "d-m-Y");
    // $eventTime = date_format($eventRow['events_time'], "HH:mm");
} 
catch (PDOException $e) {
    echo "Database Failed: " . $e->getMessage();
}

// // return to selectEvents.php to display the updated list of events
// header("Location: selectEvents.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="../../styles/stylesheet_flex_responsive.css">
    <style>
        
    </style>
</head>

<!--    mac keyboard:  shift + option + f  == format page
            thinkpad keyboard:      shift + alt + f  == format page   
    -->
<body>
    <div class="wrapper">
        <header>
            <h1>WDV341 Intro PHP</h1>
            <h2>Unit- 13: Process Event Update </h2>
        </header>
        <section class="frame">
            
        <form method="post" action="processEventUpdate.php?eventsID=<?php echo $eventsID; ?>">
        <!-- use post until you have to use get
        have to have an action, tells the form where to send info after form submitted -->
        <!--  -->
        <h3>Update Form for Event '<?php echo $eventName?>'</h3>
        <p>
            <label for="events_name">Event Name</label> <!--have to have labels for ada compliance -->
            <input type="text" name="events_name" id="events_name" placeholder="Event Name" value=" <?php echo $eventName; ?>">
            <!-- use the same name as the database columns -->
        </p>

        <p>
            <label for="events_description">Event Description</label>
            <input type="text" name="events_description" id="events_description" placeholder="Event Description" value=" <?php echo $eventRow['events_description']; ?>">
        </p>

        <p>
            <label for="events_presenter">Event Presenter</label>
            <input type="text" name="events_presenter" id="events_presenter" placeholder="Event Presenter" value=" <?php echo $eventRow['events_presenter']; ?>">
        </p>

        <p>
            <label for="events_date">Event Date</label>
            <input type="date" name="events_date" id="events_date" placeholder="MM/DD/YYY" onfocus="(this.type = 'date')" value="<?php echo $eventRow['events_date'];?>">
        </p>

        <!-- Default is 24 hours for time -->
        <p>
            <label for="events_time">Event Start Time</label>
            <input type="time" name="events_time" id="events_time" value="<?php echo $eventRow['events_time'];?>">
        </p>
        <p>
            <input type="hidden" name="events_id" id="events_id" value="<?php echo $eventsID ?>">
        </p>

        <p>
            <input type="submit" name="submit" id="submit" value="Update Event">
            <a href="../selectEvents.php"><button type=button>Cancel</button></a>
        </p>

    </form>

            <?php

            ?>
        </section>
        <div class="footer">
            <a class="" href="../../../homework/">WDV341 Homework Page</a>
            <a href="https://github.com/mistichris/wdv341.git">Git Hub Link</a>
            <a class="" href="../../../../index.html">Christianson Home Page</a>
        </div>

        <p>&nbsp;</p>
    </div>
</body>

</html>