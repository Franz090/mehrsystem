<?php

@include '../includes/config.php';

session_start();
 
@include '../php-templates/redirect/admin-page-setter.php';
@include '../php-templates/redirect/midwife-only.php'; 

// add medicine
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
    VALUES('$name', '$description', 0);  ";
    
    if (mysqli_query($conn,"$insert1"))  { 
    echo "<script>alert('Medicine Added!');</script>"; 
    }
    else {  
        $error .= 'Something went wrong adding the medicine to the database.';
    }  
  } 
}

$conn->close(); 

$page = 'add_medicine';
include_once('../php-templates/admin-navigation-head.php');
?>
 
<div class="d-flex" id="wrapper"> 
  <!-- Sidebar -->
  <?php include_once('../php-templates/admin-navigation-left.php'); ?> 
  <!-- Page Content -->
  <div id="page-content-wrapper" >
    <?php include_once('../php-templates/admin-navigation-right.php'); ?>

    <div class="container-fluid">
      <div class="row bg-light m-3"><h3>Add New Medicine</h3>
      <div class="container default table-responsive p-4">
          <div class="col-md-8 col-lg-5 ">
        <form class="form" action="" method="post" >
          <?php
            if(isset($error)) 
                echo '<span class="form__input-error-message">'.$error.'</span>'; 
          ?> 
          <div class="form__input-group">
            <input type="text" class="form__input" name="name" autofocus placeholder="Medicine Name*" required/>
          </div>
          <div class="form__input-group">
              <textarea type="text" class="form__input" name="description" placeholder="Description*" required></textarea>
          </div>  
          <!-- <div class="form__input-group">
              <label>Status</label>
              <select class="form__input" name="status">
                <option value="Inactive" selected>Inactive</option>
                <option value="Active">Active</option>
              </select>
          </div>   -->
          <button class="form__button" type="submit" name="submit">Add Medicine</button> 
        </form>  
      </div>
    </div>
    </div>
</div>
    
  </div>
</div>
 
<?php include_once('../php-templates/admin-navigation-tail.php'); ?>