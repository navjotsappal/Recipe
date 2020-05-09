<?php
/**
 * Created by PhpStorm.
 * User: Collins
 * Date: 19/01/2019
 * Time: 11:08 AM
 */
 session_start();

 if(!isset($_SESSION["email"]))
{
    header('Location: index.php');
}

//error_reporting(E_ALL); ini_set('display_errors', 1);
//echo $_FILES ["fileToUpload"]["error"];
//echo"<<<<<...entereed..." .$_FILES['fileToUpload'];

//var_dump($_POST);
//var_dump($_FILES);

$errorMessage_recipeName=$errorMessage_preparationTime=$errorMessage_cookTime=$errorMessage_servings="";
$errorMessage_otherCategory=$errorMessage_selectCategory=$errorMessage_imageUpload=$errorMessage_rating="";
$errorMessage_video=$errorMessage_ingredients=$errorMessage_directions= $errorMessage_description="";
$errorMessage_notesComments=$errorMessage_collaborateEmail=$errorMessage_shareEmail=$errorMessage_shareTime="";

$errorMessage_recipeNameCSS=$errorMessage_preparationTimeCSS=$errorMessage_cookTimeCSS=$errorMessage_servingsCSS="";
$errorMessage_otherCategoryCSS=$errorMessage_selectCategoryCSS=$errorMessage_imageUploadCSS=$errorMessage_ratingCSS="";
$errorMessage_videoCSS=$errorMessage_ingredientsCSS=$errorMessage_directionsCSS= $errorMessage_descriptionCSS="";
$errorMessage_notesCommentsCSS=$errorMessage_collaborateEmailCSS=$errorMessage_shareEmailCSS=$errorMessage_shareTimeCSS="";


$userId=$recipeName=$selectCategory=$otherCategory=$preparationTime=$cookTime=$servings=$rating=$imageUpload=$video=$youtubeId="";
$ingredients=$directions=$description=$notesComments=$collaborateEmail=$shareEmail=$shareTime=$recipeCreationTime="";

$target_image_path ="";

$userMessageRecipeCreatedSuccessfully=$userMessageRecipeCreationFail="";
$checkValidations=true;

$count=false; // user has not selected a category

$selectCategory=$_POST["selectCategory"];
$rating=$_POST["star"];

$userId=$_SESSION['uid'];
//$errorMessage_imageUpload=imageUpload();
//echo "<<<< ".$errorMessage_imageUpload;
//echo $selectCategory;
$imageUpload=prevent_SQL_Injection_attack(($_POST['fileToUpload']));

$recipeName=prevent_SQL_Injection_attack($_POST["recipeName"]);
$selectCategory=prevent_SQL_Injection_attack($_POST["selectCategory"]);
$otherCategory=prevent_SQL_Injection_attack($_POST["otherCategory"]);
$preparationTime=prevent_SQL_Injection_attack($_POST["preparationTime"]);
$cookTime=prevent_SQL_Injection_attack($_POST["cookTime"]);
$servings=prevent_SQL_Injection_attack($_POST["servings"]);

//$imageUpload=prevent_SQL_Injection_attack($_POST["imageUpload"]);
$rating=prevent_SQL_Injection_attack($_POST["star"]);

$video=prevent_SQL_Injection_attack($_POST["video"]);
$ingredients=prevent_SQL_Injection_attack($_POST["ingredients"]);
$directions=prevent_SQL_Injection_attack($_POST["directions"]);
$description=prevent_SQL_Injection_attack($_POST["description"]);
$notesComments=prevent_SQL_Injection_attack($_POST["notesComments"]);
$collaborateEmail=prevent_SQL_Injection_attack($_POST["collaborateEmail"]);
$shareEmail=prevent_SQL_Injection_attack($_POST["shareEmail"]);
$shareTime=prevent_SQL_Injection_attack($_POST["shareTime"]);

