<?php
session_start();
if ($_SESSION['validUser'] !== "valid") {
    //you are NOT a valid user and CANNOT access this page
    header("Location: login.php");      //server side redirect
}

$eventsID = $_GET["eventsID"];      //get the valye of the GET parameter into this page


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
$eventsDate = $_POST['events_date'];
$eventsTime = $_POST['events_time'];         //default is 24 hours for time


// echo $eventsName;
// echo $eventsDescription;
echo $eventsDate;
echo $eventsTime;
echo "<br/>";

$today = date_format(date_create(), "Y-m-d");
echo $today;

$eventsDateInserted = "";   //use PHP functions for creating a date
//needs to be formatted YYY-MM-DD


try {
    //#1
    require 'dbConnect.php';        //access to the database; required to continue processing SELECT statements

    //#2
    $sql = "INSERT INTO wdv341_events (
            events_name, 
            events_description, 
            events_date, 
            events_time,
            events_date_inserted
            )";


    $sql .= "VALUES (
            :eventsName, 
            :eventsDescription, 
            :eventsDate, 
            :eventsTime,
            :eventsDateInserted
            )";                 //named parameter

    #3 Prepared statement PDO - returns statement object/value, need to catch it in variable '$stmt'
    $stmt = $conn->prepare($sql);       //$conn from dbConnect.php file

    //#4 - Bind Parameters - N/A
    //Uncaught Error: PDOStatement::bindParam(): Argument #2($var) cannot be passed by reference in  . . . means unbound parameters
    $stmt->bindParam(":eventsName", $eventsName);
    $stmt->bindParam(":eventsDescription", $eventsDescription);
    $stmt->bindParam(":eventsDate", $eventsDate);
    $stmt->bindParam(":eventsTime", $eventsTime);
    $stmt->bindParam(":eventsDateInserted", $today);

    //#5 - Execute the PDO Statement/save results in $stmt object
    $stmt->execute();

    //#6 - Process the results from the query
    $stmt->setFetchMode(PDO::FETCH_ASSOC);    //tells it that everytime it runs $stmt to return values as an ASSOC array
    //returns name/value pairs and the information stored in the column
    //this does it once so we don't have to do it everytime


    // $eventRecord = $stmt->fetch();  //return the first row of the result as an ASSOC array
    // echo "<p>" . $eventRecord["events_name"] . "</p>";
    // echo "<p>" . $eventRecord["events_description"] . "</p>";
} catch (PDOException $e) {
    echo "Database Failed: " . $e->getMessage();
}

//return to selectEvents.php to display the updated list of events
header("Location: selectEvents.php");


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>micromanager view user detail page</title>
    <link rel="stylesheet" type="text/css" href="Styles/stylesheet_flex_responsive.css">
    <style>

    </style>
    <script>
        function confirmDelete(inEventsID) {
            //alert("inside confirmDelete() need to know the events_id: " + inEventsID);
            //display a model asking Delete this Record Y or N
            let confirmCode = confirm("To 'DELETE' this event, click 'OK'. If you delete this event you cannot recovder it.");

            //if the response is Y send the events_ID to the deleteEvent.php page to be deleted
            //if N nothing
            if (confirmCode) {
                //Ture - Delete Record
                //alert("Delete Record");
                //?
                window.location.href = "deleteEvent.php?eventsID=" + inEventsID;
            } else {
                //False - Do NOT delete record
                //alert("save Record");
            }
        }
    </script>
</head>

<!--    mac keyboard:  shift + option + f  == format page
            thinkpad keyboard:      shift + alt + f  == format page   
    -->

<body>
    <div class="wrapper">
        <header>
        </header>
        <nav class="footer">
            <a class="linkOnDark" href="finalIndex.php">microMANAGEMENT Home</a>
            <a class="linkOnDark" href="about.php">About microMANAGER</a>
            <a class="linkOnDark" href="contact.php">Contact US</a>
            <?php
            if ($_SESSION['validUser'] === "valid") {
                echo "<a class='linkOnDark' href='logout.php'>Logout</a>";
            } else {
                echo "<a class='linkOnDark' href='login.php'>Login</a>";
            }
            ?>
        </nav>
        <section class="frame">
            <!-- Make side navigation panel -->
            <div class="sidenav">
                <ul>
                    <p><a class="linkOnDark" href="inputUserForm.php">Add New User</a></p>
                    <p><a class="linkOnDark" href="viewAllUsers.php">View All Users</a></p>
                    <p><a class="linkOnDark" href="inputProjectForm.php">Add New Project</a></p>
                    <p><a class="linkOnDark" href="viewAllProjects.php">View All Projects</a></p>
                </ul>
            </div>
            <div class="article">
                <!-- Enter task name into title -->
                <h3>Member {Enter Name} Details</h3>
                <table>
                    <tr>
                        <th></th>
                        <th></th>
                    </tr>

                </table>


        </section>
        <div class="footer">
            <a class="" href="../wdv341Homework.php">WDV341 Homework Page</a>
            <a href="https://github.com/mistichris/wdv341.git">Git Hub Link</a>
            <a class="" href="../../../index.html">Christianson Home Page</a>
        </div>

        <p>&nbsp;</p>
    </div>
</body>

</html>