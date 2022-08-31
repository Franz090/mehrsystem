<?php

@include '../includes/config.php';

session_start();

@include '../php-templates/redirect/admin-page-setter.php';
@include '../php-templates/redirect/nurse-only.php';


// fetch barangays 
$select = "SELECT id, health_center, IF(barangay.status=0, 'Inactive', 'Active') AS status FROM barangay";
$result = mysqli_query($conn, $select);
$barangay_list = [];

if(mysqli_num_rows($result))  {
  foreach($result as $row)  {
    $id = $row['id'];  
    $h_center = $row['health_center'];    
    $s = $row['status'];  
    array_push($barangay_list, array('id' => $id,'health_center' => $h_center, 'status' => $s));
  } 
  mysqli_free_result($result);
  // print_r($nurse_list);

} 
else  { 
  mysqli_free_result($result);
  $error = 'Something went wrong fetching data from the database.'; 
}  


$conn->close(); 

$page = 'view_barangay';
include_once('../php-templates/admin-navigation-head.php');
?>
 
<div class="d-flex" id="wrapper">

  <!-- Sidebar -->
  <?php include_once('../php-templates/admin-navigation-left.php'); ?>

  <!-- Page Content -->
  <div id="page-content-wrapper" style="background-color: #f0cac4">
    <?php include_once('../php-templates/admin-navigation-right.php'); ?>

    <div class="container">
      <div class="row bg-light m-3">view-barangay

        <div class="container default">
          <?php
            if (isset($_GET['error']))  
              echo '<span class="form__input-error-message">'.$_GET['error'].'</span>';
            
          ?> 
          <table class="table mt-5 table-striped table-sm ">
            <thead class="table-dark">
              <tr>
                <th scope="col">#</th>
                <th scope="col">Barangay</th>
                <th scope="col">Status</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php 
                foreach ($barangay_list as $key => $value) {
              ?>    
              <?php  ?>
                <tr>
                  <th scope="row"><?php echo $key+1; ?></th>
                  <td><?php echo $value['health_center']; ?></td>
                  <td><?php echo $value['status']; ?></td>
                  <td>
                    <button class="edit"><a href="edit-barangay.php?id=<?php echo $value['id'] ?>">Edit</a></button>
                    <button class="del"><a href="delete-barangay.php?id=<?php echo $value['id'] ?>">Delete</a></button> 
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