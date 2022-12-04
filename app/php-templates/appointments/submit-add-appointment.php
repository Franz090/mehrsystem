<?php

// add appointment
if(isset($_POST['submit_appointment'])) {
    $_POST['submit_appointment'] = null;
    $error = ''; 

    if (empty($_POST['date']))
      $error .= 'Fill up input fields that are required (with * mark)! ';
    else {   
        if ($current_user_is_a_midwife)  
            $id_trimester_split = explode('AND',$_POST['patient_id_trimester']); 
        
        $status = $current_user_is_a_midwife?1:0; 
        $a_date = mysqli_real_escape_string($conn, $_POST['date']);
        $patient_id = mysqli_real_escape_string($conn, ($current_user_is_a_midwife?$id_trimester_split[0]:$session_id));
        $trimester_post = mysqli_real_escape_string($conn, ($current_user_is_a_midwife?$id_trimester_split[1]:$trimester_from_db));

        

        $insert1 = "INSERT INTO appointments(patient_id, date, status, trimester) 
            VALUES($patient_id, '$a_date', $status, $trimester_post);";
        // echo $insert1;
        if (mysqli_query($conn,$insert1))  { 
          echo "<script>alert('Appointment Added!'); window.location.href='../';</script>"; 
        }
        else {  
          $error .= 'Something went wrong adding the appointment to the database.';
        }  
    }  
} 