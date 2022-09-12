<?php
 

@include '../includes/config.php';

session_start();

@include '../php-templates/redirect/admin-page-setter.php';
@include '../php-templates/redirect/midwife-only.php';


// fetch medicine 
$id_from_get = $_GET['id'];
$medicine_to_edit = "SELECT name, description FROM treat_med WHERE id = '$id_from_get'";
$medicine_from_db = mysqli_query($conn, $medicine_to_edit);

if (mysqli_num_rows($medicine_from_db) > 0) {
  foreach($medicine_from_db as $row)  {
    $c_name = $row['name'];  
    $c_description = $row['description'];  
    // $c_status = $row['status'];   
  }  
  mysqli_free_result($medicine_from_db);
} 
else {
  $no_med = 'No such medicine.'; 
  mysqli_free_result($medicine_from_db);
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
      WHERE id=$id_from_get";
    if (mysqli_query($conn, $up))  {
      echo "<script>alert('Medicine Record Updated!');</script>";
      $conn->close(); 
      header('location:view-medicine.php');  
    }
    else { 
      $error .= 'Something went wrong updating the record in the database.';
    }  
  } 
} 
 
$conn->close(); 

$page = 'edit_medicine';
include_once('../php-templates/admin-navigation-head.php');
?>

 
<div class="d-flex" id="wrapper">

  <!-- Sidebar -->
  <?php include_once('../php-templates/admin-navigation-left.php'); ?>

  <!-- Page Content -->
  <div id="page-content-wrapper">
    <?php include_once('../php-templates/admin-navigation-right.php'); ?>

    <div class="container-fluid">
      <div class="row bg-light m-3"><h3>Update Medicine</h3>
      <div class="container default table-responsive p-4">
          <div class="col-md-8 col-lg-5 ">
        <?php
          if (isset($no_med))  
            echo '<span class="form__input-error-message">'.$no_med.'</span>';
          else   {
        ?>   
        <form class="form" action="" method="post">
          <?php 
            if (isset($error))  
              echo '<span class="form__input-error-message">'.$error.'</span>'; 
          ?> 
          <div class="form__input-group">
              <input value="<?php echo $c_name?>" type="text" class="form__input" name="name" autofocus placeholder="Medicine Name*" required>
          </div> 
          <div class="form__input-group">
              <textarea type="text" class="form__input" name="description" autofocus placeholder="Description*" required><?php echo $c_description?></textarea>
          </div> 
          <!-- <div class="form__input-group">
              <label>Status</label>
              <select class="form__input" name="status" >
                  <option value="Inactive" <?php //echo $c_status=='Inactive' ? 'selected':''?>>Inactive</option>
                  <option value="Active" <?php //echo $c_status=='Active' ? 'selected':''?>>Active</option>
              </select>
          </div>   -->
          <button class="form__button" type="submit" name="submit">Update Medicine Record</button> 
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