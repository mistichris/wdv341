<?php
//MODEL - data
    //assign ariables at top of page
    //access a database at top of page or near top of page
    // get information available to bring in





//CONTROLLER - business logic/general code


//VIEW -user interface



?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>

</head>

/*
    behind wordpress
    server side language similar to javascript, etc
    which language depends on company and what type of work being done 
    c# and Java need to get to advanced before get to server side

    still need an html component
    can start with a .html for autocomplete in html language then change 
    extention to .php 
    can put php anywhere on a page 

    php real goal is display information out to the customer
        echo = document.write   or print
*/

<h1>WDV341 Intro PHP</h1>
<h2>PHP Basics and Examples</h2>
<h3>Hello from PHP</h3>
<h3 class='greetingLine'>Welcome Mary</h3>


<?php
    echo "<h3>Hello from PHP</h3>";
        //will display the view of the user so is placed in the 'VIEW'
        //source code modified by the server environement
?>

<h3 class=<?php echo "'greetingLine'" ?>>Welcome: <?php echo "Mary"; ?> </h3>

<label for="colorRed">Red:</label>
<input type="radio" name="colorGroup" value="red">

<?php
    
for ($x=0; $x < count($colors); $x++){
    $radioColor = $colors[$x];
    //echo $colors [$x];
    echo "<div>";
    echo "<label for='color$colors[$x]'>$radioColor:</label>";
    echo "input type='radio' name='colorGroup' id='colorBlue' value=' "
    . strtolower($radioColor) . "'>";
    echo "</div>";
}

    //Parse error  -- syntax error, unexpected token "echo", expecting "," or";' . .  .
    //php requires semicolons in order to run correctly
?>


</body>
</html>