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
    <title>FAQs</title>
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
                        <h1 class="titleHeading" style="padding: 0 0.5em;"><b> Frequently Asked Questions </b><span class="glyphicon glyphicon-question-sign" style="font-size: 1em; color:#090d3d;"></span> </h1>

                        <br>
                    </div>

                    <div class="col">
                     <ol>
                         <li><p style="padding: 0 0.5em;"><b>What is RECIPE ?</b> </p>
                             <p style="padding: 0 0.5em;"> RECIPE is a mobile friendly web application that lets you manage, collaborate and time share your custom and private recipes with your friends, family, and colleagues.</p>
                             <br>
                         </li>

                         <li>
                             <p style="padding: 0 0.5em;"><b>Do I need to create an account to access all features of RECIPE ? </b></p>
                             <p style="padding: 0 0.5em;"> RECIPE is free. User is required to create an account to access all the features except,in case, user time shares a recipe with another person who doesn't have an account on RECIPE. </p>
                             <br>
                         </li>

                         <li>
                             <p style="padding: 0 0.5em;"><b>How can I collaborate with another user for a recipe ?</b></p>
                             <p style="padding: 0 0.5em;"> While creating or editing a recipe, user can add email of another user with whom user wants to collaborate for a recipe. A notification will be sent by an email to the another user.   </p>
                             <br>
                         </li>

                         <li>
                             <p style="padding: 0 0.5em;"><b>Can I collaborate with another person who does not have an account on RECIPE for my recipe ? </b></p>
                             <p style="padding: 0 0.5em;">Unfortunately, the answer is No. You can only collaborate your recipes with users who have an account on RECIPE. </p>
                             <br>
                         </li>


                         <li>
                             <p style="padding: 0 0.5em;"><b>How can I time share my recipe ?</b></p>
                             <p style="padding: 0 0.5em;">While creating or editing a recipe, user can add email of the person with whom user wants to time share a recipe. User is also required to add number of days to time share a recipe with another person. A link will be sent by an email to the concerned person who can then access that recipe within the time limit specified.    </p>
                             <br>
                         </li>

                         <li>
                             <p style="padding: 0 0.5em;"><b>Can I time share my recipe with another person who does not have an account on RECIPE ? </b></p>
                             <p style="padding: 0 0.5em;">Yes, you can time share your recipes with another person who does not have an account on RECIPE. </p>
                             <br>
                         </li>

                         <li>
                             <p style="padding: 0 0.5em;"><b>How many users can I collaborate with for my recipe at a time ?</b></p>
                             <p style="padding: 0 0.5em;"> You can collaborate with only 1 user at a time.</p>
                             <br>
                         </li>


                         <li>
                             <p style="padding: 0 0.5em;"><b> What are the access rights/restrictions for the another user with whom I have collaborated for a recipe? </b></p>
                             <p style="padding: 0 0.5em;"> If you have collaborated with another user for a recipe, then that user can only view and update your recipe. However, while editing that recipe, another user cannot update collaborate and time share fields marked in grey color .  </p>
                             <br>
                         </li>

                         <li>
                             <p style="padding: 0 0.5em;"><b>What are the access rights/restrictions for the another person with whom I have time shared my recipe ?</b></p>
                             <p style="padding: 0 0.5em;">If you have time shared your recipe with another person, then that person can only view your recipe for a certain period of time as specified by you.   </p>
                             <br>
                         </li>

                         <li>
                             <p style="padding: 0 0.5em;"><b>How many people can I time share my recipe with at a time ?</b></p>
                             <p style="padding: 0 0.5em;"> You can time share your recipe with only 1 person at a time.</p>
                             <br>
                         </li>

                         <li>
                             <p style="padding: 0 0.5em;"><b>Are my recipes public by default ?</b></p>
                             <p style="padding: 0 0.5em;"> All recipes that you create on RECIPE are private by default. Once you collaborate or time share your recipe with another user or another person, only then your recipe (with restrictions) becomes available to that user or that person. </p>
                             <br>
                         </li>

                         <li>
                             <p style="padding: 0 0.5em;"><b>How can I create a new recipe ?</b></p>
                             <p style="padding: 0 0.5em;">You can create a new recipe by clicking on <b>Add Recipe</b> option in the menu. </p>
                             <br>
                         </li>

                         <li>
                             <p style="padding: 0 0.5em;"><b>How can I edit my recipe ? </b></p>
                             <p style="padding: 0 0.5em;">After selecting the category of the recipe in your home page, you can click on edit icon in your recipe to update your recipe.</p>
                             <br>
                         </li>

                         <li>
                             <p style="padding: 0 0.5em;"><b>Where are my recipes listed ?</b></p>
                             <p style="padding: 0 0.5em;"> Once you get logged in, you can view your recipes in <b>My Recipes</b> section after selecting the category of that recipe from the drop down list in your home page.</p>
                             <br>
                         </li>

                         <li>
                             <p style="padding: 0 0.5em;"><b>Where can I see recipes collaborated with me ?</b></p>
                             <p style="padding: 0 0.5em;">You can view recipes collaborated with you in the <b>Recipes collaborated with you</b> section in your home page.</p>
                             <br>
                         </li>

                         <li>
                             <p style="padding: 0 0.5em;"><b>How can I delete my recipe ?</b></p>
                             <p style="padding: 0 0.5em;">After selecting the category of the recipe in your home page, you can click on delete icon in your recipe to delete your recipe. Please be advised, recipe once deleted cannot be retrieved again.</p>
                             <br>
                         </li>

                         <li>
                             <p style="padding: 0 0.5em;"><b>How can I update a recipe that I have been collaborated with ?</b></p>
                             <p style="padding: 0 0.5em;"> You can update a recipe collaborated with you by clicking on edit icon in that recipe. However fields marked in grey color cannot be updated by you.</p>
                             <br>
                         </li>

                         <li>
                             <p style="padding: 0 0.5em;"><b>How can I update my account details ?</b></p>
                             <p style="padding: 0 0.5em;"> You can click on your profile on top left of the menu bar and then choose option <b> Update Account</b> to update your account details.</p>
                             <br>
                         </li>

                         <li>
                             <p style="padding: 0 0.5em;"><b>Can I delete my account ?</b></p>
                             <p style="padding: 0 0.5em;">Unfortunately, the answer is No. We know it requires a lot of time and patience to manage recipes. That's why we don't want you to leave. Another reason would be, rest assured, RECIPE would never spam you. There is no personal information except your name and email that RECIPE had asked for when you created your account. But still if you want to delete all your recipes, then you can  delete them individually until there are no recipes in your account. </p>
                             <br>
                         </li>

                         <li>
                             <p style="padding: 0 0.5em;"><b>How can I recover / reset / change my password ?</b></p>
                             <p style="padding: 0 0.5em;">You can only reset/change your password by clicking on <b>Forgot my password ?</b> link in <b>signIn.php</b> page. An link will be sent to your email address. Once you clicked on that link, you will be redirected to <b>resetPassword.php</b> page to reset your password.  You cannot recover your old password as RECIPE encrypted and hashed your password for security reasons when you created your account. Once password is hashed, it cannot be recovered. </p>
                             <br>
                         </li>

                         <li>
                             <p style="padding: 0 0.5em;"><b>Do people at RECIPE have access to my recipes ?</b></p>
                             <p style="padding: 0 0.5em;"> Yes, for security reasons and maintenance purposes. But rest assured RECIPE will never ever by any means try to reproduce or imitate or give access in any form of your recipes to anyone. </p>
                             <br>
                         </li>

                         <li>
                             <p style="padding: 0 0.5em;"><b>I no longer want to time share or collaborate with the person or the user with whom I have time shared or collaborated my recipe. What should I do ?</b></p>
                             <p style="padding: 0 0.5em;">You can simply click on <b>My Recipes</b> option in Menu. Then select category of your recipe. Click Edit on your recipe and empty your collaborate email or time share fields and then click on <b>Update Recipe</b>. This will allow you to stop time sharing or collaborating your recipe with concerned person or concerned user.</p>
                             <br>
                         </li>

                         <li>
                             <p style="padding: 0 0.5em;"><b>I want to change email in my time share field or collaborate email field ? How can I do that? </b></p>
                             <p style="padding: 0 0.5em;">You can simply click on <b>My Recipes</b> option in Menu. Then select category of your recipe. Click Edit on your recipe and change your collaborate email or time share fields and then click on<b> Update Recipe</b>. This will allow you to time share or collaborate your recipe with a new person or a new user.</p>
                             <br>
                         </li>

                         <li>
                             <p style="padding: 0 0.5em;"><b>How can I change number of days I can time share my recipe for ? </b></p>
                             <p style="padding: 0 0.5em;">You can simply click on <b>My Recipes</b> option in Menu. Then select category of your recipe. Click Edit on your recipe and edit number of days to timeshare your recipe, then click on<b> Update Recipe</b>. This will allow you to change number of days you can time share your recipe with that person with whom you have time shared your recipe before.</p>
                             <br>
                         </li>



                         <li>
                             <p style="padding: 0 0.5em;"><b> When do I timeshare my recipe ?</b></p>
                             <p style="padding: 0 0.5em;">You can time share your recipe when you want to give only a limited time read only access of your recipe to a non-user who does not have an account on RECIPE.</p>
                             <br>
                         </li>

                         <li>
                             <p style="padding: 0 0.5em;"><b>When do I collaborate my recipe?</b></p>
                             <p style="padding: 0 0.5em;">You can collaborate your recipe when you want to work with other user for that recipe and allow that user to both view and edit your recipe as long as your recipe lasts.</p>
                             <br>
                         </li>

                         <li>
                             <p style="padding: 0 0.5em;"><b>How do I update my email address ?</b></p>
                             <p style="padding: 0 0.5em;">Unfortunately, RECIPE does not allow users to change their email addresses.</p>
                             <br>
                         </li>

                         <li>
                             <p style="padding: 0 0.5em;"><b>How can I prevent a non-user from taking screenshots of my recipe when I time shared my recipe with that user ?</b></p>
                             <p style="padding: 0 0.5em;">Unfortunately, RECIPE cannot control that aspect due to technical difficulties. We strongly advise you timeshare your recipes with only trusted non-users who cannot in any form reproduce,imitate,or take screenshots of your recipes.</p>
                             <br>
                         </li>

                         <li>
                             <p style="padding: 0 0.5em;"><b>Are my recipes secure enough on RECIPE ?</b></p>
                             <p style="padding: 0 0.5em;"> Yes, only you can manage your recipes and control whom you want to give limited access.</p>
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
