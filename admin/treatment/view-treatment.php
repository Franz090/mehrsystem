<?php

@include '../includes/config.php';

session_start();

@include '../php-templates/redirect/admin-page-setter.php';
@include '../php-templates/redirect/midwife-only.php';


// fetch treatment 
$select = "SELECT id, name, description, IF(status=0, 'Inactive', 'Active') AS status FROM treat_med WHERE category=1";
$result = mysqli_query($conn, $select);
$treatment_list = [];

if(mysqli_num_rows($result))  {
  foreach($result as $row)  {
    $id = $row['id'];  
    $name = $row['name'];    
    $description = $row['description'];    
    $s = $row['status'];  
    array_push($treatment_list, array('id' => $id,'name' => $name, 'description' => $description, 'status' => $s));
  } 
  mysqli_free_result($result);  
} 
else  { 
  mysqli_free_result($result);
  $error = 'Something went wrong fetching data from the database.'; 
}  


$conn->close(); 

$page = 'view_treatment';
include_once('../php-templates/admin-navigation-head.php');
?>
<!-- css internal style -->
  <style>
  .table {
   margin: auto;
   width: 100%!important;
   padding-top: 13px;
   
  }
  .btn{
    border-radius: 3px;
    margin: 2px 4px;
  }
  
  h3{
    font-weight: 900;  
    background-color: #ececec;  
    padding-top: 10px;
    position: relative;
    top: 8px;
  }
  a{
    text-decoration: none;
    color: white;
  }
  a:hover{
    color: #e2e5de;
  }
  .btn{
    font-weight: 400;
    font-size: 15px;
  }
  

  </style>
 
<div class="d-flex" id="wrapper"> 
  <!-- Sidebar -->
  <?php include_once('../php-templates/admin-navigation-left.php'); ?> 
  <!-- Page Content -->
  <div id="page-content-wrapper" >
    <?php include_once('../php-templates/admin-navigation-right.php'); ?>

    <div class="container-fluid">
      <div class="row bg-light m-3"><h3>View Treatment</h3>

        <div class="container default table-responsive">
            
          <?php
            if (isset($_GET['error']))  
              echo '<span class="form__input-error-message">'.$_GET['error'].'</span>';
            
          ?> 
          <table class="table mt-5 table-striped table-responsive table-lg table-bordered table-hover display" id="datatables" >
            <thead class="table-dark" colspan="3">
              <tr>
                <th scope="col">#</th>
                <th scope="col">Treatment Type</th>
                <th scope="col">Description</th>
                <th scope="col">Status</th>
                <th scope="col">Actions</th>
             
            <tbody>
              <?php 
                foreach ($treatment_list as $key => $value) {
              ?>    
                <tr>
                  <th scope="row"><?php echo $key+1; ?></th>
                  <td><?php echo $value['name']; ?></td>
                  <td><?php echo $value['description']; ?></td>
                  <td><?php echo $value['status']; ?></td>
                  <td>
                    <a href="edit-treatment.php?id=<?php echo $value['id'] ?>"><button class="edit">
                        Edit</button></a>
                    <a href="delete-treatment.php?id=<?php echo $value['id'] ?>"><button class="del">
                        Delete</button></a>
                  </td>
                </tr>
              <?php 
                }
              ?> 
            </tbody>
          </table>
        </div> 

      </div>
    </div>

  </div>
</div>
 
<?php 
include_once('../php-templates/admin-navigation-tail.php');
?>