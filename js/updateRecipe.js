function fnSelectCategory(){
    var selectDropDown=document.getElementById("selectCategory");
    var selectedValue = selectDropDown.options[selectDropDown.selectedIndex].value;
    // alert(selectedValue);
    var temp1=selectedValue.localeCompare("Other");// return 0 if string matches
    var temp2=selectedValue.localeCompare("selectCategory");

    //alert(temp1);
    if(temp2===0){

        document.getElementById("selectCategory").style.border="1px solid #DE1643";
        document.getElementById("errorMessageSelectCategory").innerHTML="Please select category";
    }

    if(temp1===0){

        document.getElementById("hideOtherCategory").style.display="block";
        validateOtherCategory();
        document.getElementById("selectCategory").style.border="1px solid #DCE1EC";
        document.getElementById("errorMessageSelectCategory").innerHTML="";
    }
    else{
        document.getElementById("selectCategory").style.border="1px solid #DCE1EC";
        document.getElementById("errorMessageSelectCategory").innerHTML="";
        document.getElementById("hideOtherCategory").style.display="none";

        //document.getElementById("displayOtherCategory").style.display="none";
    }

}

function validateOtherCategory(){
    var otherCategoryInput = document.getElementById("otherCategoryInput").value;
    var pattern= /^([a-zA-Z]{3,20}\s*)+$/;
    var regex=new RegExp(pattern);

    if(regex.test(otherCategoryInput)){
        document.getElementById("otherCategoryInput").style.border="1px solid #DCE1EC";  // valid recipe name format
        document.getElementById("errorMessageOtherCategory").innerHTML="";
    }

    else{
        document.getElementById("otherCategoryInput").style.border="1px solid #DE1643"; // invalid recipe name format
        document.getElementById("errorMessageOtherCategory").innerHTML="Invalid other category name";

    }
}

function validateRecipeName() {
    var firstNameInput = document.getElementById("recipeNameInput").value;
    var pattern= /^([a-zA-Z]{3,20}\s*)+$/;
    var regex=new RegExp(pattern);

    if(regex.test(firstNameInput)){
        document.getElementById("recipeNameInput").style.border="1px solid #DCE1EC";  // valid recipe name format
        document.getElementById("errorMessageRecipeName").innerHTML="";
        selectCategory();
    }

    else{
        document.getElementById("recipeNameInput").style.border="1px solid #DE1643"; // invalid recipe name format
        document.getElementById("errorMessageRecipeName").innerHTML="Invalid recipe name";

    }
}

function selectCategory(){
    var selectDropDown=document.getElementById("selectCategory");
    var selectedValue = selectDropDown.options[selectDropDown.selectedIndex].value;

    if(selectedValue.toString()==="selectCategory"){
        document.getElementById("selectCategory").style.border="1px solid #DE1643";
        document.getElementById("errorMessageSelectCategory").innerHTML="Please select category";
    }
    else{
        document.getElementById("selectCategory").style.border="1px solid #DCE1EC";
        document.getElementById("errorMessageSelectCategory").innerHTML="";

    }
}

function validatePreparationTime() {
    var preparationTimeInput = document.getElementById("preparationTimeInput").value;
    var pattern= /^[0-9]{1,3}$/;
    var regex=new RegExp(pattern);

    if(regex.test(preparationTimeInput) && preparationTimeInput>=1 && preparationTimeInput<=300){
        document.getElementById("preparationTimeInput").style.border="1px solid #DCE1EC";  // valid
        document.getElementById("errorMessagePreparationTime").innerHTML="";
    }
    else{
        document.getElementById("preparationTimeInput").style.border="1px solid #DE1643"; // invalid
        document.getElementById("errorMessagePreparationTime").innerHTML="Select values between 1-300";
    }

}

