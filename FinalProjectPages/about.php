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
        <nav class="spaced">
            <a class="linkOnDark" href="finalIndex.php">microMANAGEMENT Home</a>
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
                <h2>About</h2>
                <h3>Why I Love Micromanaging and You Should Too</h3>
                <p>By Jack Welch taken from <a class="linkOnDark"
                        href="https://www.linkedin.com/pulse/why-i-love-micromanaging-you-should-too-jack-welch/">LinkedIn.</a>
                </p>

                <div>
                    <p>
                        Not long ago, I co-hosted CNBC's Squawk Box with Under Armour CEO Kevin Plank. A lot was debated
                        that
                        day, but at one point, Kevin offered the opinion, “Micromanagement is vastly underrated.” I think a
                        few
                        others on the set were a little taken aback given the bad rap micromanagement often gets, but I
                        wasn't
                        among them. In fact, I totally agree.
                    </p>
                    <p>
                        Look, we all know jerk bosses who stick their nose into every little thing their people are doing,
                        and
                        basically try to drive the bus from the back seat. We also know perfectly good bosses who do the
                        same
                        kind of thing for a different and legitimate reason -- because they know the people doing the real
                        work
                        aren't yet ready to do it themselves.
                    </p>
                    <p>
                        Let's put aside those two situations, and talk about the much more common occurrence of bosses who
                        get
                        deeply involved in the day-to-day work of employees who are capable and competent.
                    </p>
                    <p>
                        And let me repeat myself: of that I approve.
                    </p>
                    <p>
                        Because micromanaging is a paradox, just like so many challenges inherent to getting business right.
                        Think about balancing long-term goals and short-term needs. Or giving a star performer the correct
                        amount of praise versus challenge. These are all judgment calls, based on the situation and the
                        individuals and the market context.
                    </p>
                    <p>
                        And so it is with micromanaging. As a manager, you have to take what I call the “accordion
                        approach.”
                        Get very close to your people and their work when they need you - that is, when your help matters -
                        and
                        pull back when you're extraneous.
                    </p>
                    <p>
                        Now what do I mean by “when your help matters?” That's the key question, and I'd answer it as
                        follows:
                        Your help matters when you bring unique expertise to a situation, or you can expedite things by dint
                        of
                        your authority, or both. Your help matters when you have highly relevant experience that no one else
                        on
                        the team brings, and your presence sets an example of best practices - and prevents costly mistakes.
                        Your help matters when it signals the organization's priorities, as in, “Hey, we have high hopes for
                        this new initiative. That's why I'm in the weeds with it.” Your help matters when you have a long
                        relationship with, say, a customer or a potential partner, and your being at the table changes the
                        game.
                    </p>
                    <p>
                        In such situations, you have to micromanage. It's your responsibility. Just as it's every employee's
                        responsibility to help the organization win.
                    </p>
                    <p>
                        Micromanaging only stinks when bosses do it because they have nothing better to do, or they're
                        constitutionally unable to trust people, employees included. I'd never support that.
                    </p>
                    <p>
                        Ultimately, knowing how and when to micromanage comes down to engagement. If you really know your
                        people
                        and their skills - as you should - and you're in their skin about their passions and concerns - as
                        you
                        should be - you will know when to “squeeze the accordion” and draw close.
                    </p>
                    <p>
                        Similarly, you'll know when to pull away and give them space. When your level of micromanaging grows
                        out
                        of strong, vibrant engagement with your people, have no fear. When you get involved, your team will
                        know
                        you're in it for them. And when you step back, they'll be in it for you too.
                    </p>
                </div>
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