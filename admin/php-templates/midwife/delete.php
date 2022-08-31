<?php

@include '../includes/config.php';

$id = $_GET['id'];
$d_id = $_GET['details_id'];

$sql1 = "DELETE FROM `users` WHERE `users`.`id` = $id";

$delete1 = mysqli_query($conn, $sql1); 
 
if ($delete1) {
    $sql2 = "DELETE FROM `details` WHERE `details`.`id` = $d_id";
    $delete2 = mysqli_query($conn, $sql2); 
    if ($delete2) {
        $response = 'Midwife record deleted successfully.';  
    }
    else {
        $response = 'Something went wrong with deleting the details of the user from the database.'; 
    } 
}
else {
    $response = 'Something went wrong with deleting the user from the database.'; 
}
// mysqli_free_result($delete);
$conn->close();
echo "<script>alert('$response');</script>";

header('location: view-midwife.php');

?>