function validateCookTime() {
    var cookTimeInput = document.getElementById("cookTimeInput").value;
    var pattern= /^[0-9]{1,3}$/;
    var regex=new RegExp(pattern);

    if(regex.test(cookTimeInput) && cookTimeInput>=1 && cookTimeInput<=300){
        document.getElementById("cookTimeInput").style.border="1px solid #DCE1EC";  // valid
        document.getElementById("errorMessageCookTime").innerHTML="";
    }
    else{
        document.getElementById("cookTimeInput").style.border="1px solid #DE1643"; // invalid
        document.getElementById("errorMessageCookTime").innerHTML="Select values between 1-300";
    }

}

function validateServings() {
    var servingsInput = document.getElementById("servingsInput").value;
    var pattern= /^[0-9]{1,3}$/;
    var regex=new RegExp(pattern);

    if(regex.test(servingsInput) && servingsInput>=1 && servingsInput<=100){
        document.getElementById("servingsInput").style.border="1px solid #DCE1EC";  // valid
        document.getElementById("errorMessageServings").innerHTML="";
        validateRating();
    }
    else{
        document.getElementById("servingsInput").style.border="1px solid #DE1643"; // invalid
        document.getElementById("errorMessageServings").innerHTML="Select values between 1-100";

    }
}

function validateRating() {
    if((document.getElementById('starOne').checked) || (document.getElementById('starTwo').checked)||(document.getElementById('starThree').checked)||(document.getElementById('starFour').checked)||(document.getElementById('starFive').checked)){
        document.getElementById("errorMessageRating").innerHTML="";
        /*document.getElementById('one').style.border="1px solid #000073";
        document.getElementById('two').style.border="1px solid #000073";
        document.getElementById('three').style.border="1px solid #000073";
        document.getElementById('four').style.border="1px solid #000073";
        document.getElementById('five').style.border="1px solid #000073";*/

    }
    else{
        document.getElementById("errorMessageRating").innerHTML="Please rate your recipe!";

        /*document.getElementById('one').style.border="1px solid #DE1643";
        document.getElementById('two').style.border="1px solid #DE1643";
        document.getElementById('three').style.border="1px solid #DE1643";
        document.getElementById('four').style.border="1px solid #DE1643";
        document.getElementById('five').style.border="1px solid #DE1643";*/
    }
}
function validateImage(){
    var imageToUpload=document.getElementById("imageUploadInput").value;

    if(imageToUpload=="")
    {
        document.getElementById("imageUploadInput").style.background="#DE1643"; // cannot leave image deselected
        document.getElementById("imageUploadInput").style.border="1px solid #DE1643";
        document.getElementById("errorMessageImageUpload").innerHTML="Please select an image";
    }
    else {
        var imageExtension=imageToUpload.substring(imageToUpload.lastIndexOf('.') + 1).toLowerCase(); //source: https://stackoverflow.com/questions/27309921/how-to-validate-the-image-size-before-uploading

        if (imageExtension == "png" || imageExtension == "jpeg" || imageExtension == "jpg")
        {
            if(document.getElementById("imageUploadInput").files[0].size <2097152) // image size less than 2MB ,source:https://stackoverflow.com/questions/27309921/how-to-validate-the-image-size-before-uploading
            {
                document.getElementById("imageUploadInput").style.border="1px solid #000073";
                document.getElementById("imageUploadInput").style.background="#000073";
                document.getElementById("errorMessageImageUpload").innerHTML="";
            }
            else{
                document.getElementById("imageUploadInput").style.border="1px solid #DE1643"; // greater image size
                document.getElementById("imageUploadInput").style.background="#DE1643";
                document.getElementById("errorMessageImageUpload").innerHTML="Maximum Image size allowed is 2 MB .";
            }
        }
        else{
            document.getElementById("imageUploadInput").style.border="1px solid #DE1643"; // invalid
            document.getElementById("imageUploadInput").style.background="#DE1643";
            document.getElementById("errorMessageImageUpload").innerHTML="Only jpg, jpeg and png formats are accepted.";
        }
    }
}


