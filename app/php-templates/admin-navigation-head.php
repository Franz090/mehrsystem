<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="../img/rhu-logo.png" type="image/icon type" sizes="16x16 32x32">
  <!-- <link rel="stylesheet" href="../../css/main.css"> -->
  <link rel="stylesheet" href="../css/dashboard.css"> 
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/theme.css"> 
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
  <link rel="stylesheet" href="../css/material-design-iconic-font.css">
  <link rel="stylesheet" href="../css/material-design-iconic-font.min.css"> -->
  <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
  
  
  <script src="../js/jquery-3.6.1.min.js" ></script>
  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script> -->
  <!-- DATA TABLES -->
  <!-- <link rel="stylesheet" href="../css/jquery.dataTables.min.css"> -->
  <script src="../js/jquery.dataTables.min.js"></script>
  <script src="../js/dataTables.bootstrap5.min.js"></script>
  <link rel="stylesheet" href="../css/dataTables.bootstrap5.min.css">
   <!-- fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@700&display=swap" rel="stylesheet">
  
<!-- bootstrap 5.2 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" >
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" ></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css" integrity="sha384-xeJqLiuOvjUBq3iGOjvSQSIlwrpqjSHXpduPd6rQpuiM3f5/ijby8pCsnbu5S81n" crossorigin="anonymous">
   <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
 
 
<!-- calendar  -->
  <?php if ($admin==-1) { ?>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link rel="stylesheet" href="../calendar/css/bootstrap.min.css">
    <link rel="stylesheet" href="../calendar/fullcalendar/lib/main.min.css">
    <script src="../calendar/js/jquery-3.6.0.min.js"></script>
    <script src="../calendar/js/bootstrap.min.js"></script>
    <script src="../calendar/fullcalendar/lib/main.min.js"></script>
  <?php } ?>
  <?php echo isset($additional_script) ? $additional_script : ''; ?>

  
</head>

