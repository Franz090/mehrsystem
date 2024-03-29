<?php

@include '../includes/config.php';

session_start();
 
@include '../php-templates/redirect/admin-page-setter.php';
@include '../php-templates/redirect/midwife-only.php'; 

// add treatment
if(isset($_POST['submit'])) { 
  $_POST['submit'] = null;
  $error = ''; 
  if (empty($_POST['name']) || 
    empty($_POST['description']))
    $error .= 'Fill up input fields that are required (with * mark)! ';
  else {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);   
    // $status = mysqli_real_escape_string($conn, ($_POST['status']=='Inactive'?0:1)); 

    $insert1 = "INSERT INTO treat_med(name, description, type) 
    VALUES('$name', '$description', 1);  ";
    
    if (mysqli_query($conn,"$insert1"))  { 
    echo "<script>alert('Treatment Added!');</script>"; 
    }
    else {  
        $error .= 'Something went wrong adding the treatment to the database.';
    }  
  } 
}

$conn->close(); 

$page = 'add_treatment';
include_once('../php-templates/admin-navigation-head.php');
?>
<style>
.form-control:focus{
  border: 1px solid #ebecf0;
	box-shadow: 0 0 5px #60e9d5;
  font-family: 'Open Sans',sans-serif;
	-webkit-transition: all 0.30s ease-in-out;
  -moz-transition: all 0.30s ease-in-out;
	-ms-transition: all 0.30s ease-in-out;
  -o-transition: all 0.30s ease-in-out;
} 
.has-error .form-control:focus{
  box-shadow: none; 
  -webkit-box-shadow: none;
}
.form-control{
  border-radius: 10px;
  padding-left: 15px;
}
</style>
<div class="d-flex" id="wrapper"> 
  <!-- Sidebar -->
  <?php include_once('../php-templates/admin-navigation-left.php'); ?> 
  <!-- Page Content -->
  <div id="page-content-wrapper">
    <?php include_once('../php-templates/admin-navigation-right.php'); ?>

    <div class="container-fluid">
      <div class="background-head row m-2 my-4"><h4 class="pb-3 m-3 fw-bolder ">Add Treatment</h4><hr>
      <div class="container default table-responsive p-4">
          <div class="col-md-8 col-lg-5 ">
        <form class="form form-box px-3" style="bottom:100px;position:relative;" action="" method="post" >
          <?php
            if(isset($error)) 
                echo '<span class="form__input-error-message">'.$error.'</span>'; 
          ?> 
          <div class="form-input">
            <input type="text" class="form-input" name="name" autofocus placeholder="Treatment Type*" required/>
          </div>
          <div class="form-input">
              <textarea type="text" class="form-control form-control-md w-100" name="description" placeholder="Description*" required></textarea>
          </div>  
          <!-- <div class="form__input-group">
              <label>Status</label>
              <select class="form__input" name="status">
                <option value="Inactive" selected>Inactive</option>
                <option value="Active">Active</option>
              </select>
          </div>   -->
          <button class="w-100 btn  text-capitalize" type="submit" name="submit">Add Treatment</button> 
        </form>  
      </div>
     </div>
    </div>
   </div>
  </div>
</div>
 
<?php include_once('../php-templates/admin-navigation-tail.php'); ?>