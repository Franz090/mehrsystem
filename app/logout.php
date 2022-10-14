<?php

@include 'config/config.php';

session_start();
session_unset();
session_destroy(); 
// $conn->close(); 
header('location: ./');

?>