//echo $ingredients;
//echo $selectCategory =="selectCategory";
//echo $selectCategory.strcmp("selectCategory");


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //var_dump($_POST);

    /*echo"heloo....".$_FILES['fileToUpload'];*/
    $errorMessage_imageUpload=imageUpload();

    if(strcmp($selectCategory,"selectCategory")==0){
        $checkValidations=false;
        $errorMessage_selectCategory = "Please select category !";
        $errorMessage_selectCategoryCSS="border-color:#DE1643";
    }

    else{
        $errorMessage_selectCategory="";
        $errorMessage_selectCategoryCSS="border-color:##DCE1EC";

    }

    if(strcmp($selectCategory,"Other")==0 )
    {
        ?>
       <!-- <style type="text/css">
            #hideOtherCategory{
                display: block ;
            }
        </style>-->

        <?php

        if(empty($otherCategory))
        {
            $checkValidations=false;
            $errorMessage_otherCategory="Cannot leave Other category empty !";
            $errorMessage_otherCategoryCSS="border-color:#DE1643";
            //echo $errorMessage_otherCategory;
        }

        else{
            $temp=preg_match("/^([a-zA-Z]{3,20}\s*)+$/",$otherCategory);

            if($temp==true){
                $temp1=strtolower($otherCategory);

                ?>
              <!--  <style type="text/css">
                    #hideOtherCategory{
                        display: block;
                    }
                </style>-->
                <?php

                if((strcmp($temp1,"mexican")==0)||(strcmp($temp1,"indian")==0)||(strcmp($temp1,"chinese")==0)||(strcmp($temp1,"italian")==0)||(strcmp($temp1,"greek")==0)||(strcmp($temp1,"french")==0)||(strcmp($temp1,"spanish")==0)||(strcmp($temp1,"thai")==0) ||(strcmp($temp1,"german")==0) ||(strcmp($temp1,"asian")==0)||(strcmp($temp1,"southern")==0)||(strcmp($temp1,"african")==0)||(strcmp($temp1,"other")==0)) // new category is already in the list
                {
                    $checkValidations=false;
                    $errorMessage_selectCategory=$otherCategory." category is already present in the list!";
                    $errorMessage_selectCategoryCSS="border-color:#DE1643";
                    //$otherCategory="";
                    $selectCategory=$otherCategory;
                    $otherCategory="";

                    ?>
                    <!--<style type="text/css">
                        #hideOtherCategory{
                            display: none;
                        }
                    </style>-->
                    <?php

                }

            }
            else{
                $checkValidations=false;
                $errorMessage_otherCategory="Only letters and white space allowed !";
                $errorMessage_otherCategoryCSS="border-color:#DE1643";

            }

        }



    }

    if (empty($recipeName)|| !preg_match("/^([a-zA-Z]{3,20}\s*)+$/",$recipeName) || strlen($recipeName)>40 )  // only letters and white space are allowed in the last name, source: https://stackoverflow.com/questions/4939722/php-preg-match-with-regex-only-single-hyphens-and-spaces-between-words-continue?utm_medium=organic&utm_source=google_rich_qa&utm_campaign=google_rich_qa
    {
        if(empty($recipeName))
        {
            $checkValidations=false;
            $errorMessage_recipeName = "Cannot leave Recipe Name empty !";
            $errorMessage_recipeNameCSS="border-color:#DE1643";


        }
        else
        {
            $checkValidations=false;
            $errorMessage_recipeName = "Only 3-40 characters and letters,white space are accepted in the Recipe Name.";
            $errorMessage_recipeNameCSS="border-color:#DE1643";
        }
    }

    else if(empty($preparationTime)||!(preg_match("/^[0-9]{1,3}$/",$preparationTime))||strlen($preparationTime)>3 ||$preparationTime>300 ||$preparationTime==0)
    {

        if(empty($preparationTime))
        {
            $checkValidations=false;
            $errorMessage_preparationTime="Cannot leave Preparation Time empty.";
            $errorMessage_preparationTimeCSS="border-color:#DE1643";

        }

        else {
            $checkValidations=false;
            $errorMessage_preparationTime="Please select value between 1 and 300.";
            $errorMessage_preparationTimeCSS="border-color:#DE1643";
        }

    }

    else if(empty($cookTime)||!(preg_match("/^[0-9]{1,3}$/",$cookTime))||strlen($cookTime)>3 ||$cookTime>300 ||$cookTime==0)
    {

        if(empty($cookTime))
        {
            $checkValidations=false;
            $errorMessage_cookTime="Cannot leave Cook Time empty.";
            $errorMessage_cookTimeCSS="border-color:#DE1643";
        }

        else {
            $checkValidations=false;
            $errorMessage_cookTime="Please select value between 1 and 300.";
            $errorMessage_cookTimeCSS="border-color:#DE1643";
        }

    }

    else if(empty($servings)||!(preg_match("/^[0-9]{1,3}$/",$servings))||strlen($servings)>3 ||$servings>100 ||$servings==0)
    {

        if(empty($servings))
        {
            $checkValidations=false;
            $errorMessage_servings="Cannot leave Servings empty.";
            $errorMessage_servingsCSS="border-color:#DE1643";
        }

        else {
            $checkValidations=false;
            $errorMessage_servings="Please select value between 1 and 100.";
            $errorMessage_servingsCSS="border-color:#DE1643";
        }

    }

    else if(isset($_POST['star'])==false)
    {

        $checkValidations=false;
        $errorMessage_rating="Please rate your recipe.";
        $errorMessage_ratingCSS="border-color:#DE1643";

    }

    else if(!empty($errorMessage_imageUpload))
    {

        $checkValidations=false;
        //$errorMessage_imageUpload;
        $errorMessage_imageUploadCSS="background:#DE1643; border:1px solid #DE1643;";

    }

    else if (empty($ingredients)|| !preg_match("/[^\r\n]+((\r|\n|\r\n)[^\r\n]+)*/",$ingredients) )  // source: https://www.regextester.com/96976 //only letters and white space are allowed in the last name, source: https://stackoverflow.com/questions/4939722/php-preg-match-with-regex-only-single-hyphens-and-spaces-between-words-continue?utm_medium=organic&utm_source=google_rich_qa&utm_campaign=google_rich_qa
    {
        if(empty($ingredients))
        {
            $checkValidations=false;
            $errorMessage_ingredients = "Cannot leave Ingredients empty !";
            $errorMessage_ingredientsCSS="border-color:#DE1643";


        }
        else
        {
            $checkValidations=false;
            $errorMessage_ingredients = "Only alphabets,digits,comma, (, ), -, ', /, and space allowed.";
            $errorMessage_ingredientsCSS="border-color:#DE1643";

        }
    }

    else if (empty($directions)|| !preg_match("/[^\r\n]+((\r|\n|\r\n)[^\r\n]+)*/",$directions) )  // source: https://www.regextester.com/96976 // only letters and white space are allowed in the last name, source: https://stackoverflow.com/questions/4939722/php-preg-match-with-regex-only-single-hyphens-and-spaces-between-words-continue?utm_medium=organic&utm_source=google_rich_qa&utm_campaign=google_rich_qa
    {
        if(empty($directions))
        {
            $checkValidations=false;
            $errorMessage_directions = "Cannot leave Directions empty !";
            $errorMessage_directionsCSS="border-color:#DE1643";


        }
        else
        {
            $checkValidations=false;
            $errorMessage_directions = "Only alphabets,digits,comma, (, ), -, ', /, and space allowed.";
            $errorMessage_directionsCSS="border-color:#DE1643";

        }
    }

    else if (empty($description)|| !preg_match("/[^\r\n]+((\r|\n|\r\n)[^\r\n]+)*/",$description) )  // source: https://www.regextester.com/96976 // only letters and white space are allowed in the last name, source: https://stackoverflow.com/questions/4939722/php-preg-match-with-regex-only-single-hyphens-and-spaces-between-words-continue?utm_medium=organic&utm_source=google_rich_qa&utm_campaign=google_rich_qa
    {
        if(empty($description))
        {
            $checkValidations=false;
            $errorMessage_description = "Cannot leave Description empty !";
            $errorMessage_descriptionCSS="border-color:#DE1643";

        }
        else
        {
            $checkValidations=false;
            $errorMessage_description = "Only alphabets,digits,comma, (, ), -, ', /, and space allowed.";
            $errorMessage_descriptionCSS="border-color:#DE1643";

        }
    }

    else if (empty($notesComments)|| !preg_match("/[^\r\n]+((\r|\n|\r\n)[^\r\n]+)*/",$notesComments) ) // source: https://www.regextester.com/96976 // only letters and white space are allowed in the last name, source: https://stackoverflow.com/questions/4939722/php-preg-match-with-regex-only-single-hyphens-and-spaces-between-words-continue?utm_medium=organic&utm_source=google_rich_qa&utm_campaign=google_rich_qa
    {
        if(empty($notesComments))
        {
            $checkValidations=false;
            $errorMessage_notesComments = "Cannot leave Notes/Comments empty !";
            $errorMessage_notesCommentsCSS="border-color:#DE1643";


        }
        else
        {
            $checkValidations=false;
            $errorMessage_notesComments ="Only alphabets,digits,comma, (, ), -, ', /, and space allowed.";
            $errorMessage_notesCommentsCSS="border-color:#DE1643";

        }
    }

    else if (!empty($collaborateEmail))        //validating email format:  source: https://www.w3schools.com/php/showphp.asp?filename=demo_form_validation_complete
    {
        if(!filter_var($collaborateEmail, FILTER_VALIDATE_EMAIL)) {
            $checkValidations = false;
            $errorMessage_collaborateEmail = "Invalid email format !";
            $errorMessage_collaborateEmailCSS="border-color:#DE1643";
        }
    }

    if(!empty($video)){

        /*preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $video, $match); // source: https://gist.github.com/ghalusa/6c7f3a00fd2383e5ef33
        $youtube_Id = $match[1];*/

        list($url,$youtubeId)=explode("?v=",$video); // put first part of youtube address, source:http://php.net/manual/en/function.explode.php

        if(strlen($youtubeId)!=0)
        {
            $errorMessage_video = "";
            $errorMessage_videoCSS="border-color:#DCE1EC";

            //echo "<<<<".$video;
        }

        else{
            $checkValidations = false;
            $errorMessage_video = "Please select URL of the video from YouTube only !";
            $errorMessage_videoCSS="border-color:#DE1643";
        }


    }

    if (!empty($shareEmail))        //validating email format:  source: https://www.w3schools.com/php/showphp.asp?filename=demo_form_validation_complete
    {
        if(!filter_var($shareEmail, FILTER_VALIDATE_EMAIL)) {
            $checkValidations = false;
            $errorMessage_shareEmail = "Invalid email format !";
            $errorMessage_shareEmailCSS="border-color:#DE1643";
        }

        if(empty($shareTime)||!(preg_match("/^[0-9]{1,3}$/",$shareTime))||strlen($shareTime)>3 ||$shareTime>365 ||$shareTime==0)
        {
            if(empty($shareTime))
            {
                $checkValidations = false;
                $errorMessage_shareTime = "Cannot leave number of days empty as you opt to time share a recipe with another user!";
                $errorMessage_shareTimeCSS="border-color:#DE1643";
            }


            else {
                $checkValidations = false;
                $errorMessage_shareTime = "Please select value between 1 and 365.";
                $errorMessage_shareTimeCSS="border-color:#DE1643";
            }
        }

    }
    else{
        $shareEmail="";
        $shareTime="";
    }

    if(!empty($collaborateEmail)|| !empty($shareEmail)){
        if(strcmp($collaborateEmail,$shareEmail)==0)
        {
            $checkValidations=false;
            $errorMessage_shareEmail="Sorry! You can't collaborate and time share a recipe with a same user.";
            $errorMessage_shareEmailCSS="border-color:#DE1643";

        }

        else if (strcmp($collaborateEmail,$_SESSION["email"])==0)
        {
            $checkValidations=false;
            $errorMessage_collaborateEmail="Sorry! You can't collaborate with yourself. Enter a different email.";
            $errorMessage_collaborateEmailCSS="border-color:#DE1643";

        }
        else if (strcmp($shareEmail,$_SESSION["email"])==0)
        {
            $checkValidations=false;
            $errorMessage_shareEmail="Sorry! You can't time share a recipe with yourself. Enter a different email.";
            $errorMessage_shareEmailCSS="border-color:#DE1643";

        }

    }

}



