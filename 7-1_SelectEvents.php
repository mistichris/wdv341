<?php

try {
    //1. Connect to the database
    require 'dbConnect.php';

    //2. Create your SQL query
    $sql = "SELECT events_name, events_description FROM wdv341_events";

    //3. Prepare your PDO statement - returns statement object/value, need to catch it in variable '$stmt'
    $stmt = $conn->prepare($sql);   

    //#4 - Bind Parameters - N/A

    //#5 - Execute the PDO Statement/save results in $stmt object
    $stmt->execute();

    //#6 - Process the results from the query
    $stmt->setFetchMode(PDO::FETCH_ASSOC);


} catch (PDOException $e) {
    echo "Database Failed: " . $e->getMessage();
}
?>


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="../styles/stylesheet_flex_responsive.css">
    <style>
        table {
            width: 75%;
            border-collapse: collapse;
        }

        td {
            text-align: left;
            word-wrap: wordwrap;
            padding-bottom: 5px;
            padding-right: 20px;
        }

        .border {
            border-bottom: 1px solid black;
        }
    </style>
</head>

<div class="wrapper">
    <header>
        <h1>WDV341 Intro PHP</h1>
        <h2>7-1: Create selectEvents.php</h2>
    </header>
    <section class="frame">
        <h3></h3>
        <table>
            <tr class="border">
                <td>
                    <h3>Event Name</h3>
                </td>
                <td>
                    <h3>Event Desription</h3>
                </td>
            </tr>
            <?php
            //put in a loop that processes the database results and outputs the content as HTML table
            while ($eventRow = $stmt->fetch()) {
                echo "<tr>";
                echo "<td>" . $eventRow["events_name"] . "</td>";
                echo "<td>" . $eventRow["events_description"] . "</td>";
                echo "</tr>";
            }
            ?>
        </table>
    </section>
    <div class="footer">
        <a class="" href="../../wdv341Homework.php">WDV341 Homework Page</a>
        <a href="https://github.com/mistichris/wdv341.git">Git Hub Link</a>
        <a class="" href="../../../index.html">Christianson Home Page</a>
    </div>

    <p>&nbsp;</p>
</div>
</body>

</html>