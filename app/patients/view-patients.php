<?php

@include '../includes/config.php';

session_start();

@include '../php-templates/redirect/admin-page-setter.php';
@include '../php-templates/redirect/not-for-patient.php';

$session_id= $_SESSION['id'];

// fetch patients 
$barangay_assigned_midwife_str = $admin==1?"":"AND $session_id=b.assigned_midwife";

$select = "SELECT u.user_id AS user_id, 
  CONCAT(d.first_name,IF(d.middle_name='' OR d.middle_name IS NULL, '', CONCAT(' ',SUBSTRING(d.middle_name,1,1),'.')),' ',d.last_name) AS name, u.email,  
  health_center, trimester, m.status 
  FROM users u, user_details as d, barangays as b, patient_details m
  WHERE u.role = -1 AND d.user_id=u.user_id 
    AND m.barangay_id=b.barangay_id $barangay_assigned_midwife_str AND m.user_id=u.user_id
    AND b.archived=0; ";
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
    $status = $row['status'];  
    // $b_date = $row['b_date'];  
    $bgy = $row['health_center'];  
    $trimester = $row['trimester'];   
    array_push($patient_list, array(
      'id' => $id,
      'name' => $name,  
      'email' => $e,
      'contact' => $c_no,
      'trimester' => $trimester==1?'1st Trimester':($trimester==2?'2nd Trimester':($trimester==3?'3rd Trimester':'N/A')),
      'status' => $status,
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
<!-- <style>
  
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
  
</style> -->
 
<div class="container_nu">

  <!-- Sidebar -->
  <?php include_once('../php-templates/admin-navigation-left.php');  ?>

  <!-- Page Content -->
  <div class="main_nu" >
    <?php include_once('../php-templates/admin-navigation-right.php'); ?>

    <div class="container-fluid default">
      <div class="background-head row m-2 my-4"><h4 class="pb-3 m-3 fw-bolder ">View Patient</h4>
        <div class="table-padding table-responsive">
          <div class="pagination-sm col-md-8 col-lg-12" id="table-position">
           <table class="text-center  table mt-5  table-responsive table-lg table-hover display" id="datatables">
            <thead class="table-light" colspan="3">
              <tr>
                <th scope="col" >#</th>
                <th scope="col" class="col-sm-2">Patient Name</th> 
                <th scope="col" class="col-sm-1 mx-auto" style="width: 10px;margin-left: 2">Email</th>  
                <th scope="col" >Trimester</th> 
                <th scope="col" class="col-sm-2">Contact Number</th>
                <!-- <th scope="col">Birthdate</th> -->
                <th scope="col">Barangay</th> 
                <th scope="col" >Actions</th>
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
                        <th scope="row" class="th-number"><span><?php echo $key+1; ?></span></th>
                        <td class="td-bold"><?php echo $value['name']; ?></td>
                        <td ><?php echo $value['email']; ?></td>
                        <td><?php echo $value['trimester']; ?></td>
                        <td><?php echo $value['contact']; ?></td>
                        <!-- <td><?php $dtf = date_create($value['b_date']); echo date_format($dtf,"F d, Y"); ?></td> -->
                        <td><?php echo $value['barangay']; ?></td>
                        <td>
                          <div class="p-2">
                            <?php if ($admin==0) { 
                              if ($value['status']==0) {?> 
                               <a href="approve-patient.php?id=<?php echo $value['id'] ?>">  
                                  <button type="button" class="mb-2 btn btn-primary btn-sm btn-inverse">
                                    Approve</button></a>  
                               <a href="reject-patient.php?id=<?php echo $value['id'] ?>" onclick="return confirm('Are you sure? Do you want to reject this patient?')">  
                                  <button type="button" class="mb-2 btn btn-outline-danger btn-sm btn-inverse">
                                    Reject</button></a>  

                              <?php } else { ?>
                                <div class="mb-2">
                                <a href="edit-patient.php?id=<?php echo $value['id'] ?>">  
                                  <button type="button" class=" btn btn-success btn-sm btn-inverse">
                                    Update</button></a>  
                                  </div>
                                <!-- <a href="delete-patient.php?id=<?php //echo $value['id'] ?>&details_id=<?php //echo $value['details_id'] ?>&med_history_id=<?php //echo $value['med_history_id'] ?>"> -->
                                  <!-- <button onclick="temp_func() " type="button" class="me-1 btn-danger btn-sm btn-inverse ">Delete</button> -->
                                <!-- </a> --> 
                                <!-- <hr/> -->
                              <?php }
                            }?>
                          <a href="med-patient.php?id=<?php echo $value['id'] ?>">
                            <button type="button" class="text-center btn btn-primary btn-sm btn-inverse ">View Report</button></a>
                          </div>
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
            [30,50, -1],
            [30,50, "All"]
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

       var el_up = document.getElementById("GFG_UP");
                  
            el_up.innerHTML =
                    "Click on the LINK for further confirmation."; 
              
            var el = document.getElementsByClassName('confirm');
              
            var confirmThis = function (e) {
                if (!confirm('Are you sure?')) e.preventDefault();
            };
              
            for (var i = 0, l = el.length; i < l; i++) {
                el[i].addEventListener('click', confirmThis, false);
            }
  </script>
 
<?php 
include_once('../php-templates/admin-navigation-tail.php');
?>