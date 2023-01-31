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
<script
      src="https://kit.fontawesome.com/3e0ba4391f.js"
      crossorigin="anonymous"
    ></script>
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
  .upload{
  width: 100px;
  position: relative;
  margin: auto;
}
.ion-cam{
  color: #636863;
}
.upload img{
  border-radius: 50%;
  border: 6px solid #eaeaea;
}

.upload .round{
  position: absolute;
  bottom: 0;
  right: 0;
  background: #f0eded;
  width: 32px;
  height: 32px;
  line-height: 33px;
  text-align: center;
  border-radius: 10%;
  overflow: hidden;
}

.upload .round input[type = "file"]{
  position: absolute;
  transform: scale(2);
  opacity: 0;
}

input[type=file]::-webkit-file-upload-button{
    cursor: pointer;
}

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
       display: block;
    width: 100%;
     padding: .375rem 2.25rem .375rem .75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #495057;
    background-color: #f0eded;

    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right .75rem center;
    background-size: 16px 12px;
    border: none;
    border-radius: .23rem;
    appearance: none;
    font-family: "Open Sans", sans-serif;
    }
    .select-btn_ss:focus-visible,
    .select-btn_ss:active{
    border-color: #81cbb8!important;
    outline: 0!important;
   box-shadow: none;
}

 
    .select-btn_ss i{
      transition: transform 0.3s linear;
    }
    .select-btn_ss span{
      font-family: "Open Sans",sans-serif;
    }
    .wrapper_ss.active .select-btn_ss i{
      transform: rotate(-180deg);
    }
    .content_ss{
      display: none;
      position: absolute;
      z-index: 1;
      padding: 20px;
      background: #fff;
      border-radius: 7px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.1);
      width: 100%;
      border: 1px solid #dee2e6;      
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
    .ss{
      font-family: "Open Sans",sans-serif;
    }
    .search-logo{
      position: relative;
      top: 25px;
      left: 23px;
    }
     .search-logo1{
      position: relative;
      top: 26px;
      right: 130px;
    }
      .search_ss ion-icon {
        font-size: 17px; 
    }
    
   
    
    .search_ss input{
      width: 100%;
      outline: none;
      padding: 0 20px 0 43px;
      border: 1px solid #dbdcdc;
      border-top: none;
      border-right: none;
      border-left: none;
      padding-right: 200px;
    }
    .search_ss input:focus{
      padding-left: 42px;
      border: 1px solid #B3B3B3;
      border-top: none;
      border-right: none;
      border-left: none;
    }
    .search_ss input::placeholder{
      color: #bfbfbf;
    }
    .content_ss .options_ss{
      margin-top: 10px;
      max-height: 250px;
      overflow-y: auto;
      padding-right: 7px;
      font-family: "Open sans",sans-serif;
      height: 110px;
      overflow:scroll;
      scrollbar-width: none;
     -ms-overflow-style: none;
    }
    .content_ss .options_ss::-webkit-scrollbar {
      display: none;
      overflow: hidden;
    }
    .options_ss li .selected{
      font-family: "Open sans",sans-serif;
     
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
      font-family: "Open sans",sans-serif;
    }
    .options_ss li:hover, li.selected{
      border-radius: 5px;
      background: #029670;
      color: white;
      font-family: "Open sans",sans-serif;
    }



    
    /* view consultations */
   
     .content_ss1{
      display: none;
      position: absolute;
      z-index: 1;
      padding: 20px;
      background: #fff;
      border-radius: 7px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.1);
      width: 46%;
      border: 1px solid #dee2e6;      
    }
    .wrapper_ss.active .content_ss1{
      display: block;
      
    }
    .content_ss1 .search_ss1{
      position: relative;
    }
     .content_ss1 .options_ss{
      margin-top: 10px;
      max-height: 250px;
      overflow-y: auto;
      padding-right: 7px;
      font-family: "Open sans",sans-serif;
      height: 110px;
      overflow:scroll;
      scrollbar-width: none;
     -ms-overflow-style: none;
    }
    .content_ss1 .options_ss::-webkit-scrollbar {
      display: none;
      overflow: hidden;
    }
     .search_ss1 input{
    
      outline: none;
      padding: 0 20px 0 43px;
      border: 1px solid #dbdcdc;
      border-top: none;
      border-right: none;
      border-left: none;
      padding-right: 10px;
    }
    .search_ss1 input:focus{
      padding-left: 42px;
      border: 1px solid #B3B3B3;
      border-top: none;
      border-right: none;
      border-left: none;
    }
    .search_ss1 input::placeholder{
      color: #bfbfbf;
    }


    
    /* add infant vaccination */
    .content_ss2{
      display: none;
      position: absolute;
      z-index: 1;
      padding: 20px;
      background: #fff;
      border-radius: 7px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.1);
      
      bottom:120px;
      border: 1px solid #dee2e6;      
    }
    .wrapper_ss.active .content_ss2{
      display: block;
      
    }
    .content_ss2 .search_ss2{
      position: relative;
    }
     .content_ss2 .options_ss{
      margin-top: 10px;
      max-height: 250px;
      overflow-y: auto;
      padding-right: 7px;
      font-family: "Open sans",sans-serif;
      height: 110px;
      overflow:scroll;
      scrollbar-width: none;
     -ms-overflow-style: none;
    }
    .content_ss2 .options_ss::-webkit-scrollbar {
      display: none;
      overflow: hidden;
    }
     .search_ss2 input{
    
      outline: none;
      padding: 0 20px 0 43px;
      border: 1px solid #dbdcdc;
      border-top: none;
      border-right: none;
      border-left: none;
      padding-right: 10px;
    }
    .search_ss2 input:focus{
      padding-left: 42px;
      border: 1px solid #B3B3B3;
      border-top: none;
      border-right: none;
      border-left: none;
    }
    .search_ss2 input::placeholder{
      color: #bfbfbf;
    }
    @media only screen and (max-width: 600px) {
  .content_ss1 {
    width: auto;
    height: auto;
  }
  .search_ss1 input{
    width: 300px;
  }
}
  </style>
</head>

