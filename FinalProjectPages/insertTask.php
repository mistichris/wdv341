<?php
session_start();
if ($_SESSION['validUser'] !== "valid") {
    header("Location: login.php");      //server side redirect
}

$errMessage = null;
$projectID = $_GET['projectID'];

//do this once for every field in the form; put each variable into PHP variable
$taskTitle = $_POST['taskTitle'];
$taskDescription = $_POST['taskDescription'];
$taskAssignedTo = $_POST['taskAssignedTo'];
$taskDueDate = $_POST['taskDueDate'];

$today = date_format(date_create(), "Y-m-d");
$taskIsOpen = "1";

$taskDateCreated = $today;   //use PHP functions for creating a date
//needs to be formatted YYY-MM-DD

try {
    //Connect to the Database: 6 steps
    //#1Connect to the database
    require 'dbConnect.php';

    //#2Create your SQL query
    $sql = "INSERT INTO mm_task(
            task_title, 
            task_description, 
            task_assignedTo,
            task_dueDate,
            task_createdDate,
            task_isOpen,
            task_project
            )";


    $sql .= "VALUES (
            :taskTitle,
            :taskDescription,
            :taskAssignedTo,
            :taskDueDate,
            :taskDateCreated,
            :taskIsOpen,
            :taskProject
            )";

    #3 Prepared statement PDO - returns statement object/value, need to catch it in variable '$stmt'
    $stmt = $conn->prepare($sql);

    //#4 - Bind Parameters - N/A
    $stmt->bindParam(":taskTitle", $taskTitle);
    $stmt->bindParam(":taskDescription", $taskDescription);
    $stmt->bindParam(":taskAssignedTo", $taskAssignedTo);
    $stmt->bindParam(":taskDueDate", $taskDueDate);
    $stmt->bindParam(":taskDateCreated", $taskDateCreated);
    $stmt->bindParam(":taskIsOpen", $taskIsOpen);
    $stmt->bindParam(":taskProject", $projectID);

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
    <title>micromanager insert new or update user form page</title>
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
                <?php
                if ($errMessage !== null) {
                    echo "<h2>" . $errMessage . "</h2>";
                } else {
                ?>
                    <!-- Insert field into element -->
                    <h3>Task '<?php echo $taskTitle ?>' has been created.</h3>

                    <p>
                        <a href="viewProjectDetails.php?projectID=<?php echo $projectID ?>"><button>Return to Project Details</button>
                            <a href="inputTaskForm.php?projectID=<?php echo $projectID ?>"><button>Add Another Task</button></a>
                    </p>
            </div>
        <?php
                }
        ?>
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