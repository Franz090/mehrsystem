// option select view-appointments.php
function SelectRedirect(){
// ON selection of section this function will work
//alert( document.getElementById('s1').value);

switch(document.getElementById('s01').value)
{
    
case "Approved":
window.location="../appointment/approved-appointment.php";
break;
case "Pending":
window.location="../appointment/pending-appointment.php";
break;
/// Can be extended to other different selections of SubCategory //////
default:
window.location="../"; // if no selection matches then redirected to home page
break;
}// end of switch 
}