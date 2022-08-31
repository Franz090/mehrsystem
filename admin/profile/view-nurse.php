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
  }
  </style>

  <!-- Sidebar -->
  <?php include_once('../php-templates/admin-navigation-left.php'); ?>

  <!-- Page Content -->
  <div id="page-content-wrapper" style="background-color:#F5F5F5;">
    <?php include_once('../php-templates/admin-navigation-right.php'); ?>

    <div class="container-fluid">
      <div class="row bg-light m-3"><h3 class="viewnurse">View Nurse</h3>
         <div class="container default table-responsive pt-4 pb-4">
          <div class="col-md-8 col-lg-12 ">
          <table class="table mt-5 table-striped table-responsive table-lg table-bordered table-hover display" id="datatables" >
            <thead class="table-dark" colspan="3">
              <tr>
 
                <th scope="col" class="col-sm-2" >#</th>
                <th scope="col" class="col-md-5" >Nurse Name</th>
                <th scope="col" class="col-sm-2" >Status</th>
                <th scope="col" class="col-lg-6" >Actions</th>
 
              </tr>
            </thead>
            <tbody id="table_body">
              <?php 
                foreach ($nurse_list as $key => $value) {
              ?>    
              <?php  ?>
                <tr>
                  <th scope="row"><?php echo $key+1; ?></th>
                  <td><?php echo $value['name']; ?></td>
                  <td><?php echo $value['status']; ?></td>
                  <td>
 
                    <button class="edit btn btn-success btn-md btn-inverse"><a href="edit-nurse.php?id=<?php echo $value['id'] ?>">Edit</a></button>
                   <?php if ($_SESSION['id'] != $value['id']) { ?> 
                    
                    <button class="del btn btn-danger btn-md btn-inverse"><a href="delete-nurse.php?id=<?php echo $value['id'] ?>">Delete</a></button> 
                     <?php } ?> 
 
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
            searchPlaceholder: "Search Nurse",
          }
        });
      } );
  </script>

<?php 
include_once('../php-templates/admin-navigation-tail.php');
include_once('../php-templates/admin-navigation-head.php');
?>