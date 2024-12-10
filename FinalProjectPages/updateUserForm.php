<?php
session_start();
if ($_SESSION['validUser'] !== "valid") {
    //you are NOT a valid user and CANNOT access this page
    header("Location: login.php");      //server side redirect
}

//get the user ID from previous page if the user is needing to be updated

$userID = $_GET["userID"];
$checkManager = "";
$checkNotManager = "";

try {
    //#1 Connect to database
    require 'dbConnect.php';

    //#2 Create SQL query
    $sql = "SELECT * FROM mm_users WHERE user_id = :userID";

    #3 Prepared statement PDO - returns statement object/value, need to catch it in variable '$stmt'
    $stmt = $conn->prepare($sql);

    //#4 - Bind Parameters - N/A
    $stmt->bindParam(":userID", $userID);

    //#5 - Execute the PDO Statement/save results in $stmt object
    $stmt->execute();

    //#6 - Process the results from the query
    $stmt->setFetchMode(PDO::FETCH_ASSOC);    //tells it that everytime it runs $stmt to return values as an ASSOC array
    //returns name/value pairs and the information stored in the column

    //get the record from the result set/$stmt object
    $userItem = $stmt->fetch();

    //create a variable for each field in the database
    $firstName = $userItem['user_firstName'];
    $lastName = $userItem['user_lastName'];
    $isManager = $userItem['user_isManager'];
    $userLogin = $userItem['user_login'];
    $userPassword = $userItem['user_password'];

    if ($isManager == 1) {
        $checkManager = "checked";
    }

    if ($isManager == 0) {
        $checkNotManager = "checked";
    }
} catch (PDOException $e) {
    echo "Database Failed: " . $e->getMessage();
}



// // return to selectEvents.php to display the updated list of events
// header("Location: viewAllUsers.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>micromanager create new or update user <form action=""></form>
    </title>
    <link rel="stylesheet" type="text/css" href="Styles/stylesheet_flex_responsive.css">
    <style>

    </style>
    <script>
        function toggleRadio() {
            let notManagerRadio = document.getElementById("notManager");
            let managerRadio = document.getElementById("manager");
            if (managerRadio.checked == false) {
                //     <?php $checkNotManager = "";
                        //    $checkManager = "checked";
                        ?>
                managerRadio.checked = true;
                notManagerRadio.checked = false;
            }
            if (managerRadio.checked == true) {
                //     <?php $checkNotManager = "checked";
                        //    $checkManager = "";
                        ?>
                managerRadio.checked = false;
                notManagerRadio.checked = true;
            }
        }

        function turnoffRadio() {
            let notManagerRadio = document.getElementById("notManager");
            let managerRadio = document.getElementById("manager");
            if (managerRadio.checked == true) {
                managerRadio.checked = false;
                notManagerRadio.checked = true;
            }
        }
    </script>
</head>

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
                <h3>Update User <?php echo $firstName . " " .  $lastName; ?></h3>

                <form id="form1" name="form1" method="post" action="updateUser.php?userID=<?php echo $userID; ?>">
                    <p>
                        <label for="firstName">First Name: </label>
                        <input type="text" name="firstName" id="firstName" placeholder="First Name" value="<?php echo $firstName; ?>" required />
                    </p>

                    <p>
                        <label for="lastName">Last Name:</label>
                        <input type="text" name="lastName" id="lastName" placeholder="Last Name" value="<?php echo $lastName; ?>" required />
                    </p>

                    <p>
                        <input type="radio" name="isManager" id="notManager" value="0" <?php echo $checkNotManager ?> />
                        <label for="isManager">Restricted Access</label>
                        <input type="radio" name="isManager" id="manager" value="1" <?php echo $checkManager ?> />
                        <label for="isManager">Manager Level Access</label>
                    </p>

                    <p>
                        <label for="userLogin">Create User Login:</label>
                        <input type="text" name="userLogin" id="userLogin" placeholder="Create Login" value="<?php echo $userLogin; ?>" required />
                    </p>

                    <p>
                        <label for="userPassword">Create User Password</label>
                        <input type="text" name="userPassword" id="userPassword" placeholder="Create Password" value="<?php echo $userPassword; ?>" required />
                    </p>

                    <label class="ohnohoney" for="name"></label>
                    <input class="ohnohoney" autocomplete="off" type="text" id="name" name="name" placeholder="Your name here">
                    <label class="ohnohoney" for="email"></label>
                    <input class="ohnohoney" autocomplete="off" type="email" id="email" name="email" placeholder="Your e-mail here">

                    <p>
                        <input type="submit" name="button" id="button" value="Update User" />
                        <a href="viewAllUsers.php"><button type=button>Cancel</button></a>
                    </p>

                </form>
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