<?php

// please note that the following code has been referenced from the assignment 3 of the course CSCI 5709 (Advanced topics in web development) source: // https://web.cs.dal.ca/~sappal/csci5709/

/**
 * Created by PhpStorm.
 * User: Collins
 * Date: 17/01/2019
 * Time: 3:39 PM
 */

$errorMessage_password=$errorMessage_confirmPassword =$userMessageResetPassword= "";
$errorMessage_passwordCSS = $errorMessage_confirmPasswordCSS="";

$checkValidations=true; // // assuming form is without errors and validated
$password=$confirmPassword =$email=$userMessageResetPasswordSuccess=$userMessageResetPasswordFail="";
$token=$uid=$time=""; // source: https://www.w3schools.com/php/showphp.asp?filename=demo_form_validation_complete

$token = $_REQUEST["q"]; // getting token value

if(empty($token)){
    header('Location: index.php');
}

$password =prevent_SQL_Injection_attack($_POST["password"]);
$confirmPassword = prevent_SQL_Injection_attack($_POST["confirmPassword"]);


if ($_SERVER["REQUEST_METHOD"] == "POST") {       //request method is POST, source:  https://www.w3schools.com/php/showphp.asp?filename=demo_form_validation_complete

    if ( empty($password)||strlen($password)<8 )        // length of the password is less than 8 characters, source:  https://gist.github.com/bmcculley/9339529
    {
        if(empty($password))
        {
            $checkValidations=false;    // validation fails
            $errorMessage_password = "Cannot leave password empty !";
            $errorMessage_passwordCSS="border-color:#DE1643";
        }
        else
        {
            $checkValidations = false;
            $errorMessage_password = "Minimum 8 characters in the password field!";
            $errorMessage_passwordCSS="border-color:#DE1643";
        }
    }

    else if ( empty($confirmPassword)||( ($_POST["password"]!=$_POST["confirmPassword"]) || strlen($confirmPassword)<8) )    // both passwords do not match
    {
        if(empty($confirmPassword))
        {
            $checkValidations=false;    // validation fails
            $errorMessage_confirmPassword = "Cannot leave confirm password empty!";
            $errorMessage_confirmPasswordCSS="border-color:#DE1643";

        }
        else
        {
            $checkValidations = false;
            $errorMessage_confirmPassword = "Password and confirm password do not match";
            $errorMessage_confirmPasswordCSS="border-color:#DE1643";
        }
    }

}

function prevent_SQL_Injection_attack($parameters) {      // stopping SQL injection attack, source:  https://www.w3schools.com/php/showphp.asp?filename=demo_form_validation_complete

    $parameters = htmlspecialchars($parameters);
    $parameters = stripslashes($parameters);
    $parameters = trim($parameters);
    return $parameters;
}

