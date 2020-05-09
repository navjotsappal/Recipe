<?php
/**
 * Created by PhpStorm.
 * User: Collins
 * Date: 19/01/2019
 * Time: 11:08 AM
 */

error_reporting(E_ALL); ini_set('display_errors', 1);
session_start();
if(!isset($_SESSION["email"]))
{
    header('Location: index.php');
}

$userId=$recipeName=$selectCategory=$rating="";
$checkValidations=true;

//print_r($_GET['selectCategory']);

$errorMessage_noCategorySelected=$errorMessage_noRecipeFound= $errorMessage_noRecipeInCategory=$errorMessage_noRecipeCollaborated="";
$errorMessage_noEditorRecipe="";
$checkValidations=true;
//$selectCategory=$_GET["selectCategory"];

$userId=$_SESSION['uid'];
$collaborateEmail=$_SESSION['email'];

function fetchUserName($usersId){

    try {

        $serverName = "db.cs.dal.ca"; // https://www.w3schools.com/php/php_mysql_insert.asp
        $dbUsername = "sappal";
        $dbPassword = "B00786813";
        $dbName = "sappal";

        $connection = new PDO("mysql:host=$serverName;dbname=$dbName", $dbUsername, $dbPassword); //setting the connection: source: https://www.w3schools.com/php/php_mysql_insert.asp
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // setting PDO error mode to exception mode, source: https://www.w3schools.com/php/php_mysql_insert.asp
        $sql = "SELECT firstName FROM tb_users WHERE uid = :uid";  //preparing SQL statement, source: http://thisinterestsme.com/php-user-registration-form/
        $statement = $connection->prepare($sql);

        $statement->bindValue(':uid', $usersId);     //bind email to prepare statement, execute the statement, source:http://thisinterestsme.com/php-user-registration-form/
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC); //fetch required row containing email.


        if($row === false){
            //username doesn't exist, source: http://thisinterestsme.com/php-user-registration-form/

            $errorMessage="Fail to fetch name !";
            return $errorMessage;

        }

        else{     //username exists in db, check password,and then redirect to index.php
             return $row['firstName'];

        }

    }

    catch(PDOException $e)       //catch exception, source: https://www.w3schools.com/php/php_mysql_insert.asp
    {
        return $errorMessage="Fail to set up database connection while fetching owners first name.";
        // echo $e." <h5 style='color: red'>Sorry! 1) Unable to set up database connection  or 2) Unable to insert data into the database  </h5>";

    }


    //$connection = null;  // releasing PDO connection


}


?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Recipes</title>
    <link rel="shortcut icon" type="image/x-icon" href="images/Recipe_Book.ico" /> <!-- icon source: https://www.iconfinder.com/icons/89064/book_recipe_icon-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/normalize.css">  <!-- normalize stylesheet "https://github.com/necolas/normalize.css"/-->


    <meta name="HandledFriendly" content="true">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">  <!-- force IE compatibility mode off , "https://stackoverflow.com/questions/3449286/force-ie-compatibility-mode-off-using-tags?utm_medium=organic&utm_source=google_rich_qa&utm_campaign=google_rich_qa" -->


    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/myRecipes.css">
    <script src="js/myRecipes.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> <!-- source:https://www.w3schools.com/howto/howto_css_icon_buttons.asp -->


    <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.7.0/css/all.css' integrity='sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ' crossorigin='anonymous'> <!-- source: https://www.w3schools.com/icons/tryit.asp?icon=fas_fa-trash-alt&unicon=f2ed-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css"> <!-- source: https://www.w3schools.com/bootstrap/bootstrap_get_started.asp-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>



</head>

<body>

<div class="top">
    <?php
    require('includes/headerLoggedInUser.php');     // php template to include header
    ?>
</div>

