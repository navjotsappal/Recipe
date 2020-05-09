<?php


if(5==5){
//echo urlencode("hello");
    $vars = array('email' => "abc@gmail.com", 'event_id' => 1);
    $querystring = http_build_query($vars);
    //echo $querystring;
    $q=urlencode("abc@gmail.com");
    $url = "http://localhost/main.php?" . $q;
    echo $url;
}
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Recipes</title>
    <link rel="shortcut icon" type="image/x-icon" href="images/Recipe_Book.ico" /> <!-- icon source: https://www.iconfinder.com/icons/89064/book_recipe_icon-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/normalize.css">  <!-- normalize stylesheet "https://github.com/necolas/normalize.css"/-->


    <meta name="HandledFriendly" content="true">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">  <!-- force IE compatibility mode off , "https://stackoverflow.com/questions/3449286/force-ie-compatibility-mode-off-using-tags?utm_medium=organic&utm_source=google_rich_qa&utm_campaign=google_rich_qa" -->



    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/demoDemo.css">
    <script src="js/myRecipes.js"></script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css"> <!-- source: https://www.w3schools.com/bootstrap/bootstrap_get_started.asp-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>


</head>

<body>
<div class="container">
    <div class="row">
        <input type="checkbox" id="st5" value="5" />
        <label for="st5"></label>
        <input type="checkbox" id="st4" value="4" />
        <label for="st4"></label>
        <input type="checkbox" id="st3" value="3" />
        <label for="st3"></label>
        <input type="checkbox" id="st2" value="2" />
        <label for="st2"></label>
        <input type="checkbox" id="st1" value="1" />
        <label for="st1"></label>
    </div>
</div>


</body>
</html>