if((isset($_POST['submit'])) and $checkValidations==true) {
    //$userMessageRecipeCreatedSuccessfully="Recipe created successfully !";
    require_once("includes/Dal_Login_Credentials.php"); //my dal's web server credentials


    try
    {
        $tempRecipeName=strtolower($recipeName);
        $userId=$_SESSION['uid'];

        // check if recipe already exists
        $connection = new PDO("mysql:host=$serverName;dbname=$dbName", $dbUsername, $dbPassword); //setting the connection: source: https://www.w3schools.com/php/php_mysql_insert.asp
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // setting PDO error mode to the exception mode,source: https://www.w3schools.com/php/php_mysql_insert.asp

        $sql = "SELECT COUNT(recipeName) AS recipeCount FROM recipe WHERE lower(recipeName) = :recipeName and userId=:userId";  //preparing the SQL statement, source: http://thisinterestsme.com/php-user-registration-form/
        $statement = $connection->prepare($sql);
        $statement->bindValue(':recipeName', $tempRecipeName);     //binding recipeName to prepare statement, then execute the statement. source: http://thisinterestsme.com/php-user-registration-form/
        $statement->bindValue(':userId', $userId);
        $statement->execute(); //Fetch row.
        $row = $statement->fetch(PDO::FETCH_ASSOC);

        if($row['recipeCount'] > 0){                                     //email exists already, source: http://thisinterestsme.com/php-user-registration-form/

            $errorMessage_recipeName="Sorry! Recipe with this name already exists!";
            $errorMessage_recipeNameCSS="border-color:#DE1643";
            goto errorMessageLabel;

        }

        else {
            // recipe is new

            //.....................................

            $flagCollaborateEmail=true;
            $flagImageUpload=true;
            $flagTimeShareEmail=true;

            $tempSelectCategory="";
            $selectCategory=$_POST["selectCategory"];
            if(strcmp($selectCategory,"Other")==0 ){
                $tempSelectCategory=$otherCategory;
            }
            else{
                $tempSelectCategory=$selectCategory;
            }

            $rating=$_POST["star"];

            $target_directory = 'uploads/';
            $target_image_path = $target_directory . basename($_FILES['fileToUpload']['name']); // specifies path of the image to be uploaded
            if(!empty($target_image_path))
            {

                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_image_path)) {
                    //echo "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";
                    $errorMessage_imageUpload = "";
                    $errorMessage_imageUploadCSS="border-color:#DCE1EC";
                }
                else {
                    $errorMessage_imageUpload = "Sorry, we could'nt upload your image. Please try after some time.";
                    $errorMessage_imageUploadCSS="border-color:#DE1643";
                    $flagImageUpload=false;
                }

            }


            if(!empty($collaborateEmail))
            {
                if(collaborateEmailExists($collaborateEmail))
                {
                    // send email if collaborate email exists in db
                    if(sendCollaborateEmail($collaborateEmail,$recipeName))
                    {
                        $errorMessage_collaborateEmail="";
                        $errorMessage_collaborateEmailCSS="border-color:#DCE1EC";
                    }

                    else{
                        $errorMessage_collaborateEmail="Sorry! We couldn't send email for a collaborate request.";
                        $errorMessage_collaborateEmailCSS="border-color:#DE1643";
                        $flagCollaborateEmail=false;
                    }

                }
                else {
                    $errorMessage_collaborateEmail="Sorry! That email is not linked with any account.";
                    $errorMessage_collaborateEmailCSS="border-color:#DE1643";
                    $flagCollaborateEmail=false;
                }


            }



            if(!empty($shareEmail) && !empty($shareTime)){

                $token=md5(mt_rand());
                if(sendTimeShareEmail($token,$shareEmail,$shareTime,$recipeName)){
                    $errorMessage_shareEmail="";
                    $errorMessage_shareEmailCSS="border-color:#DCE1EC";

                    $recipeCreationTime=time();


                }
                else{
                    $errorMessage_shareEmail="Sorry! We couldn't send an email to timeshare your recipe.";
                    $errorMessage_shareEmailCSS="border-color:#DE1643";
                    $flagTimeShareEmail=false;
                    $token="";
                    $recipeCreationTime="";

                }


            }

            if(empty($youtubeId)){
                $video="";
            }
            else{
                $video="https://www.youtube.com/embed/".$youtubeId;
            }



            //.....................................

            if($flagImageUpload==true && $flagCollaborateEmail==true && $flagTimeShareEmail==true)
            {
                $statement = $connection->prepare("INSERT INTO recipe (userId, recipeName, category,preparationTime,cookTime,servings,rating,imageURL,videoURL,ingredients,directions,description,notesComments,collaborateEmail,timeShareEmail,timeShareTime,timeShareToken,recipeCreationTime) 
                                             VALUES (:userId, :recipeName, :category,:preparationTime,:cookTime,:servings,:rating,:imageURL,:videoURL,:ingredients,:directions,:description,:notesComments,:collaborateEmail,:timeShareEmail,:timeShareTime,:timeShareToken,:recipeCreationTime)"); //// bind input values to prepare statement, then execute the statement,  source: http://thisinterestsme.com/php-user-registration-form/



                $statement->bindValue(':userId', $userId);
                $statement->bindValue(':recipeName', $recipeName);
                $statement->bindValue(':category', $tempSelectCategory);                           // source: http://thisinterestsme.com/php-user-registration-form/
                $statement->bindValue(':preparationTime', $preparationTime);
                $statement->bindValue(':cookTime', $cookTime);
                $statement->bindValue(':servings', $servings);
                $statement->bindValue(':rating', $rating);
                $statement->bindValue(':imageURL', $target_image_path);
                $statement->bindValue(':videoURL', $video);
                $statement->bindValue(':ingredients', $ingredients);
                $statement->bindValue(':directions', $directions);
                $statement->bindValue(':description', $description);
                $statement->bindValue(':notesComments', $notesComments);
                $statement->bindValue(':collaborateEmail', $collaborateEmail);
                $statement->bindValue(':timeShareEmail', $shareEmail);
                $statement->bindValue(':timeShareTime', $shareTime);
                $statement->bindValue(':timeShareToken', $token);
                $statement->bindValue(':recipeCreationTime',$recipeCreationTime);


                $result = $statement->execute();

                if($result){
                   $userId="";
                   $recipeName=""; // select category, rating
                   $preparationTime="";
                   $cookTime="";
                   $servings="";

                   $video="";
                   $ingredients="";
                   $directions="";
                   $description="";
                   $notesComments="";
                   $collaborateEmail="";
                   $shareEmail="";
                   $shareTime="";
                   $token="";
                   $otherCategory="";


                    //reference for modal starts here, source:https://getbootstrap.com/docs/4.2/components/modal/
                    //Modal starts, show this modal only when recipe gets added

                       echo "  <div class=\"modal\" data-backdrop=\"static\" id=\"successRecipeCreated\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"ModalCenterTitle\" aria-hidden=\"true\">
                                    <div class=\"modal-dialog modal-dialog-centered\" role=\"document\">
                                      <div class=\"modal-content\">
                                          <div class=\"modal-header\">
                                             <h3 style=\"display: inline-block; color: deepskyblue;\" class=\"modal-title\" id=\"ModalCenterTitle\">Success !</h3>
                                          </div>
                                          <div class=\"modal-body\">
                                             <label style=\"font-size: 1em;\"> Your recipe has been added successfully.</label>
                                             <br><br>
                                            <label style=\"font-size: 1em;\">  Please click on <b>My Recipes</b> to view your recipes.</label>
                                          </div>
                                          <div class=\"modal-footer\">
                                             <button onclick=\"window.location='myRecipes.php';\" style=\"background-color: deepskyblue; color: white;\" type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">My Recipes</button>
                                          </div>
                                     </div>
                                  </div>
                               </div>
                        ";

                    //Modal ends
                    //reference for modal ends here, source:https://getbootstrap.com/docs/4.2/components/modal/


                }

                else{

                    $userMessageRecipeCreationFail="Sorry! We are unable to add your recipe at this time.";
                }
            }

            else{
                goto errorMessageLabel;
            }

        }


    }

    catch(PDOException $e)       //catching exception, source : https://www.w3schools.com/php/php_mysql_insert.asp
    {

        $userMessageRecipeCreationFail=" 1) Fail to insert the data into the database  2) Fail to set up the database connection";

    }

    $connection = null;

}

