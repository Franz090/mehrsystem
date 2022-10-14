<?php

@include '../includes/config.php';

session_start();

@include '../php-templates/redirect/admin-page-setter.php';
@include '../php-templates/redirect/midwife-only.php';


// fetch medicine 
$select = "SELECT treat_med_id id, name, description FROM treat_med WHERE type=0";
$result = mysqli_query($conn, $select);
$med_list = [];

if(mysqli_num_rows($result))  {
  foreach($result as $row)  {
    $id = $row['id'];  
    $name = $row['name'];    
    $description = $row['description'];    
    // $s = $row['status'];  
    array_push($med_list, array('id' => $id,'name' => $name, 'description' => $description));
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
<!-- <style>
  .table-primary {
    --bs-table-bg: red!important;
    --bs-table-striped-bg: #c2ded7;
    --bs-table-striped-color: #000;
    --bs-table-active-bg: #b8d3cb;
    --bs-table-active-color: #000;
    --bs-table-hover-bg: #bdd8d1;
    --bs-table-hover-color: #000;
    color: #000;
    border-color: #b8d3cb
}
</style> -->

 
<div class="d-flex" id="wrapper"> 
  <!-- Sidebar -->
  <?php include_once('../php-templates/admin-navigation-left.php'); ?> 
  <!-- Page Content -->
  <div id="page-content-wrapper">
    <?php include_once('../php-templates/admin-navigation-right.php'); ?>

    <div class="container-fluid " >
      <div class="background-head row m-2 my-4"><h4 class="pb-3 m-3 fw-bolder ">View Medicine</h4><hr>
        <div class="table-padding table-responsive">
           <div class="col-md-8 col-lg-12" id="table-position">
            
          <?php
            if (isset($_GET['error']))  
              echo '<span class="form__input-error-message">'.$_GET['error'].'</span>';
            
          ?> 
          <table  class="text-center table mt-5 table-striped table-responsive table-lg table-bordered table-hover display" id="datatables">
            <thead class="table-light table-striped table-striped-color table-hover-bg" colspan="3">
              <tr>
                <th scope="col">#</th>
                <th scope="col">Medicine Name</th>
                <th scope="col">Description</th>
                <!-- <th scope="col">Status</th> -->
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
                  <!-- <td><?php //echo $value['status']; ?></td> -->
                  <td>
                    <div class="p-1">
                    <a href="edit-medicine.php?id=<?php echo $value['id'] ?>"><button type="button" class="me-1 btn btn-success btn-sm btn-inverse">
                        Edit</button></a>
                    <a href="delete-medicine.php?id=<?php echo $value['id'] ?>"><button type="button" class="me-1 btn btn-danger btn-sm btn-inverse">
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
            searchPlaceholder: "Search Medicine",
          }
        });
      } );
  </script>
 
<?php 
include_once('../php-templates/admin-navigation-tail.php');
?>