<div class="container outerContainer">
<div class="container containerBorder" >

    <div class="row" style="background-color: #fcf3ef !important;">
        <form method="get" enctype="multipart/form-data" action="<?php echo htmlentities($_SERVER["PHP_SELF"]);?>">

        <div class="col text-center">
            <h3 class="headingForLabel">Select a category to view your recipes</h3>

        </div>

        <div class="col text-center">
            <select class="selectCategory"  name="selectCategory" size="1" id="selectCategory" ">

            <?php
            require("includes/Dal_Login_Credentials.php");

            try{
                $connection = new PDO("mysql:host=$serverName;dbname=$dbName", $dbUsername, $dbPassword); //setting the connection: source: https://www.w3schools.com/php/php_mysql_insert.asp
                $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // setting PDO error mode to the exception mode,source: https://www.w3schools.com/php/php_mysql_insert.asp

                $sql = "SELECT DISTINCT lower(category) FROM recipe WHERE userId=:userId";  //preparing the SQL statement, source: http://thisinterestsme.com/php-user-registration-form/
                $statement = $connection->prepare($sql);
                $statement->bindValue(':userId', $userId);
                $statement->execute(); //Fetch row.
               // $row = $statement->fetch(PDO::FETCH_ASSOC);

                $result=$statement->fetchALL();
                //print_r($result[0][0]);
                //print_r(var_dump($result));
                if(empty($result)){
                    $errorMessage_noRecipeFound="Sorry ! You don't appear to have any recipes in your account !  Click on \"Add Recipe\" to create a new recipe.";

                }
                else{
                    ?>
                    <?php
                    // there are categories in user account, display those categories in select
                    foreach($result as $val){
                        ?>
                        <option value='<?php echo $val[0] ?>' <?php if(isset($_GET['selectCategory'])){if(strcmp($val[0],$_GET['selectCategory'])==0){echo "selected='selected'";}}?> ><?php echo $val[0] ?></option>

                       <!-- --><?php /*if($selectCategory=="Indian"){echo "selected='selected'";}*/?>

                        <?php
                   }
                }

            }

            catch(PDOException $e)       //catching exception, source : https://www.w3schools.com/php/php_mysql_insert.asp
            {
                $errorMessage_noRecipeFound="Fail to populate select by setting up the database connection";
            }
            ?>

            </select>
        </div>

        <div class="col text-center">
            <input id="viewRecipeButton" type="submit" value="VIEW RECIPES" name="submit"  <?php if(!empty($errorMessage_noRecipeFound)){?> disabled <?php }?> >
        </div>
        </form>

    </div>


</div>
</div>

<div class="container outerContainer">
    <div class="container containerEditorHeading">
        <div class="row text-center">
            <img src="images/shareRecipe.png" class="roundImage" >
            <!-- image source: https://www.kisspng.com/png-cooking-vegetable-food-illustration-vector-recipes-525785/-->

            <h3 class="editorsFavourite"><b>My recipes </b></h3>
        </div>
    </div>
</div>


