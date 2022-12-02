<?php
// get trimester of current patient user  
$select_trimester = "SELECT trimester FROM users u, patient_details p, user_details ud
    WHERE u.user_id=$session_id AND p.user_id=u.user_id AND ud.user_id=u.user_id";
$result_trimester = mysqli_query($conn, $select_trimester);
// echo $select_trimester;
if (mysqli_num_rows($result_trimester)) {
    foreach($result_trimester as $row)  
        $trimester_from_db = $row['trimester'];   
    mysqli_free_result($result_trimester);
} 
else  { 
    mysqli_free_result($result_trimester);
    $error = 'Something went wrong fetching data from the database.'; 
}    