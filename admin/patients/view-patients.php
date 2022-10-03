<?php

@include '../includes/config.php';

session_start();

@include '../php-templates/redirect/admin-page-setter.php';
@include '../php-templates/redirect/not-for-patient.php';

$session_id= $_SESSION['id'];

// fetch patients 
$barangay_assigned_midwife_str = $admin==1?"":"AND $session_id=b.assigned_midwife";

$select = "SELECT u.user_id AS user_id, 
  CONCAT(d.first_name,IF(d.middle_name='' OR middle_name IS NULL, '', CONCAT(' ',SUBSTRING(d.middle_name,1,1),'.')),' ',d.last_name) AS name, u.email,  
  health_center, trimester 
  FROM users u, user_details as d, barangays as b, patient_details m
  WHERE u.role = -1 AND d.user_id=u.user_id AND m.barangay_id=b.barangay_id $barangay_assigned_midwife_str AND m.user_id=u.user_id; ";
// echo $select;
$patient_list = [];

if($result = mysqli_query($conn, $select))  {
  foreach($result as $row)  {
    $id = $row['user_id'];  
    $name = $row['name'];  
    $e = $row['email'];  
    $select_c_no = "SELECT mobile_number FROM contacts WHERE owner_id=$id AND type=1";
    if ($result_c_no = mysqli_query($conn, $select_c_no)) {
      $c_no = '';
      foreach ($result_c_no as $row2) {
        $c_no .= '('.$row2['mobile_number'].') '; 
      }
    } 
    // $c_no = $row['contact_no'];  
    // $b_date = $row['b_date'];  
    $bgy = $row['health_center'];  
    $trimester = $row['trimester'];   
    array_push($patient_list, array(
      'id' => $id,
      'name' => $name,  
      'email' => $e,
      'contact' => $c_no,
      'trimester' => $trimester==1?'1st Trimester':($trimester==2?'2nd Trimester':($trimester==3?'3rd Trimester':'N/A')),
      // 'b_date' => $b_date,
      'barangay' => $bgy
    ));
  } 
  mysqli_free_result($result);
} 
else  { 
  // mysqli_free_result($result);
  $error = 'Something went wrong fetching data from the database.'; 
}  


$conn->close(); 

$page = 'view_patient';
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
  <?php include_once('../php-templates/admin-navigation-left.php');  ?>

  <!-- Page Content -->
  <div id="page-content-wrapper">
    <?php include_once('../php-templates/admin-navigation-right.php'); ?>

    <div class="container-fluid">
      <div class="row bg-light m-3"><h3>View Patient</h3>
        <div class="container default table-responsive p-4">
          <div class="col-md-8 col-lg-12 ">
          <table class="table mt-5 table-striped table-responsive table-lg table-bordered table-hover display" id="datatables">
            <thead class="table-dark" colspan="3">
              <tr>
                <th scope="col" width="6%">#</th>
                <th scope="col">Patient Name</th> 
                <th scope="col">Email</th>  
                <th scope="col">Trimester</th> 
                <th scope="col">Contact Number</th>
                <!-- <th scope="col">Birthdate</th> -->
                <th scope="col">Barangay</th> 
                <th scope="col" width="13%">Actions</th>
              </tr>
            </thead>
            <tbody>
                <?php 
                  if (isset($error)) {
                    echo '<span class="">'.$error.'</span>'; 
                  }
                  else { 
                    foreach ($patient_list as $key => $value) {
                ?>    
                    <tr>
                        <th scope="row"><?php echo $key+1; ?></th>
                        <td><?php echo $value['name']; ?></td>
                        <td><?php echo $value['email']; ?></td>
                        <td><?php echo $value['trimester']; ?></td>
                        <td><?php echo $value['contact']; ?></td>
                        <!-- <td><?php $dtf = date_create($value['b_date']); echo date_format($dtf,"F d, Y"); ?></td> -->
                        <td><?php echo $value['barangay']; ?></td>
                        <td>
                        <?php if ($admin===0) {
                        ?>  
                          <a href="edit-patient.php?id=<?php echo $value['id'] ?>"> 
                            <button class="edit btn btn-success btn-sm btn-inverse">
                              Edit</button></a>  
                          <!-- <a href="delete-patient.php?id=<?php //echo $value['id'] ?>&details_id=<?php //echo $value['details_id'] ?>&med_history_id=<?php //echo $value['med_history_id'] ?>"> -->
                            <button onclick="temp_func() " class="del btn btn-danger btn-sm btn-inverse ">Delete</button>
                          <!-- </a> --> 
                          <hr/>
                        <?php
                        }?>
                          <a href="med-patient.php?id=<?php echo $value['id'] ?>">
                            <button class="edit btn btn-info btn-sm btn-inverse ">View Report</button></a>
                        </td>
                    </tr>
                <?php 
                    }
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
            searchPlaceholder: "Search Patient",
          }
        });
      } );
  </script>
 
<?php 
include_once('../php-templates/admin-navigation-tail.php');
?>