<div class="container outerContainer">
<div class="container containerBorder">

    <div class="row">


        <?php
        require("includes/Dal_Login_Credentials.php");
       // print_r($_GET['submit']);
        if((isset($_GET['submit'])) ) {

            $selectCategory=strtolower($_GET['selectCategory']);
           // echo "ok>>>> ".$selectCategory;
            try {
                $connection = new PDO("mysql:host=$serverName;dbname=$dbName", $dbUsername, $dbPassword); //setting the connection: source: https://www.w3schools.com/php/php_mysql_insert.asp
                $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // setting PDO error mode to the exception mode,source: https://www.w3schools.com/php/php_mysql_insert.asp

                $sql = "SELECT recipeId,recipeName,imageURL,rating,description FROM recipe WHERE userId=:userId and lower(category)=:category";  //preparing the SQL statement, source: http://thisinterestsme.com/php-user-registration-form/
                $statement = $connection->prepare($sql);
                $statement->bindValue(':userId', $userId);
                $statement->bindValue(':category', $selectCategory);
                $statement->execute(); //Fetch row.
                $result = $statement->fetchALL();
                //print_r($result[0][0]);
                //echo $userId.$selectCategory;
                //var_dump($result);

                if (empty($result)) {
                    $errorMessage_noRecipeInCategory = "Your recipe has been deleted. Please change category to view other recipes !";
                } else {
                    // there are recipes in this category, display those recipes in col
                    foreach ($result as $val) {
                        ?>
                        <div class="col colFixedHeight">
                            <a title="View recipe" class="anchor" href="viewRecipe.php?q=<?php echo$val[0]?>" >

                                <img class="image" src="<?php echo$val[2]?>" alt="<?php echo$val[1]?>">
                                <h3 class="heading"><?php echo$val[1]?></h3>
                                <!-- reference starts here, css code for star rating below is referenced from source: https://www.cssscript.com/simple-5-star-rating-system-with-css-and-html-radios/ -->
                               

                                <div  class="starRating readOnly">

                                    <input class="star starFive"  type="radio" id="starFive" <?php if ((int)($val[3]>=5))echo "checked";?>/>  <!-- source: https://stackoverflow.com/questions/27082153/retain-radio-button-selection-after-submit-php-->
                                    <label class="star starFive" for="starFive"></label>

                                    <input class="star starFour" type="radio" id="starFour" <?php if ((int)($val[3]>=4))echo "checked";?>/>
                                    <label class="star starFour" for="starFour"></label>

                                    <input class="star starThree"  type="radio" id="starThree" <?php if ((int)($val[3]>=3))echo "checked";?>/>
                                    <label class="star starThree" for="starThree"></label>

                                    <input class="star starTwo" type="radio" id="starTwo" <?php if ((int)($val[3]>=2))echo "checked";?>/>
                                    <label class="star starTwo" for="starTwo"></label>

                                    <input class="star starOne"  type="radio" id="starOne"  <?php if ((int)($val[3]>=1))echo "checked";?>/>
                                    <label class="star starOne" for="starOne"></label>

                                </div>
                                <!-- reference starts here, css code for star rating above is referenced from source: https://www.cssscript.com/simple-5-star-rating-system-with-css-and-html-radios/ -->

                                <p class="paragraph"><?php echo$val[4]?></p>
                            </a>


                            <button title="Edit recipe" class="updateButton" onclick="window.location='updateRecipe.php?q=<?php echo $val[0] ?>'"> <i class="fa fa-edit"></i></button> <!-- sources: https://www.w3schools.com/icons/fontawesome5_icons_editors.asp, https://www.w3schools.com/howto/howto_css_icon_buttons.asp -->

                            <button title="Delete recipe" onclick="window.location='deleteRecipe.php?q=<?php echo $val[0]?>&category=<?php echo $selectCategory?>'" class="deleteButton" > <i class="fas fa-trash-alt"></i></button> <!-- sources: https://www.w3schools.com/icons/fontawesome5_icons_editors.asp, https://www.w3schools.com/howto/howto_css_icon_buttons.asp -->



                        </div>


                        <?php
                    }
                }

            }

            catch (PDOException $e)       //catching exception, source : https://www.w3schools.com/php/php_mysql_insert.asp
            {
                $errorMessage_noRecipeFound = $e." Fail to fetch recipes while setting up the database connection";
            }

        }
        ?>

    </div>

</div>
</div>

<div class="container outerContainer">
    <div class="container">
        <?php
        if(!empty($errorMessage_noRecipeFound))
        {
            ?>
            <div class="row text-center" style="background-color:#f8d7da !important;">         <!-- row created, source: https://www.w3schools.com/css/tryit.asp?filename=trycss_form_responsive-->

                <div class="customAlert">
                    <h3 class="errorColor"><span class="glyphicon glyphicon-remove-circle errorColor"></span><strong> No Recipes Found !</strong></h3>
                    <h5 class="errorColor"><?php echo $errorMessage_noRecipeFound ?></h5>
                </div>

            </div>
            <?php
        }
        ?>

        <?php
        if(!empty($errorMessage_noRecipeInCategory))
        {
            ?>
            <div class="row text-center" style="background-color:#d4edda !important;">         <!-- row created, source: https://www.w3schools.com/css/tryit.asp?filename=trycss_form_responsive-->

                <div class="customAlert">
                    <h3 class="successColor"><span class="glyphicon glyphicon-ok successColor"></span><strong>  Recipe deleted successfully !</strong></h3>
                    <h5 class="successColor"><?php echo $errorMessage_noRecipeInCategory ?></h5>
                </div>

            </div>
            <?php
        }
        ?>
    </div>
</div>

<div class="container outerContainer">
    <div class="container containerEditorHeading">
        <div class="row text-center">
            <img src="images/collaborate.jpg" class="roundImage" >
            <!-- image source: http://freeiconshop.com/icon/share-icon-flat//-->
            <h3 class="editorsFavourite"><b>Recipes collaborated with you</b></h3>

        </div>
    </div>
</div>


