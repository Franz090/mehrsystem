<?php

@include 'includes/config.php';

session_start();
// redirect if there is a logged in user
if (isset($_SESSION['usermail'])) 
    header('Location: ./dashboard/');
   
//login
if(isset($_POST['submit'])) {
    $_POST['submit'] = null;
    if (empty($_POST['usermail']) || empty($_POST['password']))   
        $error = 'All input fields are required!';
    else {
        $email = mysqli_real_escape_string($conn, $_POST['usermail']);
        $pass = md5(mysqli_real_escape_string($conn,$_POST['password']));

 
        $select = "SELECT 
            CONCAT(first_name,IF(mid_initial='', '', CONCAT(' ',mid_initial,'.')),' ',last_name) AS name, admin
            FROM users WHERE email = '$email' && password = '$pass'";
 

        $result = mysqli_query($conn, $select);

        if(!(mysqli_num_rows($result) > 0)) {
            $error = 'Incorrect password or email.';
            mysqli_free_result($result);
        }
        else { 
            foreach($result as $row)  {
                $name_from_db = $row['name'];    
                $admin_from_db = $row['admin']; 
            } 
            
            $_SESSION['usermail'] = $email;
            $_SESSION['name'] = $name_from_db;
            $_SESSION['admin'] = $admin_from_db;

            mysqli_free_result($result);
            header('location: ./dashboard/'); 
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
   
    <title>Admin Login</title>
</head>
<body>
    <div class="container">
        <h1 class="form__title">Login</h1>
        <form class="form" id="login" action="" method="post">
            <?php
                if(isset($error)) 
                    echo '<span class="form__input-error-message">'.$error.'</span>'; 
            ?> 
            <div class="form__input-group">
                <input type="text" class="form__input" autofocus  name="usermail" 
                placeholder="Email">
                <!-- <input type="text" class="form__input" autofocus  name="usermail" 
                placeholder="Username or email"> -->
                <!-- <div class="form__input-error-message"></div> -->
            </div>
            <div class="form__input-group">
                <input type="password" class="form__input" name="password" autofocus placeholder="Password">
                <!-- <div class="form__input-error-message"></div> -->
            </div>
            <button class="form__button" type="submit" name="submit">Login</button>
            <p class="form__text">
                <a href="adminreset-password.php" class="form__link">Forgot your password?</a>
            </p>
            <p class="form__text">
                <a class="form__link" href="adminform.php">Don't have an account? Create account</a>
            </p>
        </form>
    <script src="js/main.js"></script>
    
    
</body>
</html>