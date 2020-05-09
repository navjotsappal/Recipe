<?php
/**
 * Created by PhpStorm.
 * User: Collins
 * Date: 17/01/2019
 * Time: 8:18 AM
 */

// please note that the following code has been referenced from the assignment 3 of the course CSCI 5709 (Advanced topics in web development) source: // https://web.cs.dal.ca/~sappal/csci5709/

session_start(); // session starts


if(isset($_SESSION['email']))
{
   /* if($_SESSION['HTTP_USER_AGENT_BROWSER']!=$_SERVER['HTTP_USER_AGENT'] )
    {
        header('Location: logOut.php'); // log user out in case user copies the address in one browser and paste it in another
    }*/
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
    header('Location: signIn.php');


}

//require('includes/DestroySession.php');  // to destroy session, to be used in backend connectivity


$errorMessage_email = $errorMessage_password ="";
$errorMessage_emailCSS = $errorMessage_passwordCSS ="";
$email = $password = "";
$userMessageSignInSuccessful=$userMessageSignInFailure=""; // source: https://www.w3schools.com/php/showphp.asp?filename=demo_form_validation_complete
$checkValidations=true; // assume that signIn form is free from any errors and is validated

$password =prevent_SQL_Injection_attack($_POST["password"]);
$email = prevent_SQL_Injection_attack($_POST["email"]);

if ($_SERVER["REQUEST_METHOD"] == "POST") {       //request method is POST, source: https://www.w3schools.com/php/showphp.asp?filename=demo_form_validation_complete

    if ( empty($email)|| !filter_var($email, FILTER_VALIDATE_EMAIL))        //validating email format:  source: https://www.w3schools.com/php/showphp.asp?filename=demo_form_validation_complete
    {

        if(empty($email))
        {
            $checkValidations=false;
            $errorMessage_email = "Cannot leave email blank !";
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
            $errorMessage_password = "Minimum 8 characters in the password ";
            $errorMessage_passwordCSS="border-color:#DE1643";
        }
    }


}

function prevent_SQL_Injection_attack($parameters) {      // stopping SQL injection attack, source:  https://www.w3schools.com/php/showphp.asp?filename=demo_form_validation_complete

    $parameters = htmlspecialchars($parameters);
    $parameters = stripslashes($parameters);
    $parameters = trim($parameters);
    return $parameters;
}

if((isset($_POST['submit'])) and $checkValidations==true){
    // Sign in form validated and sign in button clicked

   // $userMessageSignInSuccessful="Sign In Successful !";
    require_once('includes/Dal_Login_Credentials.php');

   try {

        $connection = new PDO("mysql:host=$serverName;dbname=$dbName", $dbUsername, $dbPassword); //setting the connection: source: https://www.w3schools.com/php/php_mysql_insert.asp
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // setting PDO error mode to exception mode, source: https://www.w3schools.com/php/php_mysql_insert.asp
        $sql = "SELECT uid,email,password,firstName FROM tb_users WHERE email = :email";  //preparing SQL statement, source: http://thisinterestsme.com/php-user-registration-form/
        $statement = $connection->prepare($sql);

        $statement->bindValue(':email', $email);     //bind email to prepare statement, execute the statement, source:http://thisinterestsme.com/php-user-registration-form/
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC); //fetch required row containing email.


        if($row === false){
            //email doesn't exist, source: http://thisinterestsme.com/php-user-registration-form/

            $errorMessage_email="This email does not exist in our database !";
            $errorMessage_emailCSS="border-color:#DE1643";

        }

        else{     //If email exists in db, check password,and then redirect to index.php

            $saltEncrypted=md5($email);          //encrypt email, source: https://stackoverflow.com/questions/15434701/insert-password-into-database-in-md5-format?utm_medium=organic&utm_source=google_rich_qa&utm_campaign=google_rich_qa
            $hashedPassword=md5($saltEncrypted.md5($password));

            if($hashedPassword==$row['password']){
                //creating session variables for first name and email, source: http://thisinterestsme.com/php-user-registration-form/
                $_SESSION['firstName'] = $row['firstName'];

                $_SESSION['HTTP_USER_AGENT_BROWSER']=$_SERVER['HTTP_USER_AGENT']; // http headers for checking session hijacking
                $_SESSION['email'] = $row['email'];
                $_SESSION['uid']=$row['uid'];



                $userMessageSignInSuccessful="Sign In Successful!";
                header('Location: myRecipes.php');      // source: http://thisinterestsme.com/php-user-registration-form/
                exit;
            }

            else{
                $errorMessage_password="Incorrect password !"; //invalid password.
                $errorMessage_passwordCSS="border-color:#DE1643";
                //echo "<<<<<".$userMessageSignInFailure;


            }

        }

    }

    catch(PDOException $e)       //catch exception, source: https://www.w3schools.com/php/php_mysql_insert.asp
    {
        $userMessageSignInFailure="Oops! Fail to set up the database connection.";
        // echo $e." <h5 style='color: red'>Sorry! 1) Unable to set up database connection  or 2) Unable to insert data into the database  </h5>";

    }


    $connection = null;  // releasing PDO connection


}


