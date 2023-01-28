<?php

@include '../includes/config.php';

session_start();

@include '../php-templates/redirect/admin-page-setter.php';
@include '../php-templates/redirect/patient-status-checker.php';

if (isset($_POST['submit_cred'])) {
  $error = '';
  $_POST['submit_cred'] = null;
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

          echo "<script>alert('Account updated!');window.location.href='../dashboard/index.php';</script>";
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
$page = 'view_password';
include_once('../php-templates/admin-navigation-head.php');
?>
 
<div class="container_nu"> 
  <!-- Sidebar -->
  <?php include_once('../php-templates/admin-navigation-left.php'); ?>
  <!-- Page Content -->
  <div class="main_nu">
    <?php include_once('../php-templates/admin-navigation-right.php'); ?>

    <div class="container-fluid default" >
      <div class="background-head row m-2 my-4" >
       
        <h4 class="pb-5 m-3 fw-bolder ">Change Password</h4>
 <div class="container-fluid d-flex justify-content-center ">
            <form class="form form-box px-2 text-center" method="post">
    
              <label class="mb-2">Put your current password to authorize the change(s)</label>
              <div class=" mb-3">
               
                  <input type="password" class="form-control"   name="current"  placeholder="Password"  >
                  
                </div>      
              <label class="mb-2">Current Email: <?php echo $_SESSION['usermail']?><br/>Leave blank if you do not want to change the email</label>
              <div class=" mb-3">
                  <input type="email" class="form-control" id="floatingInputInvalid"  name="new_email" placeholder="New Email Address" tabindex="11">
                  
                </div>
               <label  class="mb-2"> Leave blank if you do not want to change the password</label>
              <div class="mb-3">
                  <input type="password" class="form-control"  
                    name="new" placeholder="New Password" id="floatingPassword"/>
                    
                </div> 
              <div class=" mb-2 text-center">
                  <input type="password" class="form-control"  
                    name="cnew" placeholder="Confirm New Password" id="floatingPassword"/>
                </div>
              <br>
               <div class="col-md-12 text-center">
               <button class="btn-primary w-30 btn text-capitalize" type="submit" name="submit_cred">Update Password</button>
              </div>
            </form> 
  </div>


      </div> 
    </div>

  </div> 
</div>
  <?php include_once('../php-templates/admin-navigation-tail.php'); ?>