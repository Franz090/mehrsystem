<?php

@include '../includes/config.php';

$id = $_GET['id'];

$sql = "DELETE FROM `users` WHERE `users`.`id` = $id";

$delete = mysqli_query($conn, $sql); 

if ($delete) {
    $response = 'Nurse record deleted successfully.';  
}
else {
    $response = 'Something went wrong with deleting the user from the database.'; 
}
// mysqli_free_result($delete);
$conn->close();
echo "<script>alert('".$response."');</script>";

header('location: view-nurse.php');

?>