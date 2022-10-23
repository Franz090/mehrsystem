<?php

@include '../includes/config.php';

@include '../php-templates/redirect/admin-page-setter.php';
@include '../php-templates/redirect/midwife-only.php';

$id = $_GET['id'];
// $d_id = $_GET['details_id'];
// $mh_id = $_GET['med_history_id'];

$sql_contacts = "DELETE FROM contacts WHERE owner_id = $id; ";
$sql_user_details = "DELETE FROM user_details WHERE user_id = $id; ";
$sql_patient_details = "DELETE FROM patient_details WHERE user_id = $id AND status=0; ";
$sql_users = "DELETE FROM users WHERE user_id = $id; ";

// echo "$sql_contacts $sql_user_details $sql_patient_details $sql_users";
 
if (mysqli_multi_query($conn, "$sql_contacts $sql_user_details $sql_patient_details $sql_users")) {
    $response = "Success";
}

$conn->close();

header('location: view-patients.php');

?> 