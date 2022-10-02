<?php

@include '../includes/config.php';

session_start();

@include '../php-templates/redirect/admin-page-setter.php';
@include '../php-templates/redirect/nurse-only.php';
 
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
          echo "<script>alert('Nurse Added!');</script>";
          //  header('location:adminform.php');  
        }
        else { 
           mysqli_free_result($result);
           $error .= 'Something went wrong inserting into the database.';
        }

     }  
  } 
}

 
 
$conn->close(); 

$page = 'add_nurse';
include_once('../php-templates/admin-navigation-head.php');
?>
<div class="d-flex" id="wrapper">
  <!-- css internal style -->
  <style>
     h3{
    font-weight: 900;  
    background-color: #ececec;  
    padding-top: 10px;
    position: relative;
    top: 8px;
  }
   label {
    font-family: Arial, Helvetica, sans-serif;
  }  
  
  </style>

  <!-- Sidebar -->
  <?php include_once('../php-templates/admin-navigation-left.php'); ?>

  <!-- Page Content -->
  <div id="page-content-wrapper" style="background-color: #F5F5F5;">
    <?php include_once('../php-templates/admin-navigation-right.php'); ?>

  <div class="container-fluid">
    <div class="row bg-light m-3"><h3>Add Nurse</h3>
      <div class="container default table-responsive p-4">
          <div class="col-md-8 col-lg-5 ">
            <form class="form" action="" method="post">
          <?php
            if(isset($error)) 
                echo '<span class="form__input-error-message">'.$error.'</span>'; 
          ?> 
          <div class="form__input-group">
                <input type="email"  class="form__input" name="usermail"
                placeholder="Email*"  autofocus required>
              </div>
          <div class="form__input-group">
              <input type="text" class="form__input" name="first_name" placeholder="First Name*" required>
               </div>
          <div class="form__input-group">
              <input type="text" class="form__input" name="mid_initial" placeholder="Middle Initial">
            </div>
           <div class="form__input-group">
              <input type="text" class="form__input" name="last_name" placeholder="Last Name*" required>
          </div> 
          <div class="form__input-group">
              <label>Status</label>
              <select class="form__input" name="status">
                <option value="Inactive" selected>Inactive</option>
                <option value="Active">Active</option>
              </select>
          </div> 
          <div class="form__input-group">
              <input type="password" class="form__input" name="password" id="password" autofocus placeholder="Password*" required>
                <!-- <input type="password" class="form__input"  autofocus name="password" id="password" placeholder="Password*" required />
                <i class="bi bi-eye-slash" id="togglePassword"></i> -->
            </div>
          <div class="form__input-group">
              <input type="password" class="form__input" name="cpassword" id="password" autofocus placeholder="Confirm password*" required />
          </div>
          <button class="form__button" value="register now" type="submit" id="submit" name="submit">Register Nurse</button> 
        </form> 
      </div> 
    </div>
  </div>
  </div>
  </div>
</div>

 <!-- <script>
        const togglePassword = document.querySelector("#togglePassword");
        const password = document.querySelector("#password");

        togglePassword.addEventListener("click", function () {
            // toggle the type attribute
            const type = password.getAttribute("type") === "password" ? "text" : "password";
            password.setAttribute("type", type);
            
            // toggle the icon
            this.classList.toggle("bi-eye");
        });

        // prevent form submit
        const form = document.querySelector("form");
        form.addEventListener('submit', function (e) {
            e.preventDefault();
        });
    </script> -->
<?php 
include_once('../php-templates/admin-navigation-tail.php');

?>