function validateVideo(){
    var videoInput=document.getElementById("videoInput").value;

    if(videoInput.length==0){
        document.getElementById("videoInput").style.border="1px solid #DCE1EC";  // do nothing
        document.getElementById("errorMessageVideo").innerHTML="";

    }
    else{
        var regex = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/; // source: https://ctrlq.org/code/19797-regex-youtube-id
        var temp = videoInput.match(regex);

        if ( temp && temp[7].length == 11 ) // source: https://ctrlq.org/code/19797-regex-youtube-id
        {
            document.getElementById("videoInput").style.border="1px solid #DCE1EC";  // do nothing
            document.getElementById("errorMessageVideo").innerHTML="";
        }
        else{
            document.getElementById("videoInput").style.border="1px solid #DE1643";  // do nothing
            document.getElementById("errorMessageVideo").innerHTML="Please select legitimate video URL from YouTube only.";

        }

    }
}

function validateIngredients() {
    var ingredientsInput = document.getElementById("ingredientsInput").value;
    var pattern= /[^\r\n]+((\r|\n|\r\n)[^\r\n]+)*/; // source: https://www.regextester.com/96976
    var regex=new RegExp(pattern);

    if(regex.test(ingredientsInput)){
        document.getElementById("ingredientsInput").style.border="1px solid #DCE1EC";  // valid recipe name format
        document.getElementById("errorMessageIngredients").innerHTML="";
    }

    else{
        document.getElementById("ingredientsInput").style.border="1px solid #DE1643"; // invalid recipe name format
        document.getElementById("errorMessageIngredients").innerHTML="Only letters, digits, whitespaces, (, ), /, - and commas are allowed.";

        // document.getElementById("errorMessageRating").innerHTML="Please rate your recipe.";

    }
}

function validateDirections() {
    var directionsInput = document.getElementById("directionsInput").value;
    var pattern= /[^\r\n]+((\r|\n|\r\n)[^\r\n]+)*/; // source: https://www.regextester.com/96976
    var regex=new RegExp(pattern);

    if(regex.test(directionsInput)){
        document.getElementById("directionsInput").style.border="1px solid #DCE1EC";  // valid recipe name format
        document.getElementById("errorMessageDirections").innerHTML="";
    }

    else{
        document.getElementById("directionsInput").style.border="1px solid #DE1643"; // invalid recipe name format
        document.getElementById("errorMessageDirections").innerHTML="Please enter valid characters!";
    }
}

function validateDescription() {
    var descriptionInput = document.getElementById("descriptionInput").value;
    var pattern= /[^\r\n]+((\r|\n|\r\n)[^\r\n]+)*/; // source: https://www.regextester.com/96976
    var regex=new RegExp(pattern);

    if(regex.test(descriptionInput)){
        document.getElementById("descriptionInput").style.border="1px solid #DCE1EC";  // valid recipe name format
        document.getElementById("errorMessageDescription").innerHTML="";
    }

    else{
        document.getElementById("descriptionInput").style.border="1px solid #DE1643"; // invalid recipe name format
        document.getElementById("errorMessageDescription").innerHTML="Only letters, digits, whitespaces, (, ), /, - and commas are allowed.";
    }
}

function validateNotesComments() {
    var notesCommentsInput = document.getElementById("notesCommentsInput").value;
    var pattern=/[^\r\n]+((\r|\n|\r\n)[^\r\n]+)*/; // source: https://www.regextester.com/96976
    var regex=new RegExp(pattern);

    if(regex.test(notesCommentsInput)){
        document.getElementById("notesCommentsInput").style.border="1px solid #DCE1EC";  // valid recipe name format
        document.getElementById("errorMessageNotesComments").innerHTML="";
    }

    else{
        document.getElementById("notesCommentsInput").style.border="1px solid #DE1643"; // invalid recipe name format
        document.getElementById("errorMessageNotesComments").innerHTML="Only letters, digits, whitespaces, (, ), /, - and commas are allowed.";
    }
}