<div class="container outerContainer">
    <div class="container containerBorder">

        <div class="row">


            <?php
            require("includes/Dal_Login_Credentials.php");


                try {
                    $connection = new PDO("mysql:host=$serverName;dbname=$dbName", $dbUsername, $dbPassword); //setting the connection: source: https://www.w3schools.com/php/php_mysql_insert.asp
                    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // setting PDO error mode to the exception mode,source: https://www.w3schools.com/php/php_mysql_insert.asp

                    $sql = "SELECT recipeId,recipeName,imageURL,rating,description,userId FROM recipe WHERE collaborateEmail=:collaborateEmail";  //preparing the SQL statement, source: http://thisinterestsme.com/php-user-registration-form/
                    $statement = $connection->prepare($sql);
                    $statement->bindValue(':collaborateEmail', $collaborateEmail);
                    $statement->execute(); //Fetch row.
                    $result = $statement->fetchALL();
                    //print_r($result[0][0]);
                    //print_r(var_dump($result));
                    if (empty($result)) {
                        $errorMessage_noRecipeCollaborated = "Sorry ! You don't have any recipes collaborated with you!";
                    } else {
                        // there are recipes in this category, display those recipes in col
                        foreach ($result as $val) {
                            ?>
                            <div class="col colFixedHeight">
                                <a class="anchor" href="viewCollaboratedRecipe.php?q=<?php echo$val[0]?>" >

                                    <img class="image" src="<?php echo$val[2]?>" alt="<?php echo$val[1]?>">
                                    <h3 class="heading"><?php echo$val[1]?></h3>
                                    <!-- reference starts here, css code for star rating below is referenced from source: https://www.cssscript.com/simple-5-star-rating-system-with-css-and-html-radios/ -->
                                    <div class="starRating readOnly">

                                        <input class="star starFive"  type="radio" id="starFive" <?php if ((int)($val[3]>=5))echo "checked";?>/>  <!-- source: https://stackoverflow.com/questions/27082153/retain-radio-button-selection-after-submit-php-->
                                        <label class="star starFive" for="starFive"></label>

                                        <input class="star starFour" type="radio" id="starFour" <?php if ((int)($val[3]>=4))echo "checked";?>/>
                                        <label class="star starFour" for="starFour"></label>

                                        <input class="star starThree"  type="radio" id="starThree" <?php if ((int)($val[3]>=3))echo "checked";?>/>
                                        <label class="star starThree" for="starThree"></label>

                                        <input class="star starTwo" type="radio" id="starTwo" <?php if ((int)($val[3]>=2))echo "checked";?>/>
                                        <label class="star starTwo" for="starTwo"></label>

                                        <input class="star starOne"  type="radio" id="starOne"  <?php if ((int)($val[3]>=1))echo "checked";?>/>
                                        <label class="star starOne" for="starOne"></label>

                                    </div>
                                    <!-- reference starts here, css code for star rating above is referenced from source: https://www.cssscript.com/simple-5-star-rating-system-with-css-and-html-radios/ -->
                                    <h4 style="margin-top: -10px !important; margin-bottom: 23px!important; color:#000073!important; font-size:1.25em; ">Created by : <?php echo " ".$fetch=fetchUserName($val[5]);?></h4>
                                    <p class="paragraph"><?php echo$val[4]?></p>
                                </a>

                               <button  title="Edit recipe" class="updateButton" onclick="window.location='updateCollaboratedRecipe.php?q=<?php echo $val[0] ?>'"> <i class="fa fa-edit"></i></button>

                            </div>


                            <?php
                        }
                    }

                }

                catch (PDOException $e)       //catching exception, source : https://www.w3schools.com/php/php_mysql_insert.asp
                {
                    $errorMessage_noRecipeCollaborated = "Fail to fetch collaborated recipes while setting up the database connection";
                }



            ?>

        </div>

    </div>
</div>


<div class="container outerContainer">
    <div class="container">
        <?php
        if(!empty($errorMessage_noRecipeCollaborated))
        {
            ?>

            <div class="row text-center"  style="background-color:#f8d7da !important;">         <!-- row created, source: https://www.w3schools.com/css/tryit.asp?filename=trycss_form_responsive-->

                <div class="customAlert">
                    <h3 class="errorColor"><span class="glyphicon glyphicon-remove-circle errorColor"></span><strong> No collaborated recipes found !</strong></h3>
                    <h5 class="errorColor"><?php echo $errorMessage_noRecipeCollaborated ?></h5>
                </div>

            </div>


            <?php
        }
        ?>
    </div>
</div>

<div class="container outerContainer">
<div class="container containerEditorHeading">
    <div class="row text-center">
        <img src="images/myRecipes.png" class="roundImage" >
        <!-- image source: https://www.kissclipart.com/chef-background-clipart-chef-italian-cuisine-8w7iq0/-->

        <h3 class="editorsFavourite"><b>Recipes you may like</b></h3>
    </div>
