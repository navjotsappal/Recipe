<?php

// please note that the following code has been referenced from the assignment 3 of the course CSCI 5709 (Advanced topics in web development) source: // https://web.cs.dal.ca/~sappal/csci5709/

/**

 * Created by PhpStorm.
 * User: Collins
 * Date: 17/01/2019
 * Time: 2:22 PM
 */
session_start();// start the session

if( isset($_SESSION['email'])){      // when signed in user tries to sign in, then signed him out first

    // Unsetting session variable. The code below to destroy the session is taken from the source : http://php.net/manual/en/function.session-destroy.php

    $_SESSION = array();// kill session and delete session cookie.

    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    session_destroy(); // destroying session.
    header('Location: forgotPassword.php');
}

$errorMessage_email = "";
$errorMessage_emailCSS="";

$email =$token=$uid= $userMessageSendEmailSuccess=$userMessageSendEmailFail=""; // https://www.w3schools.com/php/showphp.asp?filename=demo_form_validation_complete
$checkValidations=true; // assuming form is without errors and validated

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

}

function prevent_SQL_Injection_attack($parameters) {      // stopping SQL injection attack, source:  https://www.w3schools.com/php/showphp.asp?filename=demo_form_validation_complete

    $parameters = htmlspecialchars($parameters);
    $parameters = stripslashes($parameters);
    $parameters = trim($parameters);
    return $parameters;
}

if((isset($_POST['submit'])) and $checkValidations==true)
{

   // $userMessageSendEmailSuccess="Email sent successfully !";



    require_once("includes/Dal_Login_Credentials.php");

    try {

        $connection = new PDO("mysql:host=$serverName;dbname=$dbName", $dbUsername, $dbPassword); //setting connection: source: https://www.w3schools.com/php/php_mysql_insert.asp
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // setting the PDO error mode to exception mode, source: https://www.w3schools.com/php/php_mysql_insert.asp

        $sql = "SELECT email,uid FROM tb_users WHERE email = :email";  //preparing SQL statement, source: http://thisinterestsme.com/php-user-registration-form/
        $statement = $connection->prepare($sql);
        $statement->bindValue(':email', $email);     //bind email to prepare statement, then execute statement, source:http://thisinterestsme.com/php-user-registration-form/
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC); //fetching required row.

        if($row === false)
        {
            // email doesn't exist, source: http://thisinterestsme.com/php-user-registration-form/
            $errorMessage_email="Email doesn't exist !";
            $errorMessage_emailCSS="border-color:#DE1643";
        }
        else {     //email exists, send email
            $uid=$row['uid'];
            $time=time();
            $token=md5(mt_rand()); //create token by hashing random no
            $statement = $connection->prepare("INSERT INTO password_tokens (uid, token,time)
                                             VALUES (:uid,:token,:time)");
            // bind input values to prepare statement , then execute statement, source: http://thisinterestsme.com/php-user-registration-form/
            $statement->bindValue(':uid', $uid);
            $statement->bindValue(':time', $time);
            $statement->bindValue(':token', $token);// source: http://thisinterestsme.com/php-user-registration-form/

            $result = $statement->execute();

            if($result){

                $checkEmailSent=sendEmail($token,$email);
                if($checkEmailSent===true){
                   // $userMessageSendEmailSuccess="Email sent. Please check your inbox.";
                    $email="";

                    //reference for modal starts here, source:https://getbootstrap.com/docs/4.2/components/modal/
                    //Modal starts

                    echo "<div class=\"modal\" data-backdrop=\"static\" id=\"successAccountCreated\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"ModalCenterTitle\" aria-hidden=\"true\">
                       <div class=\"modal-dialog modal-dialog-centered\" role=\"document\">
                          <div class=\"modal-content\">
                             <div class=\"modal-header\">
                                <h3 style=\"display: inline-block; color: deepskyblue;\" class=\"modal-title\" id=\"ModalCenterTitle\">Success !</h3>
                             </div>
                             <div class=\"modal-body\">
                                <label style=\"font-size: 1em;\"> A link to reset your password has been sent to your email address.</label>
                                 <br><br>
                                 <label style=\"font-size: 1em;\"> Please check your inbox.</label>
                                </div>
                            <div class=\"modal-footer\">
                                <button onclick=\"window.location='index.php';\" style=\"background-color: deepskyblue; color: white;\" type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\"> Okay</button>
                            </div>
                          </div>
                       </div>
                      </div>
                     ";

                    //Modal ends
                    //reference for modal ends here, source:https://getbootstrap.com/docs/4.2/components/modal/


                    //header('Location: index.php');
                }
                else{
                    $errorMessage_email="Unable to send email!";
                    $errorMessage_emailCSS="border-color:#DE1643";
                }
            }
            else{
                $errorMessage_email="Unable to add token to the database!";
                $errorMessage_emailCSS="border-color:#DE1643";
            }
        }
    }

    catch(PDOException $e)       //catch exception, source: https://www.w3schools.com/php/php_mysql_insert.asp
    {
        $errorMessage_email="Oops! We could not send you an email due to some problem in setting up the database connection!";
        $errorMessage_emailCSS="border-color:#DE1643";
        //echo $e." <h5 style='color: red'>Sorry! 1) Unable to set up database connection  or 2) Unable to insert data into the database  </h5>";
    }
    $connection = null;  // releasing the pdo connection


}

