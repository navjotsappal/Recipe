<?php
/**
 * Created by PhpStorm.
 * User: Collins
 * Date: 31/01/2019
 * Time: 1:12 PM
 */

session_start();
if(!isset($_SESSION["email"]))
{
    header('Location: index.php');
}

$recipeID = $_REQUEST["q"];
$editorId=20;

$userId=$recipeName=$selectCategory=$otherCategory=$preparationTime=$cookTime=$servings=$rating=$imageUpload=$video=$youtubeId="";
$ingredients=$directions=$description=$notesComments=$collaborateEmail=$shareEmail=$shareTime="";
$errorMessage_permissionDenied="";


try
{
    // check if same user requests to view this recipe
    require_once("includes/Dal_Login_Credentials.php"); //my dal's web server credentials

    $connection = new PDO("mysql:host=$serverName;dbname=$dbName", $dbUsername, $dbPassword); //setting the connection: source: https://www.w3schools.com/php/php_mysql_insert.asp
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // setting PDO error mode to the exception mode,source: https://www.w3schools.com/php/php_mysql_insert.asp

    $sql = "SELECT recipeName,category,preparationTime,cookTime,servings,rating,imageURL,videoURL,ingredients,directions,description,notesComments,collaborateEmail,timeShareEmail,timeShareTime FROM recipe WHERE recipeId = :recipeId and userId=:editorId";  //preparing the SQL statement, source: http://thisinterestsme.com/php-user-registration-form/
    $statement = $connection->prepare($sql);
    $statement->bindValue(':recipeId', $recipeID);     //binding recipeName to prepare statement, then execute the statement. source: http://thisinterestsme.com/php-user-registration-form/
    $statement->bindValue(':editorId', $editorId);
    $statement->execute(); //Fetch row.
    $row = $statement->fetch(PDO::FETCH_ASSOC);

    if($row===false){                                     //email exists already, source: http://thisinterestsme.com/php-user-registration-form/

        $errorMessage_permissionDenied="Request rejected! You do not have permission to view this editor's recipe!";
    }

    else {
        $recipeName=$row['recipeName'];
        $selectCategory=$row['category'];
        $preparationTime=$row['preparationTime'];
        $cookTime=$row['cookTime'];
        $servings=$row['servings'];
        $rating=$row['rating'];
        $imageUpload=$row['imageURL'];
        $video=$row['videoURL'];
        $youtubeId="";
        $ingredients=$row['ingredients'];
        $directions=$row['directions'];
        $description=$row['description'];
        $notesComments=$row['notesComments'];
        $collaborateEmail=$row['collaborateEmail'];
        $shareEmail=$row['timeShareEmail'];
        $shareTime=$row['timeShareTime'];

        $explodeIngredients = multiExplodeIngredients(array(",","\r","\n","."),$ingredients);
        $explodeDirections= multiExplodeDirections(array("\r","\n"),$directions);
        $explodeDescription= multiExplodeDirections(array("\r","\n"),$description);
        $explodeNotesComments= multiExplodeDirections(array("\r","\n"),$notesComments);

    }


}

catch(PDOException $e)       //catching exception, source : https://www.w3schools.com/php/php_mysql_insert.asp
{

    $userMessageRecipeCreationFail=" 1) Fail to insert the data into the database  2) Fail to set up the database connection";

}

$connection = null;

// source for 2 functions below :http://php.net/manual/en/function.explode.php
function multiExplodeDirections ($delimiters,$string) {

    $temp = str_replace($delimiters, "!", $string);  // replace all delimiters with !
    $tempArray = explode("!", $temp);  // split string to array using ! as delimiter
    return  $tempArray;
}
function multiExplodeIngredients ($delimiters,$string) {

    $ready = str_replace($delimiters, $delimiters[0], $string);
    $launch = explode($delimiters[0], $ready);
    return  $launch;
}
// source for 2 functions above :http://php.net/manual/en/function.explode.php



?>


<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Editor favorite recipes</title>
    <link rel="shortcut icon" type="image/x-icon" href="images/Recipe_Book.ico" /> <!-- icon source: https://www.iconfinder.com/icons/89064/book_recipe_icon-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/normalize.css">  <!-- normalize stylesheet "https://github.com/necolas/normalize.css"/-->

    <meta name="HandledFriendly" content="true">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">  <!-- force IE compatibility mode off , "https://stackoverflow.com/questions/3449286/force-ie-compatibility-mode-off-using-tags?utm_medium=organic&utm_source=google_rich_qa&utm_campaign=google_rich_qa" -->


    <script src="js/createRecipe.js"></script>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/viewRecipe.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css"> <!-- source: https://www.w3schools.com/bootstrap/bootstrap_get_started.asp-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>


</head>

<body>

<div class="top" style="margin-bottom: -20px">
    <?php
    require('includes/headerLoggedInUser.php');     // php template to include header
    ?>
</div>

<?php
if(!empty($errorMessage_permissionDenied))
{
    ?>
    <div class="container containerWidth" style="margin-top: 1em;">
        <div class="container">
            <div class="row text-center"  style="background-color:#f8d7da !important; margin-top: 1em !important;">         <!-- row created, source: https://www.w3schools.com/css/tryit.asp?filename=trycss_form_responsive-->

                <div class="customAlert" style="height: 20em;">
                    <h3 class="errorColor" style="margin-top: 4em;"><span class="glyphicon glyphicon-ban-circle errorColor"></span><strong> Permission denied !</strong></h3>
                    <h5 class="errorColor"><?php echo $errorMessage_permissionDenied ?></h5>
                </div>

            </div>
        </div>
    </div>

    <?php
}

