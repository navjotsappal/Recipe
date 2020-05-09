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
    <title>Terms of Use</title>
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
                    <h1 class="titleHeading" style="padding: 0 0.5em;"><b> Terms of Use </b> <span class="glyphicon glyphicon glyphicon-list-alt" style="font-size: 1em; color:#090d3d;"></span>  </h1>
                    <br>
                </div>

                <div class="col">
                    <ol>

                        <li>
                            <p style="padding: 0 0.5em;"><b>User Agreement !</b></p>
                            <p style="padding: 0 0.5em;">Do not use RECIPE, if you do not agree with the terms of use below. Your use of RECIPE means that you agree with RECIPES terms of use. </p>
                            <br>
                        </li>


                        <li>
                            <p style="padding: 0 0.5em;"><b>Age</b></p>
                            <p style="padding: 0 0.5em;">User must be 13 years or older to use RECIPE app.</p>
                            <br>
                        </li>

                        <li>
                            <p style="padding: 0 0.5em;"><b>Password protection</b></p>
                            <p style="padding: 0 0.5em;">User is solely responsible for protecting his/her password. Under no circumstances RECIPE team will be held responsible for damages, in case user shares password with someone else. If user thinks his password is compromised ,user can reset the password on <b>signIn.php</b> page. </p>
                            <br>
                        </li>

                        <li>
                            <p style="padding: 0 0.5em;"><b>Country</b></p>
                            <p style="padding: 0 0.5em;">RECIPE can only be used in Canada.</p>
                            <br>
                        </li>

                        <li>
                            <p style="padding: 0 0.5em;"><b>Personal and professional use</b></p>
                            <p style="padding: 0 0.5em;">RECIPE can be used both for personal and professional purposes. </p>
                            <br>
                        </li>



                        <li>
                            <p style="padding: 0 0.5em;"><b>Liability</b></p>
                            <p style="padding: 0 0.5em;">User should collaborate and timeshare recipes with only trusted users who cannot reproduce/imitate/take screenshots of user's recipe in any form. RECIPE will not be responsible for any damages/consequences arising out of user's conflict/disagreement with other collaborators or other non-users.  </p>
                            <br>
                        </li>

                        <li>
                            <p style="padding: 0 0.5em;"><b>Images and Videos</b></p>
                            <p style="padding: 0 0.5em;">User must upload only images and videos relevant to the recipe. Failure to do so will result in termination of user's account.  </p>
                            <br>
                        </li>

                        <li>
                            <p style="padding: 0 0.5em;"><b>Content</b></p>
                            <p style="padding: 0 0.5em;">Users are the owners of the content of their recipes. </p>
                            <br>
                        </li>

                        <li>
                            <p style="padding: 0 0.5em;"><b>Data breach</b></p>
                            <p style="padding: 0 0.5em;">RECIPE makes every possible effort to secure user account and recipes. However, in case of data breach, RECIPE will not be held responsible for any losses.  </p>
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
