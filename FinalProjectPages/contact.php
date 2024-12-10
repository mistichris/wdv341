<?php
session_start();
if ($_SESSION['validUser'] !== "valid") {
    $today = date_format(date_create(), "Y");
}

$today = date_format(date_create(), "Y");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WDV341 Final Project</title>
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
            <?php
            if ($_SESSION['validUser'] === "valid") {
                echo "<a class='linkOnDark' href='logout.php'>Logout</a>";
            } else {
                echo "<a class='linkOnDark' href='login.php'>Login</a>";
            }
            ?>
        </nav>
        <section class="frame">
            <?php
            if ($_SESSION['validUser'] === "valid") {
            ?>
                <div class="sidenav">
                    <ul>
                        <p><a class="linkOnDark" href="inputUserForm.php">Add New User</a></p>
                        <p><a class="linkOnDark" href="viewAllUsers.php">View All Users</a></p>
                        <p><a class="linkOnDark" href="inputProjectForm.php">Add New Project</a></p>
                        <p><a class="linkOnDark" href="viewAllProjects.php">View All Projects</a></p>
                    </ul>
                </div>
            <?php
            }
            ?>
            <div class="article">
                <h2>Contact Form:</h2>
                <form id="form1" name="contactForm" method="post" action="processContact.php">

                    <legend></legend>

                    <p>
                        <label class="label" for="first_name">First Name:</label>
                        <input type="text" name="first_name" id="first_name" placeholder="First Name" required />
                    </p>

                    <p>
                        <label class="label" for="last_name">Last Name:</label>
                        <input type="text" name="last_name" id="last_name" placeholder="Last Name" required />
                    </p>

                    <p>
                        <label class="label" for="email">Email Address:</label>
                        <input type="email" name="email" id="email" placeholder="sample@email.com" required />
                    </p>

                    <p>
                        <label class="label" for="reason">Reason for contact: </label>
                        <select id="reason" name="reason" required>
                            <option value="default" selected disabled>Select a Reason</option>
                            <option value="services">Sign-up for Services</option>
                            <option value="help">Customer Service</option>
                            <option value="suggestion">General Suggestion</option>
                            <option value="job">Job Opportunity</option>
                            <option value="other">Other</option>
                        </select>
                    </p>

                    <label class="classy" for="name"></label>
                    <input class="classy" autocomplete="off" type="text" id="name" name="name"
                        placeholder="Your name here">
                    <label class="classy" for="city"></label>
                    <input class="classy" autocomplete="off" type="city" id="city" name="city"
                        placeholder="City Name">



                    <p>
                        <label class="label" type="text" id="comments">Comments: </label>
                    </p>
                    <p>
                        <textarea name="comments" id="comments" rows="5" cols="45" placeholder="Insert Comments Here"
                            maxlength="200" required></textarea>
                    </p>

                    <p>
                        <input type="submit" name="submit" value="Submit">
                        <input type="reset">
                    </p>
                </form>
            </div>
        </section>
        <div class="footer">
            <a class="" href="../wdv341Homework.php">WDV341 Homework Page</a>
            <a href="https://github.com/mistichris/wdv341.git">Git Hub Link</a>
            <a class="" href="../../../index.html">Christianson Home Page</a>
        </div>
        <div style="text-align: center;">
            <p>Copyright &#169 <?php echo $today ?> microMANAGER All rights reserved.
            <p>
        </div>

        <p>&nbsp;</p>
    </div>
</body>

</html>