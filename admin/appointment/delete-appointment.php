<?php

@include '../includes/config.php';

@include '../php-templates/redirect/admin-page-setter.php';
@include '../php-templates/redirect/midwife-only.php';

$id = $_GET['id'];


$sql = "SELECT treatment_record_id, medicine_record_id FROM appointment WHERE id=$id;";

if ($result = mysqli_query($conn, $sql)) {
    // $response = 'Appointment Approved!'; 
    foreach ($result as $row) {
        $tr_id = $row['treatment_record_id'];
        $mr_id = $row['medicine_record_id'];   
    }
    $sql2 = "DELETE FROM `appointment` WHERE `appointment`.`id` = $id;";
    $sql3 = "DELETE FROM `treat_med_record` WHERE `treat_med_record`.`id` = $tr_id;";
    $sql4 = "DELETE FROM `treat_med_record` WHERE `treat_med_record`.`id` = $mr_id;";

    if (mysqli_multi_query($conn, "$sql2 $sql3 $sql4")) { 
        $response = 'Appointment record deleted successfully.';   
    }
    else {
        $response = 'Something went wrong with deleting the appointment in the database.'; 
    } 
}
else { 
    $response = 'Something went wrong with deleting the appointment in the database.'; 
}

echo "<script>alert('$response');</script>";

$conn->close();

header('location: pending-appointment.php');
