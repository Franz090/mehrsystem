<?php

@include '../includes/config.php';

session_start();

@include '../php-templates/redirect/admin-page-setter.php';
@include '../php-templates/redirect/nurse-only.php';
 
// fetch nurses 
$select = "SELECT * FROM users WHERE admin = 1";
$result = mysqli_query($conn, $select);
$nurse_list = [];

if(mysqli_num_rows($result))  {
  foreach($result as $row)  {
    $id = $row['id'];  
    $f = $row['first_name'];  
    $m = $row['mid_initial'];  
    $l = $row['last_name'];  
    $s = $row['status'] == 0? 'Inactive' : 'Active';  
    array_push($nurse_list, array('id' => $id,'name' => ("$f ".($m? "$m. ":'')."$l"), 'status' => $s));
  } 
  mysqli_free_result($result);
  // print_r($nurse_list);

} 
else  { 
  mysqli_free_result($result);
  $error = 'Something went wrong fetching data from the database.'; 
}  


$conn->close(); 

$page = 'view_nurse';
// $additional_script = '<script defer src="../js/nurse-table.js"></script>'; 
include_once('../php-templates/admin-navigation-head.php');
?>
 
<div class="d-flex" id="wrapper">

  <!-- Sidebar -->
  <?php include_once('../php-templates/admin-navigation-left.php'); ?>

  <!-- Page Content -->
  <div id="page-content-wrapper" style="background-color: #f0cac4">
    <?php include_once('../php-templates/admin-navigation-right.php'); ?>

    <div class="container">
      <div class="row bg-light m-3 ">view-nurse
         <div class="container default">
          <table class="table mt-5 table-striped table-sm ">
            <thead class="table-dark">
              <tr>
                <th scope="col">#</th>
                <th scope="col">Nurse Name</th>
                <th scope="col">Status</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php 
                foreach ($nurse_list as $key => $value) {
              ?>    
              <?php  ?>
                <tr>
                  <th scope="row"><?php echo $key+1; ?></th>
                  <td><?php echo $value['name']; ?></td>
                  <td><?php echo $value['status']; ?></td>
                  <td>
                    <button class="edit"><a href="edit-nurse.php?id=<?php echo $value['id'] ?>">Edit</a></button>
                    <button class="del"><a href="delete-nurse.php?id=<?php echo $value['id'] ?>">Delete</a></button> 
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