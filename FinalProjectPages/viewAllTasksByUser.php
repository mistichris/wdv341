<?php
session_start();
if ($_SESSION['validUser'] !== "valid") {
    //you are NOT a valid user and CANNOT access this page
    header("Location: login.php");      //server side redirect
}


$userID = $_GET["userID"];

try {
    //#1 Connect to the database
    require 'dbConnect.php';

    //#2 Create your SQL query
    $sqlTasksByUser = "SELECT * FROM mm_task
    WHERE task_assignedTo = $userID";

    #3 Prepared statement PDO 
    $stmtTasksByUser = $conn->prepare($sqlTasksByUser);

    //#5 - Execute the PDO Statement/save results in $stmt object
    $stmtTasksByUser->execute();

    //#6 - Process the results from the query
    $stmtTasksByUser->setFetchMode(PDO::FETCH_ASSOC);



    function retrieveUserName($inUserID)
    {
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
} catch (PDOException $e) {
    echo "Database Failed: " . $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>micromanagement view all tasks by user</title>
    <link rel="stylesheet" type="text/css" href="Styles/stylesheet_flex_responsive.css">
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
                <h3>Tasks Assigned to User '<?php echo retrieveUserName($userID) ?>'</h3>
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
                    $taskRow = $stmtTasksByUser->fetch();
                    if ($taskRow == null) {
                    ?>
                </table>
                <p></p>
                <p class="error"> There are no tasks assigned to this user.</p>
                <?php
                    } else {
                        //put the loop that process the database results and outputs the content as HTML table
                        while ($taskRow = $stmtTasksByUser->fetch()) {    //returns items as an associative array since that what we told it to do previously in #6

                            echo "<tr>";
                            echo "<td>" . $taskRow['task_title'] . "</td>";
                            echo "<td>" . $taskRow['task_description'] . "</td>";
                            echo "<td> " . retrieveUserName($taskRow['task_assignedTo']) . "</td>";
                            echo "<td>" . $taskRow['task_dueDate'] . "</td>";
                            echo "<td>" . $taskRow['task_isOpen'] . "</td>";
                            echo "<td><a href='viewTaskDetails.php?taskID=" . $taskRow['task_ID'] . "'><button>View Details</button></td>";
                            echo "</tr>";
                        }
                ?>
                </table>
                <p></p>
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