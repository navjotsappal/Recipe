<?php
/**
 * Created by PhpStorm.
 * User: Collins
 * Date: 19/01/2019
 * Time: 11:08 AM
 */
// session_start();
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link rel="shortcut icon" type="image/x-icon" href="images/Recipe_Book.ico" /> <!-- icon source: https://www.iconfinder.com/icons/89064/book_recipe_icon-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/normalize.css">  <!-- normalize stylesheet "https://github.com/necolas/normalize.css"/-->


    <meta name="HandledFriendly" content="true">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">  <!-- force IE compatibility mode off , "https://stackoverflow.com/questions/3449286/force-ie-compatibility-mode-off-using-tags?utm_medium=organic&utm_source=google_rich_qa&utm_campaign=google_rich_qa" -->

    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/index.css">


    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css"> <!-- source: https://www.w3schools.com/bootstrap/bootstrap_get_started.asp-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>



</head>

<body>

<div class="top">
    <?php
    require('includes/header.php');     // php template to include header
    ?>
</div>

<div class="midContainer3 container ">                                  <!--outer div for SignUp, source: https://www.w3schools.com/css/tryit.asp?filename=trycss_form_responsive-->
    <div class="row rowWidth">
         <div class="column1 text-center">
            <h1 class="headingOne">Recipe lets you manage, collaborate and time share your recipes.</h1>
             <p class="paraOne">Recipe organizes your custom and private recipes that you can time share and collaborate with your friends, family, and colleagues.   </p>
             <input type="button" class="signUpButton" value="SIGN UP - IT'S FREE !" name="signUp" onclick="window.location='signUp.php';" >
         </div>

         <div class="column2">
            <img class="imageHome" alt="Recipe Image" src="images/maple-roasted-pumpkin-and-chicken-salad.jpeg"  /> <!-- source of image: https://www.taste.com.au/recipes/maple-roasted-pumpkin-chicken-salad/4989e6cb-eeab-4b9e-a852-f8d1f815b3e6-->

         </div>
    </div>
</div>



<div class="midContainer2 container">
    <div class="row">

        <div>
                 <h2 class="headingOne text-center">Recipe your way</h2>
                 <p class="paraOne textAlign padding">Use Recipe the way you cook best. Recipe has all the features and the flexibility to fit your cooking style. </p> <!-- source for content: https://trello.com/-->
        </div>

        </div>

    <div class="row text-center">
        <div class="layoutThreeColumn">
            <div class ="col column3">
                <div >
                    <img class="img" src="images/collaborateTeam.png" alt="Collaborate with team" >

                    <!-- image source: https://www.kisspng.com/png-clip-art-computer-icons-scalable-vector-graphics-e-6435030/download-png.html-->
                </div>

                <h3 class="threeColumnHeading">Collaborate With Team</h3>
                <p class="threeColumnPara"> It's easy to collaborate with team members and work on the same recipe.</p>
                <input type="button" class="signUpButton" value="COLLABORATE" name="signUp" onclick="window.location='signUp.php';" >
                <!-- image source: https://www.kisspng.com/png-computer-icons-teamwork-graphic-design-teamwork-724962/preview.html-->
            </div>

            <div class="col column3">

                <div >
                    <img class="img" src="images/shareRecipe.png" alt="Share your recipes" >
                </div>

                <h3 class="threeColumnHeading">Share Your Recipes</h3>
                <p class="threeColumnPara"> Time share your custom recipes with family and friends and spread love and joy.</p>
                <input type="button" class="signUpButton" value="SHARE RECIPES" name="signUp" onclick="window.location='signUp.php';" >
                <!-- image source: https://www.kisspng.com/png-cooking-vegetable-food-illustration-vector-recipes-525785/-->
            </div>

            <div class="col column3">

                <div >
                    <img class="img" src="images/manageRecipeNew.png" alt="Manage recipes">
                    <!-- image source new: https://roaringapps.s3.amazonaws.com/assets/icons/1373932572177-macgourmet-deluxe.png-->
                    <!-- image source: https://www.clipartmax.com/middle/m2i8K9H7K9d3H7d3_cook-book-clip-art-recipe-clip-art-free/-->
                </div>

                <h3 class="threeColumnHeading">Manage Recipes</h3>
                <p class="threeColumnPara"> With Recipe,it's fun to create, view, rate, update, and delete your custom recipes.</p>
                <input type="button" class="signUpButton" value="MANAGE RECIPES" name="signUp" onclick="window.location='signUp.php';" >
                 <!-- image source: https://www.clipartmax.com/max/m2i8K9H7K9d3H7d3/-->
            </div>

        </div>

    </div>
</div>


<div class="container ">                                  <!--outer div for SignUp, source: https://www.w3schools.com/css/tryit.asp?filename=trycss_form_responsive-->
    <div class="row rowWidth text-center" >
        <h1 class="headingOne text-center" style="margin-bottom:1em;">Features in Recipe</h1>
        <img src="images/sitemap.png" alt="Features in Recipe" style="width: 80%; height:80%; margin-bottom: 1em;">



    </div>
</div>

<div class="bottom">

    <div class="bottomContainer">
        <?php
        require('includes/footer.php');     // php template to include header
        ?>
    </div>
</div>




</body>
</html>
