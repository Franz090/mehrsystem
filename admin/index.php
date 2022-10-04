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
 
        // $select = "SELECT user_id, 
        //     CONCAT(first_name,IF(middle_name IS NULL, '', CONCAT(' ',middle_name)),' ',last_name) AS name, admin
        //     FROM users WHERE email = '$email' && password = '$pass'";

        
        $select = "SELECT u.user_id, u.role, 
            CONCAT(first_name, 
                IF(middle_name IS NULL OR middle_name='', '', CONCAT(' ', SUBSTRING(middle_name, 1, 1), '.')), 
                ' ', last_name) name 
        FROM (SELECT user_id, role FROM users WHERE email = '$email' && password = '$pass') u 
        LEFT JOIN user_details USING(user_id);";
 
        // echo $select;
        $result = mysqli_query($conn, $select);

        if(!(mysqli_num_rows($result) > 0)) {
            $error = 'Incorrect password or email.';
            mysqli_free_result($result);
        }
        else { 
            foreach($result as $row)  {
 
                $id_from_db = $row['user_id'];   
                $name_from_db = $row['name'];    
                // $status_from_db = $row['status'];    
                $role_from_db = $row['role']; 
            } 
            
            // if ($status_from_db==0) {
            //     $error = 'Your account is not activated.';
            //     mysqli_free_result($result);
            // }
            // else {
                $_SESSION['id'] = $id_from_db;
                $_SESSION['usermail'] = $email;
                $_SESSION['name'] = $name_from_db;
                $_SESSION['role'] = $role_from_db;
                // $_SESSION['status'] = $status_from_db;
              
     
    
                // if patient, get the barangay 
                if ($role_from_db==-1) {
                    mysqli_free_result($result);
                    $select = "SELECT barangay_id FROM users LEFT JOIN patient_details 
                        USING (user_id)";  
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
            // } 
        } 
    } 
} 

$conn->close(); 

?>

<!-- comment ni francis <!DOCTYPE html>
<body>
    <div class="container">
        <h1 class="form__title">Login</h1>
        <form class="form" id="login" action="" method="post">
            <div class="form__input-group">
                <input type="text" class="form__input" autofocus  name="usermail" 
                placeholder="Email"> -->
                <!-- comment ni daniel <input type="text" class="form__input" autofocus  name="usermail" 
                placeholder="Username or email"> -->
                <!-- <div class="form__input-error-message"></div> -->
            <!-- comment ni francis </div>
            <div class="form__input-group">
               <input type="password" class="form__input"  autofocus name="password" id="password" placeholder="Password" required />
                <i class="bi bi-eye-slash" id="togglePassword"></i>
                 -->
                <!-- comment ni daniel <div class="form__input-error-message"></div> -->

            <!-- comment ni francis </div>
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
</html> -->
<!DOCTYPE html>
<html>
<head>
  <title>RHU Login</title>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="icon" href="img/rhu-logo.png" type="image/icon type" sizes="16x16 32x32">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="css/login.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
  
  

  <!-- script -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

  <!-- fonts -->
  
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@700&display=swap" rel="stylesheet">
</head>
<body>
  <div class="container">
    <div class="row px-4">
      <div class="col-lg-12 col-xl-12 card flex-row mx-auto px-0" style="height: 550px;">
        <div class="img-left d-none col-sm-7 d-md-flex"></div>

        <div class="card-body">
          <h4 class="title text-center mt-4">
            Login 
          </h4>
            <form class="form form-box px-3" id="login" action="" method="post">
              <div class="text-center">
            <?php
                if(isset($error)) 
                    echo '<span class="form__input-error-message">'.$error.'</span>'; 
            ?> 
            </div>
            <div class="form-input">
              <input type="email"  name="usermail" autofocus placeholder="Email Address" tabindex="10" required>
            </div>
            <div class="form-input">
              <input type="password" name="password" id="id_password"  autocomplete="current-password" placeholder="Password" required>
              <i class="bi bi-eye-slash" id="togglePassword" style="padding-bottom: 20px;margin-left: -30px; cursor: pointer;"></i>
            </div>

            <div class="mb-3">
              <div class="custom-control">
               
                
              </div>
            </div>

            <div class="mb-3 position-relative ">
              <button type="submit" name="submit" style="font-family: arial;position:absolute;bottom: -2px;" class="w-100 btn btn-dark-dark  text-capitalize">
                Log In
              </button>
              <br>
            </div>

            <div class="text-center">
              <a href="adminreset-password.php" class="forget-link text-decoration-none">
                Forget your Password?
              </a>
            </div>

          
     

            <hr class="my-2">

            <div class="text-center mb-2 have-account">
              Don't have an account?
              <a href="adminform.php" class="register-link text-decoration-none">
                Register here
              </a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
<script>
    //  toggle eye
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#id_password');

    togglePassword.addEventListener('click', function () {
      // toggle the type attribute
      const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
      password.setAttribute('type', type);
      // toggle the eye slash icon
      this.classList.toggle('bi-eye');
    });
</script>



