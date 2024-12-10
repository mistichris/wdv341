<?php
session_start();
if ($_SESSION['validUser'] !== "valid") {
    //you are NOT a valid user and CANNOT access this page
    header("Location: login.php");      //server side redirect
}

try {
    //#1 Connect to the database
    require 'dbConnect.php';

    //#2 Create your SQL query
    $sql = "SELECT * FROM mm_users ORDER BY user_lastName";

    #3 Prepared statement PDO 
    $stmt = $conn->prepare($sql);

    //#4 - Bind Parameters - N/A
    //Uncaught Error: PDOStatement::bindParam(): Argument #2($var) cannot be passed by reference in  . . . means unbound parameters
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
    <title>micromanager view all users page</title>
    <link rel="stylesheet" type="text/css" href="Styles/stylesheet_flex_responsive.css">
    <style>

    </style>
    <script>
        function confirmDelete(inUserID, inFirst, inLast) {
            //alert("inside confirmDelete() need to know the user_id: " + inUserID);
            //display a model asking Delete this Record Y or N
            let confirmCode = confirm("To 'DELETE' this user, click 'OK'. If you delete this user you cannot recovder it.");

            //if the response is Y send the user_ID to the deleteUser.php page to be deleted
            //if N nothing
            if (confirmCode) {
                //True - Delete Record
                //alert("Delete Record");
                //?
                window.location.href = "deleteUser.php?userID=" + inUserID + "&firstName=" + inFirst + "&lastName=" + inLast;
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
                    <p><a class="linkOnDark" href="inputProjectForm.php">Add New Project</a></p>
                    <p><a class="linkOnDark" href="viewAllProjects.php">View All Projects</a></p>
                </ul>
            </div>
            <div class="article">
                <h2>All Users:</h2>
                <h3></h3>
                <!-- Make each table row clickable to go to project details; on action -->
                <table>
                    <tr class="tableheader">
                        <td>First Name</td>
                        <td>Last Name</td>
                        <td>Manager Access</td>
                        <td>Login</td>
                        <td>Password</td>
                    </tr>
                    <?php
                    $userRow = $stmt->fetch();
                    if ($userRow === null) {
                    ?>
                </table>
                <p></p>
                <p class="error"> There are currently no users. Please go to 'Add New User' to add additonal users.</p>
                <?php
                } else {
                        //put the loop that process the database results and outputs the content as HTML table
                        while ($userRow = $stmt->fetch()) {    //returns items as an associative array since that what we told it to do previously in #6
                            echo "<tr>";
                            echo "<td>" . $userRow['user_firstName'] . "</td>";
                            echo "<td>" . $userRow['user_lastName'] . "</td>";
                            echo "<td>" . $userRow['user_isManager'] . "</td>";
                            echo "<td>" . $userRow['user_login'] . "</td>";
                            echo "<td>" . $userRow['user_password'] . "</td>";
                            echo "<td><a href='updateUserForm.php?userID=" . $userRow['user_ID'] . "'><button>Update</button></td>";
                            echo "<td><a href='viewAllTasksByUser.php?userID=" . $userRow['user_ID'] . "'><button>View Tasks</button></td>";
                            // echo "<td><button onclick='confirmDelete(" . $userRow['user_ID'] . ", " . $userRow['user_firstName'] . ", " . $userRow['user_lastName'] . ")'>Delete</button></td>";
                            echo "</tr>";
                            //echo out a button for each row in loop

                        }
                ?>
                </table>
                <p></p>
            <?php
                    }
            ?>
            <tr>
                <th></th>
                <th></th>
            </tr>

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