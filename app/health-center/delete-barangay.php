<?php

@include '../includes/config.php';

session_start();

@include '../php-templates/redirect/admin-page-setter.php';
@include '../php-templates/redirect/nurse-only.php';

$id = $_GET['id'];

// check if the barangay is not used 
$sql1 = "SELECT patient_details_id FROM `patient_details` WHERE `barangay_id` = $id";
$details_barangay_check = mysqli_query($conn, $sql1); 
if (mysqli_num_rows($details_barangay_check) > 0) {
    $response = 'Barangay can not be archived, it is used.'; 
    $error = "?error=$response";
}else { 
    $sql2 = "UPDATE barangays SET archived=1 WHERE `barangay_id` = $id"; 
    $delete = mysqli_query($conn, $sql2);  
    if ($delete) {
        $response = 'Barangay record archived successfully.';  
        $error = '';
    }
    else {
        $response = 'Something went wrong with archiving the barangay in the database.'; 
        $error = "?error=$response";
    } 
} 
mysqli_free_result($details_barangay_check);
// mysqli_free_result($delete);
$conn->close();
 
echo "<script>alert('".$response."');</script>";
 

header("location: view-barangay.php$error");

?>