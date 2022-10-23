<?php 
$success = false;
@include 'includes/config.php'; 
session_start();
// redirect if there is a logged in user
if (isset($_SESSION['usermail'])) 
    header('Location: ./dashboard/'); 
 
if (isset($_POST['submit'])) {
    $error = '';
    $_POST['submit'] = null;
    if (empty($_POST['email']) || empty($_POST['otp'])  || empty($_POST['password']) || empty($_POST['cpassword']))   
       $error = 'Please enter your email address, matching passwords, and the one time pin.';
    else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $error = 'Email invalid.';
    }
    else if ($_POST['password'] != $_POST['cpassword']) {
        $error = 'Passwords do not match.';
    }
    else { 
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $otp = mysqli_real_escape_string($conn, md5($_POST['otp']));
        $pass = mysqli_real_escape_string($conn, md5($_POST['password'])); 
 

 
        $select = "SELECT * FROM users WHERE email = '$email' && otp = '$otp'";
 
        $result = mysqli_query($conn, $select);
        if(mysqli_num_rows($result) > 0) {  
            foreach($result as $row)  
                $id_from_db = $row['user_id'];  
 
            $update_sql = "UPDATE users SET password='$pass', otp=NULL WHERE user_id=$id_from_db";
 

            if (mysqli_query($conn, $update_sql))  
                $success = true;
            else  
                $success = false; 
        } else {
            
            $error = 'User does not exist.';
        } 
        mysqli_free_result($result);
    }
}
// $success = 'otp sent! Please check your email';
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
    <form class="form form-box px-3" action="" method="post">
        <?php
            if(isset($error)) 
                echo '<span class="form__input-error-message">'.$error.'</span>';   
        
            if ($success) {
        ?>
        
        <p class="form__text">Password updated successfully.</p>

        <?php    
            } else {
        ?>

        <div class="text-center mb-2 have-account" style="position:relative;bottom: 12px;">The OTP is sent to your email upon reset password request.
            <a class="register-link text-decoration-none" href="reset-password.php"> Don't have an OTP? Request here.</a>
      </div>
        <div class="form-input">
            <input type="text" autofocus name="email" placeholder="Email" tabindex="10" required>
        </div>
        <div class="form-input">
            <input type="password" name="password" autofocus placeholder="New Password" tabindex="10" required>
        </div>
        <div class="form-input">
            <input type="password"  name="cpassword" autofocus placeholder="Confirm New Password" tabindex="10" required>
        </div>
        <div class="form-input">
            <input type="number" autofocus name="otp" placeholder="One Time Pin" tabindex="10" required>
        </div>
    <div class="mb-3 position-relative ">
        <button class="w-100 btn btn-dark-dark  text-capitalize" style="font-family: arial;position:absolute;bottom: -35px;" type="submit" name="submit">Update Password</button>
            </div>
     
        <?php    
            }  
        ?>  
     <hr class="my-2" style="position:relative;top: 40px;">
        <a class="register-link text-decoration-none" href="../app"  style="position:relative;top: 50px;">Sign in</a>
       <div class="text-center mb-2 have-account" style="position:relative;top: 50px;">Don't have an account? 
        <a class="register-link text-decoration-none" href="register-form.php">Create account</a>
    <div>
    

    </form>
  
  </div>
</div>
</div>
</div>
<?php 
    include_once('php-templates/admin-tail.php');
?>