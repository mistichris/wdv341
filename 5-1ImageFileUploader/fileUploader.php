<?php


$ext = pathinfo($_FILES["inFile"]["name"],  PATHINFO_EXTENSION);
$newName = $_POST["inFileName"] . "." . $ext;

$hostImageFolder = "uploadedImages/";

$fileName = basename($_FILES["inFile"]["name"]);


$hostImagePath = $hostImageFolder . $newName;

move_uploaded_file($_FILES["inFile"]["tmp_name"], $hostImagePath);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

</head>

<body>
    <div class="wrapper">
        <header>
            <h1>WDV341 Intro PHP</h1>
            <h2>PHP File Uploader</h2>
        </header>
        <section class="frame">
            <h3>File successfully loaded as:</h3>
            <p><?php echo  $hostImagePath  ?></p>

            <?php

            ?>
        </section>
        <div class="footer">
            <a class="" href="../wdv321Homework.html">Christianson Homework Page</a>
            <a href="https://github.com/mistichris/wdv341.git">Git Hub Link</a>
            <a class="" href="../../../index.html">Christianson Home Page</a>
        </div>

        <p>&nbsp;</p>
    </div>
</body>

</html>