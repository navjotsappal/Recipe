<!-- this code for hamburger menu was referenced from source: https://www.w3schools.com/bootstrap/tryit.asp?filename=trybs_navbar_collapse&stacked=h-->


<nav class="navbar navbar-inverse" style="background-color: #090d3d;">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" style="margin-top: 1em" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="index.php"><img class="imageRecipeLogo" alt="RECIPE LOGO" src="images/recipeLogo.png"  onclick="location.href='index.php'" /></a>

        </div>
        <div class="collapse navbar-collapse" id="myNavbar">

            <ul class="nav navbar-nav navbar-right">

                        <li><a href="signIn.php"><span class="glyphicon glyphicon-log-in"></span> Sign In</a></li>
                        <li><a href="signUp.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>

            </ul>




        </div>
    </div>
</nav>