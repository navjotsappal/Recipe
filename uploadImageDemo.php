<?php
//error_reporting(E_ALL); ini_set('display_errors', 1);
// code below for uploading an image is taken from source: https://www.w3schools.com/php/php_file_upload.asp
$errorMessage_imageUpload = "";
$checkValidations = true;
var_dump($_FILES);
/*$imageUpload="";

$imageUpload=prevent_SQL_Injection_attack($_POST["imageUpload"]);*/

$imageUpload = prevent_SQL_Injection_attack(($_POST['fileToUpload']));

function prevent_SQL_Injection_attack($parameters)
{      // to stop sql injection attack, source:  https://www.w3schools.com/php/showphp.asp?filename=demo_form_validation_complete

    $parameters = htmlspecialchars($parameters);
    $parameters = stripslashes($parameters);
    $parameters = trim($parameters);
    return $parameters;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $errorMessage_imageUpload = imageUpload();
    if (!empty($errorMessage_imageUpload)) {

        $checkValidations = false;
        //$errorMessage_imageUpload;
        $errorMessage_imageUploadCSS = "background:#DE1643; border:1px solid #DE1643;";

    }

}

if ((isset($_POST['submit'])) and $checkValidations == true) {
    try {
        $target_directory = 'uploads/';
        $target_image_path = $target_directory . basename($_FILES['fileToUpload']['name']); // specifies path of the image to be uploaded
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_image_path)) {
            echo "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";
            $errorMessage_imageUpload = "";
            $errorMessage_imageUploadCSS = "border-color:#DCE1EC";
        } else {
            $errorMessage_imageUpload = "Sorry, we could'nt upload your image. Please try after some time.";
            $errorMessage_imageUploadCSS = "border-color:#DE1643";
            $flagImageUpload = false;
        }

    } catch (PDOException $e)       //catching exception, source : https://www.w3schools.com/php/php_mysql_insert.asp
    {

        $userMessageRecipeCreationFail = "Oops ! : 1) Fail to insert the data into the database  or 2) Fail to set up the database connection";

    }

}

function imageUpload()
{
    // reference starts here: source for file upload code: https://www.w3schools.com/php/php_file_upload.asp
    try {

        // reference starts here: source for file upload code: https://www.w3schools.com/php/php_file_upload.asp
        $errorMessage_imageUpload = "";
        $target_directory = 'uploads/';
        $target_image_path = $target_directory . basename($_FILES['fileToUpload']['name']); // specifies path of the image to be uploaded
        $imageExtension = strtolower(pathinfo($target_image_path, PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES['fileToUpload']['tmp_name']);
        //var_dump($check);
        //echo var_dump($_FILES);
        //echo $_FILES['fileToUpload'];
        // print_r($check);

        if ($_FILES["fileToUpload"]["size"] == 0) {
            $errorMessage_imageUpload = "Please select an image (jpg,png,and jpeg) of size upto 2MB.";
        } else if ($_FILES["fileToUpload"]["size"] > 2000000) {
            $errorMessage_imageUpload = "Sorry, your image is too large. Size limit is 2MB.";
        } else if ($imageExtension != "jpg" && $imageExtension != "png" && $imageExtension != "jpeg") {
            $errorMessage_imageUpload = "Sorry, only JPG, JPEG, and PNG  formats are allowed.";
        } else if (file_exists($target_image_path)) {
            $errorMessage_imageUpload = "Sorry, image with same name already exists.";
        } else if ($check == false) {
            $errorMessage_imageUpload = "Please select an image(jpg,png,and jpeg formats only) with size upto 2MB!";
        }
        // Check file size, should not be more than 2MB

        return ($errorMessage_imageUpload);

    } catch (Exception $e) {
        $errorMessage_imageUpload = $e->getMessage();
    }
// reference ends here: source for file upload code: https://www.w3schools.com/php/php_file_upload.asp

}


// code above for uploading an image is taken from source: https://www.w3schools.com/php/php_file_upload.asp


?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>RECIPE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/normalize.css">
    <!-- normalize stylesheet "https://github.com/necolas/normalize.css"/-->
    <link rel="stylesheet" href="css/createRecipe.css">
    <meta name="HandledFriendly" content="true">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- force IE compatibility mode off , "https://stackoverflow.com/questions/3449286/force-ie-compatibility-mode-off-using-tags?utm_medium=organic&utm_source=google_rich_qa&utm_campaign=google_rich_qa" -->


    <script src="js/createRecipe.js"></script>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <!-- source: https://www.w3schools.com/bootstrap/bootstrap_get_started.asp-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>


</head>

<body>
<!--<form method="post" enctype="multipart/form-data" action="<?php /*echo htmlentities($_SERVER["PHP_SELF"]);*/ ?>">
    <input type="file" name="fileToUpload" class="fileUpload">
    <input type="submit" value="Upload File" name="submit">
    <span style="color: red;"><?php /*echo $errorMessage_imageUpload;*/ ?></span> <br>
</form>-->

<form method="post" enctype="multipart/form-data" action="<?php echo htmlentities($_SERVER["PHP_SELF"]); ?>">


    <label><span class="glyphicon glyphicon-picture"></span> Upload Image *</label>
    <span class="errorMessage" id="errorMessageImageUpload"><?php echo $errorMessage_imageUpload; ?></span>
    <input type="file" name="fileToUpload" id="imageUploadInput" class="fileUpload" onchange="validateImage();"
           style="<?php echo $errorMessage_imageUploadCSS; ?>">
    <input type="submit" value="ADD RECIPE" name="submit">

    <!-- <input type="file" name="fileToUpload" class="fileUpload">-->

</form>


<!--<form method="post" enctype="multipart/form-data " action="<?php /*echo htmlentities($_SERVER["PHP_SELF"]);*/ ?>">

<div>
    <label>Upload Image</label>
    <input type="hidden" name="MAX_FILE_SIZE" value="2000000"/>
    <input type="file" name="fileToUpload" class="fileUpload"/>
    <span class="errorMessage"><?php /*echo $errorMessage_imageUpload;*/ ?></span> <br>
</div>
    <div class="columnOne CreateRecipeButton">
        <br>
        <input type="submit" value="CREATE RECIPE" name="submit"/>
    </div>

</form>-->
</body>
</html>

