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
   
    $insert = "INSERT INTO barangays(health_center, assigned_midwife, archived) 
      VALUES('$health_center', NULL, 0)";
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
  

<div class="container_nu"> 
  <!-- Sidebar -->
  <?php include_once('../php-templates/admin-navigation-left.php'); ?> 
  <!-- Page Content -->
  <div class="main_nu">
    <?php include_once('../php-templates/admin-navigation-right.php'); ?>

    <div class="container-fluid default">
      <div class="background-head row m-2 my-4"><h4 class="pb-3 m-3 fw-bolder ">Add New Barangay</h4><hr>

        <div class="container default table-responsive p-4">
          <div class="col-md-8 col-lg-5 ">
        <form class="form form-box px-3" style="padding-top: 4px;" action="" method="post">
 
          <?php
            if(isset($error)) 
                echo '<span class="form__input-error-message">'.$error.'</span>'; 
          ?> 
          <div class="form-floating">
            <input type="text" class="form-control" name="health_center"  placeholder="Barangay Health Center" id="floatingPassword"  >
             <label for="floatingPassword">Barangay Health Center</label>
          </div>  
          <button class="w-100 btn  text-capitalize" type="submit" name="submit">Register Barangay</button> 
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