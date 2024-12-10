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
    //Query database for all possible users
    //#2 Create your SQL query
    $sqlUser = "SELECT * FROM mm_users";

    #3 Prepared statement PDO 
    $stmtUser = $conn->prepare($sqlUser);

    //#4 - Bind Parameters - N/A

    //#5 - Execute the PDO Statement/save results in $stmt object
    $stmtUser->execute();

    //#6 - Process the results from the query
    $stmtUser->setFetchMode(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Database Failed: " . $e->getMessage();
    $errMessage = "Unable to connect to the database. Try again later.";
}


//verify information entered for user login
// function verifyName()
// {
//     $userName = $_POST["userName"];
//     // To check that User Name only contains alphabets, numbers, and underscores 
//     if (!preg_match("/^[a-zA-Z0-9_]*$/", $userName)) {
//         $errorMsg = "Only alphabets, numbers, and underscores are allowed for User Name";
//     } else {
//         echo $userName;
//     }
// }


// function userExists($inFirst, $inLast) {
//     // Create a new DOM Document 
//     $dom = new DOMDocument('1.0', 'iso-8859-1');

//     // Enable validate on parse 
//     $dom->validateOnParse = true; 

//     // $tagcontent = $dom->getElementById('my_id')->textContent; 
//     // echo "The element whose id is 'php-basics' is: " . $doc->getElementById('php-basics')->tagName . "\n";

//     $inFirst = $dom->getElementByID('firstName')->textContent;
//     $inLast = $dom->getElementByID('lastName')->textContent;
//     $errUserExists = "";
//     while ($userRow = $stmtUser->fetch()){
//         if(($inFirst == $userRow['user_firstName'])  && ($inLast == $userRow['user_lastName'])){
//             $errUserExists = "User already exists. Please update user if information needs to be changed.";
//         }

//     }

// }
// function uniqueUserID() {}


// 
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
                <h3>Insert New User Information</h3>

                <form id="form1" name="form1" method="post" action="insertUser.php">
                    <p>
                        <label for="firstName">First Name: </label>
                        <input type="text" name="firstName" id="firstName" placeholder="First Name" required />
                    </p>

                    <p>
                        <label for="lastName">Last Name:</label>
                        <input type="text" name="lastName" id="lastName" placeholder="Last Name" required />
                    </p>

                    <p>
                        <label for="isManager">Select Level of Access Required: </label>
                    </p>

                    <p>
                        <input type="radio" name="isManager" id="notManager" value="0" checked />
                        <label for="isManager">Restricted Access</label>
                        <input type="radio" name="isManager" id="manager" value="1" />
                        <label for="isManager">Manager Level Access</label>
                    </p>

                    <p>
                        <label for="userLogin">Create User Login:</label>
                        <input type="text" name="userLogin" id="userLogin" placeholder="Create Login" required />
                    </p>

                    <p>
                        <label for="userPassword">Create User Password</label>
                        <input type="text" name="userPassword" id="userPassword" placeholder="Create Password" required />
                    </p>

                    <label class="ohnohoney" for="name"></label>
                    <input class="ohnohoney" autocomplete="off" type="text" id="name" name="name" placeholder="Your name here">
                    <label class="ohnohoney" for="email"></label>
                    <input class="ohnohoney" autocomplete="off" type="email" id="email" name="email" placeholder="Your e-mail here">

                    <p>
                        <input type="submit" name="submit" id="submit" onclick="<?php ?>" value="Submit" />
                        <input type="reset" name="reset" id="reset" value="Reset" />
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