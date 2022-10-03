<?php

@include '../includes/config.php';

@include '../php-templates/redirect/admin-page-setter.php';
@include '../php-templates/redirect/not-for-nurse.php';

$id = $_GET['id'];


// $sql = "SELECT treatment_record_id, medicine_record_id FROM appointment WHERE id=$id;";
$session_id = $_SESSION['id'];

if ($admin==0) {
    $sql2 = "DELETE FROM `appointments` WHERE `appointments`.`appointment_id` = $id;"; 
    $page_to = "pending-appointment";
} else {
    $sql2 = "DELETE FROM `appointments` 
        WHERE `appointments`.`appointment_id` = $id AND `appointments`.`patient_id` = $session_id; ";
    $page_to = "view-appointment";
}

if (mysqli_query($conn, $sql2)) { 
    $response = 'Appointment record deleted successfully.';   
}
else {
    $response = 'Something went wrong with deleting the appointment in the database.'; 
} 

echo "<script>alert('$response');</script>";

$conn->close();

header("location: $page_to.php");
