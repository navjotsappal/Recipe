function fnSelectCategory(){
    var selectDropDown=document.getElementById("selectCategory");
    var selectedValue = selectDropDown.options[selectDropDown.selectedIndex].value;
    // alert(selectedValue);
    var str=selectedValue.localeCompare("selectCategory");

    if(str==0){
        //document.getElementById("displayContainer").style.display="none";
        document.getElementById("errorMessage").innerHTML='* Required';

    }
    else{
       // document.getElementById("displayContainer").style.display="block";
        document.getElementById("errorMessage").innerHTML='';
    }
}

