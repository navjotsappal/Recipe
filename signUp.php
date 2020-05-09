<?php
/**
 * Created by PhpStorm.
 * User: Collins
 * Date: 17/01/2019
 * Time: 8:18 AM
 */

// please note that the following code has been referenced from the assignment 3 of the course CSCI 5709 (Advanced topics in web development) source: // https://web.cs.dal.ca/~sappal/csci5709/

session_start(); // session starts


if( isset($_SESSION['email'])){      // when signed in user clicks on Sign up, then sign the user out
    // Unset session variables.
    $_SESSION = array();        // code below to destroy the session is retrieved from the source : http://php.net/manual/en/function.session-destroy.php

    if (ini_get("session.use_cookies")) {       // killing the session,deleting the session cookie.   source: http://php.net/manual/en/function.session-destroy.php
        $params = session_get_cookie_params();             // http://php.net/manual/en/function.session-destroy.php
        setcookie(session_name(), '', time() - 42000,           // http://php.net/manual/en/function.session-destroy.php
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    session_destroy(); // session is destroyed.
    header('Location: signUp.php');
}


$errorMessage_firstName =$errorMessage_lastName= $errorMessage_email = $errorMessage_password = $errorMessage_confirmPassword="";
$errorMessage_firstNameCSS =$errorMessage_lastNameCSS= $errorMessage_emailCSS = $errorMessage_passwordCSS = $errorMessage_confirmPasswordCSS="";

$firstName =$lastName= $email = $password = $confirmPassword= "";
$userMessageSignUpSuccessful=$userMessageSignUpFailure=""; // source: https://www.w3schools.com/php/showphp.asp?filename=demo_form_validation_complete
$checkValidations=true; // assume that signUp form is free from any errors and is validated

$firstName = prevent_SQL_Injection_attack($_POST["firstName"]);
$lastName = prevent_SQL_Injection_attack($_POST["lastName"]);
$password =prevent_SQL_Injection_attack($_POST["password"]);
$email = prevent_SQL_Injection_attack($_POST["email"]);
$confirmPassword = prevent_SQL_Injection_attack($_POST["confirmPassword"]);

if ($_SERVER["REQUEST_METHOD"] == "POST") {       //request method is POST, source: https://www.w3schools.com/php/showphp.asp?filename=demo_form_validation_complete

    if (empty($firstName)|| !(preg_match("/^([a-zA-Z]{3,20}\s*)+$/",$firstName))||strlen($firstName)>40)  // only letters and alphabets in first name,source:source: https://stackoverflow.com/questions/4939722/php-preg-match-with-regex-only-single-hyphens-and-spaces-between-words-continue?utm_medium=organic&utm_source=google_rich_qa&utm_campaign=google_rich_qa
    {
        if(empty($firstName))
        {
            $checkValidations=false;    // validation fails
            $errorMessage_firstName = "Cannot leave first name empty !"; // cant leave first name field empty
            $errorMessage_firstNameCSS="border-color:#DE1643";
        }

        else
        {
            echo strlen($firstName);
            $checkValidations=false;
            $errorMessage_firstName = "Only 3-40 characters and letters and a space are accepted in the First Name";
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
            $errorMessage_lastName = "Only 3-40 characters and letters and a white space are accepted in the Last Name";
            $errorMessage_lastNameCSS="border-color:#DE1643";
        }
    }

    else if ( empty($email)|| !filter_var($email, FILTER_VALIDATE_EMAIL))        //validating email format:  source: https://www.w3schools.com/php/showphp.asp?filename=demo_form_validation_complete
    {

        if(empty($email))
        {
            $checkValidations=false;
            $errorMessage_email = "Cannot leave email blank!";
            $errorMessage_emailCSS="border-color:#DE1643";

        }
        else
        {
            $checkValidations = false;
            $errorMessage_email = "Invalid email format !";
            $errorMessage_emailCSS="border-color:#DE1643";
        }
    }

    else if (empty($password)||strlen($password)<8 )        // if length of the password field is < 8 characters, source:  https://gist.github.com/bmcculley/9339529
    {
        if(empty($password))
        {
            $checkValidations=false;
            $errorMessage_password = "Cannot leave password empty !";
            $errorMessage_passwordCSS="border-color:#DE1643";


        }
        else
        {
            $checkValidations = false;
            $errorMessage_password = "Minimum 8 characters in password ";
            $errorMessage_passwordCSS="border-color:#DE1643";

        }
    }

    else if ( empty($confirmPassword)||(strlen($confirmPassword)<8 || ($_POST["password"]!=$_POST["confirmPassword"])) )    // if both passwords do not match
    {
        if(empty($confirmPassword))
        {
            $checkValidations = false;
            $errorMessage_confirmPassword = "Cannot leave confirm password empty !";
            $errorMessage_confirmPasswordCSS="border-color:#DE1643";
        }
        else
        {
            $checkValidations = false;
            $errorMessage_confirmPassword = "Password and confirm password fields do not match";
            $errorMessage_confirmPasswordCSS="border-color:#DE1643";
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
    // form has been validated and signUp is clicked
    // $userMessageSignUpSuccessful="SignUp successful!"; // remove this line and uncomment below code for db connection

    require_once("includes/Dal_Login_Credentials.php"); //my dal's web server credentials

    try {
        $connection = new PDO("mysql:host=$serverName;dbname=$dbName", $dbUsername, $dbPassword); //setting the connection: source: https://www.w3schools.com/php/php_mysql_insert.asp
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // setting PDO error mode to the exception mode,source: https://www.w3schools.com/php/php_mysql_insert.asp


        $sql = "SELECT COUNT(email) AS numcount FROM tb_users WHERE email = :email";  //preparing the SQL statement, source: http://thisinterestsme.com/php-user-registration-form/
        $statement = $connection->prepare($sql);
        $statement->bindValue(':email', $email);     //binding email to prepare statement, then execute the statement. source: http://thisinterestsme.com/php-user-registration-form/
        $statement->execute(); //Fetch row.
        $row = $statement->fetch(PDO::FETCH_ASSOC);


        if($row['numcount'] > 0){                                     //email exists already, source: http://thisinterestsme.com/php-user-registration-form/

            $errorMessage_email="This email already exists!";
            $errorMessage_emailCSS="border-color:#DE1643";

        }

        else {
            $saltEncrypted = md5($email);          // encrypt email with md5,  source: https://stackoverflow.com/questions/15434701/insert-password-into-database-in-md5-format?utm_medium=organic&utm_source=google_rich_qa&utm_campaign=google_rich_qa
            $hashedPassword = md5($saltEncrypted.md5($password)); // adding more encryption for more security

            $statement = $connection->prepare("INSERT INTO tb_users (firstName, lastName, email,password) 
                                             VALUES (:firstName, :lastName, :email,:password)"); //// bind input values to prepare statement, then execute the statement,  source: http://thisinterestsme.com/php-user-registration-form/
            $statement->bindValue(':firstName', $firstName);
            $statement->bindValue(':email', $email);
            $statement->bindValue(':lastName', $lastName);                           // source: http://thisinterestsme.com/php-user-registration-form/

            $statement->bindValue(':password', $hashedPassword);

            $result = $statement->execute();                         //source:  http://thisinterestsme.com/php-user-registration-form/

            if ($result) {                                    //source: http://thisinterestsme.com/php-user-registration-form/
                //"user signUp is successful"

                $_SESSION['firstName'] = $firstName;
                $_SESSION['email'] = $email; // creating session

                $_SESSION['HTTP_USER_AGENT_BROWSER'] = $_SERVER['HTTP_USER_AGENT']; // http headers used to prevent session hijacking

                $firstName="";
                $lastName="";
                $email="";
                $password="";
                $confirmPassword="";
                $userMessageSignUpSuccessful="Sign Up Successful! Please Sign In.";

                //reference for modal starts here, source:https://getbootstrap.com/docs/4.2/components/modal/
                //Modal starts
                echo "<div class=\"modal\" data-backdrop=\"static\" id=\"successAccountCreated\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"ModalCenterTitle\" aria-hidden=\"true\">
                       <div class=\"modal-dialog modal-dialog-centered\" role=\"document\">
                          <div class=\"modal-content\">
                             <div class=\"modal-header\">
                                <h3 style=\"display: inline-block; color: deepskyblue;\" class=\"modal-title\" id=\"ModalCenterTitle\">Success !</h3>
                             </div>
                             <div class=\"modal-body\">
                                <label style=\"font-size: 1em;\"> Your account has been created successfully.</label>
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
            else { // unable to sign Up

                $userMessageSignUpFailure="Unable to Sign Up user!";

            }
        }

    }
    catch(PDOException $e)       //catching exception, source : https://www.w3schools.com/php/php_mysql_insert.asp
    {

        $userMessageSignUpFailure="Oops ! : 1) Fail to insert the data into the database  or 2) Fail to set up the database connection";

    }

    $connection = null;


}


?>


<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>RECIPE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/normalize.css">  <!-- normalize stylesheet "https://github.com/necolas/normalize.css"/-->
    <link rel="stylesheet" href="css/signUp.css">
    <meta name="HandledFriendly" content="true">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">  <!-- force IE compatibility mode off , "https://stackoverflow.com/questions/3449286/force-ie-compatibility-mode-off-using-tags?utm_medium=organic&utm_source=google_rich_qa&utm_campaign=google_rich_qa" -->


    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <script src="js/signUp.js"></script>

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




    <div class="containerSignUp">                                  <!--outer div for SignUp, source: https://www.w3schools.com/css/tryit.asp?filename=trycss_form_responsive-->


        <form method="post" action="<?php echo htmlentities($_SERVER["PHP_SELF"]);?>">

            <div class="row" >  <!-- source:  https://www.w3schools.com/css/tryit.asp?filename=trycss_form_responsive */-->
                <span class="signUpTitle"><b>Create a free account</b></span><br><br>
            </div>


            <div class="row">                                <!-- source:  https://www.w3schools.com/css/tryit.asp?filename=trycss_form_responsive */-->
                <div class="col">                <!--for label in left column, source: https://www.w3schools.com/css/tryit.asp?filename=trycss_form_responsive */-->
                    <label><span class="glyphicon glyphicon-user"></span> First Name</label>
                </div>
                <div class="col">                 <!--for text input in right column, source:  https://www.w3schools.com/css/tryit.asp?filename=trycss_form_responsive */-->
                    <input type="text" title="Minimum 3 characters and only letters and space accepted" id="firstNameInput" required placeholder="Only letters accepted." name="firstName"  value="<?php echo $firstName;?>" onchange="validateFirstName();" style="<?php echo $errorMessage_firstNameCSS;?>"> <br>
                    <span class="errorMessage" id="errorMessageFirstName"><?php echo $errorMessage_firstName;?></span> <br>
                </div>
            </div>


            <div class="row">
                <div class="col">
                    <label><span class="glyphicon glyphicon-user"></span> Last Name</label>
                </div>
                <div class="col">
                    <input type="text" id="lastNameInput" title="Minimum 3 characters and only letters and space accepted" required placeholder="Only letters and white space are accepted" name="lastName"  value="<?php echo $lastName;?>" onchange="validateLastName();" style="<?php echo $errorMessage_lastNameCSS;?>" > <br>
                    <span class="errorMessage" id="errorMessageLastName"> <?php echo $errorMessage_lastName;?></span> <br>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <label><span class="glyphicon glyphicon-envelope"></span> Email</label>
                </div>
                <div class="col">
                    <input type="email" id="emailId" required placeholder="someone@email.com." name="email"  value="<?php echo $email;?>" onchange="validateEmail();" style="<?php echo $errorMessage_emailCSS;?>"> <br>
                    <span class="errorMessage" id="errorMessageEmail"> <?php echo $errorMessage_email;?></span> <br>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <label> <span class="glyphicon glyphicon-lock"></span> Password</label>
                </div>
                <div class="col">
                    <input type="password" id="passwordInput" required placeholder="Minimum 8 characters." name="password"  value="<?php echo $password;?>" onchange="validatePassword();" style="<?php echo $errorMessage_passwordCSS;?>" > <br>
                    <span class="errorMessage" id="errorMessagePassword"> <?php echo $errorMessage_password;?></span> <br>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <label><span class="glyphicon glyphicon-lock"></span> Confirm Password</label>
                </div>
                <div class="col">
                    <input type="password" id="confirmPasswordInput" required placeholder="Both passwords should match." name="confirmPassword"  value="<?php echo $confirmPassword;?>" onchange="validateConfirmPassword();" style="<?php echo $errorMessage_confirmPasswordCSS;?>"> <br>
                    <span class="errorMessage" id="errorMessageConfirmPassword"> <?php echo $errorMessage_confirmPassword;?></span> <br>
                </div>
            </div>

            <div class="row text-center">         <!-- row created, source: https://www.w3schools.com/css/tryit.asp?filename=trycss_form_responsive-->

                <input type="submit" value="SIGN UP" name="submit" >

            </div>

            <div class="row" >
                <div class="col">
                    <!--<span class="userMessageSignUpSuccessful"><?php /*echo $userMessageSignUpSuccessful;*/?></span>-->
                    <span class="userMessageSignUpFailure"><?php echo $userMessageSignUpFailure;?></span>

                </div>
            </div>
        </form>

    </div>



    <div class="otherContainer">


            <div class="row">         <!-- row created, source:  https://www.w3schools.com/css/tryit.asp?filename=trycss_form_responsive */-->
            <div class="col">
                <label><b>Have an account ?</b></label>
            </div>
        </div>

            <div class="row text-center">         <!-- row created, source:  https://www.w3schools.com/css/tryit.asp?filename=trycss_form_responsive */-->
            <div class="col">
                <input type="button" value="SIGN IN" name="signIn"  onclick="window.location='signIn.php';" >
            </div>
        </div>

    </div>



<div class="bottom">
    <?php
    require('includes/footer.php');     // php template to include header
    ?>
</div>


</body>
</html>