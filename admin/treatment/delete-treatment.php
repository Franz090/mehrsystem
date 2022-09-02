<?php

@include '../includes/config.php';

session_start();

@include '../php-templates/redirect/admin-page-setter.php';
@include '../php-templates/redirect/midwife-only.php';

$id = $_GET['id'];

// check if the treatment is not used 
$sql1 = "SELECT id FROM `treat_med_record` WHERE `treat_med_id` = $id";
$treat_med_record_check = mysqli_query($conn, $sql1); 
if (mysqli_num_rows($treat_med_record_check) > 0) {
    $response = 'Treatment can not be deleted, it is used.'; 
    $error = "?error=$response";
}else { 
    $sql2 = "DELETE FROM `treat_med` WHERE `id` = $id"; 
    $delete = mysqli_query($conn, $sql2);  
    if ($delete) {
        $response = 'Treatment record deleted successfully.';  
        $error = '';
    }
    else {
        $response = 'Something went wrong with deleting the treatment from the database.'; 
        $error = "?error=$response";
    }

} 
mysqli_free_result($treat_med_record_check);
// mysqli_free_result($delete);
$conn->close();
 
// echo "<script>alert('".$response."');</script>";
 

header("location: view-treatment.php$error");

?>