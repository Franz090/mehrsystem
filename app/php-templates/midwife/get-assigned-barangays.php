<?php 
$_barangay_list = [];

if ($admin==0) {
    // get assigned barangays 
    $_select_brgy = "SELECT barangay_id id FROM barangays WHERE assigned_midwife=$session_id AND archived=0";
    
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
}
