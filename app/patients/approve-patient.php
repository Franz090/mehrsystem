<?php

@include '../includes/config.php';

@include '../php-templates/redirect/admin-page-setter.php';
@include '../php-templates/redirect/midwife-only.php';

$id = $_GET['id'];
// $d_id = $_GET['details_id'];
// $mh_id = $_GET['med_history_id'];

$sql1 = "UPDATE patient_details SET status=1; ";

 
 
mysqli_query($conn, "$sql1");

$conn->close();

header('location: view-patients.php');

?> 