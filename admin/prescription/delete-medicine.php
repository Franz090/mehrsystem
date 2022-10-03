<?php

@include '../includes/config.php';

session_start();

@include '../php-templates/redirect/admin-page-setter.php';
@include '../php-templates/redirect/midwife-only.php';

$id = $_GET['id'];

// check if the medicine is not used 
$sql1 = "SELECT consultation_id FROM `consultations` WHERE `prescription_id` = $id";
$treat_med_record_check = mysqli_query($conn, $sql1); 
if (mysqli_num_rows($treat_med_record_check) > 0) {
    $response = 'Medicine can not be deleted, it is used.'; 
    $error = "?error=$response";
}else { 
    $sql2 = "DELETE FROM `treat_med` WHERE `treat_med_id` = $id"; 
    $delete = mysqli_query($conn, $sql2);  
    if ($delete) {
        $response = 'Medicine record deleted successfully.';  
        $error = '';
    }
    else {
        $response = 'Something went wrong with deleting the medicine from the database.'; 
        $error = "?error=$response";
    }

} 
mysqli_free_result($treat_med_record_check);
// mysqli_free_result($delete);
$conn->close();
 
// echo "<script>alert('".$response."');</script>";
 

header("location: view-medicine.php$error");

?>