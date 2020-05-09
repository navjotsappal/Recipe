<?php
/**
 * Created by PhpStorm.
 * User: Collins
 * Date: 25/02/2019
 * Time: 11:18 AM
 */

session_start();

?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Privacy Policy</title>
    <link rel="shortcut icon" type="image/x-icon" href="images/Recipe_Book.ico" /> <!-- icon source: https://www.iconfinder.com/icons/89064/book_recipe_icon-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/normalize.css">  <!-- normalize stylesheet "https://github.com/necolas/normalize.css"/-->
    <link rel="stylesheet" href="css/createRecipe.css">
    <meta name="HandledFriendly" content="true">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">  <!-- force IE compatibility mode off , "https://stackoverflow.com/questions/3449286/force-ie-compatibility-mode-off-using-tags?utm_medium=organic&utm_source=google_rich_qa&utm_campaign=google_rich_qa" -->


    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css"> <!-- source: https://www.w3schools.com/bootstrap/bootstrap_get_started.asp-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>



</head>

<body>

<?php
if(isset($_SESSION['email']))
{
    ?>
    <div class="top" style="margin-bottom: -20px">
        <?php
        require('includes/headerLoggedInUser.php');     // php template to include header
        ?>
    </div>
    <?php
}

else
{
    ?>
    <div class="top" style="margin-bottom: -20px">
        <?php
        require('includes/header.php');     // php template to include header
        ?>
    </div>
    <?php

}
?>


<div class="container enclosedContainer">
    <div class="container containerWidth">                                  <!--outer div for SignUp, source: https://www.w3schools.com/css/tryit.asp?filename=trycss_form_responsive-->
        <div class="container">
            <div class="row">
                <div class="col">
                    <br>
                    <h1 class="titleHeading" style="padding: 0 0.5em;"><b> Privacy Policy </b> <span class="glyphicon glyphicon-eye-close" style="font-size: 1em; color:#090d3d;"></span> </h1>
                    <br>
                </div>

                <div class="col">
                    <ol>
                        <li>
                            <p style="padding: 0 0.5em;"><b> What personal information is collected and stored ?</b></p>
                            <p style="padding: 0 0.5em;"> RECIPE collects and stores name, email and password as personal information only when user creates an account. RECIPE also collects and stores email of other user or other person when user decides to collaborate on a recipe with other user or when user decides to time share a recipe with other person. Should a user decides to opt out of sharing user's recipe by collaborating email or by time sharing email, then those emails that user had earlier provided will be deleted from RECIPE's database.  </p>
                            <p style="padding: 0 0.5em;"></p>
                            <br>
                        </li>

                        <li>
                            <p style="padding: 0 0.5em;"><b>How the personal information is used ?</b></p>
                            <p style="padding: 0 0.5em;"> RECIPE uses email, password, and name of the user so that RECIPE can authenticate and authorize user to access/manage user's recipes by validating the password that user had used while logging into the RECIPE. </p>
                            <br>
                        </li>

                        <li>
                            <p style="padding: 0 0.5em;"><b>How personal information is protected and stored ?</b></p>
                            <p style="padding: 0 0.5em;">RECIPE stores user's email, name and password when user first signed up for the application. Since passwords are encrypted and hashed for security reasons, RECIPE has no access to the passwords in plain text. RECIPE stores email and name in the My SQL database management system. Access to the database system is only granted to people at RECIPE.</p>
                            <br>
                        </li>

                        <li>
                            <p style="padding: 0 0.5em;"><b>Does RECIPE shares user's personal information with third parties ?</b></p>
                            <p style="padding: 0 0.5em;">RECIPE does not and will never provide any personal information that it collects from its users to any third party. RECIPE values user privacy as of utmost importance. </p>
                            <br>
                        </li>

                        <li>
                            <p style="padding: 0 0.5em;"><b>Does RECIPE uses cookies in any form ?</b></p>
                            <p style="padding: 0 0.5em;">RECIPE does not use cookies. However, RECIPE uses the concept of session variables to store email and name of the user as a means of providing security to its users and to keep track of its users when they are being redirected to different web pages of RECIPE.  </p>
                            <br>
                        </li>

                        <li>
                            <p style="padding: 0 0.5em;"><b>Should I be informed of any changes in privacy policy at RECIPE ? </b></p>
                            <p style="padding: 0 0.5em;">RECIPE will inform its users via email in case its privacy policy changes.</p>
                            <br>
                        </li>

                        <li>
                            <p style="padding: 0 0.5em;"><b>Does RECIPE hosts ads on its platform ? Does RECIPE share any information about its users with those ads?</b></p>
                            <p style="padding: 0 0.5em;">No. RECIPE neither runs advertisements on its platform nor does it shares any information about its users with anyone .</p>
                            <br>
                        </li>

                        <li>
                            <p style="padding: 0 0.5em;"><b></b></p>
                            <p style="padding: 0 0.5em;"></p>
                            <br>
                        </li>

                        <li>
                            <p style="padding: 0 0.5em;"><b></b></p>
                            <p style="padding: 0 0.5em;"></p>
                            <br>
                        </li>


                    </ol>

                </div>

            </div>
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
