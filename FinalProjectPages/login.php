<?php
session_start();
$errorMsg = "";
$_SESSION['validUser'] = "invalid";

if ($_SESSION['validUser'] === "valid") {
    $_SESSION['validUser'] = "valid";
} else {

    //check  if the form was submitted or needs to be displayed to the customer
    if (isset($_POST["submit"])) {

        //1.get the data from the form
        $inUsername = $_POST['inUsername'];   //pull the username from the login form
        $inPassword = $_POST['inPassword'];   //pull the password from the login form

        //2.connect to the database
        try {
            //#1
            require 'dbConnect.php';        //access to the database; required to continue processing SELECT statements

            //#2
            $sql = "SELECT COUNT(*) FROM mm_users WHERE user_login = :username AND user_password = :userpass;";


            #3 Prepared statement PDO - returns statement object/value, need to catch it in variable '$stmt'
            $stmt = $conn->prepare($sql);       //$conn from dbConnect.php file

            //#4 - Bind Parameters - N/A
            //Uncaught Error: PDOStatement::bindParam(): Argument #2($var) cannot be passed by reference in  . . . means unbound parameters
            $stmt->bindParam(":username", $inUsername);
            $stmt->bindParam(":userpass", $inPassword);

            //#5 - Execute the PDO Statement/save results in $stmt object
            $stmt->execute();

            $rowCount = $stmt->fetchColumn();   //get number of rows in result set/statement; is only 

            if ($rowCount > 0) {        //if there is a match; it will return a successful login response
                //echo "<h3> Login successful </h3>";
                $_SESSION['validUser'] = "valid";
            } else {
                $_SESSION['validUser'] = "invalid";
                $errorMsg = "Invalid username or password entered. Please Try again.";
            }

            //#6 - Process the results from the query
            // $stmt->setFetchMode(PDO::FETCH_ASSOC);    //tells it that everytime it runs $stmt to return values as an ASSOC array


        } catch (PDOException $e) {
            echo "Database Failed: " . $e->getMessage();
        }
    } else {
        //the customer needs to see the form in order to fill out the SUBMIT it for signon
    }
} //end of check for 'validSession'


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>micromanager Login Page</title>
    <link rel="stylesheet" type="text/css" href="Styles/stylesheet_flex_responsive.css">
    <style>
        .errorMsgFormat {
            color: red;
            font-style: italic;
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
            <h3></h3>

            <div class="sidenav">
                <img src="Styles/micro1.jpg" alt="magnifying image" style="max-height: 400px; align-items: center;" />
            </div>

            <div class="article">

                <?php

                if (isset($_POST['submit']) && $_SESSION['validUser'] === "valid") {
                    //display ADMIN
                ?>

                    <div class="article">
                        <!-- this section will display to a VALID user once they login -->
                        <p>
                        <h2>Admin Page</h2>
                        </p>
                        <p>
                        <h3>Choose from the following options:</h3>
                        </p>
                        <ol>
                            <li><a href="viewAllUsers.php">Display All Users</a></li>
                            <li><a href="inputUserForm.php">Add New User</a></li>
                            <li><a href="viewAllProjects.php">Display All Projects</a></li>
                            <li><a href="inputProjectForm.php">Add New Project</a></li>
                        </ol>
                    </div>
                <?php
                } else {
                    //display Form

                ?>
                    <div class="article">
                        <div class="center">
                            <!-- this section will display when the user asks to login to the application -->
                            <h2>Login Form</h2>
                            <form method="post" action="login.php">
                                <div class="errorMsgFormat">
                                    <?php
                                    //option 2 - check to see if you have defined this variable yet?
                                    if ($errorMsg !== "") {
                                        echo $errorMsg;     //display error message invalide username/password
                                    }
                                    ?>
                                </div class="errorMsgFormat">
                                <p>
                                    <label for="inUsername">Username: </label>
                                    <input type="text" name="inUsername" id="inUsername">
                                </p>

                                <p>
                                    <label for="inPassword">Password: </label>
                                    <input type="password" name="inPassword" id="inPassword">
                                </p>

                                <p>
                                    <input type="submit" name="submit" value="Submit">
                                    <input type="reset">
                                </p>
                            </form>
                        </div>
                    </div>
                <?php
                }   //end the else branch
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