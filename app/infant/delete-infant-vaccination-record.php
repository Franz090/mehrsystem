<?php

@include '../includes/config.php';

session_start();

@include '../php-templates/redirect/admin-page-setter.php';
@include '../php-templates/redirect/midwife-only.php';

$id = $_GET['id'];
$infant_id = $_GET['infant_id'];

 
$sql = "DELETE FROM `infant_vac_records` WHERE `infant_vac_rec_id` = $id"; 
 
if ($delete = mysqli_query($conn, $sql)) {
    $response = 'Barangay record deleted successfully.';  
    $error = '';
} 
// mysqli_free_result($delete);
$conn->close();
 
// echo "<script>alert('".$response."');</script>";
 

header("location: infant-vacc-record.php?id=$infant_id");

?>