if((isset($_POST['submit'])) and $checkValidations==true ){

   // $userMessageResetPasswordSuccess="Password Reset Successful!";


    require_once("includes/Dal_Login_Credentials.php");

    try {

        $connection = new PDO("mysql:host=$serverName;dbname=$dbName", $dbUsername, $dbPassword); //setting connection: source: https://www.w3schools.com/php/php_mysql_insert.asp
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // setting PDO error mode to exception mode, source: https://www.w3schools.com/php/php_mysql_insert.asp
        $sql = "SELECT token,uid,time FROM password_tokens WHERE token = :token";  //preparing SQL statement, source: http://thisinterestsme.com/php-user-registration-form/
        $statement = $connection->prepare($sql);

        $statement->bindValue(':token', $token);     //bind token to prepare statement, then execute statement, source:http://thisinterestsme.com/php-user-registration-form/
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC); //fetch row with given token.


        if($row === false){ // token doesn't exist in database, source: http://thisinterestsme.com/php-user-registration-form/

            $userMessageResetPasswordFail="Sorry! Token does not exist!";
        }

        else {     //token exists, check timestamp, fetch email and update(reset) the password  .

            $uid=$row['uid'];
            $currentTime= time(); // source: https://stackoverflow.com/questions/4298059/time-subtract-mysql-and-php
            $time=$row['time'];
            $timeGapDifference=(int)($currentTime-$time); // source: https://stackoverflow.com/questions/4298059/time-subtract-mysql-and-php

            if((int)($timeGapDifference)>2700){   // reset password in 45 minutes otherwise token expires
                $errorMessage_confirmPassword="Sorry! Time limit to reset your password is already expired !";
                $errorMessage_confirmPasswordCSS="border-color:#DE1643";
                $errorMessage_passwordCSS="border-color:#DE1643";

            }
            else{ // retrieve email from db

                $statement = $connection->prepare("SELECT email,uid FROM tb_users WHERE uid = :uid"); //// bind input to prepare statement, execute statement, source: http://thisinterestsme.com/php-user-registration-form/
                $statement->bindValue(':uid', $uid);
                $result = $statement->execute();
                $row = $statement->fetch(PDO::FETCH_ASSOC); //fetch row with email.

                if($row===false){
                    $userMessageResetPasswordFail="Email doesn't exist in database !";

                }
                else{     // email exists, reset password

                    $email=$row['email'];
                    $saltEncrypted = md5($email);          // encrypt email, source: https://stackoverflow.com/questions/15434701/insert-password-into-database-in-md5-format?utm_medium=organic&utm_source=google_rich_qa&utm_campaign=google_rich_qa
                    $hashedPassword = md5($saltEncrypted.md5($password));

                    $statement = $connection->prepare("UPDATE tb_users SET password = :password WHERE email = :email"); //// bind input to prepare statement, execute statement. source: http://thisinterestsme.com/php-user-registration-form/

                    $statement->bindValue(':email', $email);                           // source: http://thisinterestsme.com/php-user-registration-form/
                    $statement->bindValue(':password', $hashedPassword);
                    $result = $statement->execute();

                    if ($result) //source: http://thisinterestsme.com/php-user-registration-form/
                    {
                       // $userMessageResetPasswordSuccess="Password Reset Successful! Please Sign In.";
                        $password="";
                        $confirmPassword="";
                        $statement = $connection->prepare("Delete FROM password_tokens WHERE token = :token"); // delete token from database, bind input values to prepare statement, execute statement. source: http://thisinterestsme.com/php-user-registration-form/
                        $statement->bindValue(':token', $token);
                        $result = $statement->execute();

                        //reference for modal starts here, source:https://getbootstrap.com/docs/4.2/components/modal/
                        //Modal starts

                        echo "<div class=\"modal\" data-backdrop=\"static\" id=\"successAccountCreated\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"ModalCenterTitle\" aria-hidden=\"true\">
                       <div class=\"modal-dialog modal-dialog-centered\" role=\"document\">
                          <div class=\"modal-content\">
                             <div class=\"modal-header\">
                                <h3 style=\"display: inline-block; color: deepskyblue;\" class=\"modal-title\" id=\"ModalCenterTitle\">Success !</h3>
                             </div>
                             <div class=\"modal-body\">
                                <label style=\"font-size: 1em;\"> Your password has been reset successfully.</label>
                                <br><br>
                                <label style=\"font-size: 1em;\">  Please click on <b>Sign In</b> below to login.</label>
                             </div>
                            <div class=\"modal-footer\">
                                <button onclick=\"window.location='signIn.php';\" style=\"background-color: deepskyblue; color: white;\" type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Sign In</button>
                            </div>
                          </div>
                       </div>
                      </div>
                     ";

                        //Modal ends
                        //reference for modal ends here, source:https://getbootstrap.com/docs/4.2/components/modal/



                    }
                    else
                    {
                        $errorMessage_confirmPassword=" Sorry! We could not reset your password!";
                        $errorMessage_confirmPasswordCSS="border-color:#DE1643";
                        $errorMessage_passwordCSS="border-color:#DE1643";
                    }
                }
            }

        }

    }

    catch(PDOException $e)       //catch exception, source: https://www.w3schools.com/php/php_mysql_insert.asp
    {
        $errorMessage_confirmPassword="Sorry! We were unable to reset your password as we could not set up the database connection !";
        $errorMessage_confirmPasswordCSS="border-color:#DE1643";
        $errorMessage_passwordCSS="border-color:#DE1643";
    }


    $connection = null;  // releasing pdo connection


}

?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
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
    require('includes/header.php');     // php template to include header
    ?>
</div>


<div class="containerSignUp">                                  <!-- source: https://www.w3schools.com/css/tryit.asp?filename=trycss_form_responsive-->
    <form method="post" action="<?php echo htmlentities($_SERVER["PHP_SELF"] . '?'.http_build_query($_GET));?>">

    <div class="row" >
        <span class="signUpTitle"><b>Reset password </b></span><br><br>
        </div>

        <div class="row">                         <!-- source:  https://www.w3schools.com/css/tryit.asp?filename=trycss_form_responsive */-->
            <div class="col">                <!--label in left column : https://www.w3schools.com/css/tryit.asp?filename=trycss_form_responsive */-->
                <label><span class="glyphicon glyphicon-lock"></span> Password</label>
            </div>
            <div class="col">                 <!--text element in right column:  https://www.w3schools.com/css/tryit.asp?filename=trycss_form_responsive */-->
                <input type="password" id="passwordInput" required placeholder="Minimum 8 characters in password." name="password"  value="<?php echo $password;?>" onchange="validatePassword();" style="<?php echo $errorMessage_passwordCSS;?>"> <br>
                <span class="errorMessage" id="errorMessagePassword"> <?php echo $errorMessage_password;?></span> <br></div>
        </div>

        <div class="row">
            <div class="col">
                <label> <span class="glyphicon glyphicon-lock"></span> Confirm Password</label>
            </div>
            <div class="col">
                <input type="password" id="confirmPasswordInput" required placeholder="Both passwords should match." name="confirmPassword"  value="<?php echo $confirmPassword;?>" onchange="validateConfirmPassword();" style="<?php echo $errorMessage_confirmPasswordCSS;?>"> <br>
                <span class="errorMessage" id="errorMessageConfirmPassword"> <?php echo $errorMessage_confirmPassword;?></span> <br>
            </div>
        </div>

        <div class="row text-center">

            <input type="submit" value="RESET" name="submit"  >

        </div>

        <div class="row" >
            <div class="col">
                <!--<span class="userMessageSignUpSuccessful"><?php /*echo $userMessageResetPasswordSuccess;*/?></span>-->
                <span class="userMessageSignUpFailure"><?php echo $userMessageResetPasswordFail;?></span>
            </div>
        </div>

    </form>

</div>



<div class="bottom">
    <?php
    require('includes/footer.php');     // php template to include header
    ?>
</div>


</body>
</html>




