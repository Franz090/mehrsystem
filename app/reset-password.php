<?php

@include 'includes/config.php';

session_start();
// redirect if there is a logged in user
if (isset($_SESSION['usermail'])) 
    header('Location: ./dashboard/'); 
// check if there is such user 
if (isset($_POST['submit'])) {
    $error = '';
    $_POST['submit'] = null;
    if (empty($_POST['email']))   
       $error = 'Please enter your email address.';
    else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $error = 'Email invalid.';
    }
    else {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $select = "SELECT * FROM users WHERE email = '$email'"; 
        if($result = mysqli_query($conn, $select)) { 
            // generate and send otp 
            foreach($result as $row) {
                // print_r($row);
                $id_from_db = $row['user_id'];
                $email_from_db = $row['email']; 
            } 
            $random_pin = rand(1000,9999);  
            $random_pin_hashed = mysqli_real_escape_string($conn, md5($random_pin)); 
            $update_sql = "UPDATE users SET otp='$random_pin_hashed' WHERE user_id=$id_from_db";
            include '../phpmailer/reset-mail.php';
            
            mysqli_query($conn, $update_sql);  
            mysqli_free_result($result); 
            // header('Location: reset-password-otp.php');  
        } else  { 
            $error = 'User does not exist.'; 
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
          <h4 class="title text-center mt-4">
           Reset Password
          </h4>
    <form class="form form-box px-3" id="login" action="" method="post">
         <div class="text-center">
        <?php
            if(isset($error) ) 
                echo '<span class="form__input-error-message">'.$error.'</span>';   
        ?> 
        </div>
        <div  class="form-input">
            <input type="text"  autofocus  name="email" 
                placeholder="Email" tabindex="10" required>  
        </div> 
   <div class="mb-3 position-relative ">
        <button class="w-100 btn btn-dark-dark  text-capitalize" style="font-family: arial;position:absolute;bottom: -2px;" type="submit" name="submit" >Reset Password</button>
        <br>
        <br>
    </div>
       <div class="text-center">Already have an OTP?
            <a class="forget-link text-decoration-none" href="reset-password-otp.php"> Change your password here.</a>
        </div>
   
         <div class="text-center">
            <a class="forget-link text-decoration-none"  href="index.php">Sign in</a>
        </div>
        <hr class="my-2">
         <div class="text-center mb-2 have-account">Don't have an account? 
            <a class="register-link text-decoration-none" href="register-form.php">Create account
            </a>
          </div>
    </form> 
   </div> 
   </div>
  </div>
</div>
<?php 
    include_once('php-templates/admin-tail.php');
?>