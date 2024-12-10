<?php
session_start();
if ($_SESSION['validUser'] !== "valid") {
    //you are NOT a valid user and CANNOT access this page
    header("Location: login.php");      //server side redirect
}

$errMessage = null;
try {
    //#1 Connect to the database
    require 'dbConnect.php';

    //#2 Create your SQL query
    $sql = "SELECT * FROM mm_users";

    if ($sql == null) {
        $errMessage = "Unable to connect to the database. Try again later.";
    } else {
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
    }
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
    <title>micromanager new project or update event form</title>
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
                <h3>Insert New Project</h3>
                <?php
                if ($errMessage !== null) {
                    echo "<h2>" . $errMessage . "</h2>";
                } else {
                ?>

                    <!-- populate form with existing Team Member info from database -->
                    <form id="form1" name="form1" method="post" action="insertProject.php">
                        <p>
                            <label for="projectTitle">Title: </label>
                            <input type="text" name="projectTitle" id="projectTitle" required />
                        </p>

                        <p>
                            <label for="projectDescription">Project Description: </label>
                            <input type="text" name="projectDescription" id="projectDescription" required />
                        </p>

                        <p>
                            <label for="projectManager">Choose a Project Owner: </label>
                            <select name="projectManager" id="projectManager">
                                <option value="none" selected disabled>Select an Option</option>
                                <?php
                                while ($userRow = $stmt->fetch()) {    //returns items as an associative array of values from mm_users table
                                    //echo out an option for the drop down for each user with value equal to user ID number
                                    echo "<option value='" . $userRow['user_ID'] . "'>" . $userRow['user_firstName'] . " " . $userRow['user_lastName'] . "</option>";
                                }
                                ?>
                            </select>
                        </p>

                        <p>
                            <label for="projectDueDate">Project Due Date: </label>
                            <input type="date" name="projectDueDate" id="projectDueDate" placeholder="MM/DD/YYY" onfocus="(this.type = 'date')" required>
                        </p>

                        <label class="ohnohoney" for="name"></label>
                        <input class="ohnohoney" autocomplete="off" type="text" id="name" name="name" placeholder="Your name here">
                        <label class="ohnohoney" for="email"></label>
                        <input class="ohnohoney" autocomplete="off" type="email" id="email" name="email" placeholder="Your e-mail here">

                        <p>
                            <input type="submit" name="button" id="button" value="Submit" />
                            <input type="reset" name="button2" id="button2" value="Reset" />
                        </p>

                    </form>
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