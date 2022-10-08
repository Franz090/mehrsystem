<?php
 

@include '../includes/config.php';

session_start();

@include '../php-templates/redirect/admin-page-setter.php';
@include '../php-templates/redirect/midwife-only.php';


// fetch treatment 
$id_from_get = $_GET['id'];
$treatment_to_edit = "SELECT treat_med_id id, name, description FROM treat_med WHERE treat_med_id = '$id_from_get'";
$treatment_from_db = mysqli_query($conn, $treatment_to_edit);

if (mysqli_num_rows($treatment_from_db) > 0) {
  foreach($treatment_from_db as $row)  {
    $c_id = $row['id'];  
    $c_name = $row['name'];  
    $c_description = $row['description'];  
    // $c_status = $row['status'];   
  }  
  mysqli_free_result($treatment_from_db);
} 
else {
  $no_treat = 'No such treatment.'; 
  mysqli_free_result($treatment_from_db);
}


// edit
if(isset($_POST['submit'])) {
  $_POST['submit'] = null;
  $error = ''; 

  if (empty($_POST['name']) || empty($_POST['description'])) 
    $error .= 'Fill up input fields that are required (with * mark)! ';
  else {
    $name = mysqli_real_escape_string($conn, $_POST['name']); 
    $description = mysqli_real_escape_string($conn, $_POST['description']); 
    // $status = mysqli_real_escape_string($conn, ($_POST['status']=='Inactive'?0:1));

        
    $up = "UPDATE treat_med SET name='$name', description='$description'
      WHERE treat_med_id=$c_id";
    if (mysqli_query($conn, $up))  {
      echo "<script>alert('Treatment Record Updated!');</script>";
      $conn->close(); 
      header('location:view-treatment.php');  
    }
    else { 
      $error .= 'Something went wrong updating the record in the database.';
    }  
  } 
} 
 
$conn->close(); 

$page = 'edit_treatment';
include_once('../php-templates/admin-navigation-head.php');
?>

<style>
     h3{
    font-weight: 900;  
    background-color: #ececec;  
    padding-top: 10px;
    position: relative;
    top: 8px;
  }
</style>
 
<div class="d-flex" id="wrapper">

  <!-- Sidebar -->
  <?php include_once('../php-templates/admin-navigation-left.php'); ?>

  <!-- Page Content -->
  <div id="page-content-wrapper">
    <?php include_once('../php-templates/admin-navigation-right.php'); ?>

    <div class="container-fluid default">
      <div class="background-head row m-2 my-4"><h4 class="pb-3 m-3 fw-bolder ">Update Treatment</h4><hr>
      <div class="container default table-responsive p-4">
        <div class="col-md-8 col-lg-5 ">
        <?php
          if (isset($no_treat))  
            echo '<span class="form__input-error-message">'.$no_treat.'</span>';
          else   {
        ?>   
        <form class="form form-box px-3" style="bottom:100px;position:relative;" action="" method="post">
          <?php 
            if (isset($error))  
              echo '<span class="form__input-error-message">'.$error.'</span>'; 
          ?> 
          <div class="form-input">
              <input value="<?php echo $c_name?>" type="text" class="form-input" name="name" autofocus placeholder="Treatment Type*" required>
          </div> 
          <div class="form-input">
              <textarea type="text" class="form-control form-control-md w-100"  name="description" autofocus placeholder="Description*" required><?php echo $c_description?></textarea>
          </div> 
          <!-- <div class="form__input-group">
              <label>Status</label>
              <select class="form__input" name="status" >
                  <option value="Inactive" <?php //echo $c_status=='Inactive' ? 'selected':''?>>Inactive</option>
                  <option value="Active" <?php //echo $c_status=='Active' ? 'selected':''?>>Active</option>
              </select>
          </div>   -->
          <button  class="w-100 btn  text-capitalize" type="submit" name="submit">Update Treatment Record</button> 
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