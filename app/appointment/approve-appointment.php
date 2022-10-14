<?php

@include '../includes/config.php';

@include '../php-templates/redirect/admin-page-setter.php';
@include '../php-templates/redirect/midwife-only.php';

$id = $_GET['id'];


$sql = "UPDATE appointments SET status=1 WHERE appointment_id=$id;";

if (mysqli_query($conn, $sql)) {
    $response = 'Appointment Approved!'; 
}
else {
    $response = 'Something went wrong with approving the appointment in the database.'; 
    echo "<script>alert('$response');</script>";
}

$conn->close();

header('location: pending-appointment.php');
