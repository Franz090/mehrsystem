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
         $insert = "INSERT INTO users(first_name, mid_initial, last_name, email, password, status, admin, otp,details_id)
          VALUES('$first_name', '$mid_initial', '$last_name', '$email','$pass', $status, 1, '',null)";
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

include_once('php-templates/admin-head.php');
include_once('php-templates/css/black-bg-remover.php');
?>


<div class="container">
    <div class="row px-4">
      <div class="col-lg-12 col-xl-12 card flex-row mx-auto px-0" style="height: 550px;">
        <div class="img-left d-none col-sm-7 d-md-flex"></div>
        <div class="card-body">
          <h4 class="title text-center mt-1">
           Create Account
          </h4>
    
      <form class="form form-box px-3 " action="" method="post">
         <div class="text-center">
         <?php
         if(isset($error)) 
            echo '<span class="form__input-error-message">'.$error.'</span>'; 
      ?>
         </div>
         <div class="form-input">
            <input type="text"  name="usermail" autofocus placeholder="Email Address*"  tabindex="10" required>
         </div>
         <div class="form-input mb-1">
            <input class="mb-1" type="text" name="first_name" placeholder="First Name*" tabindex="10" required>
            <input class="mb-1" type="text" name="mid_initial" placeholder="Middle Initial" tabindex="10" required>
            <input type="text" class="form__input" name="last_name" placeholder="Last Name*" tabindex="10" required>
         </div> 
         <div class="form_select" style="position: relative;bottom: 10px;">
            <select  class="form_select_focus" id="selectCenter" name="status">
               <option value="" disabled selected hidden>Status</option>
               <option value="Inactive">Inactive</option>
               <option value="Active">Active</option>
            </select>
           </div>
         <div class="form-input"  style="position: relative;bottom: 19px;"> 
            <input class="mb-1" type="password" name="password" autofocus placeholder="Password*" tabindex="10" required>
            <input class="mb-1" type="password"  name="cpassword" autofocus placeholder="Confirm password*" tabindex="10" required>
         </div>
         <button style="position: relative; bottom: 25px;" class="w-100 btn  text-capitalize" value="register now" type="submit" name="submit">Register Nurse</button> 
      </form>
      <div class="text-center mb-2 have-account" style="position:relative;bottom: 20px;">Already have an account?
         <a class="register-link text-decoration-none" href="index.php" id="linkLogin"> Sign in</a>
     </div>
      
    </div>
  </div>
</div>
</div>

<?php 
    include_once('php-templates/admin-tail.php');
?>