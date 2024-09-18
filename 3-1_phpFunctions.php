<?php
//MODEL - data
$time = time();
$inputString = " DMACC has something for everyone! ";
$inputNumber = 1234567890;
$inputCurrency = 123456;

//CONTROLLER - business logic/general code
function formatDate($time)
{
    global $time;
    echo (date("m/d/Y", $time));
}

function formatInternationDate($time)
{
    global $time;
    echo (date("d/m/Y", $time));
}

function formatString($inputString)
{
    global $inputString;
    echo ("1. Number of characters in String: ");
    echo strlen($inputString);
    echo ('<br>');
    echo ("2. Trimmed leading and tailing whitespaces: ");
    echo trim($inputString);
    echo ('<br>');
    echo ("3. String as all lower cases: ");
    echo strtolower($inputString);
    echo ('<br>');
    echo ('4. Does the string contain "DMACC": ');
    echo strpos(strtoupper($inputString), 'DMACC');
}

function formatPhoneNumber($inputNumber)
{
    global $inputNumber;
    $numString = (string)$inputNumber;
    $value1 = substr($numString, 0, 3);
    $value2 = substr($numString, 3, 3);
    $value3 = substr($numString, 6, 4);
    echo ("(" . $value1 . ") " . $value2 . "-" . $value3);
}

function formatCurrency($inputCurrency)
{
    global $inputCurrency;
    echo ('$' . number_format($inputCurrency, 2));
}

//VIEW -user interface

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WDV341 INTRO PHP</title>
    <link rel="stylesheet" type="text/css" href="styles/stylesheet_flex_responsive.css">
    <script>    </script>
</head>

<body>
    <h1>WDV341 Intro PHP</h1>
    <h2>Unit-3 PHP Functions</h2>

    <ol>
        <li>Create a function that will accept a Unix Timestamp as a parameter and format it into
            mm/dd/yyyy format.</li>
        <p> <?php formatDate($time); ?> </p>
        <li>Create a function that will accept a Unix Timestamp as a parameter and format it into
            dd/mm/yyyy format to use when working with international dates.</li>
        <p> <?php formatInternationDate($time); ?> </p>

        <li>Create a function that will accept a string parameter. It will do the following things
            to the string:
            <ul>
                <li>Display the number of characters in the string</li>
                <li>Trim any leading or trailing whitespace</li>
                <li>Display the string as all lowercase characters</li>
                <li>Will display whether or not the string contains "DMACC" either upper or lowercase</li>
                <li>
                    <p> <?php formatString($inputString); ?> </p>
                </li>
            </ul>
        </li>
        <li>Create a function that will accept a number parameter and display it as a formatted
            phone number. Use 1234567890 for your testing.</li>
        <p> <?php formatPhoneNumber($inputNumber); ?> </p>
        <li>Create a function that will accept a number parameter and display it as US currency
            with a dollar sign. Use 123456 for your testing.</li>
        <p> <?php formatCurrency($inputCurrency); ?> </p>
    </ol>


    <div class="footer">
        <a class="" href="../wdv221Homework.html">Christianson Homework Page</a>
        <a class="" href="../../index.html">Christianson Home Page</a>
    </div>
</body>

</html>

<!-- Create a PHP page that will process and display the following pieces of information.  
    Use a combination of custom PHP functions and functions from the PHP API as needed. 

Your page should do the following:

1.Create a function that will accept a Unix Timestamp as a parameter and format it into 
    mm/dd/yyyy format.
2.Create a function that will accept a Unix Timestamp as a parameter and format it into 
    dd/mm/yyyy format to use when working with international dates.
3.Create a function that will accept a string parameter.  It will do the following things 
        to the string:
    Display the number of characters in the string
    Trim any leading or trailing whitespace
    Display the string as all lowercase characters
    Will display whether or not the string contains "DMACC" either upper or lowercase
4.Create a function that will accept a number parameter and display it as a formatted 
    phone number.   Use 1234567890 for your testing.
5.Create a function that will accept a number parameter and display it as US currency 
    with a dollar sign.  Use 123456 for your testing.
When complete please do the following:

Post all necessary files to your website.
Update your WDV341 homework page with a link to the assignment.  If your assignment 
    is not on your website it will not be graded.
Include a link to your Git repo on the Blackboard assignment. If your assignment is 
    not in your Git repo it will not be graded.
Place a link to your homework page on the Blackboard assignment.
Submit your assignment on Blackboard.  If you do not submit the assignment on 
    Blackboard it will not be graded.  -->