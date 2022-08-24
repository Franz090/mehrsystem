<?php 
$success = false;
@include 'includes/config.php'; 
session_start();
// redirect if there is a logged in user
if (isset($_SESSION['usermail'])) 
    header('Location: admindashboard.php'); 
// check if there is such user 
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
                $id_from_db = $row['id'];  
            $update_sql = "UPDATE users SET password='$pass', otp='' WHERE id=$id_from_db";

            if (mysqli_query($conn, $update_sql))  
                $success = true;
            else  
                $success = false;

            mysqli_free_result($result);

        } else {
            $error = 'User does not exist.';
        } 
    }
}
// $success = 'otp sent! Please check your email';
$conn->close();  

include_once('php-templates/admin-head.php');
?>
<div class="container">
    <h1 class="form__title">Reset Password</h1>
    <form class="form" action="" method="post">
        <?php
            if(isset($error)) 
                echo '<span class="form__input-error-message">'.$error.'</span>';   
        
            if ($success) {
        ?>
        
        <p class="form__text">Password updated successfully.</p>

        <?php    
            } else {
        ?>

        <p class="form__text">The OTP is sent to your email upon reset password request.
            <a class="form__link" href="adminreset-password.php"> Don't have an OTP? Request here.</a>
        </p>
        <div class="form__input-group">
            <input type="text" class="form__input" autofocus name="email" placeholder="Email">
        </div>
        <div class="form__input-group">
            <input type="password" class="form__input" name="password" autofocus placeholder="New Password">
        </div>
        <div class="form__input-group">
            <input type="password" class="form__input" name="cpassword" autofocus placeholder="Confirm New Password">
        </div>
        <div class="form__input-group">
            <input type="number" class="form__input" autofocus name="otp" placeholder="One Time Pin">
        </div>
        <button class="form__button" type="submit" name="submit">Update Password</button>
        <p class="form__text">
            <a class="form__link" href="adminreset-password.php">Don't have an OTP? Request here.</a>
        </p> 
        <?php    
            }  
        ?>  
        
    </form>
    <p class="form__text">
        <a class="form__link" href="adminlogin.php" id="linkLogin">Sign in</a>
    </p> 
    <p class="form__text">
        <a class="form__link" href="adminform.php">Don't have an account? Create account</a>
    </p>
</div>
<?php 
    include_once('php-templates/admin-tail.php');
?>