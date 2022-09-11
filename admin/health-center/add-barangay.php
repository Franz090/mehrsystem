<?php

@include '../includes/config.php';

session_start();

@include '../php-templates/redirect/admin-page-setter.php';  
@include '../php-templates/redirect/nurse-only.php';

// register
if(isset($_POST['submit'])) {
  $_POST['submit'] = null;
  $error = '';  
  if (empty($_POST['health_center']))
    $error .= 'Fill up input fields that are required (with * mark)! ';
  else {
    $health_center = mysqli_real_escape_string($conn, $_POST['health_center']); 
   
    $insert = "INSERT INTO barangay(health_center, assigned_midwife) 
      VALUES('$health_center', NULL)";
    if (mysqli_query($conn, $insert))  {
      echo "<script>alert('Barangay Added!');</script>";
    }
    else { 
        $error .= 'Something went wrong inserting into the database.';
    } 
  } 
} 

$conn->close(); 

$page = 'add_barangay';
include_once('../php-templates/admin-navigation-head.php');
?>
 
<style>
label {
  font-family: Arial, Helvetica, sans-serif;
}  
</style>


<div class="d-flex" id="wrapper"> 
  <!-- Sidebar -->
  <?php include_once('../php-templates/admin-navigation-left.php'); ?> 
  <!-- Page Content -->
  <div id="page-content-wrapper">
    <?php include_once('../php-templates/admin-navigation-right.php'); ?>

    <div class="container-fluid">
      <div class="row bg-light m-3"><h3>Add New Barangay</h3>

        <div class="container default table-responsive p-4">
          <div class="col-md-8 col-lg-5 ">
        <form class="form" action="" method="post">
 
          <?php
            if(isset($error)) 
                echo '<span class="form__input-error-message">'.$error.'</span>'; 
          ?> 
          <div class="form__input-group">
            <input type="text" class="form__input" name="health_center" autofocus placeholder="Barangay Health Center*" required>
          </div> 
          <!-- <div class="form__input-group">
              <label>Status</label>
              <select class="form__input" name="status">
                <option value="Inactive" selected>Inactive</option>
                <option value="Active">Active</option>
              </select>
          </div>   -->
          <button class="form__button" type="submit" name="submit">Register Barangay</button> 
        </form>  
          </div>
        </div>

      </div>
    </div>

  </div>
</div>
 
<?php 
include_once('../php-templates/admin-navigation-tail.php');
?>