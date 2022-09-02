<?php
 

@include '../includes/config.php';

session_start();

@include '../php-templates/redirect/admin-page-setter.php';
@include '../php-templates/redirect/midwife-only.php';


// fetch treatment 
$id_from_get = $_GET['id'];
$treatment_to_edit = "SELECT name, description, IF(status=0, 'Inactive', 'Active') AS status FROM treat_med WHERE id = '$id_from_get'";
$treatment_from_db = mysqli_query($conn, $treatment_to_edit);

if (mysqli_num_rows($treatment_from_db) > 0) {
  foreach($treatment_from_db as $row)  {
    $c_name = $row['name'];  
    $c_description = $row['description'];  
    $c_status = $row['status'];   
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
    $status = mysqli_real_escape_string($conn, ($_POST['status']=='Inactive'?0:1));

        
    $up = "UPDATE treat_med SET name='$name', description='$description', status=$status
      WHERE id=$id_from_get";
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
 
<div class="d-flex" id="wrapper">

  <!-- Sidebar -->
  <?php include_once('../php-templates/admin-navigation-left.php'); ?>

  <!-- Page Content -->
  <div id="page-content-wrapper" style="background-color: #f0cac4">
    <?php include_once('../php-templates/admin-navigation-right.php'); ?>

    <div class="container">
      <div class="row bg-light m-3">Update Treatment
        <?php
          if (isset($no_treat))  
            echo '<span class="form__input-error-message">'.$no_treat.'</span>';
          else   {
        ?>   
        <form class="form" action="" method="post">
          <?php 
            if (isset($error))  
              echo '<span class="form__input-error-message">'.$error.'</span>'; 
          ?> 
          <div class="form__input-group">
              <input value="<?php echo $c_name?>" type="text" class="form__input" name="name" autofocus placeholder="Treatment Type*" required>
          </div> 
          <div class="form__input-group">
              <textarea type="text" class="form__input" name="description" autofocus placeholder="Description*" required><?php echo $c_description?></textarea>
          </div> 
          <div class="form__input-group">
              <label>Status</label>
              <select class="form__input" name="status" >
                  <option value="Inactive" <?php echo $c_status=='Inactive' ? 'selected':''?>>Inactive</option>
                  <option value="Active" <?php echo $c_status=='Active' ? 'selected':''?>>Active</option>
              </select>
          </div>  
          <button class="form__button" type="submit" name="submit">Update Treatment Record</button> 
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