?>


<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="shortcut icon" type="image/x-icon" href="images/Recipe_Book.ico" /> <!-- icon source: https://www.iconfinder.com/icons/89064/book_recipe_icon-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/normalize.css">  <!-- normalize stylesheet "https://github.com/necolas/normalize.css"/-->
    <link rel="stylesheet" href="css/signUp.css">
    <meta name="HandledFriendly" content="true">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">  <!-- force IE compatibility mode off , "https://stackoverflow.com/questions/3449286/force-ie-compatibility-mode-off-using-tags?utm_medium=organic&utm_source=google_rich_qa&utm_campaign=google_rich_qa" -->


    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <script src="js/signIn.js"></script>

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
            <span class="signUpTitle"><b>Sign In</b></span>
        </div>


        <div class="row"> <!-- source:  https://www.w3schools.com/css/tryit.asp?filename=trycss_form_responsive */-->
            <br>
            <div class="col"> <!--for label in left column, source: https://www.w3schools.com/css/tryit.asp?filename=trycss_form_responsive */-->
                <label><span class="glyphicon glyphicon-envelope blueColor"></span> Email</label>
            </div>
            <div class="col"> <!--for text input in right column, source:  https://www.w3schools.com/css/tryit.asp?filename=trycss_form_responsive */-->
                <input type="email" id="emailId" required placeholder="someone@email.com." name="email" onchange="validateEmail();" value="<?php echo $email;?>" style="<?php echo $errorMessage_emailCSS;?>">
                <span class="errorMessage invalid-feedback" id="errorMessageEmail"> <?php echo $errorMessage_email;?></span>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <br><label ><span class="glyphicon glyphicon-lock blueColor"></span> Password</label>
            </div>
            <div class="col">
                <input type="password" id="passwordInput" required placeholder="Minimum 8 characters." name="password" onchange="validatePassword();"  value="<?php echo $password;?>" style="<?php echo $errorMessage_passwordCSS;?>">
                <span class="errorMessage invalid-feedback" id="errorMessagePassword"> <?php echo $errorMessage_password;?></span>
            </div>
        </div>


        <div class="row text-center">            <!-- row created, source:  https://www.w3schools.com/css/tryit.asp?filename=trycss_form_responsive */-->
            <br>
            <div class="col">
                <input class="btn btn-primary" type="submit" value="SIGN IN" name="submit"  >
            </div>

        </div>


        <div class="row">

            <label ><a class="anchorForgotPassword" href="forgotPassword.php"> <u><b>Forgot your Password? </b></u> </a></label>
        </div>


    </form>

</div>

<div class="otherContainer">

    <div class="row">
        <div class="col">
            <label><b>New around here? Join FREE</b></label>
        </div>
    </div>

    <div class="row text-center">         <!-- row created, source:  https://www.w3schools.com/css/tryit.asp?filename=trycss_form_responsive */-->

        <div class="col">
            <input type="button" value="SIGN UP" name="signUp" onclick="window.location='signUp.php';" >
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