<?php
session_start();
if ($_SESSION['validUser'] !== "valid") {
    //you are NOT a valid user and CANNOT access this page
    header("Location: login.php");      //server side redirect
}

try {
    //#1
    require 'dbConnect.php';        //access to the database; required to continue processing SELECT statements

    //#2            //named parameter
    $sql = "SELECT * FROM mm_project JOIN mm_users ON mm_project.project_manager = mm_users.user_ID";


    #3 Prepared statement PDO - returns statement object/value, need to catch it in variable '$stmt'
    $stmt = $conn->prepare($sql);        //$conn from dbConnect.php file

    //#5 - Execute the PDO Statement/save results in $stmt object
    $stmt->execute();

    //#6 - Process the results from the query
    $stmt->setFetchMode(PDO::FETCH_ASSOC);    //tells it that everytime it runs $stmt to return values as an ASSOC array

} catch (PDOException $e) {
    echo "Database Failed: " . $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>micromanager view all projects page</title>
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
                </ul>
            </div>
            <div class="article">
                <h2>All Projects</h2>
                <h3></h3>
                <!-- Make each table row clickable to go to project details; on action -->
                <table>
                    <tr class="tableheader">
                        <td>Project Title</td>
                        <td>Description</td>
                        <td>Assigned Owner</td>
                        <td>Due Date</td>
                        <td>Next Task Follow-Up</td>
                        <td>Status</td>
                    </tr>

                    <?php
                    $projectRow = $stmt->fetch();
                    if ($projectRow == null) {
                    ?>
                </table>
                <p></p>
                <p class="error"> There are currently no open projects. Go to 'Add New Project' to begin a new project.</p>
                <?php
                } else {
                        //put the loop that process the database results and outputs the content as HTML table
                        while ($projectRow = $stmt->fetch()) {    //returns items as an associative array since that what we told it to do previously in #6
                            echo "<tr>";
                            echo "<td>" . $projectRow['project_title'] . "</td>";
                            echo "<td>" . $projectRow['project_description'] . "</td>";
                            echo "<td>" . $projectRow['user_firstName'] . " " . $projectRow['user_lastName'] . "</td>";
                            echo "<td>" . $projectRow['project_dueDate'] . "</td>";
                            echo "<td>" . $projectRow['project_nextTaskDue'] . "</td>";
                            echo "<td>" . $projectRow['project_isOpen'] . "</td>";
                            echo "<td><a href='viewProjectDetails.php?projectID=" . $projectRow['project_id'] . "'><button>View Details</button></td>";
                            echo "</tr>";
                            //echo out a button for each row in loop

                        }
                ?>
                </table>
                <p></p>
            <?php
                    }
            ?>
            </table>
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