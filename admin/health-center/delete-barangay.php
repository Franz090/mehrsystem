<?php

@include '../includes/config.php';

$id = $_GET['id'];

// check if the barangay is not used 
$sql1 = "SELECT id FROM `details` WHERE `barangay_id` = $id";
$details_barangay_check = mysqli_query($conn, $sql1); 
if (mysqli_num_rows($details_barangay_check) > 0) {
    $response = 'Barangay can not be deleted, it is used.'; 
    $error = "?error=$response";
}else { 
    $sql2 = "DELETE FROM `barangay` WHERE `barangay`.`id` = $id"; 
    $delete = mysqli_query($conn, $sql2);  
    if ($delete) {
        $response = 'Barangay record deleted successfully.';  
        $error = '';
    }
    else {
        $response = 'Something went wrong with deleting the barangay from the database.'; 
        $error = "?error=$response";
    }

} 
mysqli_free_result($details_barangay_check);
// mysqli_free_result($delete);
$conn->close();
 
echo "<script>alert(".$response.");</script>";
 

header("location: view-barangay.php$error");

?>