function prevent_SQL_Injection_attack($parameters) {      // to stop sql injection attack, source:  https://www.w3schools.com/php/showphp.asp?filename=demo_form_validation_complete

    $parameters = htmlspecialchars($parameters);
    $parameters = stripslashes($parameters);
    $parameters = trim($parameters);
    return $parameters;
}

function imageUpload(){
    // reference starts here: source for file upload code: https://www.w3schools.com/php/php_file_upload.asp
    try {

        // reference starts here: source for file upload code: https://www.w3schools.com/php/php_file_upload.asp
        $errorMessage_imageUpload = "";
        $target_directory = 'uploads/';
        $target_image_path = $target_directory . basename($_FILES['fileToUpload']['name']); // specifies path of the image to be uploaded
        $imageExtension = strtolower(pathinfo($target_image_path, PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES['fileToUpload']['tmp_name']);
        //var_dump($check);
        //echo var_dump($_FILES);
        //echo $_FILES['fileToUpload'];
       // print_r($check);

        if ($_FILES["fileToUpload"]["size"] == 0) {
            $errorMessage_imageUpload = "Please select an image (jpg,png,and jpeg) of size upto 2MB.";
        } else if ($_FILES["fileToUpload"]["size"] > 2000000) {
            $errorMessage_imageUpload = "Sorry, your image is too large. Size limit is 2MB.";
        } else if ($imageExtension != "jpg" && $imageExtension != "png" && $imageExtension != "jpeg") {
            $errorMessage_imageUpload = "Sorry, only JPG, JPEG, and PNG  formats are allowed.";
        } else if (file_exists($target_image_path)) {
            $errorMessage_imageUpload = "Sorry, image with same name already exists.";
        } else if ($check == false) {
            $errorMessage_imageUpload = "Please select an image(jpg,png,and jpeg formats only) with size upto 2MB!";
        }
        // Check file size, should not be more than 2MB

        return ($errorMessage_imageUpload);

    }

    catch (Exception $e){
        $errorMessage_imageUpload=$e->getMessage();
    }
// reference ends here: source for file upload code: https://www.w3schools.com/php/php_file_upload.asp

}

function collaborateEmailExists($collaborateEmail){


    try{

        $serverName = "db.cs.dal.ca"; // https://www.w3schools.com/php/php_mysql_insert.asp
        $dbUsername = "sappal";
        $dbPassword = "B00786813";
        $dbName = "sappal";

        $connection = new PDO("mysql:host=$serverName;dbname=$dbName", $dbUsername, $dbPassword); //setting the connection: source: https://www.w3schools.com/php/php_mysql_insert.asp
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // setting PDO error mode to the exception mode,source: https://www.w3schools.com/php/php_mysql_insert.asp


        $sql = "SELECT COUNT(email) AS numcount FROM tb_users WHERE email = :email";  //preparing the SQL statement, source: http://thisinterestsme.com/php-user-registration-form/
        $statement = $connection->prepare($sql);
        $statement->bindValue(':email', $collaborateEmail);     //binding email to prepare statement, then execute the statement. source: http://thisinterestsme.com/php-user-registration-form/
        $statement->execute(); //Fetch row.
        $row = $statement->fetch(PDO::FETCH_ASSOC);


        if($row['numcount'] > 0){                                     //collaborate email exists , source: http://thisinterestsme.com/php-user-registration-form/

           return true;

        }

        else {
            return false;
        }
    }
    catch(PDOException $e)       //catching exception, source : https://www.w3schools.com/php/php_mysql_insert.asp
    {

        $userMessageRecipeCreationFail="Oops ! There is an error in making database connection for sending an email to collaborate on a recipe.";

    }
    $connection = null;
}

function sendCollaborateEmail($collaborateEmail,$recipeName){

    $url="https://web.cs.dal.ca/~sappal/Recipe/signIn.php";      // Create a link in the email message , source: https://www.dreamincode.net/forums/topic/370692-reset-password-system/
    $subject="Request to collaborate on a recipe !";
    $messageBody = "Dear User,\n\n".$_SESSION['firstName']." wants to collaborate with you on a recipe named ".$recipeName.". Please note that you can only view and update that recipe. \n\nYou can view recipes collaborated with you in your My Recipes section. Click on the link below to start collaborating on a recipe.\n\nIn case you are not able to click on the link below, please copy and then paste the link onto your browser's address bar.\n\n" . $url . "\n\nCheers,\nTeam Recipe "; //create parameters for mail(), source:http://codingcyber.org/send-forgotten-password-by-mail-using-php-and-mysql-35/
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

function sendTimeShareEmail($token,$shareEmail,$shareTime,$recipeName){

    $url="https://web.cs.dal.ca/~sappal/Recipe/timeShareRecipe.php?q=".$token;      // Create a link in the email message , source: https://www.dreamincode.net/forums/topic/370692-reset-password-system/
    $subject="Timeshare recipe!";
    $messageBody = "Dear User,\n\n".$_SESSION['firstName']." has given you a read only access to the recipe named ".$recipeName." for ". $shareTime." days. \nPlease view this recipe before the link below expires in ".$shareTime." days.\n\nIn case you are not able to click on the link below, please copy and then paste the link onto your browser's address bar.\n\n" . $url . "\n\nCheers,\nTeamRecipe"; //create parameters for mail(), source:http://codingcyber.org/send-forgotten-password-by-mail-using-php-and-mysql-35/
    $to=$shareEmail;
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

// label when there is problem moving image to uploads folder even after all validation checks
errorMessageLabel:
//$errorMessage_imageUpload = "Sorry, we could'nt upload your image. Please try after some time.";

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

<div class="container enclosedContainer">
<div class="container containerWidth">                                  <!--outer div for SignUp, source: https://www.w3schools.com/css/tryit.asp?filename=trycss_form_responsive-->
    <form method="post" enctype="multipart/form-data" action="<?php echo htmlentities($_SERVER["PHP_SELF"]);?>">

        <div class="container">

         <div class="row"  >  <!-- source:  https://www.w3schools.com/css/tryit.asp?filename=trycss_form_responsive */-->

            <br>
            <h1 class="titleHeading" style="padding: 0 0.5em; margin-bottom: -0.25em;"><b> Add Recipe</b></h1>
            <br>
            <br>

        </div>

            <?php
            if(!empty($userMessageRecipeCreationFail))
            {
                ?>
                <div class="row text-center">         <!-- row created, source: https://www.w3schools.com/css/tryit.asp?filename=trycss_form_responsive-->

                    <div class="alert alert-danger" role="alert">
                        <h3 class="alert-heading errorColor"><span class="glyphicon glyphicon-remove-circle errorColor"></span><strong class="errorColor"> Fail to add recipe !</strong></h3>
                        <h5 class="errorColor">Sorry! We couldn't add your recipe at this time.</h5>
                        <strong class="errorColor">Reason:</strong> <span class="errorColor"><?php echo $userMessageRecipeCreationFail ?> </span>
                    </div>

                </div>
                <?php
            }
            ?>

            <div class="row">                                <!-- source:  https://www.w3schools.com/css/tryit.asp?filename=trycss_form_responsive */-->
            <div class="columnOne">                 <!--for text input in right column, source:  https://www.w3schools.com/css/tryit.asp?filename=trycss_form_responsive */-->
                <div>
                    <label><span class="glyphicon glyphicon-tag"></span> Recipe Name *</label><span class="errorMessage" id="errorMessageRecipeName"><?php echo $errorMessage_recipeName;?></span>
                <input type="text" title="Minimum 3 characters and only letters and space accepted" id="recipeNameInput" required placeholder="Only letters and white space allowed." name="recipeName"  value="<?php echo $recipeName;?>" onchange="validateRecipeName();" style="<?php echo $errorMessage_recipeNameCSS;?>" > <br>

                </div>

                <div>
                    <label> <span class="glyphicon glyphicon-tasks"></span> Category *</label><span class="errorMessage" id="errorMessageSelectCategory"><?php echo $errorMessage_selectCategory;?></span><br>
                    <select class="selectCategory" name="selectCategory" size="1" id="selectCategory"  onchange="fnSelectCategory();" style="<?php echo $errorMessage_selectCategoryCSS;?>">
                        <option value="selectCategory" <?php if($selectCategory=="selectCategory"){echo "selected='selected'";}?>>Select Category</option>
                        <option value="indian" <?php if($selectCategory=="indian"){echo "selected='selected'";}?>> Indian</option>  <!-- source referenced: https://stackoverflow.com/questions/1336353/how-do-i-set-the-selected-item-in-a-drop-down-box-->
                        <option value="mexican" <?php if($selectCategory=="mexican"){echo "selected='selected'";}?>>Mexican</option>
                        <option value="chinese" <?php if($selectCategory=="chinese"){echo "selected='selected'";}?>>Chinese</option>
                        <option value="italian" <?php if($selectCategory=="italian"){echo "selected='selected'";}?>>Italian</option>
                        <option value="greek" <?php if($selectCategory=="greek"){echo "selected='selected'";}?>>Greek</option>
                        <option value="french" <?php if($selectCategory=="french"){echo "selected='selected'";}?>>French</option>
                        <option value="spanish" <?php if($selectCategory=="spanish"){echo "selected='selected'";}?>>Spanish</option>
                        <option value="thai" <?php if($selectCategory=="thai"){echo "selected='selected'";}?>>Thai</option>
                        <option value="german" <?php if($selectCategory=="german"){echo "selected='selected'";}?>>German</option>
                        <option value="asian" <?php if($selectCategory=="asian"){echo "selected='selected'";}?>>Asian</option>
                        <option value="southern" <?php if($selectCategory=="southern"){echo "selected='selected'";}?>>Southern</option>
                        <option value="african" <?php if($selectCategory=="african"){echo "selected='selected'";}?>>African</option>
                        <option value="Other" <?php if($selectCategory=="Other"){echo "selected='selected'";}?>>Other</option>
                    </select>

                </div>
                <div <?php if(strcmp($selectCategory,"Other")==0){ ?> id="displayOtherCategory"<?php } else{?> id="hideOtherCategory" <?php } ?> >
                    <label>Other Category ? Please specify *</label><span class="errorMessage" id="errorMessageOtherCategory"><?php echo $errorMessage_otherCategory;?></span><br>
                    <input type="text" id="otherCategoryInput" placeholder="Minimum 3 characters. Only letters and white space allowed." name="otherCategory"  value="<?php echo $otherCategory;?>" onchange="validateOtherCategory();" style="<?php echo $errorMessage_otherCategoryCSS;?>" >


                </div>

                <div>
                    <label><span class="glyphicon glyphicon-time"></span> Preparation Time (mins) *</label> <span class="errorMessage"id="errorMessagePreparationTime"><?php echo $errorMessage_preparationTime;?></span>
                    <input type="number" pattern="[0-9]{1,3}" id="preparationTimeInput" required title="Only numbers(1-300) allowed !" min="1" max="300" placeholder="Only numbers(1-300) allowed." name="preparationTime"  value="<?php echo $preparationTime;?>" onchange="validatePreparationTime();" style="<?php echo $errorMessage_preparationTimeCSS;?>" > <br>

                </div>

                <div>
                    <label><span class="glyphicon glyphicon-time"></span> Cook Time (mins) *</label>  <span class="errorMessage" id="errorMessageCookTime"><?php echo $errorMessage_cookTime;?></span>
                    <input type="number"  pattern="[0-9]{1,3}" id="cookTimeInput" required title="Only numbers(1-300) allowed !"min="1" max="300" placeholder="Only numbers(1-300) allowed." name="cookTime"  value="<?php echo $cookTime;?>"  onchange="validateCookTime();" style="<?php echo $errorMessage_cookTimeCSS;?>" > <br>

                </div>

                <div>
                    <label><span class="glyphicon glyphicon-cutlery"></span> No of Servings *</label><span class="errorMessage" id="errorMessageServings"><?php echo $errorMessage_servings;?></span>
                    <input type="number" pattern="[0-9]{1,3}" id="servingsInput" required title="Only numbers (1-100) allowed !" min="1" max="100" placeholder="Only numbers(1-100) allowed." name="servings"  value="<?php echo $servings;?>" onchange="validateServings();" style="<?php echo $errorMessage_servingsCSS;?>"> <br>

                </div>


                <div>
                    <label ><span class="glyphicon glyphicon-star"></span> Rating *</label><span class="errorMessage" id="errorMessageRating"><?php echo $errorMessage_rating;?></span>
                </div>

                <div>
                    <!-- reference starts here, css code for star rating below is referenced from source: https://www.cssscript.com/simple-5-star-rating-system-with-css-and-html-radios/ -->
                    <div title="Please rate your recipe" class="starRating">

                        <input class="star starFive" onclick="validateRating();" type="radio" id="starFive" name="star" <?php if (isset($_POST['star']) && $_POST['star']=="5") echo "checked";?> value="5"/>  <!-- source: https://stackoverflow.com/questions/27082153/retain-radio-button-selection-after-submit-php-->
                        <label class="star starFive" id="five" for="starFive"></label>

                        <input class="star starFour" onclick="validateRating();" type="radio" id="starFour" name="star" <?php if (isset($_POST['star']) && $_POST['star']=="4") echo "checked";?> value="4"/>
                        <label class="star starFour" id="four" for="starFour"></label>

                        <input class="star starThree" onclick="validateRating();" type="radio" id="starThree" name="star" <?php if (isset($_POST['star']) && $_POST['star']=="3") echo "checked";?> value="3"/>
                        <label class="star starThree" id="three" for="starThree"></label>

                        <input class="star starTwo" onclick="validateRating();" type="radio" id="starTwo" name="star" <?php if (isset($_POST['star']) && $_POST['star']=="2") echo "checked";?> value="2"/>
                        <label class="star starTwo" id="two" for="starTwo"></label>

                        <input class="star starOne"  onclick="validateRating();"  type="radio" id="starOne" name="star" <?php if (isset($_POST['star']) && $_POST['star']=="1") echo "checked";?> value="1"/>
                        <label class="star starOne" id="one" for="starOne"></label>

                    </div>
                    <!-- reference starts here, css code for star rating above is referenced from source: https://www.cssscript.com/simple-5-star-rating-system-with-css-and-html-radios/ -->
                </div>


                <div>
                    <label><span class="glyphicon glyphicon-picture"></span> Upload Image *</label>
                    <span class="errorMessage" id="errorMessageImageUpload"><?php echo $errorMessage_imageUpload;?></span>
                   <input type="file" name="fileToUpload" id="imageUploadInput" class="fileUpload" onchange="validateImage();" style="<?php echo $errorMessage_imageUploadCSS;?>">
               </div>

                <div>
                    <br>
                    <label><span class="glyphicon glyphicon-facetime-video"></span> Add Video URL (YouTube only) </label><span class="errorMessage" id="errorMessageVideo"><?php echo $errorMessage_video;?></span>
                    <input style="margin-bottom: 0em;" type="url" id="videoInput" title="Please enter a URL in proper format (For example: https://www.youtube.com/watch?v=x4FX4XjUsDM ) !" placeholder="https://www.youtube.com/watch?v=x4FX4XjUsDM" name="video" value="<?php echo $video;?>" onchange="validateVideo();" style="<?php echo $errorMessage_videoCSS;?>" >

                </div>

            </div>

            <div class="columnOne">

                <div>
                    <label><span class="glyphicon glyphicon-list-alt"></span> Ingredients *</label><span class="errorMessage" id="errorMessageIngredients"><?php echo $errorMessage_ingredients;?></span>
                    <textarea title="Only letters, digits, whitespaces, (, ), /, - and commas are allowed." id="ingredientsInput" required placeholder="Only letters, digits, whitespaces, (, ), /, - and commas are allowed. Please add comma between your ingredients.(for example Salt,Sugar,Pepper.)" rows="1" cols="40" name="ingredients" onchange="validateIngredients();" style="<?php echo $errorMessage_ingredientsCSS;?>" ><?php echo $ingredients;?></textarea>

                </div>

                <div>
                    <label><span class="glyphicon glyphicon-list-alt"></span> Directions *</label> <span class="errorMessage" id="errorMessageDirections"><?php echo $errorMessage_directions;?></span>
                    <textarea title="Only letters, digits, whitespaces, (, ), /, - and commas are allowed." id="directionsInput" required placeholder="Only letters, digits, whitespaces, (, ), /, - and commas are allowed. Please add a new line before writing a new paragraph." rows="3" cols="40" name="directions" onchange="validateDirections();" style="<?php echo $errorMessage_directionsCSS;?>" ><?php echo $directions;?></textarea>
                   <br>
                </div>

                <div>
                    <label><span class="glyphicon glyphicon-pencil"></span> Description *</label> <span class="errorMessage" id="errorMessageDescription"><?php echo $errorMessage_description;?></span>
                    <textarea title="Only letters, digits, whitespaces, (, ), /, - and commas are allowed." id="descriptionInput" required placeholder="Only letters, digits, whitespaces, (, ), /, - and commas are allowed. Please add a new line before writing a new paragraph." rows="3" cols="40" name="description" onchange="validateDescription();" style="<?php echo $errorMessage_descriptionCSS;?>" ><?php echo $description;?></textarea>
                    <br>
                </div>

                <div>
                    <label><span class="glyphicon glyphicon-comment"></span> Notes/Comments *</label> <span class="errorMessage" id="errorMessageNotesComments"><?php echo $errorMessage_notesComments;?></span>
                    <textarea title = "Only letters, digits, whitespaces, (, ), /, - and commas are allowed." id="notesCommentsInput" required placeholder="Only letters, digits, whitespaces, (, ), /, - and commas are allowed. Please add a new line before writing a new paragraph." rows="1" cols="40" name="notesComments" onchange="validateNotesComments();" style="<?php echo $errorMessage_notesCommentsCSS;?>" ><?php echo $notesComments;?></textarea>
                    <br>
                </div>

                <div>
                    <label style="display: inline;"><span class="glyphicon glyphicon-user"></span> Collaborate for recipe</label>
                    <span style="color:deepskyblue; font-size: 1.25em;cursor: pointer;" class="glyphicon glyphicon-info-sign" data-toggle="modal" data-target="#exampleModalCenter"></span>
                    <span class="errorMessage" id="errorMessageCollaborateEmail"><?php echo $errorMessage_collaborateEmail;?></span>
                    <!-- reference for modal starts here, source:https://getbootstrap.com/docs/4.2/components/modal/ -->
                    <!-- Modal starts -->
                    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 style="display: inline-block; color: deepskyblue;" class="modal-title" id="exampleModalCenterTitle">Instructions</h3>
                                    <button style="color: deepskyblue; font-size: 2em; "type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <label style="font-size: 1em;">Collaborating with other user for a recipe allows that user to only view and edit that recipe.</label>
                                    <label style="font-size: 1em;">To collaborate, other user should have an account on this website.</label>
                                    <label style="font-size: 1em;">Time sharing a recipe allows other user to only view that recipe for a certain time.</label>
                                    <label style="font-size: 1em;">You can't collaborate and time share a recipe with a same user.</label>
                                    <label style="font-size: 1em;">To timeshare a recipe, other user need not have an account on this website.</label>
                                    <label style="font-size: 1em;">User must also mention number of days if user wants to timeshares a recipe.</label>
                                    <label style="font-size: 1em;">User should only timeshare a recipe if other user can be trusted not to reproduce/imitate/take a screenshot of user's recipe in any form.</label>

                                </div>
                                <div class="modal-footer">
                                    <button style="background-color: deepskyblue; color: white;" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Modal ends -->
                    <!-- reference for modal ends here, source:https://getbootstrap.com/docs/4.2/components/modal/ -->

                    <input type="email" id="collaborateEmailInput" placeholder="Please enter email (user@email.com) of the user." name="collaborateEmail"  value="<?php echo $collaborateEmail;?>" onchange="validateCollaborateEmail();" style="<?php echo $errorMessage_collaborateEmailCSS;?>" > <br>

                </div>

                <div>
                    <label  style="display: inline;"><span class="glyphicon glyphicon-user"></span> Timeshare recipe </label>
                    <span style="color:deepskyblue; font-size: 1.25em;cursor: pointer;" class="glyphicon glyphicon-info-sign" data-toggle="modal" data-target="#exampleModalCenter"></span>
                    <span class="errorMessage" id="errorMessageShareEmail"><?php echo $errorMessage_shareEmail;?></span>
                    <input type="email" id="shareEmailInput" placeholder="Please enter email (user@email.com) of the user." name="shareEmail"  value="<?php echo $shareEmail;?>" onchange="validateShareEmail();" style="<?php echo $errorMessage_shareEmailCSS;?>"> <br>


                </div>

                <div>
                    <label style="display: inline;"> <span class="glyphicon glyphicon-calendar"></span> If time sharing, enter number of days to share recipe.</label>
                    <span class="errorMessage" id="errorMessageShareTime"><?php echo $errorMessage_shareTime;?></span>
                    <input style="margin-bottom: 0em;" type="number"  readonly id="shareTimeInput" pattern="[0-9]{1,3}" title="Only digits allowed !" min="1" max="365" placeholder="Only digits allowed. Adding user email will activate this textbox." name="shareTime"  value="<?php echo $shareTime;?>" onchange="validateShareTime();" style="<?php echo $errorMessage_shareTimeCSS;?>">

                </div>

                <!-- ...................................-->

            </div>

        </div>


        <div class="row text-center">         <!-- row created, source: https://www.w3schools.com/css/tryit.asp?filename=trycss_form_responsive-->

            <div class="CreateRecipeButton">
                <input type="submit" value="ADD RECIPE" name="submit">

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
