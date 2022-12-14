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
                    FROM foods, item_specials
                    WHERE foods.food_id = item_specials.special_id";

    /* Perform the query against the database */
    $this_food_result = mysqli_query($dbcon, $this_food_query);

    /* Fetch the result into an associative array */
    $this_food_record = mysqli_fetch_assoc($this_food_result);


    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>

        <!-- Heading, beginning information -->

        <meta charset="UTF-8">
        <title>Food - Wellington Girls' College Canteen</title>
        <meta name="description" content="WGC Home Page Layout">
        <link href="canteen_style.css" rel="stylesheet" type="text/css">

        <!-- CSS Stylesheet starts -->

        <style>
            <?php include "canteen_style.css" ?>
            .item1 { grid-area: product1; }
            .product-display {
                display: grid;
                grid-column-start: 1;
                grid-column-end: 4;
                grid-template-areas:
                            'product0 product1 product2';
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

    <!-- Navigation bars at the top of the page -->

    <div class="grid-container">
        <div class="grid-item header">
            <a href="http://dtweb.wgc.school.nz/dunnam/school_canteen/canteen_home.php">
            <img src="https://wgc.school.nz/wp-content/uploads/2018/09/WGC_Logo_Transparent_RGB.png"
                 width="53" height="70"
                 alt="The logo of the school.">
            </a>
            <p> <b> WGC Canteen </b> </p>
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

         <div class="grid-item special-display">

         <!-- Introduction to specific page, as well as search form -->

               <p> <b> OUR FOOD MENU FOR 2022 </b> <br>
               Check the information under each food to see the specials!
               Each has a 20% discount. </p>

             <p><b>Search for a food:</b></p>
                <form action="" method="post">
                <input type="text" name="search">
                <input type="submit" name="submit" value="Search">
                </form>
         </div>


        <!-- Display the result of the search -->

            <div class="search-display">

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
                       echo $result_row['food']. " - $";
                       echo $result_row['cost'];
                       echo "<br>";    /* line break */
                      }
                 }
              }
             ?>
            </div>
        </div>

        <!-- All food items on the menu are displayed -->

    <div class="product-display">
    <div class="item1">
    <?php
        echo "<b> COMPLETE FOOD MENU <br><br>";
       while ($food_record = mysqli_fetch_assoc($this_food_result)) {
           echo "<em><b>" . $food_record['food'] . "</b></em><br>";
           echo "$<em>" . $food_record['cost'] . "</em><br>";
           echo "Vegetarian: <em>" . $food_record['vegetarian'] . "</em><br>";
           echo "Vegan: <em>" . $food_record['vegan'] . "</em><br>";
           echo "Allergy Warnings: <em>" . $food_record['allergens'] . "</em><br>";
           echo "Discount on <em>" . $food_record['weekday'] . "</em>";
           echo "In stock: <b>" . $food_record['stock'] . "</b>";
           echo "<p> --:::------::------------------->???<--------------------::------:::--- <br><br>";
    }
    ?>
    </div>
    </div>
    <div class="grid-item special-display">
        <br> <p> ?? Copyright Wellington Girls' College (logo), 2022.
    </div>


    </body>
    </html>
