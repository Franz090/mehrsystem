<!DOCTYPE html>
<html lang="en">
  
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" >
  <!-- calendar  -->

  <link rel="icon" href="../img/rhu-logo.png" type="image/icon type" sizes="16x16 32x32">
  <!-- <link rel="stylesheet" href="../../css/main.css"> -->

  <link rel="stylesheet" href="../css/new-ui.css"/> 

  <link rel="stylesheet" href="../css/dashboard.css"> 
  <link rel="stylesheet" href="../css/bootstrap.min.css">
 
  <?php if (!$current_user_is_an_admin) { ?>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link rel="stylesheet" href="../calendar/css/bootstrap.min.css">
    <link rel="stylesheet" href="../calendar/fullcalendar/lib/main.min.css">
    <script src="../calendar/js/jquery-3.6.0.min.js"></script>
    <script src="../calendar/js/bootstrap.min.js"></script>
    <script src="../calendar/fullcalendar/lib/main.min.js"></script>
  <?php } ?>
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
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" ></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css" integrity="sha384-xeJqLiuOvjUBq3iGOjvSQSIlwrpqjSHXpduPd6rQpuiM3f5/ijby8pCsnbu5S81n" crossorigin="anonymous">
   <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
 
 <!-- icon frameworks go to https://ionic.io/ionicons -->
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

  <?php //echo isset($additional_script) ? $additional_script : ''; ?>
  <link rel="stylesheet" href="../css/theme.css"> 
  <!-- for searchable select -->
  <style> 
    /* *{
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    } */
    ::selection{
      color: #fff;
      background: #4285f4;
    }
    .wrapper_ss{
    }
    li{
      display: flex;
      align-items: center;
      cursor: pointer;
    }
    .select-btn_ss{
      padding: 0 20px;
      background: #fff;
      border-radius: 7px;
      justify-content: space-between;
      box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    .select-btn_ss i{
      transition: transform 0.3s linear;
    }
    .wrapper_ss.active .select-btn_ss i{
      transform: rotate(-180deg);
    }
    .content_ss{
      display: none;
      padding: 20px;
      margin-top: 15px;
      background: #fff;
      border-radius: 7px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    .wrapper_ss.active .content_ss{
      display: block;
    }
    .content_ss .search_ss{
      position: relative;
    }
    .search_ss i{
      top: 50%;
      left: 15px;
      color: #999;
      pointer-events: none;
      transform: translateY(-50%);
      position: absolute;
    }
    .search_ss input{
      width: 100%;
      outline: none;
      border-radius: 5px;
      padding: 0 20px 0 43px;
      border: 1px solid #B3B3B3;
    }
    .search_ss input:focus{
      padding-left: 42px;
      border: 2px solid #4285f4;
    }
    .search_ss input::placeholder{
      color: #bfbfbf;
    }
    .content_ss .options_ss{
      margin-top: 10px;
      max-height: 250px;
      overflow-y: auto;
      padding-right: 7px;
    }
    .options_ss::-webkit-scrollbar{
      width: 7px;
    }
    .options_ss::-webkit-scrollbar-track{
      background: #f1f1f1;
      border-radius: 25px;
    }
    .options_ss::-webkit-scrollbar-thumb{
      background: #ccc;
      border-radius: 25px;
    }
    .options_ss::-webkit-scrollbar-thumb:hover{
      background: #b3b3b3;
    }
    .options_ss li{
      padding: 0 13px;
    }
    .options_ss li:hover, li.selected{
      border-radius: 5px;
      background: #f2f2f2;
    }
  </style>
</head>

