<?php

if(!isset($_SESSION['role'])) 
    header('location: ../'); 
else {
    $admin = $_SESSION['role'];  
    $current_user_is_an_admin = $admin==1; 
    $current_user_is_a_midwife = $admin==0; 
    $current_user_is_a_patient = $admin==-1;  
} 
// user is not a patient 
if (!$current_user_is_a_patient) {
    // if the account logged in is a nurse 
    // they will see add/view midwife 
    // else - meaning they are midwife, they ll see profile 
    $account_type_midwife = $current_user_is_an_admin ? "midwife":"profile";
    // echo $account_type_midwife;
} 

$select_footer_data = "SELECT * FROM footer WHERE footer_id=1";


if($result_footer_data = mysqli_query($conn, $select_footer_data))  {
    foreach($result_footer_data as $_row)  {
        $contact_num_select = "SELECT mobile_number FROM contacts WHERE type=0";
        if ($result_contact_num_select = mysqli_query($conn, $contact_num_select)) {
            if (mysqli_num_rows($result_contact_num_select)>0) { 
                $_contact_num = "Contact Numbers:"."<br/>";
                foreach ($result_contact_num_select as $_key=>$__row) {
                    $_contact_num .= ("(".$__row['mobile_number'].")" . 
                        (($_key===mysqli_num_rows($result_contact_num_select)-1)?"":'<br/>')); 
                }
            } 
        } 
        $footer_contact_no_str = $_contact_num; 
        $footer_email = $_row['email']?"Email: ".$_row['email']:NULL;  
        $footer_contacts = "$footer_contact_no_str"."<br/>"."$footer_email";

        $footer_address = $_row['address'];  
        $footer_availability = $_row['schedule'];  
        $footer_fb = $_row['fb_link'];   
    } 
    mysqli_free_result($result_footer_data);
} 
else  { 
    mysqli_free_result($result_footer_data);
    $error = 'Something went wrong fetching data from the database.'; 
}  