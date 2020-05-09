<!-- this code for hamburger menu was referenced from source: https://www.w3schools.com/bootstrap/tryit.asp?filename=trybs_navbar_collapse&stacked=h-->


<nav class="navbar navbar-inverse" style="background-color: #090d3d;">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" style="margin-top: 1em" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="myRecipes.php"><img class="imageRecipeLogo" alt="RECIPE LOGO" src="images/recipeLogo.png"  onclick="location.href='myRecipes.php'" /></a>

        </div>
        <div class="collapse navbar-collapse" id="myNavbar">

            <ul class="nav navbar-nav navbar-right">

                <li>
                    <?php

                    if(isset($_SESSION['email']))
                       {
                           $welcomeName=$_SESSION['firstName'];
                        echo "
                              <li><a href=\"createRecipe.php\"><span class=\"glyphicon glyphicon-plus\"></span> Add Recipe</a></li>
                              
                              <li><a href=\"myRecipes.php\"><span class=\"glyphicon glyphicon-list-alt\"></span> My Recipes</a></li>

                              <li class=\"dropdown\">
                              <a class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\"><span class=\"glyphicon glyphicon-user\"></span> $welcomeName </a>
                                 <ul class=\"dropdown-menu\">
                                    <li><a href=\"updateAccount.php\"><span class=\"glyphicon glyphicon-pencil\"></span> Update Account</a></li>
                                    <li><a href=\"logOut.php\"><span class=\"glyphicon glyphicon-log-out\"></span> Logout</a></li>

                                  </ul>
                              </li>";

                       }
                       /*else{
                           header('Location: index.php');
                       }*/

                    ?>

                </li>

            </ul>



            <!--

                <li><a href="createRecipe.php"><span class="glyphicon glyphicon-plus"></span> Add Recipe</a></li>
                <li><a href="index.php"><span class="glyphicon glyphicon-list-alt"></span> My Recipes</a></li>

                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-user"></span> My Account </a>
                    <ul class="dropdown-menu">
                        <li><a href="updateAccount.php"><span class="glyphicon glyphicon-pencil"></span> Update Account</a></li>
                        <li><a href="logOut.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
                    </ul>
                </li>

                <li><a href="signIn.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                <li><a href="signUp.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
             -->



        </div>
    </div>
</nav>