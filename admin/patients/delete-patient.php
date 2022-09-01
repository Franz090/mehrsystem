<?php

@include '../includes/config.php';

@include '../php-templates/redirect/admin-page-setter.php';
@include '../php-templates/redirect/midwife-only.php';

$id = $_GET['id'];
$d_id = $_GET['details_id'];
$mh_id = $_GET['med_history_id'];

$sql1 = "DELETE FROM `users` WHERE `users`.`id` = $id;";
$sql2 = "DELETE FROM `details` WHERE `details`.`id` = $d_id;";
$sql3 = "DELETE FROM `med_history` WHERE `med_history`.`id` = $mh_id;";

 
 
if (mysqli_multi_query($conn, "$sql1 $sql2 $sql3")) { 
    $response = 'Patient record deleted successfully.';   
}
else {
    $response = 'Something went wrong with deleting the user from the database.'; 
}
$conn->close();
echo "<script>alert('$response');</script>";

header('location: view-patients.php');

?>