<?php
/**
 * Created by PhpStorm.
 * User: Collins
 * Date: 17/01/2019
 * Time: 8:18 AM
 */

// please note that the following code has been referenced from the assignment 3 of the course CSCI 5709 (Advanced topics in web development) source: // https://web.cs.dal.ca/~sappal/csci5709/

session_start(); // session starts
if(!isset($_SESSION["email"]))
{
    header('Location: index.php');
}

$errorMessage_firstName =$errorMessage_lastName=$errorMessage_permissionDenied="";
$errorMessage_firstNameCSS =$errorMessage_lastNameCSS="";
$firstName =$lastName= $email="";
$userMessageUpdateSuccessful=$userMessageUpdateFailure=""; // source: https://www.w3schools.com/php/showphp.asp?filename=demo_form_validation_complete
$checkValidations=true; // assume that update account form is free from any errors and is validated
$email=$_SESSION['email'];

$fetchUserDetails=readUserDetails($errorMessage_permissionDenied);
if($fetchUserDetails!=false)
{
    $row=$fetchUserDetails;
    $firstName=$row['firstName'];
    $lastName=$row['lastName'];

}
function readUserDetails(&$errorMessage_permissionDenied){

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

        $sql = "SELECT firstName,lastName FROM tb_users WHERE uid = :userId";  //preparing the SQL statement, source: http://thisinterestsme.com/php-user-registration-form/
        $statement = $connection->prepare($sql);
        $statement->bindValue(':userId', $userId);
        $statement->execute(); //Fetch row.

        $row = $statement->fetch(PDO::FETCH_ASSOC);


        if($row===false){                                     //email exists already, source: http://thisinterestsme.com/php-user-registration-form/

            $errorMessage_permissionDenied="There is no user with such an email in our database!";
            return false;

        }

        else {

            return $row;

        }


    }

    catch(PDOException $e)       //catching exception, source : https://www.w3schools.com/php/php_mysql_insert.asp
    {

        $errorMessage_permissionDenied=" 1) Fail to fetch user account details from the database  2) Fail to set up the database connection";

    }

    $connection = null;

}



if ($_SERVER["REQUEST_METHOD"] == "POST") {       //request method is POST, source: https://www.w3schools.com/php/showphp.asp?filename=demo_form_validation_complete

    $firstName = prevent_SQL_Injection_attack($_POST["firstName"]);
    $lastName = prevent_SQL_Injection_attack($_POST["lastName"]);


    if (empty($firstName)|| !(preg_match("/^([a-zA-Z]{3,20}\s*)+$/",$firstName))||strlen($firstName)>40)  // only letters and alphabets in first name,source:source: https://stackoverflow.com/questions/4939722/php-preg-match-with-regex-only-single-hyphens-and-spaces-between-words-continue?utm_medium=organic&utm_source=google_rich_qa&utm_campaign=google_rich_qa
    {
        if(empty($firstName))
        {
            $checkValidations=false;    // validation fails
            $errorMessage_firstName = "Cannot leave first name empty!"; // cant leave first name field empty
            $errorMessage_firstNameCSS="border-color:#DE1643";

        }

        else
        {
            $checkValidations=false;
            $errorMessage_firstName = "Only 3-40 characters and letters and white space are accepted in the First Name";
            $errorMessage_firstNameCSS="border-color:#DE1643";

        }

    }

    else if (empty($lastName)|| !(preg_match("/^([a-zA-Z]{3,20}\s*)+$/",$lastName)) ||strlen($lastName)>40)  // only letters and white space are allowed in the last name, source: https://stackoverflow.com/questions/4939722/php-preg-match-with-regex-only-single-hyphens-and-spaces-between-words-continue?utm_medium=organic&utm_source=google_rich_qa&utm_campaign=google_rich_qa
    {
        if(empty($lastName))
        {
            $checkValidations=false;
            $errorMessage_lastName = "Cannot leave last name empty !";
            $errorMessage_lastNameCSS="border-color:#DE1643";


        }
        else
        {
            $checkValidations=false;
            $errorMessage_lastName = "Only 3-40 characters and letters and white space are accepted in the Last Name";
            $errorMessage_lastNameCSS="border-color:#DE1643";

        }
    }


}

