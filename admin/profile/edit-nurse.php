<?php

// @include '../includes/config.php';

// $id = $_GET['id'];
// echo "<script>alert('edit $id');</script>";

// $conn->close();
// header('location: view-nurse.php'); 

@include '../includes/config.php';

session_start();

if(!isset($_SESSION['usermail'])) 
  header('location: ../');

// fetch user 
$id_from_get = $_GET['id'];
$user_to_edit = "SELECT * FROM users WHERE id = '$id_from_get'";
$user_from_db = mysqli_query($conn, $user_to_edit);

if (mysqli_num_rows($user_from_db) > 0) {
  foreach($user_from_db as $row)  {
    $c_email = $row['email'];  
    $c_first_name = $row['first_name'];  
    $c_mid_initial = $row['mid_initial'];  
    $c_last_name = $row['last_name'];  
    $c_status = $row['status'] == 0? 'Inactive' : 'Active';   
  }  
  mysqli_free_result($user_from_db);
} 
else {
  $no_user = 'No such user.'; 
  mysqli_free_result($user_from_db);
}


// edit
if(isset($_POST['submit'])) {
  $_POST['submit'] = null;
  $error = ''; 

  if (empty($_POST['usermail']) ||  
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

    $select = "SELECT * FROM users WHERE email = '$email'";

  
    $result = mysqli_query($conn, $select);
  
    if(mysqli_num_rows($result) > 1)  { 
      $error .= 'The email inputted was already used. ';  
      mysqli_free_result($result);
    } 
    else  {
      foreach($result as $row)   
        $id_from_db = $row['id'];    
      $up = "UPDATE users SET first_name='$first_name', mid_initial='$mid_initial', last_name='$last_name', 
      email='$email', status=$status WHERE id=$id_from_db";
      if (mysqli_query($conn, $up))  {
        mysqli_free_result($result);
        echo "<script>alert('Nurse Record Updated!');</script>";
        $conn->close(); 
        header('location:view-nurse.php');  
      }
      else { 
        mysqli_free_result($result);
        $error .= 'Something went wrong updating the record in the database.';
      } 
    }  
  } 
} 
 
$conn->close(); 

$page = 'edit_nurse';
include_once('../php-templates/admin-navigation-head.php');
?>
 
<div class="d-flex" id="wrapper">

  <!-- Sidebar -->
  <?php include_once('../php-templates/admin-navigation-left.php'); ?>

  <!-- Page Content -->
  <div id="page-content-wrapper" style="background-color: #f0cac4">
    <?php include_once('../php-templates/admin-navigation-right.php'); ?>

    <div class="container">
      <div class="row bg-light m-3">Update Nurse Record
        <?php
          if (isset($no_user))  
            echo '<span class="form__input-error-message">'.$no_user.'</span>';
          else   {
        ?>   
        <form class="form" action="" method="post">
          <?php 
            if (isset($error))  
              echo '<span class="form__input-error-message">'.$error.'</span>'; 
          ?> 
          <div class="form__input-group">
              <input value="<?php echo $c_email?>" type="text" class="form__input" name="usermail" autofocus placeholder="Email Address*" required>
          </div>
          <div class="form__input-group">
              <input value="<?php echo $c_first_name?>" type="text" class="form__input" name="first_name" placeholder="First Name*" required>
      
              <input value="<?php echo $c_mid_initial?>" type="text" class="form__input" name="mid_initial" placeholder="Middle Initial">
          
              <input value="<?php echo $c_last_name?>" type="text" class="form__input" name="last_name" placeholder="Last Name*" required>
          </div> 
          <div class="form__input-group">
              <label>Status</label>
              <select class="form__input" name="status" >
                  <option value="Inactive" <?php echo $c_status=='Inactive' ? 'selected':''?>>Inactive</option>
                  <option value="Active" <?php echo $c_status=='Active' ? 'selected':''?>>Active</option>
              </select>
          </div>  
          <button class="form__button" value="register now" type="submit" name="submit">Update Nurse Record</button> 
        </form> 

        <?php
          }
        ?>
        
      </div>
    </div>
  </div>
</div>
 
<?php 
include_once('../php-templates/admin-navigation-tail.php');
?>