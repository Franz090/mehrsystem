<?php

@include 'includes/config.php';

session_start();
// redirect if there is a logged in user
if (isset($_SESSION['usermail'])) 
   header('Location: admindashboard.php');
// register
if(isset($_POST['submit'])) {
   $_POST['submit'] = null;
   $error = '';
   if (empty($_POST['usermail']) || empty($_POST['password']) || empty($_POST['cpassword']))
      $error .= 'All input fields are required! ';
   else {
      $email = mysqli_real_escape_string($conn, $_POST['usermail']);
      $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
      $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
   
      $select = "SELECT * FROM admin WHERE email = '$email'";
   
      $result = mysqli_query($conn, $select);
   
      if(mysqli_num_rows($result) > 0 || $pass != $cpass)  {
         if (mysqli_num_rows($result) > 0)
            $error .= 'User already exists. '; 
         if ($pass != $cpass)
            $error .= 'Passwords do not match! ';
         mysqli_free_result($result);
      } 
      else  {
         $insert = "INSERT INTO admin(email, password, otp) VALUES('$email','$pass', '')";
      
         mysqli_query($conn, $insert);
         mysqli_free_result($result);
         header('location:adminform.php');  
      }  
   } 
}
$conn->close(); 
?>



<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <!-- bootstrap -->
   <link rel="shortcut icon" href="/assets/favicon.ico">
   <link rel="stylesheet" href="css/main.css">
   <title>Admin | Sign Up</title>
</head>

<body>
   <div class="container">
      <form id="createAccount" action="" method="post">
         <?php
         if(isset($error)) 
            echo '<span class="form__input-error-message">'.$error.'</span>'; 
      ?>
         <h1 class="form__title">Create Account</h1>
         <div class="form__message form__message--error"></div>
         <div class="form__input-group">
            <input type="text" class="form__input" name="usermail" autofocus placeholder="Email Address">
            <!-- <div class="form__input-error-message"></div> -->
         </div>
         <div class="form__input-group">
            <input type="password" class="form__input" name="password" autofocus placeholder="Password">
            <!-- <div class="form__input-error-message"></div> -->
         </div>
         <div class="form__input-group">
            <input type="password" class="form__input" name="cpassword" autofocus placeholder="Confirm password">
            <!-- <div class="form__input-error-message"></div> -->
         </div>
         <button class="form__button" value="register now" type="submit" name="submit">Register</button>
         <p class="form__text">
            <a class="form__link" href="adminlogin.php" id="linkLogin">Already have an account? Sign in</a>
         </p>
      </form>
      <script src="js/main.js"></script>
</body>

</html>