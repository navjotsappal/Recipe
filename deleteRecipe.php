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
$category=$_REQUEST["category"];
$userId=$_SESSION['uid'];

$errorMessage_permissionDenied="";

if(isset($_POST['delete'])){

    readRecipe($errorMessage_permissionDenied);

    if(empty($errorMessage_permissionDenied))
    {
        deleteRecipe();
    }

}

else if(isset($_POST['cancel'])){
    redirectBack($category);
}

function deleteRecipe(){
    try
    {
        $recipeID = $_REQUEST["q"];
        $category=$_REQUEST["category"];
        //echo "inside delete".$category;

           //die;
        $userId=$_SESSION['uid'];
        $serverName = "db.cs.dal.ca"; // https://www.w3schools.com/php/php_mysql_insert.asp
        $dbUsername = "sappal";
        $dbPassword = "B00786813";
        $dbName = "sappal";

        // check if same user requests to view this recipe
        $connection = new PDO("mysql:host=$serverName;dbname=$dbName", $dbUsername, $dbPassword); //setting the connection: source: https://www.w3schools.com/php/php_mysql_insert.asp
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // setting PDO error mode to the exception mode,source: https://www.w3schools.com/php/php_mysql_insert.asp

        $sql = "Delete FROM recipe WHERE recipeId = :recipeId and userId=:userId and category=:category";  //preparing the SQL statement, source: http://thisinterestsme.com/php-user-registration-form/
        $statement = $connection->prepare($sql);
        $statement->bindValue(':recipeId', $recipeID);     //binding recipeName to prepare statement, then execute the statement. source: http://thisinterestsme.com/php-user-registration-form/
        $statement->bindValue(':userId', $userId);
        $statement->bindValue(':category', $category);
        $statement->execute(); //Fetch row.

        // recipe deleted successfully.
        $errorMessage_permissionDenied="done";
        $url="myRecipes.php?selectCategory=".$category."&submit=VIEW+RECIPES";
        //$url="myRecipes.php";
        header('Location:'.$url);
        exit();

    }

    catch(PDOException $e)       //catching exception, source : https://www.w3schools.com/php/php_mysql_insert.asp
    {

        $errorMessage_permissionDenied= $e." 1) Fail to delete the data from the database  2) Fail to set up the database connection";

    }

    $connection = null;
}

function redirectBack($category){
    //echo "inside redirect ".$category;
    //die;
    $url="myRecipes.php?selectCategory=".$category."&submit=VIEW+RECIPES";
    //$url="myRecipes.php";
    header('Location:'.$url);
    exit();
}

function readRecipe(&$errorMessage_permissionDenied){

    $recipeId=$_REQUEST["q"];
    $userId=$_SESSION['uid'];

    try
    {
        // check if same user requests to update this recipe

        $serverName = "db.cs.dal.ca"; // https://www.w3schools.com/php/php_mysql_insert.asp
        $dbUsername = "sappal";
        $dbPassword = "B00786813";
        $dbName = "sappal";

        $connection = new PDO("mysql:host=$serverName;dbname=$dbName", $dbUsername, $dbPassword); //setting the connection: source: https://www.w3schools.com/php/php_mysql_insert.asp
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // setting PDO error mode to the exception mode,source: https://www.w3schools.com/php/php_mysql_insert.asp

        $sql = "SELECT recipeName,category,preparationTime,cookTime,servings,rating,imageURL,videoURL,ingredients,directions,description,notesComments,collaborateEmail,timeShareEmail,timeShareTime,recipeCreationTime,timeShareToken FROM recipe WHERE recipeId = :recipeId and userId=:userId";  //preparing the SQL statement, source: http://thisinterestsme.com/php-user-registration-form/
        $statement = $connection->prepare($sql);
        $statement->bindValue(':recipeId', $recipeId);     //binding recipeName to prepare statement, then execute the statement. source: http://thisinterestsme.com/php-user-registration-form/
        $statement->bindValue(':userId', $userId);
        $statement->execute(); //Fetch row.
        $row = $statement->fetch(PDO::FETCH_ASSOC);

        if($row===false){                                     //email exists already, source: http://thisinterestsme.com/php-user-registration-form/

            $errorMessage_permissionDenied="Request rejected! You do not have permission to delete this recipe!";


        }

        else {


            $recipeName=$row['recipeName'];
            $collaborateEmail=$row['collaborateEmail'];
            $shareEmail=$row['timeShareEmail'];

            if(!empty($collaborateEmail)  )
            {
                if(sendDeleteRecipeNotificationToCollaboratedUser($collaborateEmail,$recipeName))
                {
                    $errorMessage_permissionDenied="";
                }

                else{
                    $errorMessage_permissionDenied="Unable to send recipe deletion notification to collaborated user. ";
                }

            }

            if(!empty($shareEmail))
            {
                if (sendDeleteRecipeNotificationToTimeSharedUser($shareEmail,$recipeName))
                {
                    $errorMessage_permissionDenied="";
                }

                else{
                    $errorMessage_permissionDenied="Unable to send recipe deletion notification to the person with whom recipe was time shared.";
                }
            }




        }


    }

    catch(PDOException $e)       //catching exception, source : https://www.w3schools.com/php/php_mysql_insert.asp
    {

        $userMessageRecipeCreationFail=" 1) Fail to insert the data into the database  2) Fail to set up the database connection";

    }

    $connection = null;

}
function sendDeleteRecipeNotificationToCollaboratedUser($collaborateEmail,$recipeName){

    $url="https://web.cs.dal.ca/~sappal/Recipe/signIn.php";      // Create a link in the email message , source: https://www.dreamincode.net/forums/topic/370692-reset-password-system/
    $subject="Recipe deletion notification !";
    $messageBody = "Dear User,\n\nThis email is sent to let you know, ".strtoupper($_SESSION['firstName'])." has deleted the recipe ".strtoupper($recipeName)." that was collaborated with you. Since the recipe is deleted, you cannot have access to this recipe anymore. \n\nCheers,\nTeam Recipe "; //create parameters for mail(), source:http://codingcyber.org/send-forgotten-password-by-mail-using-php-and-mysql-35/
    $to=$collaborateEmail;
    $header="From:".$_SESSION['email'];       // create parameters for mail(), source:http://codingcyber.org/send-forgotten-password-by-mail-using-php-and-mysql-35/


    if(mail($to,$subject,$messageBody,$header))
    {      // call mail(), Reference ends here,  source:http://codingcyber.org/send-forgotten-password-by-mail-using-php-and-mysql-35/
        return true;
    }
    else
    {
        return false;
    }

}

