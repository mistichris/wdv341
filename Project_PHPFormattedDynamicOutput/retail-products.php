<?php

try {
    //#1
    require '../dbConnect.php';

    //#2
    $sql = "SELECT * FROM wdv341_products";
    //put sql query in own variable: SELECT column_name FROM table_name;

    #3 Prepared statement PDO - returns statement object/value, need to catch it in variable '$stmt'
    $stmt = $conn->prepare($sql);       //$conn from dbConnect.php file


    //#4 - Bind Parameters -NA
    // $stmt->bindParam(':productName', $eventsID);

    //#5 - Execute the PDO Statement/save results in $stmt object
    $stmt->execute();

    //#6 - Process the results from the query
    $stmt->setFetchMode(PDO::FETCH_ASSOC);    //tells it that everytime it runs $stmt to return values as an ASSOC array

} catch (PDOException $e) {
    echo "Database Failed: " . $e->getMessage();
}
?>

<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Untitled Document</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles/productStyles.css">
    <link rel="stylesheet" type="text/css" href="../styles/stylesheet_flex_responsive.css">
    <style>

    </style>
</head>

<body>

    <header>
        <h1>DMACC Electronics Store!</h1>
        <p>Products for your Home and School Office</p>
    </header>
    <section>
        <!-- This .productBlock is an example displaying the format/structure of each product.
        It will be replaced by the actual data. Please loop through all of your products and display them using
        this layout and following the instructions of the assignment. -->
        <?php
        while ($productRow = $stmt->fetch()) {

            //  " . $productRow["product_"] . "

            echo "<div class=\"productBlock\">";
            echo "<div class=\"productImage\">";
            echo "<image src=\"../productImages/" . $productRow["product_image"] . "\">";
            echo "</div>";
            echo "<p class=\"productName\">" . $productRow["product_name"] . "\" Monitor</p>";
            echo "<p id='prodDesc' class=\"productDesc\">" . $productRow["product_description"] . "</p>";
            echo "<p class=\"productPrice\">$" . $productRow["product_price"] . "</p>";
            echo "<!-- The productStatus element should only be displayed if there is product_status data in the record -->";
            if ($productRow["product_status"]) {
                echo "<p class=\"productStatus\">" . $productRow["product_status"] . "</p>";
            }
            if ($productRow["product_inStock"] < 10) {
                echo "<p class=\"productLowInventory\">" . $productRow["product_inStock"] . " In Stock!</p>";
            } else {
                echo "<p class=\"productInventory\">" . $productRow["product_inStock"] . " In Stock!</p>";
            }
            echo "</div>";
        }
        ?>
    </section>


    <div class="footer">
        <a class="" href="../../wdv341Homework.php">WDV341 Homework Page</a>
        <a href="https://github.com/mistichris/wdv341.git">Git Hub Link</a>
        <a class="" href="../../../index.html">Christianson Home Page</a>
    </div>

    <p>&nbsp;</p>

</body>

</html>


<!-- 
    Your program should pull all rows from the table.
    Sort in Descending order by product name. 
    For each row in your table format the content as described in the comments on the 
        retail-products.php file.

    -If there is content in the product_status field display the contents and apply the 
        productStatus class to the p container.
    -If the product_inventory is less than 10 then apply the productLowInventory class 
        to the inventory p container.
-->