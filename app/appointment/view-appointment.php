<?php

@include '../includes/config.php';

session_start();

@include '../php-templates/redirect/admin-page-setter.php';
@include '../php-templates/redirect/patient-status-checker.php';
@include '../php-templates/redirect/patient-only.php';
 
$session_id = $_SESSION['id'];
$appointment_list = [];
$yester_date = date("Y-m-d", strtotime('-1 day'));
  
$select = "SELECT CONCAT(d.first_name, 
  IF(d.middle_name IS NULL OR d.middle_name='', '', 
      CONCAT(' ', SUBSTRING(d.middle_name, 1, 1), '.')), 
  ' ', d.last_name) patient, 
    a.date a_date, health_center, a.status, d.user_id u_id, a.appointment_id a_id
FROM appointments a, user_details d, patient_details m, barangays b
WHERE b.barangay_id=m.barangay_id AND a.patient_id=d.user_id AND d.user_id=m.user_id AND a.date>='$yester_date 00:00:00' AND d.user_id=$session_id";

// echo $select;


if($result = mysqli_query($conn, $select))  {
    foreach($result as $row)  {
      $u_id = $row['u_id'];  
      $a_id = $row['a_id'];  
      $name = $row['patient'];  
      $a_date = $row['a_date'];  
      // $c_no = $row['contact_no'];  
      $status = $row['status'];  
      $bgy = $row['health_center'];  
      array_push($appointment_list, array(
        'u_id' => $u_id,
        'a_id' => $a_id,
        'name' => $name,  
        'a_date' => $a_date,
        // 'contact_no' => $c_no,
        'status' => $status,
        'barangay' => $bgy
      ));
    } 
    mysqli_free_result($result);
  } 
  else  { 
    mysqli_free_result($result);
    $error = 'Something went wrong fetching data from the database.'; 
  }  

$page = 'view_appointment';

$conn->close(); 

include_once('../php-templates/admin-navigation-head.php');
?>


<div class="d-flex" id="wrapper"> 
  <!-- Sidebar -->
  <?php include_once('../php-templates/admin-navigation-left.php');  ?> 
  <!-- Page Content -->
  <div id="page-content-wrapper">
    <?php include_once('../php-templates/admin-navigation-right.php'); ?>

    <div class="container-fluid default">
      <div class="background-head row m-2 my-4"><h4 class="pb-3 m-3 fw-bolder ">Appointments</h4><hr>
        <div class="table-padding table-responsive">
          <div class="pagination-sm col-md-8 col-lg-12" id="table-position">
           <table class=" text-center  table mt-5 table-striped table-responsive table-lg table-bordered table-hover display" id="datatables">
            <thead class="table-light" colspan="3">
              <tr>
                <th scope="col">#</th>
                <th scope="col">Patient Name</th> 
                <th scope="col">Barangay</th>  
                <th scope="col">Date and Time</th>
                <!-- <th scope="col">Contact Number</th> -->
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
                <?php 
                  if (isset($error)) {
                    echo '<span class="">'.$error.'</span>'; 
                  } 
                  else { 
                    foreach ($appointment_list as $key => $value) {
                ?>    
                    <tr>
                        <th scope="row"><?php echo $key+1; ?></th>
                        <td><?php echo $value['name']; ?></td>
                        <td><?php echo $value['barangay']; ?></td>
                        <td><?php $dtf = date_create($value['a_date']); 
                            echo date_format($dtf,'F d, Y h:i A'); ?></td>
                        <!-- <td><?php // echo $value['contact_no']; ?></td> -->
                        <td>  
                            <a href="../patients/med-patient.php?id=<?php echo $value['u_id'] ?>">
 
                             
                            <button type="button" type="button" class="text-center btn btn-primary btn-sm btn-inverse ">View Report</button></a> 

                            <?php if ($value['status']==0)  { ?> 
                              <a href="delete-appointment.php?id=<?php echo $value['a_id'] ?>"> 
                                <button type="button" class=" btn btn-danger btn-sm btn-inverse ">
                                  Delete</button></a>
                            <?php } ?> 
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
        searchPlaceholder: "Search Appointments",
      }
    });
  } );
</script>

<?php 
include_once('../php-templates/admin-navigation-tail.php');
?>