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
include_once('php-templates/admin-head.php'); 
include_once('php-templates/css/black-bg-remover.php');
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
              <a href="reset-password.php" class="forget-link text-decoration-none">
                Forgot your Password?
              </a>
            </div>
            <hr class="my-2">
            <div class="text-center mb-2 have-account">
              Don't have an account?
              <a href="register-form.php" class="register-link text-decoration-none">
                Register here
              </a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>
</htmL>
<script src="js/toggle-eye.js"></script>
<?php 
    include_once('php-templates/admin-tail.php');
?>

