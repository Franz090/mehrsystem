<?php
 

@include '../includes/config.php';

session_start();

@include '../php-templates/redirect/admin-page-setter.php';
@include '../php-templates/redirect/nurse-only.php';


// fetch user 
$id_from_get = $_GET['id'];
$barangay_to_edit = "SELECT health_center FROM barangays WHERE barangay_id = '$id_from_get' AND archived=0";
$barangay_from_db = mysqli_query($conn, $barangay_to_edit);

if (mysqli_num_rows($barangay_from_db) > 0) {
  foreach($barangay_from_db as $row)  {
    $c_health_center = $row['health_center'];  
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

        
    $up = "UPDATE barangays SET health_center='$h_center' 
      WHERE barangay_id=$id_from_get";
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

<div class="container_nu"> 
  <!-- Sidebar -->
  <?php include_once('../php-templates/admin-navigation-left.php'); ?> 
  <!-- Page Content -->
  <div class="main_nu">
    <?php include_once('../php-templates/admin-navigation-right.php'); ?>

    <div class="container-fluid  h-100" >
      <div class="background-head row m-2 my-4"><h4 class="pb-3 m-3 fw-bolder ">Update Barangay Record</h4><br><br>
<br><br><br><br><br><br><br><br><br><br><br><br>
    
     
        <?php
          if (isset($no_bgy))  
            echo '<span class="form__input-error-message">'.$no_bgy.'</span>';
          else   {
        ?>   
         <div class="row h-100 justify-content-center align-items-center">
          <div class="col-md-6 col-lg-5">
        <form class="form form-box " action="" method="post" >
          <?php 
            if (isset($error))  
              echo '<span class="form__input-error-message">'.$error.'</span>'; 
          ?> 
       
      <label >Barangay Health Center</label>
              <input value="<?php echo $c_health_center?>" type="text"  name="health_center" class="form-control" placeholder="Edit Barangay Health Center" required>
             
          
          <!-- <div class="form__input-group">
              <label>Status</label>
              <select class="form__input" name="status" >
                  <option value="Inactive" <?php //echo $c_status=='Inactive' ? 'selected':''?>>Inactive</option>
                  <option value="Active" <?php// echo $c_status=='Active' ? 'selected':''?>>Active</option>
              </select>
          </div>   -->
        <div class="col-md-12 text-center pt-4">
          <button class="w-80 btn  btn-primary btn-sm text-capitalize" value="register now" type="submit" name="submit">Update Barangay Record</button> </div>
        </form>  
        <?php
          }
        ?>
        
   
       </div>
   
    </div>

        </div>
   
    </div>

  </div>
</div>
 
<?php 
include_once('../php-templates/admin-navigation-tail.php');
?>