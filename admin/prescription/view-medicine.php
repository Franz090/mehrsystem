<?php

@include '../includes/config.php';

session_start();

@include '../php-templates/redirect/admin-page-setter.php';
@include '../php-templates/redirect/midwife-only.php';


// fetch medicine 
$select = "SELECT id, name, description, IF(status=0, 'Inactive', 'Active') AS status FROM treat_med WHERE category=0";
$result = mysqli_query($conn, $select);
$med_list = [];

if(mysqli_num_rows($result))  {
  foreach($result as $row)  {
    $id = $row['id'];  
    $name = $row['name'];    
    $description = $row['description'];    
    $s = $row['status'];  
    array_push($med_list, array('id' => $id,'name' => $name, 'description' => $description, 'status' => $s));
  } 
  mysqli_free_result($result);  
} 
else  { 
  mysqli_free_result($result);
  $error = 'Something went wrong fetching data from the database.'; 
}  


$conn->close(); 

$page = 'view_medicine';
include_once('../php-templates/admin-navigation-head.php');
?>
 
<div class="d-flex" id="wrapper"> 
  <!-- Sidebar -->
  <?php include_once('../php-templates/admin-navigation-left.php'); ?> 
  <!-- Page Content -->
  <div id="page-content-wrapper" style="background-color: #f0cac4">
    <?php include_once('../php-templates/admin-navigation-right.php'); ?>

    <div class="container">
      <div class="row bg-light m-3">view-medicine

        <div class="container default">
            
          <?php
            if (isset($_GET['error']))  
              echo '<span class="form__input-error-message">'.$_GET['error'].'</span>';
            
          ?> 
          <table class="table mt-5 table-striped table-sm ">
            <thead class="table-dark">
              <tr>
                <th scope="col">#</th>
                <th scope="col">Medicine Name</th>
                <th scope="col">Description</th>
                <th scope="col">Status</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php 
                foreach ($med_list as $key => $value) {
              ?>    
                <tr>
                  <th scope="row"><?php echo $key+1; ?></th>
                  <td><?php echo $value['name']; ?></td>
                  <td><?php echo $value['description']; ?></td>
                  <td><?php echo $value['status']; ?></td>
                  <td>
                    <a href="edit-medicine.php?id=<?php echo $value['id'] ?>"><button class="edit">
                        Edit</button></a>
                    <a href="delete-medicine.php?id=<?php echo $value['id'] ?>"><button class="del">
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