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
<!-- css style -->
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
  <!-- Page Content -->
  <div id="page-content-wrapper">
    <?php include_once('../php-templates/admin-navigation-right.php'); ?>

    <div class="container-fluid ">
      <div class="row bg-light m-3"><h3>View Barangay</h3>
        <div class="container default table-responsive p-4">
           <div class="col-md-8 col-lg-12 ">
          <?php
            if (isset($_GET['error']))  
              echo '<span class="form__input-error-message">'.$_GET['error'].'</span>';
            
          ?> 
          <table class="table mt-5 table-striped table-responsive table-lg table-bordered table-hover display" id="datatables" >
            <thead class="table-dark" colspan="3">
              <tr>
                <th scope="col" class="col-sm-2">#</th>
                <th scope="col" class="col-md-5">Barangay</th>
                <th scope="col" class="col-sm-2" >Status</th>
                <th scope="col" class="col-lg-6">Actions</th>
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
                    <button class="edit btn btn-success btn-sm btn-inverse"><a href="edit-barangay.php?id=<?php echo $value['id'] ?>">Edit</a></button>
                    <button class="del btn btn-danger btn-sm btn-inverse"><a href="delete-barangay.php?id=<?php echo $value['id'] ?>">Delete</a></button> 
                  </td>
                </tr>
              <?php 
                }
              ?> 
            </tbody>
          </table>
        </div>


      </div>
    </div<>
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
            searchPlaceholder: "Search Barangay",
          }
        });
      } );
  </script>

 
<?php 
include_once('../php-templates/admin-navigation-tail.php');
include_once('../php-templates/admin-navigation-head.php');
?>