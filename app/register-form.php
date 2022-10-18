<?php

@include 'includes/config.php';

session_start();

// redirect if there is a logged in user
if (isset($_SESSION['usermail'])) 
   header('Location: ./dashboard');

// register
if(isset($_POST['submit'])) { 
   $_POST['submit'] = null;
   $error = ''; 
   $select_next_user_id = "SELECT COUNT(user_id) c FROM users;"; 

   if($result_next_user_id =  mysqli_query($conn, $select_next_user_id) )  { 
      foreach ($result_next_user_id as $row) {
         $next_user_id = $row['c']+1;
      }
   } 


   if (empty(trim($_POST['usermail'])) || 
      empty(trim($_POST['password'])) || 
      empty(trim($_POST['cpassword'])) ||
      empty(trim($_POST['first_name'])) ||
      empty(trim($_POST['last_name'])))
      $error .= 'Fill up input fields that are required (with * mark)! ';
   else {
      $email = mysqli_real_escape_string($conn, $_POST['usermail']);
      $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
      $mid_name = mysqli_real_escape_string($conn, $_POST['mid_name']);
      $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
      $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
      $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword'])); 
   
      $select = "SELECT user_id FROM users WHERE email = '$email'";  
      $result = mysqli_query($conn, $select);
   
      if(mysqli_num_rows($result) > 0 || $pass != $cpass)  {
         if (mysqli_num_rows($result) > 0)
            $error .= 'User already exists. '; 
         if ($pass != $cpass)
            $error .= 'Passwords do not match! ';
         mysqli_free_result($result);
      } 
      else  {
         $insert_user = "INSERT INTO users(user_id, email, password, role)
            VALUES($next_user_id, '$email','$pass', 0); ";
         $insert_user_details = "INSERT INTO user_details(user_id, first_name, middle_name, last_name)
            VALUES($next_user_id, '$first_name', '$mid_name', '$last_name'); ";

         if (mysqli_multi_query($conn, "$insert_user $insert_user_details"))  {
            mysqli_free_result($result);
            header('location:index.php');  
         }
         else { 
            mysqli_free_result($result);
            $error .= 'Something went wrong registering user into the database.';
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
            <h4 class="title text-center">
            Create Midwife Account
            </h4>
    
            <form class="form form-box px-3 " action="" method="post">
               <div class="text-center">
               <?php
                  if(isset($error)) 
                     echo '<span class="form__input-error-message">'.$error.'</span>'; 
               ?>
               </div>
               <div class="form-input">
                  <input type="text"  name="usermail" autofocus placeholder="Email Address*"  
                     tabindex="10" required>
               </div>
               <div class="form-input">
                  <input class="mb-1" type="text" name="first_name" placeholder="First Name*" 
                     tabindex="10" required>
                    
               </div>
                <div class="form-input">
                  <input class="mb-1" type="text" name="mid_name" placeholder="Middle Name" 
                     tabindex="10" required>
                 </div>
                  <div class="form-input">
                  <input type="text" class="form__input" name="last_name" placeholder="Last Name*" 
                     tabindex="10" required>
               </div>  
               <div class="form-input"  > 
                  <input class="mb-1" type="password" name="password" autofocus placeholder="Password*" tabindex="10" required>
                  <input class="mb-1" type="password"  name="cpassword" autofocus placeholder="Confirm password*" tabindex="10" required>
               </div>
               
               <button style="position: relative; top: 3px;" class="w-100 btn text-capitalize" 
                  value="register now" type="submit" name="submit">Register Midwife</button> 
            </form>
           <hr class="my-2" style="position:relative;top: 10px;">
            <div class="text-center mb-2 have-account" style="position:relative;top: 10px;">
               Already have an account?
               <a class="register-link text-decoration-none" href="index.php" id="linkLogin">
                  Sign in</a>
            </div> 
         </div>

      </div> 
   </div>
</div>

<?php include_once('php-templates/admin-tail.php'); ?>