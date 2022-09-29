<?php
    $dbcon = mysqli_connect("localhost", "dunnam", "pinkwhale66",
        "dunnam_cafeteria");

    if ($dbcon == NULL) {
        echo "Could not connect to database";
        exit();
    }

    if(isset($_GET['food_id'])) {
        $food_id = $_GET['food_id'];
    } else {
        $food_id = 1;
    }

    /* Create the SQL query */
    $this_food_query = "SELECT food_id, food, cost, stock, allergens, vegetarian, vegan, weekday
                    FROM foods, food_specials
                    WHERE foods.food_id = food_specials.special_id";

    /* Perform the query against the database */
    $this_food_result = mysqli_query($dbcon, $this_food_query);

    /* Fetch the result into an associative array */
    $this_food_record = mysqli_fetch_assoc($this_food_result);


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

            .product-display {
                display: grid;
                grid-column-start: 1;
                grid-column-end: 4;
                grid-template-areas:
                            'product1';
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
            <p> <a href="http://dtweb.wgc.school.nz/dunnam/school_canteen/canteen_home.php">HOME</a>
            </p>
        </div>
        <div class="grid-item navigation-2">
            <p> <a href="http://dtweb.wgc.school.nz/dunnam/school_canteen/canteen_food.php">FOOD MENU</a>
            </p>
        </div>
        <div class="grid-item navigation-3">
            <p> <a href="http://dtweb.wgc.school.nz/dunnam/school_canteen/canteen_drinks.php">DRINK MENU</a>
            </p>
        </div>
    </div>
    <h1>Canteen</h1>
    <!--List the information of the selected food record-->
    <h2>Food Information</h2>
    <div class="grid-item search-display">
        <h2>Food Search</h2>
        <form action="" method="post">
            <input type="text" name="search">
            <input type="submit" name="submit" value="Search">
        </form>


        <!--Display the search result-->
        <?php
        if(isset($_POST['search'])){
            $search = $_POST['search'];

            /* % represents zero or more characters before and after the search term */
            $search_query = "SELECT * FROM foods WHERE foods.food LIKE '%$search%'";
            $search_result = mysqli_query($dbcon, $search_query);
            $search_records = mysqli_num_rows($search_result);

            /* If there are no results found */
            if($search_records == 0){
                echo "There was no results found!";
            } else {    /* Print all results found */
                while ($result_row = mysqli_fetch_array($search_result)) {
                    echo $result_row['food'];
                    echo "<br>";    /* line break */
                }
            }
        }
        ?>
    </div>
    <div class="product-display">
    <div class="item1">
    <?php
       while ($food_record = mysqli_fetch_assoc($this_food_result)) {
           echo "<em><b>" . $food_record['food'] . "</b></em><br>";
           echo "$<em>" . $food_record['cost'] . "</em><br>";
           echo "Vegetarian: <em>" . $food_record['vegetarian'] . "</em><br>";
           echo "Vegan: <em>" . $food_record['vegan'] . "</em><br>";
           echo "Allergy Warnings: <em>" . $food_record['allergens'] . "</em><br>";
           echo "Discount on <em>" . $food_record['weekday'] . "</em></p>";
    }
    ?>
    </div>
    </div>


    </body>
    </html>