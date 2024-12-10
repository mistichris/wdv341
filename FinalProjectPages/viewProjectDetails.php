<?php
session_start();
if ($_SESSION['validUser'] !== "valid") {
    //you are NOT a valid user and CANNOT access this page
    header("Location: login.php");      //server side redirect
}


$projectID = $_GET["projectID"];

try {
    //#1 Connect to the database
    require 'dbConnect.php';

    //#2 Create your SQL query
    $sql = "SELECT * FROM mm_project 
    JOIN mm_users ON mm_project.project_manager = mm_users.user_ID
    WHERE project_id = $projectID";

    #3 Prepared statement PDO 
    $stmt = $conn->prepare($sql);

    //#5 - Execute the PDO Statement/save results in $stmt object
    $stmt->execute();

    //#6 - Process the results from the query
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $projectRow = $stmt->fetch();
    $projectTitle = $projectRow['project_title'];
    $projectDescription = $projectRow['project_description'];
    $projectManager = $projectRow['user_firstName'] . " " . $projectRow['user_lastName'];
    $projectDueDate = $projectRow['project_dueDate'];
    $projectCreatedDate = $projectRow['project_createdDate'];
    $projectNextTaskDue = $projectRow['project_nextTaskDue'];
    $projectStatus = $projectRow['project_isOpen'];



    //#2 Create your SQL query
    $sql2 = "SELECT * FROM mm_task 
    JOIN mm_project ON mm_task.task_project = mm_project.project_id
    WHERE mm_task.task_project = $projectID";


    #3 Prepared statement PDO 
    $stmt2 = $conn->prepare($sql2);

    //#5 - Execute the PDO Statement/save results in $stmt object
    $stmt2->execute();

    //#6 - Process the results from the query
    $stmt2->setFetchMode(PDO::FETCH_ASSOC);

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
    <title>micromanager view project details</title>
    <link rel="stylesheet" type="text/css" href="Styles/stylesheet_flex_responsive.css">
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

        function retrieveUserName(inUserID) {

            <?php $userID ?> = inUserID;
            <?php
            try {
                //#1 Connect to the database
                require 'dbConnect.php';
                //Query to pull in user first and last name
                //#2 Create your SQL query
                $sql3 = "SELECT user_firstName, user_lastName FROM mm_user
                    WHERE mm_task.task_user = $userID";


                #3 Prepared statement PDO 
                $stmt3 = $conn->prepare($sql3);

                //#5 - Execute the PDO Statement/save results in $stmt object
                $stmt3->execute();

                //#6 - Process the results from the query
                $stmt3->setFetchMode(PDO::FETCH_ASSOC);
                $userRow = $stmt2->fetch();

                $userName = $userRow['user_firstName'] . " " . $userRow['user_lastName'];
            } catch (PDOException $e) {
                echo "Database Failed: " . $e->getMessage();
            }
            ?>

            return <?php echo $userName ?>;
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
                <!-- Enter project name into title -->
                <h2>Project <?php echo $projectTitle ?> Details</h2>

                <table>
                    <tr>
                        <th class="detailheader">Description: </th>
                        <th class="cellLeft"><?php echo $projectDescription ?></th>
                    </tr>
                    <tr>
                        <th class="detailheader">Owner: </th>
                        <th class="cellLeft"><?php echo $projectManager ?></th>
                    </tr>
                    <tr>
                        <th class="detailheader">Due Date: </th>
                        <th class="cellLeft"><?php echo $projectDueDate ?></th>
                    </tr>
                    <tr>
                        <th class="detailheader">Created Date: </th>
                        <th class="cellLeft"><?php echo $projectCreatedDate  ?></th>
                    </tr>
                    <tr>
                        <th class="detailheader">Next Task Follow-Up: </th>
                        <th class="cellLeft"><?php echo $projectNextTaskDue ?></th>
                    </tr>
                    <tr>
                        <th class="detailheader">Status: </th>
                        <th class="cellLeft"><?php echo $projectStatus ?></th>
                    </tr>

                </table>

                <p></p>
                <h3>Project Tasks</h3>
                <!-- Make each table row clickable to go to project details; on action -->
                <table>
                    <tr class="tableheader">
                        <td>Task Title</td>
                        <td>Description</td>
                        <td>Assigned Owner</td>
                        <td>Due Date</td>
                        <td>Status</td>
                    </tr>

                    <?php
                    //put the loop that process the database results and outputs the content as HTML table
                    while ($taskRow = $stmt2->fetch()) {    //returns items as an associative array since that what we told it to do previously in #6
                        echo "<tr>";
                        echo "<td>" . $taskRow['task_title'] . "</td>";
                        echo "<td>" . $taskRow['task_description'] . "</td>";
                        echo "<td>" ?> <script>
                            retrieveUserName(<?php echo $taskRow['task_user'] ?>)
                        </script><?php "</td>";
                                    echo "<td>" . $taskRow['project_dueDate'] . "</td>";
                                    echo "<td>" . $taskRow['project_nextTaskDue'] . "</td>";
                                    echo "<td>" . $taskRow['project_isOpen'] . "</td>";
                                    echo "<td><a href='viewTaskDetails.php?taskID=" . $taskRow['task_ID'] . "'><button>View Details</button></td>";
                                    echo "</tr>";
                                    //echo out a button for each row in loop

                                }

                                    ?>
                </table>
                <p></p>
                <!-- Need button for updating the project -->
                <a href="updateProjectForm.php?projectID=<?php echo $projectID ?>"><button>Update Project</button></a>
                <!-- button for adding tasks to the project -->
                <a href="inputTaskForm.php?projectID=<?php echo $projectID ?>"><button>Add Task</button></a>
                <!-- button for adding tasks to the project -->
                <a href="viewAllProjects.php"><button type="button">Return to All Projects</button></a>

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