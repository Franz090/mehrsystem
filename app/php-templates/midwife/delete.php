<?php

@include '../includes/config.php';

session_start();

@include '../php-templates/redirect/admin-page-setter.php';
@include '../php-templates/redirect/nurse-only.php';

$id = $_GET['id'];
$d_id = $_GET['details_id'];


$sql = "DELETE FROM `users` WHERE `users`.`id` = $id; 
    DELETE FROM `details` WHERE `details`.`id` = $d_id;
    UPDATE barangay SET `barangay`.`assigned_midwife`=NULL WHERE `barangay`.`assigned_midwife`=$id";
 
if (mysqli_multi_query($conn, $sql))  
    $response = 'Midwife record deleted successfully.';   
else {
    $response = 'Something went wrong with deleting the user from the database.'; 
}

$conn->close();
// not working 
echo "<script>alert('$response');</script>";

header('location: view-midwife.php');

?>