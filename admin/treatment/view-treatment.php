<?php

@include '../includes/config.php';

session_start();

@include '../php-templates/redirect/admin-page-setter.php';
@include '../php-templates/redirect/midwife-only.php';


// fetch treatment 
$select = "SELECT treat_med_id id, name, description FROM treat_med WHERE type=1";
$result = mysqli_query($conn, $select);
$treatment_list = [];

if(mysqli_num_rows($result))  {
  foreach($result as $row)  {
    $id = $row['id'];  
    $name = $row['name'];    
    $description = $row['description'];    
    // $s = $row['status'];  
    array_push($treatment_list, array('id' => $id,'name' => $name, 'description' => $description));
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
<style></style>

<div class="d-flex" id="wrapper"> 
  
  <!-- Sidebar -->
  <?php include_once('../php-templates/admin-navigation-left.php'); ?> 
  <!-- Page Content -->
  <div id="page-content-wrapper" >
    <?php include_once('../php-templates/admin-navigation-right.php'); ?>

    <div class="container-fluid default">
      <div class="background-head row m-2 my-4"><h4 class="pb-3 m-3 fw-bolder ">View Treatment</h4><hr>

        <div class="table-padding table-responsive">
          <div class="col-md-8 col-lg-12"  id="table-position">
            
          <?php
            if (isset($_GET['error']))  
              echo '<span class="form__input-error-message">'.$_GET['error'].'</span>';
            
          ?> 
          <table class="text-center table mt-5 table-striped table-responsive table-lg table-bordered table-hover display" id="datatables" >
            <thead class="table-dark" colspan="3">
              <tr>
                <th scope="col">#</th>
                <th scope="col">Treatment Type</th>
                <th scope="col">Description</th>
                <!-- <th scope="col">Status</th> -->
                <th scope="col">Actions</th>
             
            <tbody>
              <?php 
                foreach ($treatment_list as $key => $value) {
              ?>    
                <tr>
                  <th scope="row"><?php echo $key+1; ?></th>
                  <td><?php echo $value['name']; ?></td>
                  <td><?php echo $value['description']; ?></td>
                  <!-- <td><?php //echo $value['status']; ?></td> -->
                  <td>
                    <div class="p-2">
                    <a href="edit-treatment.php?id=<?php echo $value['id'] ?>"><button  class="me-1 btn btn-success btn-sm btn-inverse">
                        Edit</button></a>
                    <a href="delete-treatment.php?id=<?php echo $value['id'] ?>"><button  class="btn btn-danger btn-sm btn-inverse">
                        Delete</button></a>
                </div>
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
<script>
       $(document).ready( function () {
        $('#datatables').DataTable({
          "pagingType": "full_numbers",
          "lengthMenu":[
            [10, 25, 30,50, -1],
            [10, 25, 30,50, "All"]
          ],
          destroy: true,
          fixedColumns: true,
          responsive: true,
          language:{
            search: "_INPUT_",
            searchPlaceholder: "Search Treatment",
          }
        });
      } );
  </script>
 
<?php 
include_once('../php-templates/admin-navigation-tail.php');
?>