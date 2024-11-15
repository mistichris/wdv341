<?php
try{
    //To connect to the database the following steps are required: (algorithm)
    //1. Connect to the database
        require 'dbConnect.php';
        require 'Event.php';
        $eventsID = 1;
    //2. Create your SQL query
        $sql = "SELECT events_name, events_description, events_presenter, events_date, events_time FROM wdv341_events WHERE events_id = :eventsID";
    //3. Prepare your PDO statement 
        $stmt = $conn->prepare($sql);       //$conn from dbConnect.php file
    //4. Bind Variables to the PDO Statement, if any
         $stmt->bindParam(":eventsID", $eventsID);
        
    //5. Execute the PDO Statement - run your SQL against the database
        $stmt->execute();

    //6. Process the results from the query
        //while the statement is still fetching data; put the data in data[]
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $outputObj = new Event;

        //Create a php object to hold the data
        $data = [];
        while ($row = $stmt->fetch()) {
            $data[] = $row;
        }

        foreach($data as $value){
            $outputObj->setEventsName($value["events_name"] );
            $outputObj->setEventsDescription($value["events_description"]);
            $outputObj->setEventsPresenter($value["events_presenter"]);
            $outputObj->setEventsDate($value["events_date"]);
            $outputObj->setEventsTime($value["events_time"]);
        }
        
        //put data[] in to $response object
        $response = [];
        $response['data'] = $data;

        //echo #response as a json object
        $jsonObj = json_encode($response);
        // echo $jsonObj;

    }catch(PDOException $e) {
        echo "Database Failed: " . $e->getMessage();
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="styles/stylesheet_flex_responsive.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            text-align: left;
            word-wrap: wordwrap;
            padding-bottom: 5px;
            padding-right: 20px;
        }

        .tableTitle {
            font-weight: bold;
        }
        .border {
            border-bottom: 1px solid black;
        }
    </style>
</head>

    <div class="wrapper">
        <header>
            <h1>WDV341 Intro PHP</h1>
            <h2>Unit 8-1: PHP-JSON Event Object</h2>
        </header>

        <section class="frame">
            <h3></h3>

            <table>
            <tr class="tableTitle">
                <td>Event Name</td>
                <td>Event Desription</td>
                <td>Event Presenter</td>
                <td>Event Date</td>
                <td>Event Time</td>
            </tr>
            <?php
                foreach($data as $value){
                    echo "<tr>";
                    echo "<td>" . $value["events_name"] . "</td>";
                    echo "<td>" . $value["events_description"] . "</td>";
                    echo "<td>" . $value["events_presenter"] . "</td>";
                    echo "<td>" . $value["events_date"] . "</td>";
                    echo "<td>" . $value["events_time"] . "</td>";
                    echo "</tr><br />";
                }
            ?>
        </table>

        <table>
            <tr class="tableTitle">
                <td>JSON Object</td>
            </tr>
            <tr>
                <td>  <?php echo $jsonObj ?>  </td>
            
            </tr>
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

<!-- Create a SELECT statement that will pull one row/event from your wdv341_events table. 
Use SQL WHERE clause to limit the result set to one, and prepare your statement before execution.
Format the result into a PHP associative array by setting the PDO fetch style. 
This will turn the result object row into an associative array using the column names as the indexes.
Create a Class called Event and give it a property for every column in your wpdv341_events table 
    (excluding the date_inserted/update columns). There are a couple of ways to make the properties 
    editable by your code. Both have their place and will work. Please understand why you would use either of them.
You can make the properties public so they can be mutated on the fly
You can make the properties private and create public getters and setters to let users modify their values
Create a PHP object called $outputObj and assign it to be an instance of the Event class.
Assign a value to each property of your $outputObj instance based on the row you pulled from your DataBase (DB). 
    There are a few of ways to do this
        You can manually set each property value (if the properties are public)
        You can set them in the constructor as long as your Class constructor is set up for this
        You can use your setters if you set them up
Encode the $outputObj into a JSON object using json_encode
Echo the JSON object
Test you page and view the response in your localhost browser. -->