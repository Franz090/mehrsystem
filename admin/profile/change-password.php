<?php

@include '../includes/config.php';

session_start();

if(!isset($_SESSION['usermail'])) 
  header('location:../');


if (isset($_POST['submit'])) {
  $error = '';
  $_POST['submit'] = null;
  if (empty($_POST['current']) || empty($_POST['new'])  || empty($_POST['cnew']))   
    $error = 'Please enter your current password and matching passwords as your new password.'; 
  else if ($_POST['new'] != $_POST['cnew']) {
    $error = 'New Password fields do not match.';
  }
  else { 
    $email = mysqli_real_escape_string($conn, $_SESSION['usermail']);
    $current_password = mysqli_real_escape_string($conn, md5($_POST['current']));
 
    $select = "SELECT * FROM users WHERE email = '$email' && password = '$current_password'";

    $result = mysqli_query($conn, $select);

    if(mysqli_num_rows($result) > 0) {  

        $new_password = mysqli_real_escape_string($conn, md5($_POST['new']));
        
        foreach($result as $row)  
            $id_from_db = $row['id'];  

        $update_sql = "UPDATE users SET password='$new_password' WHERE id=$id_from_db";


        if (mysqli_query($conn, $update_sql)) {
          $error= '';
          echo "<script>alert('Password updated!');</script>";
        }   
        else  {
          $error = 'Something went wrong changing your password.';
        }

        mysqli_free_result($result);

    } else { 
        $error = 'Wrong current password.';
    } 
  }
}

$conn->close(); 

$page = 'change_password';
include_once('../php-templates/admin-navigation-head.php');
?>
 
<div class="d-flex" id="wrapper">

  <!-- Sidebar -->
  <?php include_once('../php-templates/admin-navigation-left.php'); ?>

  <!-- Page Content -->
  <div id="page-content-wrapper" style="background-color: #f0cac4">
    <?php include_once('../php-templates/admin-navigation-right.php'); ?>

    <div class="container">
      <div class="row bg-light m-3">Change Password
        <form class="form" action="" method="post">
          <?php
            if(isset($error)) 
                echo '<span class="form__input-error-message">'.$error.'</span>'; 
          ?> 
          <div class="form__input-group">
              <input type="password" class="form__input" autofocus  name="current" 
              placeholder="Current Password"> 
          </div>
          <div class="form__input-group">
              <input type="password" class="form__input" autofocus  name="new" 
              placeholder="New Password"> 
              <input type="password" class="form__input" autofocus  name="cnew" 
              placeholder="Confirm New Password"> 
          </div>
          <button class="form__button" type="submit" name="submit">Update Password</button>
        </form> 
      </div>
    </div>
  </div>
</div>
 
<?php 
include_once('../php-templates/admin-navigation-tail.php');
?>