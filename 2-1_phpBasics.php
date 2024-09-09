<?php
//MODEL - data
//assigning variables and values
$yourName = "Misti Christianson";
$assignment = "2-1: PHP Basics";

$number1 = 100;
$number2 = 73;
$total = $number1 + $number2;

//establishing php array
$wdvLanguages = array('PHP', 'HTML', 'Javascript');

//CONTROLLER - business logic/general code

//function to display php array in order to insert in to javascript array
function displayArray()
{
    global $wdvLanguages;
    for ($i = 0; $i < 3; $i++) {
        echo '"' . $wdvLanguages[$i] . '",';
    }
}

// echo displayArray();
//VIEW -user interface

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="styles/stylesheet_flex_responsive.css">

    <!-- /**Javascript functions to convert php array to js array and display on html page */ -->
    <script>
        const wdvLanguages = [<?php displayArray() ?>];

        //js function to loop through array and display on page
        function displayJSArray() {
            text = "";
            for (let i of wdvLanguages) {
                text += i + " ";
            }
            document.write("Javascript Array: " + text);
            // console.log(text);
        }
        // console.log("test");




        // wdvLanguages.forEach(javascriptArray);
        // document.getElementByID("jsArray").innerHTML = "test";
    </script>

</head>

<h1>WDV341 Intro PHP: <?php echo $assignment ?> Assignment</h1>
<h2><?php echo $yourName ?></h2>
<h3></h3>

<!-- Display PHP variables on html page -->
    
<p>Value Number1: <?php echo $number1 ?></p>
<p>Value Number2: <?php echo $number2 ?></p>
<p>Total Value: <?php echo $total ?></p>

<!-- Display javascript array on html page -->
<p>
    <script>
        displayJSArray();
    </script>
</p>

<?php

?>

<p><a href="https://github.com/mistichris/wdv341.git">Git Hub Link</a></p>

<div class="footer">
    <a class="" href="../wdv341Homework.php">Christianson WDV321 Homework</a>
    <a class="" href="../../index.html">Christianson Home Page</a>
</div>
</body>

</html>