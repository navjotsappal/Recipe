function validateFirstName() {
    var firstNameInput = document.getElementById("firstNameInput").value;
    var pattern= /^([a-zA-Z]{3,20}\s*)+$/;
    var regex=new RegExp(pattern);

    if(regex.test(firstNameInput)){
        document.getElementById("firstNameInput").style.border="1px solid #DCE1EC";  // valid first name format
        document.getElementById("errorMessageFirstName").innerHTML="";
    }

    else{
        document.getElementById("firstNameInput").style.border="1px solid #DE1643"; // invalid first name format
        document.getElementById("errorMessageFirstName").innerHTML="Invalid first name";
    }
}

function validateLastName() {
    var firstNameInput = document.getElementById("lastNameInput").value;
    var pattern= /^([a-zA-Z]{3,20}\s*)+$/;
    var regex=new RegExp(pattern);

    if(regex.test(firstNameInput)){
        document.getElementById("lastNameInput").style.border="1px solid #DCE1EC";  // valid first name format
        document.getElementById("errorMessageLastName").innerHTML="";
    }

    else{
        document.getElementById("lastNameInput").style.border="1px solid #DE1643"; // invalid last name format
        document.getElementById("errorMessageLastName").innerHTML="Invalid last name";
    }
}


function validateEmail() {
    var emailInput = document.getElementById("emailId").value;
    var pattern=/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/ ;
    // source for above regular expression : https://emailregex.com/

    // var pattern=/^(?:[a-z0-9!#$%&amp;'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&amp;'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])$/;
    // source for above regular expression: http://form.guide/best-practices/validate-email-address-using-javascript.html

    var regexEmail=new RegExp(pattern);

    if(regexEmail.test(emailInput)){
        document.getElementById("emailId").style.border="1px solid #DCE1EC";  // valid email format
        document.getElementById("errorMessageEmail").innerHTML="";
    }

    else{
        document.getElementById("emailId").style.border="1px solid #DE1643"; // invalid email format
        document.getElementById("errorMessageEmail").innerHTML="Invalid email format";
    }
}


function validatePassword(){
    var passwordInput = document.getElementById("passwordInput").value;
    if(passwordInput.length<8){
        document.getElementById("passwordInput").style.border="1px solid #DE1643"; // password
        document.getElementById("errorMessagePassword").innerHTML="Minimum 8 characters in password";
    }

    else{
        document.getElementById("passwordInput").style.border="1px solid #DCE1EC"; // password
        document.getElementById("errorMessagePassword").innerHTML="";

    }
}

function validateConfirmPassword(){
    var confirmPasswordInput = document.getElementById("confirmPasswordInput").value;
    var passwordInput = document.getElementById("passwordInput").value;


    if(confirmPasswordInput.length<8){
        document.getElementById("confirmPasswordInput").style.border="1px solid #DE1643"; // password
        document.getElementById("errorMessageConfirmPassword").innerHTML="Minimum 8 characters in confirm password";
    }

    else if(confirmPasswordInput.localeCompare(passwordInput)!=0){
        document.getElementById("confirmPasswordInput").style.border="1px solid #DE1643"; // password
        document.getElementById("errorMessageConfirmPassword").innerHTML="Password and confirm password do not match";
    }

    else{
        document.getElementById("confirmPasswordInput").style.border="1px solid #DCE1EC"; // password
        document.getElementById("errorMessageConfirmPassword").innerHTML="";
    }

}