function sendDeleteRecipeNotificationToTimeSharedUser($collaborateEmail,$recipeName){

    $url="https://web.cs.dal.ca/~sappal/Recipe/signIn.php";      // Create a link in the email message , source: https://www.dreamincode.net/forums/topic/370692-reset-password-system/
    $subject="Recipe deletion notification !";
    $messageBody = "Dear User,\n\nThis email is sent to let you know, ".strtoupper($_SESSION['firstName'])." has deleted the recipe ".strtoupper($recipeName)." that was timeshared with you. Since the recipe is deleted, you cannot have access to this recipe anymore. \n\nCheers,\nTeam Recipe "; //create parameters for mail(), source:http://codingcyber.org/send-forgotten-password-by-mail-using-php-and-mysql-35/
    $to=$collaborateEmail;
    $header="From:".$_SESSION['email'];       // create parameters for mail(), source:http://codingcyber.org/send-forgotten-password-by-mail-using-php-and-mysql-35/


    if(mail($to,$subject,$messageBody,$header))
    {      // call mail(), Reference ends here,  source:http://codingcyber.org/send-forgotten-password-by-mail-using-php-and-mysql-35/
        return true;
    }
    else
    {
        return false;
    }

}
?>


<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Recipe</title>
    <link rel="shortcut icon" type="image/x-icon" href="images/Recipe_Book.ico" /> <!-- icon source: https://www.iconfinder.com/icons/89064/book_recipe_icon-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/normalize.css">  <!-- normalize stylesheet "https://github.com/necolas/normalize.css"/-->
    <link rel="stylesheet" href="css/createRecipe.css">
    <meta name="HandledFriendly" content="true">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">  <!-- force IE compatibility mode off , "https://stackoverflow.com/questions/3449286/force-ie-compatibility-mode-off-using-tags?utm_medium=organic&utm_source=google_rich_qa&utm_campaign=google_rich_qa" -->


    <script src="js/createRecipe.js"></script>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">

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



<div class="container enclosedContainer" >
    <div class="container containerWidth deleteConfirmation" style="background-color: #f8d7da !important;">
        <form method="post" action="<?php echo htmlentities($_SERVER["PHP_SELF"] . '?'.http_build_query($_GET));?>">

        <div class="container">
            <div class="row">
                <br>
                <div class="col text-center" style="margin-top: 3em;">
                    <span class="titleHeading" style="padding: 3em 0.5em; color: #DE1643 !important;"><b> Confirmation Required ! </b></span>

                    <p style="margin-top: 1em; font-size: 1.25em!important;">Are you sure you want to delete this recipe ? </p>
                    <p style="margin-top: 1em;font-size: 1.25em!important;">This action cannot be undone. </p>

                    <div class="CreateRecipeButton">
                        <input style="background-color: #DE1643; color: white;" type="submit" value="DELETE" name="delete">
                    </div>

                    <div class="CreateRecipeButton" style="margin-bottom: 4em;">
                        <input type="submit" value="CANCEL" name="cancel">
                    </div>
                </div>

            </div>
        </div>

        </form>
    </div>
</div>


<div class="bottom">
    <?php
    require('includes/footer.php');     // php template to include header
    ?>
</div>


</body>
</html>
