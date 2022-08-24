<?php
// dev
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'emr';
// prod 
// $dbhost = '';
// $dbuser = '';
// $dbpass = '';
// $dbname = '';
$conn = mysqli_connect($dbhost, $dbuser,  $dbpass, $dbname);

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
    echo "DB Connection Failed" . $conn->connect_error;
}