function prevent_SQL_Injection_attack($parameters) {      // to stop sql injection attack, source:  https://www.w3schools.com/php/showphp.asp?filename=demo_form_validation_complete

    $parameters = htmlspecialchars($parameters);
    $parameters = stripslashes($parameters);
    $parameters = trim($parameters);
    return $parameters;
}

if((isset($_POST['submit'])) and $checkValidations==true) {
    // form has been validated and update is clicked
    // $userMessageUpdateSuccessful="SignUp successful!";

    require_once("includes/Dal_Login_Credentials.php"); //my dal's web server credentials

    try {
        $connection = new PDO("mysql:host=$serverName;dbname=$dbName", $dbUsername, $dbPassword); //setting the connection: source: https://www.w3schools.com/php/php_mysql_insert.asp
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // setting PDO error mode to the exception mode,source: https://www.w3schools.com/php/php_mysql_insert.asp

       // echo "<h5 style='color: red'>.........+$email+Sorry! Email does not exist !</h5>"; //// http://thisinterestsme.com/php-user-registration-form/

        $sql = "SELECT firstName,lastName FROM tb_users WHERE email = :email";  //preparing the SQL statement, source: http://thisinterestsme.com/php-user-registration-form/
        $statement = $connection->prepare($sql);
        $statement->bindValue(':email', $email);     //binding email to prepare statement, then execute the statement. source: http://thisinterestsme.com/php-user-registration-form/

        $statement->execute(); //Fetch row.
        $row = $statement->fetch(PDO::FETCH_ASSOC);


        if($row===false){                                     //email does not exist, source: http://thisinterestsme.com/php-user-registration-form/
            $userMessageUpdateFailure="Email does not exists in database !";
        }

        else {
            $statement = $connection->prepare("UPDATE tb_users SET firstName = :firstName, lastName=:lastName WHERE email = :email"); //// bind input to prepare statement, execute statement. source: http://thisinterestsme.com/php-user-registration-form/
            $statement->bindValue(':firstName', $firstName);
            $statement->bindValue(':lastName', $lastName);                           // source: http://thisinterestsme.com/php-user-registration-form/
            $statement->bindValue(':email', $email);

            $result = $statement->execute();

            if ($result) //source: http://thisinterestsme.com/php-user-registration-form/
            {
             //   $userMessageUpdateSuccessful="Account details updated successfully!";
                $_SESSION['firstName'] = $firstName;
                $firstName="";
                $lastName="";

                //reference for modal starts here, source:https://getbootstrap.com/docs/4.2/components/modal/
                //Modal starts

                echo "<div class=\"modal\" data-backdrop=\"static\" id=\"successAccountCreated\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"ModalCenterTitle\" aria-hidden=\"true\">
                       <div class=\"modal-dialog modal-dialog-centered\" role=\"document\">
                          <div class=\"modal-content\">
                             <div class=\"modal-header\">
                                <h3 style=\"display: inline-block; color: deepskyblue;\" class=\"modal-title\" id=\"ModalCenterTitle\">Success !</h3>
                             </div>
                             <div class=\"modal-body\">
                                <label style=\"font-size: 1em;\"> Your account details have been successfully updated.</label>
                                 <br><br>
                                 <label style=\"font-size: 1em;\"> Please click on <b>Home</b> to go your home page.</label>
                                </div>
                            <div class=\"modal-footer\">
                                <button onclick=\"window.location='myRecipes.php';\" style=\"background-color: deepskyblue; color: white;\" type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\"> Home</button>
                            </div>
                          </div>
                       </div>
                      </div>
                     ";

                //Modal ends
                //reference for modal ends here, source:https://getbootstrap.com/docs/4.2/components/modal/

            }

            else{
                $userMessageUpdateFailure="Unable to update account details !";

            }


        }

    }
    catch(PDOException $e)       //catching exception, source : https://www.w3schools.com/php/php_mysql_insert.asp
    {

        $userMessageUpdateFailure="Oops ! : 1) Fail to update the data into the database  or 2) Fail to set up the database connection";
       // echo $e. " <h5 style='color: red'>Sorry : 1) Unable to update data into the database  or 2) Unable to set up database connection  </h5>" ;

    }

    $connection = null;


}


