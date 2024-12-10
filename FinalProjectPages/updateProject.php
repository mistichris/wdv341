<?php
session_start();
if ($_SESSION['validUser'] !== "valid") {
    //you are NOT a valid user and CANNOT access this page
    header("Location: login.php");      //server side redirect
}

$errMessage = null;


//get project_ID from previous page
$projectID = $_GET["projectID"];

// project_id	project_title	project_description	project_manager	project_dueDate	project_createdDate	project_nextTaskDue	project_isOpen	
//do this once for every field in the form; put each variable into PHP variable
$projectTitle = $_POST['projectTitle'];
$projectDescription = $_POST['projectDescription'];
$projectManager = $_POST['projectManager'];
$projectDueDate = $_POST['projectDueDate'];

$today = date_format(date_create(), "Y-m-d");
$projectIsOpen = "1";

$projectDateCreated = $today;   //use PHP functions for creating a date
//needs to be formatted YYY-MM-DD

try {
    //Connect to the Database: 6 steps
    //#1Connect to the database
    require 'dbConnect.php';

    //#2Create your SQL query
    $sql = "UPDATE mm_project
            SET 
            project_title = :projectTitle,
            project_description = :projectDescription,
            project_manager = :projectManager,
            project_dueDate = :projectDueDate
            WHERE project_id = $projectID";

    #3 Prepared statement PDO - returns statement object/value, need to catch it in variable '$stmt'
    $stmt = $conn->prepare($sql);

    //#4 - Bind Parameters - N/A
    $stmt->bindParam(":projectTitle", $projectTitle);
    $stmt->bindParam(":projectDescription", $projectDescription);
    $stmt->bindParam(":projectManager", $projectManager);
    $stmt->bindParam(":projectDueDate", $projectDueDate);


    //#5 - Execute the PDO Statement/save results in $stmt object
    $stmt->execute();

    //#6 - Process the results from the query
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Database Failed: " . $e->getMessage();
    $errMessage = "Unable to connect to the database. Try again later.";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>micromanager process upate project form</title>
    <link rel="stylesheet" type="text/css" href="Styles/stylesheet_flex_responsive.css">
    <style>
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
                <ul>
                    <p><a class="linkOnDark" href="inputUserForm.php">Add New User</a></p>
                    <p><a class="linkOnDark" href="viewAllUsers.php">View All Users</a></p>
                    <p><a class="linkOnDark" href="inputProjectForm.php">Add New Project</a></p>
                    <p><a class="linkOnDark" href="viewAllProjects.php">View All Projects</a></p>
                </ul>
            </div>
            <div class="article">
                <!-- Insert field into element -->
                <h3>Insert Updated Information for Project '<?php echo $projectTitle ?>'</h3>
                <?php
                if ($errMessage !== null) {
                    echo "<h2>" . $errMessage . "</h2>";
                } else {
                ?>

                <?php
                }
                ?>
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