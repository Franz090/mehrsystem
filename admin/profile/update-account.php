<?php

@include '../includes/config.php';

session_start();

@include '../php-templates/redirect/admin-page-setter.php';
 

if (isset($_POST['submit'])) {
  $error = '';
  $_POST['submit'] = null;
  if (!empty($_POST['new']) && (empty($_POST['current'])) ||
    !empty($_POST['new_email']) && empty($_POST['current']) || 
    empty($_POST['new_email']) && empty($_POST['new']))   
    $error = 'Please enter your current password and your desired change(s).'; 
  else if ($_POST['new'] != $_POST['cnew']) {
    $error = 'New Password fields do not match.';
  }
  else { 
    $cemail = mysqli_real_escape_string($conn, $_SESSION['usermail']);
    $current_password = mysqli_real_escape_string($conn, md5($_POST['current']));
 
    $select = "SELECT * FROM users WHERE email = '$cemail' && password = '$current_password'";

    $result = mysqli_query($conn, $select);

    if(mysqli_num_rows($result) > 0) {  
      $update_str = '';
      if (!empty($_POST['new'])) {
        $new_password = mysqli_real_escape_string($conn, md5($_POST['new']));
        $update_str .= ("password='$new_password'" . ((!empty($_POST['new_email']))?", ":""));
      }
      if (!empty($_POST['new_email'])) {
        $new_email = mysqli_real_escape_string($conn, ($_POST['new_email']));
        $update_str .= "email='$new_email'";
      } 

        foreach($result as $row)  
            $id_from_db = $row['user_id'];  

        $update_sql = "UPDATE users SET $update_str WHERE user_id=$id_from_db";
        // echo $update_sql;

        if (mysqli_query($conn, $update_sql)) {

          $error= '';
          if (!empty($_POST['new_email'])) $_SESSION['usermail'] = $new_email;
          echo "<script>alert('Accout updated!');</script>";
        }   
        else  {
          $error = 'Something went wrong updating your account.';
        } 

        mysqli_free_result($result); 
    } else { 
        $error = 'Wrong current password.';
    } 
  }
}
 
$conn->close(); 

$page = 'update_account';
include_once('../php-templates/admin-navigation-head.php');
?>
 
<div class="d-flex" id="wrapper"> 
  <!-- Sidebar -->
  <?php include_once('../php-templates/admin-navigation-left.php'); ?>
  <!-- Page Content -->
  <div id="page-content-wrapper">
    <?php include_once('../php-templates/admin-navigation-right.php'); ?>

    <div class="container-fluid default" >
      <div class="background-head row m-2 my-4" ><h4 class="m-2 fw-bolder ">Update Account</h4>
        <div class="container default p-4 ">
          <div class="col-md-8 col-lg-5 ">
        <form class="form form-box px-3" style="bottom:100px;position:relative;"  action="" method="post">
          <?php
            if(isset($error)) 
                echo '<span class="form__input-error-message">'.$error.'</span><br/>'; 
          ?> 
          
          <!-- <div class="form__input-group">
              <input type="password" class="form__input" autofocus  name="current" required
              placeholder="Current Password"> 
          </div> -->
          Put your current password to authorize the change(s)
          <div class="form-input">
              <input type="password" class="form-input"  name="current" autofocus placeholder="Current Password" tabindex="10" required>
            </div>
          
          <!-- <div class="form__input-group">
              <input type="email" class="form__input"  name="new_email" 
              placeholder="New Email"> 
          </div> -->
          Leave blank if you do not want to change the email
          <div class="form-input">
              <input type="email" class="form-input"  name="new_email" autofocus placeholder="New Email" tabindex="10" required>
            </div>

          
          <!-- <div class="form__input-group">
              <input type="password" class="form__input"  name="new" 
              placeholder="New Password"> 
          </div> -->
          Leave blank if you do not want to change the password
          <div class="form-input">
              <input type="password" class="form-input"  name="new" autofocus placeholder="New Password" tabindex="10" required>
            </div>
          <!-- <div class="form__input-group">
              <input type="password" class="form__input"  name="cnew" 
              placeholder="Confirm New Password"> 
          </div> -->
           <div class="form-input">
              <input type="password" class="form-input"  name="cnew" autofocus placeholder="Confirm New Password" tabindex="10" required>
            </div>
          <button class="w-100 btn  text-capitalize" type="submit" name="submit">Update Account</button>
        </form> 
      </div>
    </div>
      </div> 
    </div>
  </div> 
</div>


 
<?php include_once('../php-templates/admin-navigation-tail.php'); ?>