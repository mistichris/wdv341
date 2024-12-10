<?php
session_start();
if ($_SESSION['validUser'] !== "valid") {
    header("Location: login.php");      //server side redirect
}

$userID = $_GET["userID"];      //get the valye of the GET parameter into this page
$firstName = $_GET["firstName"];
$lastName = $_GET["lastName"];

//do this once for every field in the form; put each variable into PHP variable
// $firstName = $_POST['firstName'];
// $lastName = $_POST['lastName'];
// $isManager = $_POST['isManager'];
// $userLogin = $_POST['userLogin'];
// $userPassword = $_POST['userPassword'];

// $today = date_format(date_create(), "Y-m-d");

// $eventsDateInserted = "";   //use PHP functions for creating a date
// //needs to be formatted YYY-MM-DD

try {
    //Connect to the Database: 6 steps
    //#1Connect to the database
    require 'dbConnect.php';

    //#2Create your SQL query
    
    $sql = "DELETE FROM mm_users WHERE user_ID = :eventsID";
    
    #3 Prepared statement PDO - returns statement object/value, need to catch it in variable '$stmt'
    $stmt = $conn->prepare($sql);

    //#4 - Bind Parameters - N/A
    // $stmt->bindParam(":firstName", $firstName);
    // $stmt->bindParam(":lastName", $lastName);
    // $stmt->bindParam(":isManager", $isManager);
    // $stmt->bindParam(":userLogin", $userLogin);
    // $stmt->bindParam(":userPassword", $userPassword);

    //#5 - Execute the PDO Statement/save results in $stmt object
    $stmt->execute();

    //#6 - Process the results from the query
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Database Failed: " . $e->getMessage();
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>micromanager delete user page</title>
    <link rel="stylesheet" type="text/css" href="Styles/stylesheet_flex_responsive.css">
    <style>
        .ohnohoney {
            opacity: 0;
            position: absolute;
            top: 0;
            left: 0;
            height: 0;
            width: 0;
            z-index: -1;
        }
    </style>
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
            <li><a class="linkOnDark" href="inputUserForm.php">Add New User</a></li>
            <li><a class="linkOnDark" href="viewAllUsers.php">View All Users</a></li>
            <li><a class="linkOnDark" href="inputProjectForm.php">Add New Project</a></li>
            <li><a class="linkOnDark" href="viewAllProjects.php">View All Projects</a></li>
        </div>
        <div class="article">
        <!-- Insert field into element -->
        <h3>User <?php echo $firstName . " " . $lastName ?> has been deleted.</h3>
        </div>
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