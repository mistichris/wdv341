<?php
session_start();
if ($_SESSION['validUser'] !== "valid") {
    //you are NOT a valid user and CANNOT access this page
    header("Location: login.php");      //server side redirect
}


$taskID = $_GET["taskID"];


try {

    function getUserName($inUserID)
    {
        ###retrieve user names
        require 'dbConnect.php';
        //Query database for all possible users
        //#2 Create your SQL query
        $sqlUser = "SELECT * FROM mm_users WHERE user_ID = $inUserID";
        #3 Prepared statement PDO 
        $stmtUser = $conn->prepare($sqlUser);
        //#4 - Bind Parameters - N/A
        //#5 - Execute the PDO Statement/save results in $stmt object
        $stmtUser->execute();
        //#6 - Process the results from the query
        $stmtUser->setFetchMode(PDO::FETCH_ASSOC);
        $userRow = $stmtUser->fetch();
        return $userRow['user_firstName'] . " " . $userRow['user_lastName'];
    }
    //#1 Connect to the database
    require 'dbConnect.php';

    //#2 Create your SQL query
    $sql = "SELECT * FROM mm_task 
    WHERE task_id = $taskID";

    #3 Prepared statement PDO 
    $stmt = $conn->prepare($sql);

    //#5 - Execute the PDO Statement/save results in $stmt object
    $stmt->execute();

    //#6 - Process the results from the query
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $taskRow = $stmt->fetch();
    $taskTitle = $taskRow['task_title'];
    $taskDescription = $taskRow['task_description'];
    $userID = $taskRow['task_assignedTo'];
    $taskManager = getUserName($userID);
    $taskDueDate = $taskRow['task_dueDate'];
    $taskCreatedDate = $taskRow['task_createdDate'];
    $taskStatus = $taskRow['task_isOpen'];

} catch (PDOException $e) {
    echo "Database Failed: " . $e->getMessage();
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>micromanager view task details page</title>
    <link rel="stylesheet" type="text/css" href="Styles/stylesheet_flex_responsive.css">
    <style>

    </style>
    <script>
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
                <h3>Task '<?php $taskTitle?>' Details</h3>
                <table>
                    <tr>
                        <th class="detailheader">Description: </th>
                        <th class="cellLeft"><?php echo $taskDescription ?></th>
                    </tr>
                    <tr>
                        <th class="detailheader">Owner: </th>
                        <th class="cellLeft"><?php echo $taskManager ?></th>
                    </tr>
                    <tr>
                        <th class="detailheader">Due Date: </th>
                        <th class="cellLeft"><?php echo $taskDueDate ?></th>
                    </tr>
                    <tr>
                        <th class="detailheader">Created Date: </th>
                        <th class="cellLeft"><?php echo $taskCreatedDate  ?></th>
                    </tr>
                    <tr>
                        <th class="detailheader">Status: </th>
                        <th class="cellLeft"><?php echo $taskStatus ?></th>
                    </tr>
                </table>

                <p></p>
                <p></p>
                <!-- Need button for updating the task -->
                <a href="updateTaskForm.php?taskID=<?php echo $taskID ?>"><button>Update Task</button></a>
                

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