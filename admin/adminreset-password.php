<?php

@include 'includes/config.php';

session_start();
// redirect if there is a logged in user
if (isset($_SESSION['usermail'])) 
    header('Location: admindashboard.php'); 
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
        $result = mysqli_query($conn, $select);
        if(mysqli_num_rows($result) > 0) { 
            // generate and send otp 
            foreach($result as $row) {
                // print_r($row);
                $id_from_db = $row['id'];
                $email_from_db = $row['email']; 
            } 
            $random_pin = rand(1000,9999);
            // TODO: remove this cookie from production
            setcookie('pin', $random_pin, time() + 60); 
            $random_pin_hashed = md5($random_pin);
            // echo "id: $id_from_db";
            $update_sql = "UPDATE users SET otp='$random_pin_hashed' WHERE id='$id_from_db'";
 
           
            mysqli_query($conn, $update_sql);
            // echo "email: $email_from_db";
            // TODO: email otp to $email_from_db

            mysqli_free_result($result);

            header('Location: adminreset-password-otp.php'); 
  
        } else  
            $error = 'User does not exist.'; 
    }
}
$conn->close();  

include_once('php-templates/admin-head.php');
?> 
<div class="container">
    <h1 class="form__title">Reset Password</h1>
    <form class="form" id="login" action="" method="post">
        <?php
            if(isset($error) ) 
                echo '<span class="form__input-error-message">'.$error.'</span>';   
        ?> 
        <div class="form__input-group">
            <input type="text" class="form__input" autofocus  name="email" 
                placeholder="Email"> 
        </div> 
        <button class="form__button" type="submit" name="submit" >Reset Password</button>
       
        <p class="form__text">
            <a class="form__link" href="adminreset-password-otp.php">Already have an OTP? Change your password here.</a>
        </p>
        <p class="form__text">
            <a class="form__link" href="adminlogin.php" id="linkLogin">Sign in</a>
        </p>
        <p class="form__text">
            <a class="form__link" href="adminform.php">Don't have an account? Create account</a>
        </p>
    </form> 
</div> 
<?php 
    include_once('php-templates/admin-tail.php');
?>