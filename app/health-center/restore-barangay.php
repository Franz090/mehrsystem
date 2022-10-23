<?php

@include '../includes/config.php';

session_start();

@include '../php-templates/redirect/admin-page-setter.php';
@include '../php-templates/redirect/nurse-only.php';

$id = $_GET['id'];
 
$sql2 = "UPDATE barangays SET archived=0 WHERE `barangay_id` = $id"; 
$delete = mysqli_query($conn, $sql2);  
if ($delete) {
    $response = 'Barangay record restored successfully.';  
    $error = '';
}
else {
    $response = 'Something went wrong with restoring the barangay in the database.'; 
    $error = "?error=$response";
}  
$conn->close();
 
echo "<script>alert('".$response."');</script>";
 

header("location: view-barangay.php$error");

?>