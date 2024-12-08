<?php


session_start();
$errorMsg = "";
$_SESSION['validUser'] = false;
if ($_SESSION['validUser'] === true) {
    //if you are a 'validSession' then you should see the Admin page
    //you do not need to sign on again. We will keep you signed on.
    $_SESSION['validUser'] = true;
} else {



    //check  if the form was submitted or needs to be displayed to the customer
    if (isset($_POST["submit"])) {
        //did the user submit the form to signon? Yes
        //the form was submitted continue PROCESSING the form data
        /*
        1.get the data from the form
        2.connect to the database
        see if you have a matching record in the users table
        if (match = true){
            valid user
            display Admin Page
        }
        else{
            Invalid User
            display error message
            display the form
        }

    */
        //1.get the data from the form
        $inUsername = $_POST['inUsername'];   //pull the username from the login form
        $inPassword = $_POST['inPassword'];   //pull the password from the login form


        //2.connect to the database
        try {
            //#1
            require 'dbConnect.php';        //access to the database; required to continue processing SELECT statements

            //#2
            $sql = "SELECT COUNT(*) FROM wdv341_users WHERE user_username = :username AND user_password = :userpass;";
            //is only going to return one column of data; which will be the count of greater than zero if one row matches


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
                $_SESSION['validUser'] = true;
            } else {
                $_SESSION['validUser'] = false;
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
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="../homework/styles/stylesheet_flex_responsive.css">
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

<div class="wrapper">
    <header>
        <h1>WDV341 Intro PHP</h1>
        <h2>Unit-10: Login Example Page</h2>
    </header>
    <section class="frame">
        <h3></h3>

        <?php

        if (isset($_POST['submit']) && $_SESSION['validUser'] === true) {
            //display ADMIN
        ?>

            <section class="adminPage">
                <!-- this section will display to a VALID user once they login -->
                <h2>Admin Page</h2>
                <h3>Choose your option:</h3>
                <ol>
                    <li><a href="9-1_InputFormEvents_INSERT/eventInputForm.php">Add new Event</a></li>
                    <li><a href="7_SelectEvent/selectEvents.php">Display Events</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ol>
            </section>
        <?php
        } else {
            //display Form

        ?>
            <section class="loginForm">
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
                    </div>
                    <p>
                        <label for="inUsername">Username: </label>
                        <input type="text" name="inUsername" id="inUsername">
                    </p>

                    <p>
                        <label for="inPassword">Password: </label>
                        <input type="password" name="inPassword" id="inPassword">
                    </p>

                    <p>
                        <input type="submit" name="submit" value="Submit"> <!-- 'submit'='submit'   -->
                        <input type="reset">
                    </p>
                </form>
            </section>

        <?php
        }   //end the else branch
        ?>
    </section>
    <div class="footer">
        <a class="" href="../../wdv341Homework.php">WDV341 Homework Page</a>
        <a href="https://github.com/mistichris/wdv341.git">Git Hub Link</a>
        <a class="" href="../../../index.html">Christianson Home Page</a>
    </div>

    <p>&nbsp;</p>
</div>
</body>

</html>