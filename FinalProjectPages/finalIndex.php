<?php
session_start();
if ($_SESSION['validUser'] !== "valid") {
}

$today = date_format(date_create(), "Y");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Micromanager site home page</title>
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

                <h2>Trust in The Best</h2>

                <p> <em>"I am not micromanaging. And I certainly don't want to. But whenever there is a leadership gap, then expect higher level leaders to step down. The role of a leader is to 'Stay ahead of their management' and know more about the project than anyone else. Your issue is you are not on top of things. So, I am forced to have to step down."</em></p>
                <p>James Michael Lafferty</p>
                <p><a href="https://www.linkedin.com/pulse/micromanagement-myth-james-michael-lafferty/">LinkedIn-The Micromanagement Myth</p>

                <img src="Styles/comic1.jpg" alt="Comic" style="max-height: 300px; align-items: center;" />
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


</body>

</html>