</div>
</div>

<div class="container outerContainer">
<div class="container containerBorder">

    <div class="row">


        <?php
        require("includes/Dal_Login_Credentials.php");


        try {
            $editorId=20;
            $connection = new PDO("mysql:host=$serverName;dbname=$dbName", $dbUsername, $dbPassword); //setting the connection: source: https://www.w3schools.com/php/php_mysql_insert.asp
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // setting PDO error mode to the exception mode,source: https://www.w3schools.com/php/php_mysql_insert.asp

            $sql = "SELECT recipeId,recipeName,imageURL,rating,description,userId FROM recipe WHERE userId=:editorId";  //preparing the SQL statement, source: http://thisinterestsme.com/php-user-registration-form/
            $statement = $connection->prepare($sql);
            $statement->bindValue(':editorId', $editorId);
            $statement->execute(); //Fetch row.
            $result = $statement->fetchALL();
            //print_r($result[0][0]);
            //print_r(var_dump($result));
            if (empty($result)) {
                $errorMessage_noEditorRecipe = "Sorry ! We couldn't fetch editor's favorite recipes !";
            } else {
                // there are recipes in this category, display those recipes in col
                foreach ($result as $val) {
                    ?>
                    <div class="col colFixedHeight">
                        <a class="anchor" href="editorFavourite.php?q=<?php echo$val[0]?>" >

                            <img class="image" src="<?php echo$val[2]?>" alt="<?php echo$val[1]?>">
                            <h3 class="heading"><?php echo$val[1]?></h3>
                            <!-- reference starts here, css code for star rating below is referenced from source: https://www.cssscript.com/simple-5-star-rating-system-with-css-and-html-radios/ -->
                            <div class="starRating readOnly">

                                <input class="star starFive"  type="radio" id="starFive" <?php if ((int)($val[3]>=5))echo "checked";?>/>  <!-- source: https://stackoverflow.com/questions/27082153/retain-radio-button-selection-after-submit-php-->
                                <label class="star starFive" for="starFive"></label>

                                <input class="star starFour" type="radio" id="starFour" <?php if ((int)($val[3]>=4))echo "checked";?>/>
                                <label class="star starFour" for="starFour"></label>

                                <input class="star starThree"  type="radio" id="starThree" <?php if ((int)($val[3]>=3))echo "checked";?>/>
                                <label class="star starThree" for="starThree"></label>

                                <input class="star starTwo" type="radio" id="starTwo" <?php if ((int)($val[3]>=2))echo "checked";?>/>
                                <label class="star starTwo" for="starTwo"></label>

                                <input class="star starOne"  type="radio" id="starOne"  <?php if ((int)($val[3]>=1))echo "checked";?>/>
                                <label class="star starOne" for="starOne"></label>

                            </div>
                            <!-- reference starts here, css code for star rating above is referenced from source: https://www.cssscript.com/simple-5-star-rating-system-with-css-and-html-radios/ -->
                            <h4 style="margin-top: -10px !important; margin-bottom: 23px!important; color:#000073!important; font-size:1.25em; ">Created by : Editor </h4>
                            <p class="paragraph"><?php echo$val[4]?></p>
                        </a>
                    </div>


                    <?php
                }
            }

        }

        catch (PDOException $e)       //catching exception, source : https://www.w3schools.com/php/php_mysql_insert.asp
        {
            $errorMessage_noEditorRecipe = "Fail to fetch editor's favorite recipes while setting up the database connection";
        }



        ?>

    </div>

</div>
</div>

<div class="container outerContainer">
    <div class="container">
        <?php
        if(!empty($errorMessage_noEditorRecipe))
        {
            ?>

            <div class="row text-center"  style="background-color:#f8d7da !important;">         <!-- row created, source: https://www.w3schools.com/css/tryit.asp?filename=trycss_form_responsive-->

                <div class="customAlert">
                    <h3 class="errorColor"><span class="glyphicon glyphicon-remove-circle errorColor"></span><strong> Fail to fetch editor's favorite recipes !</strong></h3>
                    <h5 class="errorColor"><?php echo $errorMessage_noEditorRecipe ?></h5>
                </div>

            </div>


            <?php
        }
        ?>
    </div>
</div>


<div class="bottom">
    <?php
    require('includes/footer.php');     // php template to include header
    ?>
</div>


</body>
</html>
