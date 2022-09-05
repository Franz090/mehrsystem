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

 
 
        $select = "SELECT id, 
            CONCAT(first_name,IF(mid_initial='', '', CONCAT(' ',mid_initial,'.')),' ',last_name) AS name, admin
            FROM users WHERE email = '$email' && password = '$pass'";
 

        $result = mysqli_query($conn, $select);

        if(!(mysqli_num_rows($result) > 0)) {
            $error = 'Incorrect password or email.';
            mysqli_free_result($result);
        }
        else { 
            foreach($result as $row)  {
 
                $id_from_db = $row['id'];    
 
                $name_from_db = $row['name'];    
                $admin_from_db = $row['admin']; 
            } 
            
 

            $_SESSION['id'] = $id_from_db;
            $_SESSION['usermail'] = $email;
            $_SESSION['name'] = $name_from_db;
            $_SESSION['admin'] = $admin_from_db;
          
 

            // if not nurse, get the barangay 
            if ($admin_from_db!=1) {
                mysqli_free_result($result);
                $select = "SELECT barangay_id FROM users,details 
                    WHERE users.id = $id_from_db && details_id = details.id";  
                $result = mysqli_query($conn, $select);
                if((mysqli_num_rows($result) > 0)) {  
                    foreach($result as $row)  { 
                        $barangay_id_from_db = $row['barangay_id']; 
                    } 
                    $_SESSION['barangay_id'] = $barangay_id_from_db;
                }
            }
            mysqli_free_result($result);
            header('location: ./dashboard'); 
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
  <script src="../js/jquery-3.6.1.min.js" ></script>
  <script src="../js/main.js"></script>
   
    <title>Admin Login</title>
</head>
<body>
    <div class="container">
        <h1 class="form__title">Admin Login</h1>
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
               <input type="password" class="form__input"  autofocus name="password" id="password" placeholder="Password" required />
                <i class="bi bi-eye-slash" id="togglePassword"></i>
                
                <!-- <div class="form__input-error-message"></div> -->
            </div>
            <button class="form__button" type="submit" id="submit" name="submit">Login</button>
            <p class="form__text">
                <a href="adminreset-password.php" id="form_link" class="form__link">Forgot your password?</a>
            </p>
            <p class="form__text">
                <a class="form__link" href="adminform.php">Don't have an account? Create account</a>
            </p>
        </form>
    <script src="js/main.js"></script>
    
</body>
</html>