?>


<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update account</title>
    <link rel="shortcut icon" type="image/x-icon" href="images/Recipe_Book.ico" /> <!-- icon source: https://www.iconfinder.com/icons/89064/book_recipe_icon-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/normalize.css">  <!-- normalize stylesheet "https://github.com/necolas/normalize.css"/-->
    <link rel="stylesheet" href="css/signUp.css">
    <meta name="HandledFriendly" content="true">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">  <!-- force IE compatibility mode off , "https://stackoverflow.com/questions/3449286/force-ie-compatibility-mode-off-using-tags?utm_medium=organic&utm_source=google_rich_qa&utm_campaign=google_rich_qa" -->

    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <script type="text/javascript" src="js/signUp.js"></script>

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

<?php
           if(!empty($errorMessage_permissionDenied)){
               ?>
               <div class="containerSignUp" style="background-color:#f8d7da !important;">
                   <div class="row text-center" >
                       <div class="customAlert">
                           <h3 class="errorColor" style="color: #DE1643;"><span class="glyphicon glyphicon-ban-circle errorColor"></span><strong> Fail to fetch user details !</strong></h3>
                           <h5 class="errorColor" style="color: #DE1643;"><?php echo $errorMessage_permissionDenied ?></h5>
                       </div>
                   </div>

               </div>

               <?php

           }

           else{

               ?>

               <div class="containerSignUp">                                  <!--outer div for SignUp, source: https://www.w3schools.com/css/tryit.asp?filename=trycss_form_responsive-->
                   <form method="post" action="<?php echo htmlentities($_SERVER["PHP_SELF"]);?>">

                       <div class="row" >  <!-- source:  https://www.w3schools.com/css/tryit.asp?filename=trycss_form_responsive */-->
                           <span class="signUpTitle"><b>Update account</b></span><br><br>
                       </div>


                       <div class="row">                                <!-- source:  https://www.w3schools.com/css/tryit.asp?filename=trycss_form_responsive */-->
                           <div class="col">                <!--for label in left column, source: https://www.w3schools.com/css/tryit.asp?filename=trycss_form_responsive */-->
                               <label><span class="glyphicon glyphicon-user"></span> First Name</label>
                           </div>
                           <div class="col">                 <!--for text input in right column, source:  https://www.w3schools.com/css/tryit.asp?filename=trycss_form_responsive */-->
                               <input type="text" title="Minimum 3 characters and only letters and space accepted" id="firstNameInput" required  placeholder="Only letters and space accepted." name="firstName"  value="<?php echo $firstName;?>" onchange="validateFirstName();" style="<?php echo $errorMessage_firstNameCSS;?>" > <br>
                               <span class="errorMessage" id="errorMessageFirstName"><?php echo $errorMessage_firstName;?></span> <br>
                           </div>
                       </div>


                       <div class="row">
                           <div class="col">
                               <label><span class="glyphicon glyphicon-user"></span> Last Name</label>
                           </div>
                           <div class="col">
                               <input type="text" id="lastNameInput" title="Minimum 3 characters and only letters and space accepted" required  placeholder="Only letters and white space are accepted" name="lastName"  value="<?php echo $lastName;?>" onchange="validateLastName();" style="<?php echo $errorMessage_lastNameCSS;?>" > <br>
                               <span class="errorMessage" id="errorMessageLastName"> <?php echo $errorMessage_lastName;?></span> <br>
                           </div>
                       </div>


                       <div class="row text-center">         <!-- row created, source: https://www.w3schools.com/css/tryit.asp?filename=trycss_form_responsive-->
                           <input type="submit" value="UPDATE" name="submit" >
                       </div>

                       <div class="row" >
                           <div class="col">
                               <!-- <span class="userMessageSignUpSuccessful"><?php /*echo $userMessageUpdateSuccessful;*/?></span>-->
                               <span class="userMessageSignUpFailure"><?php echo $userMessageUpdateFailure;?></span>
                           </div>
                           <br>
                       </div>
                   </form>

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