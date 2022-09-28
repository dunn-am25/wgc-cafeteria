<?php

/* Connect to the database */
$dbcon = mysqli_connect ("localhost", "dunnam", "pinkwhale66",
    "dunnam_cafeteria");

/* Check if DB connection was successful */
if($dbcon == NULL) {
    echo "Could not connect to database";
    exit();
}

/* Food query for all foods */
$food_query = "SELECT food_id, food, cost, stock, allergens, vegetarian, vegan, weekday
                    FROM foods, food_specials
                    WHERE foods.food_id = food_specials.special_id";


/* Queries the database */
$food_result = mysqli_query($dbcon, $food_query);

/* Counts the results */
$food_rows = mysqli_num_rows($food_result);

/* Forms an associative array */
$food_record = mysqli_fetch_assoc($food_result);

/* Runs the result */
$food_query_run = mysqli_query($dbcon, $food_query);

if($food_rows > 0)
{    foreach($food_query_run as $food_list)
    {
    // echo $food_list['food'];
        ?>
            <div>
                <input type="checkbox" name="food[]" value="<?= $food_list['food_id']; ?>">
                <?= $food_list ['weekday']; ?>
            </div>
        <?php
    }

} else {
    echo "No results found.";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Food - Wellington Girls' College Canteen</title>
    <meta name="description" content="WGC Home Page Layout">
    <link href="canteen_style.css" rel="stylesheet" type="text/css">
    <style>
        <?php include "canteen_style.css" ?>
        .item1 { grid-area: product1; }
        .item2 { grid-area: product2; }
        .item3 { grid-area: product3; }
        .item4 { grid-area: product4; }
        .item5 { grid-area: product5; }
        .item6 { grid-area: product6; }

        .product-display {
            display: grid;
            grid-column-start: 1;
            grid-column-end: 4;
            grid-template-areas:
                            'product1 product2 product3'
                            'product4 product5 product6';
            background-color: #f0f5f6ff;
            font-family: 'Source Sans Pro';
            font-size: 30px;
            gap: 10px;
            padding: 10px;
        }

        .product-display > div {
            background-color: white;
            text-align: center;
            padding: 20px 0;
            font-size: 30px;
        }
    </style>
</head>
<body>
<div class="grid-container">
    <div class="grid-item header">
        <img src="https://wgc.school.nz/wp-content/uploads/2018/09/WGC_Logo_Transparent_RGB.png"
             width="53%" height="70%"
             alt="The logo of the school."> <p> <b> WGC Canteen </b> </p>
    </div>
    <div class="grid-item navigation-1">
        <p> <a href="http://dtweb.wgc.school.nz/dunnam/school_canteen/canteen_page_1.html">HOME</a>
        </p>
    </div>
    <div class="grid-item navigation-2">
        <p> <a href="http://dtweb.wgc.school.nz/dunnam/school_canteen/canteen_foods.php">FOOD MENU</a>
        </p>
    </div>
    <div class="grid-item navigation-3">
        <p> <a href="http://dtweb.wgc.school.nz/dunnam/school_canteen/canteen_drinks.php">DRINK MENU</a>
        </p>
    </div>
    <div class="grid-item special-display">
        <p> <b> OUR FOOD MENU FOR 2022 </b> <br>
            The daily special (with a discount) is indicated by a gold star. </p>
        <form name="foods_form" id="foods_form" method = "get" action ='canteen.php'>
            <select id = 'food' name = 'food'>
                <!--options-->
                <?php
                while($food_record = mysqli_fetch_assoc($food_result)){
                    echo "<option value = '".$food_record['food_id'] . "'>";
                    echo $food_record['food'];
                    echo "</option>";
                }

                ?>
            </select>
            <input type="submit" name="food_button" value="Show food information."
        </form>
    </div>
    <div class="product-display">
        <div class="item1">
            <?php
            while($food_record = mysqli_fetch_assoc($food_result)){
                echo "<em>". $food_record['food'] ."</em><br>";
                echo "$<em>" . $food_record['cost'] ."</em><br>";
                echo "Allergy Warnings: <em>" . $food_record['allergens'] ."</em><br>";
                echo "Discount on <em>". $food_record['weekday'] ."</em></p>";
            }

            ?>
        </div>
        <div class="item2">
        </div>
        <div class="item3">Product3</div>
        <div class="item4">Product4</div>
        <div class="item5">Product5</div>
        <div class="item6">Product6</div>
    </div>



</body>
</html>
