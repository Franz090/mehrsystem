<?php
 

@include '../includes/config.php';

session_start();

@include '../php-templates/redirect/admin-page-setter.php';
@include '../php-templates/redirect/nurse-only.php';


// fetch user 
$id_from_get = $_GET['id'];
$barangay_to_edit = "SELECT health_center, IF(barangay.status=0, 'Inactive', 'Active') AS status FROM barangay WHERE id = '$id_from_get'";
$barangay_from_db = mysqli_query($conn, $barangay_to_edit);

if (mysqli_num_rows($barangay_from_db) > 0) {
  foreach($barangay_from_db as $row)  {
    $c_health_center = $row['health_center'];  
    $c_status = $row['status'];   
  }  
  mysqli_free_result($barangay_from_db);
} 
else {
  $no_bgy = 'No such barangay health center.'; 
  mysqli_free_result($barangay_from_db);
}


// edit
if(isset($_POST['submit'])) {
  $_POST['submit'] = null;
  $error = ''; 

  if (empty($_POST['health_center']))
    $error .= 'Fill up input fields that are required (with * mark)! ';
  else {
    $h_center = mysqli_real_escape_string($conn, $_POST['health_center']); 
    $status = mysqli_real_escape_string($conn, ($_POST['status']=='Inactive'?0:1));

        
    $up = "UPDATE barangay SET health_center='$h_center', status=$status
      WHERE id=$id_from_get";
    if (mysqli_query($conn, $up))  {
      echo "<script>alert('Barangay Record Updated!');</script>";
      $conn->close(); 
      header('location:view-barangay.php');  
    }
    else { 
      $error .= 'Something went wrong updating the record in the database.';
    }  
  } 
} 
 
$conn->close(); 

$page = 'edit_barangay';
include_once('../php-templates/admin-navigation-head.php');
?>
 
<div class="d-flex" id="wrapper">

  <!-- Sidebar -->
  <?php include_once('../php-templates/admin-navigation-left.php'); ?>

  <!-- Page Content -->
  <div id="page-content-wrapper" style="background-color: #f0cac4">
    <?php include_once('../php-templates/admin-navigation-right.php'); ?>

    <div class="container">
      <div class="row bg-light m-3">Update Barangay Record
        <?php
          if (isset($no_bgy))  
            echo '<span class="form__input-error-message">'.$no_bgy.'</span>';
          else   {
        ?>   
        <form class="form" action="" method="post">
          <?php 
            if (isset($error))  
              echo '<span class="form__input-error-message">'.$error.'</span>'; 
          ?> 
          <div class="form__input-group">
              <input value="<?php echo $c_health_center?>" type="text" class="form__input" name="health_center" autofocus placeholder="Health Center*" required>
          </div> 
          <div class="form__input-group">
              <label>Status</label>
              <select class="form__input" name="status" >
                  <option value="Inactive" <?php echo $c_status=='Inactive' ? 'selected':''?>>Inactive</option>
                  <option value="Active" <?php echo $c_status=='Active' ? 'selected':''?>>Active</option>
              </select>
          </div>  
          <button class="form__button" value="register now" type="submit" name="submit">Update Barangay Record</button> 
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