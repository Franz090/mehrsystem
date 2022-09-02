<?php

@include '../includes/config.php';

session_start();

@include '../php-templates/redirect/admin-page-setter.php';
 

// fetch nurses 
$select = "SELECT u.id AS id, 
  CONCAT(u.first_name,IF(u.mid_initial='', '', CONCAT(' ',u.mid_initial,'.')),' ',u.last_name) AS name, u.email,  
  IF(u.status=0, 'Inactive', 'Active') AS status, d.contact_no, d.b_date,  health_center,
  details_id 
  FROM users as u, details as d,
  barangay as b WHERE u.admin = 0 AND d.id=u.details_id AND d.barangay_id=b.id;";
$result = mysqli_query($conn, $select);
$midwife_list = [];

if(mysqli_num_rows($result))  {
  foreach($result as $row)  {
    $id = $row['id'];  
    $name = $row['name'];  
    $e = $row['email'];  
    $s = $row['status'];  
    $c_no = $row['contact_no'];  
    $b_date = $row['b_date'];  
    $bgy = $row['health_center'];  
    $det_id = $row['details_id'];  
    array_push($midwife_list, array(
      'id' => $id,
      'name' => $name,  
      'email' => $e,
      'status' => $s,
      'contact' => $c_no,
      'b_date' => $b_date,
      'barangay' => $bgy,
      'details_id' => $det_id
    ));
  } 
  mysqli_free_result($result);
  // print_r($midwife_list);

} 
else  { 
  mysqli_free_result($result);
  $error = 'Something went wrong fetching data from the database.'; 
}  


$conn->close(); 

$page = 'view_midwife';
include_once('../php-templates/admin-navigation-head.php');
?>
 
<div class="d-flex" id="wrapper">

  <!-- Sidebar -->
 
  <?php include_once('../php-templates/admin-navigation-left.php'); 
  
    // from edit.php 
    if (isset($_GET['edit']) && $_GET['edit']==0) {
      echo "<script>alert(\"Can't edit this account!\");</script>";
    }   

  ?>
 
<!-- style css -->
<style>
  .table-condensed {
width: 100% !important;
}

</style>
  <!-- Page Content -->
  <div id="page-content-wrapper" >
    <?php include_once('../php-templates/admin-navigation-right.php'); ?>
    <div class="container-fluid">
      <div class="row bg-light m-3"><h3>View Midwife</h3>

        <div class="container default table-responsive-sm p-4">
          <div class="col-md-8 col-lg-12 table-responsive-md">
          <table class="table mt-5 table-striped table-lg table-bordered table-hover table-condensed display" id="datatables">
            <thead class="table-dark" colspan="3"> 
              <tr>
                <th scope="col" class="col-sm-1">#</th>
                <th scope="col" class="col-sm2">Midwife Name</th>
 
                <?php if ($admin==1) { ?>
                  <th scope="col">Email</th>
                <?php } ?>

                <th scope="col">Status</th>
                <?php if ($admin==1) { ?>
                  <th scope="col">Contact Number</th>
                  <th scope="col">Birthdate</th>
                  <th scope="col">Barangay</th>
                <?php } ?>
 
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php 
                foreach ($midwife_list as $key => $value) {
              ?>    
              <?php  ?>
                <tr>
                  <th scope="row"><?php echo $key+1; ?></th>
                  <td><?php echo $value['name']; ?></td>
 
                  <?php if ($admin==1) { ?>  
                    <td><?php echo $value['email']; ?></td>
                  <?php } ?>
                  <td><?php echo $value['status']; ?></td>
                  <?php if ($admin==1) { ?>
                    <td><?php echo $value['contact']; ?></td>
                    <td><?php $dtf = date_create($value['b_date']); echo date_format($dtf,"F d, Y"); ?></td>
                    <td><?php echo $value['barangay']; ?></td>
                  <?php } ?>
                  <td>
                    <button class="edit btn btn-success btn-md btn-inverse"><a href="edit-midwife.php?id=<?php echo $value['id'] ?>">Edit</a></button>
                    <?php if ($value['id']!=$_SESSION['id']) { ?>
                      <button class="del btn btn-danger btn-md btn-inverse"><a href="delete-midwife.php?id=<?php echo $value['id'] ?>&details_id=<?php echo $value['details_id'] ?>">Delete</a></button> 
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
            searchPlaceholder: "Search Midwife",
          }
        });
      } );
  </script>
 
<?php 
include_once('../php-templates/admin-navigation-tail.php');
include_once('../php-templates/admin-navigation-head.php');
?>