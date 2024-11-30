<?php
session_start();
if ($_SESSION['validUser'] !== "valid") {
    //you are NOT a valid user and CANNOT access this page
    header("Location: login.php");      //server side redirect
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../styles/stylesheet_flex_responsive.css">
    <title>Document</title>
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
    <script>
    </script>


</head>

<body>
    <div class="wrapper">
        <header>
            <h1>WDV341 Intro PHP</h1>
            <h2>Unit-9 INSERT - Input form sends data to the database</h2>
        </header>
        <section class="frame">
            <form method="post" action="insertEvent.php">
                <!-- use post until you have to use get
        have to have an action, tells the form where to send info after form submitted -->
                <!--  -->
                <p>
                    <label for="events_name">Event Name</label> <!--have to have labels for ada compliance -->
                    <input type="text" name="events_name" id="events_name" placeholder="Event Name" required>
                    <!-- use the same name as the database columns -->
                </p>

                <p>
                    <label for="events_description">Event Description</label>
                    <input type="text" name="events_description" id="events_description" placeholder="Event Description" required>
                </p>

                <p>
                    <label for="events_presenter">Event Presenter</label>
                    <input type="text" name="events_presenter" id="events_presenter" placeholder="Event Presenter">
                </p>

                <p>
                    <label for="events_date">Event Date</label>
                    <input type="date" name="events_date" id="events_date" placeholder="MM/DD/YYY" onfocus="(this.type = 'date')" required>
                </p>

                <!-- Default is 24 hours for time -->
                <p>
                    <label for="events_time">Event Start Time</label>
                    <input type="time" name="events_time" id="events_time" required>
                </p>

                <label class="ohnohoney" for="name"></label>
                <input class="ohnohoney" autocomplete="off" type="text" id="name" name="name" placeholder="Your name here">
                <label class="ohnohoney" for="email"></label>
                <input class="ohnohoney" autocomplete="off" type="email" id="email" name="email" placeholder="Your e-mail here">

                <p>
                    <input type="submit" name="" id="" value="Submit">
                    <input type="reset" name="" id="" value="Reset">
                </p>
                <?php
                ?>

            </form>
        </section>
        <div class="footer">
            <a class="" href="../wdv341Homework.html">WDV341 Homework Page</a>
            <a href="https://github.com/mistichris/wdv341.git">Git Hub Link</a>
            <a class="" href="../../../index.html">Christianson Home Page</a>
        </div>
    </div>
</body>

</html>

<!-- 
It will display a form that can be used to input the information for an event.
Make sure your form contains fields for all the columns in the events table in your database.
    -name, description, presenter, date and time
    -The date_inserted and date_updated should also have the current date filled when the record is inserted.
The action attribute of your form will call the insertEvent.php file that will insert data into your database.
Include at least one form protection technique such as honeypot, Captcha, reCaptcha, etc.

Use PHP, PDO and SQL to process the form data into your database. 

Create a file called insertEvent.php.
It will connect to your wdv341 database using a db-connect.php file. 
It will access the wdv341_event table that we've used throughout the course.  
Use a PDO Prepared Statement to process a SQL INSERT command to insert the form data into your table.  
-->