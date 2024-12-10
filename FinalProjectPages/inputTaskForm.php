<?php
session_start();
if ($_SESSION['validUser'] !== "valid") {
    //you are NOT a valid user and CANNOT access this page
    header("Location: login.php");      //server side redirect
}


//get project_ID from previous page
$projectID = $_GET["projectID"];

try {
    //#1 Connect to the database
    require 'dbConnect.php';

    //Get table name and save to variable
    $retrieveProjectNameStmt = $conn->prepare("SELECT project_title FROM mm_project WHERE project_id = $projectID");
    $retrieveProjectNameStmt->execute();
    $retrieveProjectNameStmt->setFetchMode(PDO::FETCH_ASSOC);
    $projectRow = $retrieveProjectNameStmt->fetch();
    $projectTitle = $projectRow["project_title"];

    //Query database for all possible users
    //#2 Create your SQL query
    $sqlUser = "SELECT * FROM mm_users";

    #3 Prepared statement PDO 
    $stmtUser = $conn->prepare($sqlUser);

    //#4 - Bind Parameters - N/A

    //#5 - Execute the PDO Statement/save results in $stmt object
    $stmtUser->execute();

    //#6 - Process the results from the query
    $stmtUser->setFetchMode(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Database Failed: " . $e->getMessage();
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>micromanager enter new task or update task form</title>
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
            <ul>
                    <p><a class="linkOnDark" href="inputUserForm.php">Add New User</a></p>
                    <p><a class="linkOnDark" href="viewAllUsers.php">View All Users</a></p>
                    <p><a class="linkOnDark" href="inputProjectForm.php">Add New Project</a></p>
                    <p><a class="linkOnDark" href="viewAllProjects.php">View All Projects</a></p>
                </ul>
            </div>
            <div class="article">
                <!-- Insert field into element -->
                <h3>Create a New Task for Project '<?php echo $projectTitle ?>'</h3>
                <!-- populate form with existing Team Member info from database -->
                <form id="form1" name="form1" method="post" action="insertTask.php">
                    <p>
                        <label for="taskTitle">Task Title: </label>
                        <input type="text" name="taskTitle" id="taskTitle" />
                    </p>
                    <p>
                        <label for="taskDescription">Task Description: </label>
                        <input type="text" name="taskDescription" id="taskDescription" required />
                    </p>

                    <p>
                        <label for="taskAssignedTo">Choose a Task Owner: </label>
                        <select name="taskAssignedTo" id="taskAssignedTo">
                            <option value="none" selected disabled>Select an Option</option>
                            <?php
                            while ($userRow = $stmtUser->fetch()) {
                                echo "<option value='" . $userRow['user_ID'] . "'>" . $userRow['user_firstName'] . " " . $userRow['user_lastName'] . "</option>";
                            }
                            ?>
                        </select>
                    </p>

                    <p>
                        <label for="taskDueDate">Next Follow Up Date: </label>
                        <input type="date" name="taskDueDate" id="taskDueDate" placeholder="MM/DD/YYY" onfocus="(this.type = 'date')" required>
                    </p>



                    <label class="ohnohoney" for="name"></label>
                    <input class="ohnohoney" autocomplete="off" type="text" id="name" name="name" placeholder="Your name here">
                    <label class="ohnohoney" for="email"></label>
                    <input class="ohnohoney" autocomplete="off" type="email" id="email" name="email" placeholder="Your e-mail here">

                    <p>
                        <input type="submit" name="button" id="button" value="Create Task" />
                        <a href="viewProjectDetails.php?projectID=<?php echo $projectID ?>"><button type="button">Cancel</button>
                            <!-- <input type="reset" name="button2" id="button2" value="Cancel" /> -->
                    </p>

                </form>

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