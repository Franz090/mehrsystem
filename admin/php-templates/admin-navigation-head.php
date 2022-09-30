<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- <link rel="stylesheet" href="../../css/main.css"> -->
  <link rel="stylesheet" href="../css/dashboard.css">
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
  <link rel="stylesheet" href="../css/material-design-iconic-font.css">
  <link rel="stylesheet" href="../css/material-design-iconic-font.min.css"> -->
  <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
  <script src="../js/jquery-3.6.1.min.js" ></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- DATA TABLES -->
  <!-- <link rel="stylesheet" href="../css/jquery.dataTables.min.css"> -->
  <script src="../js/jquery.dataTables.min.js"></script>
  <script src="../js/dataTables.bootstrap5.min.js"></script>
  <link rel="stylesheet" href="../css/dataTables.bootstrap5.min.css">
  
  


  <?php echo isset($additional_script) ? $additional_script : ''; ?>
  <style>
    .container {
      --color-error: #cc3333;
    }
    body{
      font-family: 'Open Sans',
		sans-serif;
    }
    .form {
      --color-primary: #0275d8;
	    --color-primary-dark: #1871be;
      --color-secondary: #252c6a;
      --color-info: #00C0F0;
      --color-info-dark: #19C6F1;
      --color-success: #4bb544;
      --border-radius: 4px;
    }
    .form__input,
    .form__button {
      font: 500 1rem 'Quicksand', sans-serif;
    } 
    .form>*:first-child {
      margin-top: 0;
    } 
    .form>*:last-child {
      margin-bottom: 0;
    }.form__title {
      margin-bottom: 2rem;
      text-align: center;
    } 
    .form__message {
      text-align: center;
      margin-bottom: 1rem;
    } 
    .form__message--error {
      color: var(--color-error);
    } 
    .form__input-group {
      margin-bottom: 1rem;
      font-family: arial, sans-serif;
    } 
    .form__input {
      display: block;
      width: 100%;
      padding: 0.75rem;
      box-sizing: border-box;
      border-radius: var(--border-radius);
      border: 1px solid #dddddd;
      outline: none;
      background: #e1e1e1;
      transition: background 0.2s, border-color 0.2s;
    } 
    .form i {
      margin-left: 390px;
      cursor: pointer;
      color: black;
      
    }
    .form__input:focus {
      border-color: var(--color-primary);
      background: #ffffff;
    } 
    .form__input--error {
      color: var(--color-error);
      border-color: var(--color-error);
    } 
    .form__input-error-message {
      margin-top: 0.5rem;
      font-size: 0.85rem;
      color: var(--color-error);
    } 
    .form__button {
      width: 100%;
      padding: 1rem 2rem;
      font-weight: bold;
      font-size: 1.1rem;
      color: #ffffff;
      border: none;
      border-radius: var(--border-radius);
      outline: none;
      cursor: pointer;
      background: var(--color-primary);
    } 
    .form__button:hover {
      background: var(--color-primary-dark);
    } 
    .form__button:active {
      transform: scale(0.98);
    } 
    .form__text {
      text-align: center;
    } 
    #page-content-wrapper {
 	    background-color: #F5F5F5;
    }
    td{
      font-weight: 500;
      font-size: 15px;
      line-height: 2;
      font-family: arial, sans-serif;
    }
    th{
      font-size: 16px;
    } 
    .btn-info{
      background: #0ab1ff;
      border: none;
      color: white;
    }
    .btn-info:hover{
      background:  #19abf0;
      border: none;
      color: whitesmoke;
    }
    .btn-info:focus{
      color: whitesmoke;
      background:  #19abf0;
      border: none;
    }

    hr{
    margin-top: 5px;
    display: block;
    border-style: inset;
    border-width: 2px;
    margin-bottom: 1px;
    }
    /* from treatment and prescription records */
    h3{
        font-weight: 900;  
        background-color: #ececec;  
        padding-top: 10px;
        position: relative;
        top: 8px;
    }
    label {
        font-family: Arial, Helvetica, sans-serif;
    }   
      /* table  */
    .table {
      margin: auto;
      width: 100%!important;
      padding-top: 13px; 
    }
    .btn {
      font-family: arial,sans-serif;
      border-radius: 3px;
      margin: 2px 4px;
      font-weight: 400;
      font-size: 15px;
    } 
    a {
      text-decoration: none;
      color: white;
    }
    a:hover {
      color: #e2e5de;
    } 
    /* end   */



    

  </style> 
</head>

<body>