<?php 

$_barangay_list = [];
// get assigned barangays 
$_select_brgy = "SELECT id FROM barangay WHERE assigned_midwife=$session_id";

if($_result_brgy = mysqli_query($conn, $_select_brgy))  {
    foreach($_result_brgy as $_row)  {
        $_b_id = $_row['id'];  
        array_push($_barangay_list, $_b_id); 
    } 
    mysqli_free_result($_result_brgy);
} 
else  { 
    mysqli_free_result($_result_brgy);
    $error = 'Something went wrong fetching data from the database.'; 
}  