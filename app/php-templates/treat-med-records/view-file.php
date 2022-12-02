<?php 

@include '../includes/config.php';

session_start();

@include '../php-templates/redirect/admin-page-setter.php';
// @include '../php-templates/redirect/not-for-nurse.php';

$conn->close(); 

$id = $_GET['id'];
// can later add data control 
$file = 'uploaded treatment files/treatment_file-'.$id;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Treatment File</title>
</head>
<body style="display: flex; justify-content:center; align-items:center">
    <img style="width: 80%"
        src="<?php echo $file?>"
    />
</body>
</html>