function sendEmail($token,$email){

    $url="https://web.cs.dal.ca/~sappal/Recipe/resetPassword.php?q=".$token;      // Create a link in the email message , source: https://www.dreamincode.net/forums/topic/370692-reset-password-system/
    $subject="Password Reset Request !";
    $messageBody = "Dear User,\n\nWe have received a request to reset the password of your account.\n\nPlease click on the link below in next 30 minutes or the link will expire.\n\nIf you ignore this message, then your password will not be reset. In case you are not able to click on the link below, please copy and then paste the link onto your browser's address bar.\n\n" . $url . "\n\nRegards,\nRecipe Team"; //create parameters for mail(), source:http://codingcyber.org/send-forgotten-password-by-mail-using-php-and-mysql-35/
    $to=$email;
    $header="From: navjotsappal@dal.ca";       // create parameters for mail(), source:http://codingcyber.org/send-forgotten-password-by-mail-using-php-and-mysql-35/



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
    <title>Forgot Password</title>
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


<div class="containerSignUp">                                  <!-- source: https://www.w3schools.com/css/tryit.asp?filename=trycss_form_responsive-->
    <form method="post" action="<?php echo htmlentities($_SERVER["PHP_SELF"]);?>">

        <div class="row" >
            <span class="signUpTitle"><b>Password recovery</b></span><br><br>
        </div>


        <div class="row">                         <!-- source:  https://www.w3schools.com/css/tryit.asp?filename=trycss_form_responsive */-->
            <div class="col">                <!--label in left column : https://www.w3schools.com/css/tryit.asp?filename=trycss_form_responsive */-->
                <label><span class="glyphicon glyphicon-envelope"></span> Email</label>
            </div>
            <div class="col">                 <!--text element in right column:  https://www.w3schools.com/css/tryit.asp?filename=trycss_form_responsive */-->
                <input type="email" id="emailId" required placeholder="someone@email.com." name="email"  value="<?php echo $email;?>"  onchange="validateEmail();" style="<?php echo $errorMessage_emailCSS;?>"> <br>
                <span class="errorMessage" id="errorMessageEmail"> <?php echo $errorMessage_email;?></span> <br>
            </div>
        </div>

        <div class="row text-center">
            <div class="col">
                <input type="submit" value="SEND EMAIL" name="submit"  >
            </div>
        </div>

    </form>

   <!-- <div class="row" >
        <div class="col">
            <span class="userMessageSignUpSuccessful"><?php /*echo $userMessageSendEmailSuccess;*/?></span>
        </div>
    </div>-->

    <div class="row text-center">
        <div class="col">
            <input type="submit" value="CANCEL"  name="submit" onclick="window.location.href='signIn.php'" >
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