else{

    ?>
    <div class="container containerWidth">
        <div class="row">
            <div class="columnOne">
                <img class="img" src="<?php echo $imageUpload?>" alt="<?php echo $recipeName;?>"> <!-- image source: https://img.taste.com.au/oZGy-Oqm/w720-h480-cfill-q80/taste/2016/11/satay-chicken-rice-paper-rolls-85577-1.jpeg-->
            </div>
            <div class="columnTwo">
                <h1 class="recipeHeading"><?php echo $recipeName;?></h1>
                <div>
                    <!-- reference starts here, css code for star rating below is referenced from source: https://www.cssscript.com/simple-5-star-rating-system-with-css-and-html-radios/ -->
                    <div class="starRating readOnly">

                        <input class="star starFive"  type="radio" id="starFive" <?php if ((int)($rating>=5))echo "checked";?>/>  <!-- source: https://stackoverflow.com/questions/27082153/retain-radio-button-selection-after-submit-php-->
                        <label class="star starFive" for="starFive"></label>

                        <input class="star starFour" type="radio" id="starFour" <?php if ((int)($rating>=4))echo "checked";?>/>
                        <label class="star starFour" for="starFour"></label>

                        <input class="star starThree"  type="radio" id="starThree" <?php if ((int)($rating>=3))echo "checked";?>/>
                        <label class="star starThree" for="starThree"></label>

                        <input class="star starTwo" type="radio" id="starTwo" <?php if ((int)($rating>=2))echo "checked";?>/>
                        <label class="star starTwo" for="starTwo"></label>

                        <input class="star starOne"  type="radio" id="starOne"  <?php if ((int)($rating>=1))echo "checked";?>/>
                        <label class="star starOne" for="starOne"></label>

                    </div>
                    <!-- reference starts here, css code for star rating above is referenced from source: https://www.cssscript.com/simple-5-star-rating-system-with-css-and-html-radios/ -->
                </div>
                <h4 class="categoryHeading"><b class="categoryHeadingColor">Category :</b> <?php echo $selectCategory;?></h4>
                <h4 class="categoryHeading"><b class="categoryHeadingColor">Preparation Time :</b> <?php echo $preparationTime;?> minutes</h4>
                <h4 class="categoryHeading"><b class="categoryHeadingColor">Cooking Time :</b> <?php echo $cookTime;?> minutes</h4>
                <h4 class="categoryHeading"><b class="categoryHeadingColor">Servings :</b> <?php echo $servings;?> People</h4>
                <h4 class="categoryHeading"> <b class="categoryHeadingColor">Description :</b></h4>
                <div>
                    <p class="paragraphDescription"> <?php echo $description;?></p> <!-- paragraph's text source: https://www.campbells.com/kitchen/recipes/creamy-chicken-marsala/  -->

                </div>
            </div>

        </div>

        <div class="row">
            <div class="columnOne">
                <h4 class="ingredientHeading"> <b>Ingredients :</b></h4>
                <div>
                    <ol>
                        <?php
                        for($i=0;$i<count($explodeIngredients);$i++)
                        {
                            if(strcmp($explodeIngredients[$i],"")==0)
                            {

                            }
                            else {

                                ?>
                                <li class="listIngredients"><p class="paragraphIngredient"><?php echo $explodeIngredients[$i];?></p></li>
                                <?php
                            }

                        }

                        ?>

                    </ol>
                </div>

                <h4 class="directionHeading"> <b class="categoryHeadingColor">Notes/Comments :</b></h4>
                <div>

                    <ol>
                        <?php
                        for($i=0;$i<count($explodeNotesComments);$i++)
                        {
                            if(strcmp($explodeNotesComments[$i],"")==0)
                            {

                            }
                            else {

                                ?>
                                <li class="listIngredients"><p class="paragraphIngredient"><?php echo $explodeNotesComments[$i];?></p></li>
                                <?php
                            }

                        }

                        ?>

                    </ol>

                </div>

            </div>

            <div class="columnTwo">

                <h4 class="directionHeading"> <b class="categoryHeadingColor">Directions :</b></h4>
                <div>

                    <ol>
                        <?php
                        for($i=0;$i<count($explodeDirections);$i++)
                        {
                            if(strcmp($explodeDirections[$i],"")==0)
                            {

                            }
                            else {

                                ?>
                                <li class="listIngredients"><p class="paragraphIngredient"><?php echo $explodeDirections[$i];?></p></li>
                                <?php
                            }

                        }

                        ?>

                    </ol>

                </div>

            </div>

        </div>

        <div class="row">
            <div class="columnOne">

                <h4 class="directionHeading"> <b class="categoryHeadingColor">Watch Video :</b></h4>

                <div class="embed-responsive embed-responsive-16by9"> <!-- code reference: https://getbootstrap.com/docs/4.1/utilities/embed/-->
                    <iframe class="embed-responsive-item" src="<?php echo $video;?>" allowfullscreen></iframe>
                </div>
            </div>

        </div>

    </div>

    <?php

}

?>



<div class="bottom">
    <?php
    require('includes/footer.php');     // php template to include header
    ?>
</div>


</body>
</html>
