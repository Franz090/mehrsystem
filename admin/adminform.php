<?php

@include 'includes/config.php';

session_start();
// redirect if there is a logged in user
if (isset($_SESSION['usermail'])) 
   header('Location: ./dashboard/index.php');
// register
if(isset($_POST['submit'])) {
   $_POST['submit'] = null;
   $error = '';


   if (empty($_POST['usermail']) || 
      empty($_POST['password']) || 
      empty($_POST['cpassword']) ||
      empty($_POST['first_name']) ||
      empty($_POST['last_name']) ||
      empty($_POST['status']))
      $error .= 'Fill up input fields that are required (with * mark)! ';
   else {
      $email = mysqli_real_escape_string($conn, $_POST['usermail']);
      $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
      $mid_initial = mysqli_real_escape_string($conn, $_POST['mid_initial']);
      $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
      $status = mysqli_real_escape_string($conn, ($_POST['status']=='Inactive'?0:1));
      $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
      $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
   
      $select = "SELECT * FROM users WHERE email = '$email'";

   
      $result = mysqli_query($conn, $select);
   
      if(mysqli_num_rows($result) > 0 || $pass != $cpass)  {
         if (mysqli_num_rows($result) > 0)
            $error .= 'User already exists. '; 
         if ($pass != $cpass)
            $error .= 'Passwords do not match! ';
         mysqli_free_result($result);
      } 
      else  {
         $insert = "INSERT INTO users(first_name, mid_initial, last_name, email, password, status, admin, otp)
          VALUES('$first_name', '$mid_initial', '$last_name', '$email','$pass', $status, 1, '')";
         if (mysqli_query($conn, $insert))  {
            mysqli_free_result($result);
            header('location:adminform.php');  
         }
         else { 
            mysqli_free_result($result);
            $error .= 'Something went wrong inserting into the database.';
         }

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

         <div class="form__input-group">
            <input type="text" class="form__input" name="usermail" autofocus placeholder="Email Address*">
         </div>
         <div class="form__input-group">
            <input type="text" class="form__input" name="first_name" placeholder="First Name*">
  
            <input type="text" class="form__input" name="mid_initial" placeholder="Middle Initial">
         
            <input type="text" class="form__input" name="last_name" placeholder="Last Name*">
         </div> 
         <div class="form__input-group">
            <label>Status</label>
            <select class="form__input" name="status">
               <option value="Inactive" selected>Inactive</option>
               <option value="Active">Active</option>
            </select>
         </div> 
         <div class="form__input-group">
            <input type="password" class="form__input" name="password" autofocus placeholder="Password*">
         
            <input type="password" class="form__input" name="cpassword" autofocus placeholder="Confirm password*">
         </div>
         <button class="form__button" value="register now" type="submit" name="submit">Register Nurse</button> 
      </form>
      <p class="form__text">
         <a class="form__link" href="index.php" id="linkLogin">Already have an account? Sign in</a>
      </p>
      <script src="js/main.js"></script>
</body>

</html>