function validateCollaborateEmail() {
    var collaborateEmailInput = document.getElementById("collaborateEmailInput").value;


    if(collaborateEmailInput.length==0)
    {
        document.getElementById("collaborateEmailInput").style.border="1px solid #DCE1EC";  // don't do anything if email is empty
        document.getElementById("errorMessageCollaborateEmail").innerHTML="";

    }
    else{
        var pattern=/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/ ;
        // source for above regular expression : https://emailregex.com/

        // var pattern=/^(?:[a-z0-9!#$%&amp;'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&amp;'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])$/;
        // source for above regular expression: http://form.guide/best-practices/validate-email-address-using-javascript.html

        var regexCollaborateEmail=new RegExp(pattern);

        if(regexCollaborateEmail.test(collaborateEmailInput)){
            document.getElementById("collaborateEmailInput").style.border="1px solid #DCE1EC";  // valid email format
            document.getElementById("errorMessageCollaborateEmail").innerHTML="";
        }

        else{
            document.getElementById("collaborateEmailInput").style.border="1px solid #DE1643"; // invalid email format
            document.getElementById("errorMessageCollaborateEmail").innerHTML="Invalid email format";
        }
    }

}

function validateShareEmail() {
    var shareEmailInput = document.getElementById("shareEmailInput").value;


    if(shareEmailInput.length==0)
    {
        document.getElementById("shareEmailInput").style.border="1px solid #DCE1EC";  // don't do anything if email is empty
        document.getElementById("errorMessageShareEmail").innerHTML="";

        document.getElementById("shareTimeInput").style.border="1px solid #DCE1EC";  // do nothing if share email is empty
        document.getElementById("errorMessageShareTime").innerHTML="";
        document.getElementById("shareTimeInput").value="";
       // document.getElementById("shareTimeInput").readOnly=true;

    }
    else{
        var pattern=/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/ ;
        // source for above regular expression : https://emailregex.com/

        // var pattern=/^(?:[a-z0-9!#$%&amp;'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&amp;'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])$/;
        // source for above regular expression: http://form.guide/best-practices/validate-email-address-using-javascript.html

        var regexShareEmail=new RegExp(pattern);

        if(regexShareEmail.test(shareEmailInput)){
            document.getElementById("shareEmailInput").style.border="1px solid #DCE1EC";  // valid email format
            document.getElementById("errorMessageShareEmail").innerHTML="";
            validateShareTime();
            //document.getElementById("shareTimeInput").readOnly=false;
        }

        else{
            document.getElementById("shareEmailInput").style.border="1px solid #DE1643"; // invalid email format
            document.getElementById("errorMessageShareEmail").innerHTML="Invalid email format";
            //document.getElementById("shareTimeInput").readOnly=true;
        }
    }

}

function validateShareTime() {
    var shareEmailInput = document.getElementById("shareEmailInput").value;

    if(shareEmailInput.length==0){
        document.getElementById("shareTimeInput").style.border="1px solid #DCE1EC";  // do nothing if share email is empty
        document.getElementById("errorMessageShareTime").innerHTML="";
        document.getElementById("shareTimeInput").value="";

    }
    else{

        var shareTimeInput = document.getElementById("shareTimeInput").value;
        var pattern= /^[0-9]{1,3}$/;
        var regex=new RegExp(pattern);


        if(regex.test(shareTimeInput) && shareTimeInput>=1 && shareTimeInput<=365)
        {
                document.getElementById("shareTimeInput").style.border="1px solid #DCE1EC";  // valid
                document.getElementById("errorMessageShareTime").innerHTML="";
        }
        else{
            document.getElementById("shareTimeInput").style.border="1px solid #DE1643"; // invalid
            document.getElementById("errorMessageShareTime").innerHTML="Select values between 1-365";
        }
    }


}




