<?php

@include '../includes/config.php';

session_start();

@include '../php-templates/redirect/admin-page-setter.php';
@include '../php-templates/redirect/patient-status-checker.php';
@include '../php-templates/redirect/patient-only.php';

$session_id = $_SESSION['id'];
$appointment_list = [];
$yester_date = date("Y-m-d", strtotime('-1 day'));


$admin_b = $admin==1;
$u_id = $yester_date;
$yester_date = date("Y-m-d H:i:s", strtotime('-1 day'));
$midwife_sql = $admin==-1?'':($admin_b?'':"AND b.assigned_midwife=".$_SESSION['id']);

$select = "SELECT CONCAT(d.first_name, 
  IF(d.middle_name IS NULL OR d.middle_name='', '', 
      CONCAT(' ', SUBSTRING(d.middle_name, 1, 1), '.')), 
  ' ', d.last_name) patient, 
    a.date a_date, health_center, a.status, d.user_id u_id, a.appointment_id a_id
FROM appointments a, user_details d, patient_details m, barangays b
WHERE b.barangay_id=m.barangay_id AND a.patient_id=d.user_id AND d.user_id=m.user_id AND a.date>='$yester_date 00:00:00' AND d.user_id=$session_id ORDER BY a.date DESC";

// echo $select;


if ($result = mysqli_query($conn, $select)) {
  foreach ($result as $row) {
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
  $error = 'Something went wrong fetching data from the database.'; 
}  

// all appointments

$order = $admin_b?'DESC':'ASC';
$date = $admin_b?'':"AND a.date>'$yester_date' ";
$appointments_list = [];
// fetch patient appointments 
$select2_a = "SELECT a.date a_date, trimester
  FROM appointments a
  WHERE $u_id=a.patient_id AND a.status=1 $date
  ORDER BY a.date $order";

// echo $select2_a;  
if($result2_a = mysqli_query($conn, $select2_a))  {
  foreach($result2_a as $row)  {
    $a_date = $row['a_date'];  
    $trimester = $row['trimester'];  
    array_push($appointments_list, array(
      'date' => $a_date,
      'trimester' => $trimester==1?'1st Trimester':($trimester==2?'2nd Trimester':($trimester==3?'3rd Trimester':'N/A'))
    ));
  } 
} else {
  mysqli_free_result($result);
  $error = 'Something went wrong fetching data from the database.';
}


@include '../php-templates/appointments/patient/trimester.php';
// @include '../php-templates/appointments/submit-add-appointment.php';


$page = 'view_appointment';

$conn->close();

include_once('../php-templates/admin-navigation-head.php');
?>


<div class="container_nu">
  <!-- Sidebar -->
  <?php include_once('../php-templates/admin-navigation-left.php');  ?>
  <!-- Page Content -->
  <div class="main_nu">
    <?php include_once('../php-templates/admin-navigation-right.php'); ?>

    <!-- Modal -->
    <?php
    // if (count($_barangay_list)) {
    //   if (count($patient_list)>0) {
    ?>
    <div class="modal fade" id="add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Add a New Appointment</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form class="m-5" action="" method="POST" id="new_appointment">
              <?php
              if (isset($error))
                echo '<span class="form__input-error-message">' . $error . '</span>';
              ?>
              <div class="mb-3">
                <label>Appointment Date and Time*</label>
                <div class="input-group date" id="datepicker">
                  <input class="form-control option" type="datetime-local" name="date" id="date" />
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button class="btn btn-primary btn-submit" id="submit" type="submit" name="submit_appointment" form="new_appointment">Add Appointment</button>
          </div>
        </div>
      </div>
    </div>
    <?php
    // } else { 
    ?>
    <!-- There should be at least one patient (under your assigned barangay) available in the database. -->
    <?php
    //   }
    // } else {
    ?>
    <!-- You can't book an appointment because you are not assigned to any barangay. -->
    <?php
    // } 
    ?>

    <!-- End Modal -->

    <div class="container-fluid default">
      <div class="background-head row m-2 my-4"><br>
        <h4 class="fw-bolder ">Appointments</h4><br>
        <div class="d-flex justify-content-between">
          <div class=" align-items-start">
          <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#searchSchedule">Search Availability</button>
          <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#upcomingAppointment">Upcoming Appointment</button>
    </div>

          <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#add"> Add Appointment </button>

        </div>
        <div class="table-padding table-responsive mt-1 px-2">
          <div class="col-md-8 col-lg-12 pagination-sm" id="table-position">
            <table class="text-center  table mt-5  table-responsive table-lg table-hover display" id="datatables">
              <thead class="table-light" colspan="3">
                <tr>
                  <th scope="col" class="col-sm-1">#</th>
                  <!-- <th scope="col">Patient Name</th>  -->
                  <!-- <th scope="col">Barangay</th>   -->
                  <th scope="col">Date and Time</th>
                  <!-- <th scope="col">Contact Number</th> -->
                  <th scope="col">Status</th>
                  <th scope="col">Actions</th>
                 
                </tr>
              </thead>
              <tbody>
                <?php
                if (isset($error)) {
                  echo '<span class="">' . $error . '</span>';
                } else {
                  foreach ($appointment_list as $key => $value) {
                ?>
                    <tr>
                      <th scope="row" class="th-number"><span><?php echo $key + 1; ?></span></th>
                      <!-- <td><?php //echo $value['name']; 
                                ?></td> -->
                      <!-- <td><?php //echo $value['barangay']; 
                                ?></td> -->
                      <td><?php $dtf = date_create($value['a_date']);
                          echo date_format($dtf, 'F d, Y h:i A'); ?></td>
                      <!-- <td><?php // echo $value['contact_no']; 
                                ?></td> -->

                      <td>
                        <?php
                        if ($value['status'] == -1) {
                          echo '<span class="badge bg-danger p-2 rounded">Cancelled</span>';
                        } else if ($value['status'] == 0) {
                          echo '<span class="badge bg-warning p-2 rounded">Pending</span>';
                        } else {
                          echo '<span class="badge bg-info p-2 rounded">Approved</span>';
                        }

                        ?>
                      </td>
                      <td>
                        <!-- <a href="../patients/med-patient.php?id=<?php //echo $value['u_id'] ?>">
                          <button type="button" type="button" class=" btn btn-primary btn-sm btn-inverse ">View Report</button></a> -->
                        <?php if ($value['status'] == 0) { ?>
                          <button type="button" class=" btn btn-danger btn-sm btn-inverse cancel-appointment" data-id="<?php echo $value['a_id'] ?>" data-date="<?php echo date_format($dtf, 'F d, Y h:i A'); ?>" data-patient="0">
                            Cancel </button>
                        <?php } else {?> 
                          No Actions
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
<!-- start upcoming appointment modal -->
<div class="modal fade" id="upcomingAppointment" aria-hidden="true" aria-labelledby="upcomingAppointment" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content px-3 m-5 pb-3 text-center">
      <div class="modal-header ">
        <div class="col-md-6 col-lg-12 text-center ">
        <h1 class="modal-title fs-5 text-center" > <?php echo $admin_b?"Appointment Records":"Upcoming Appointment" ?> </h1></div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">     
                    <?php if (!$current_user_is_an_admin) {?>
                  <?php if (count($appointments_list) > 0) {
                    // if (FALSE) {
                    if ($admin_b) {
                      foreach ($appointments_list as $key => $value) { 
                  ?> 
    <p class="card-text  mr-3 "><strong> Appointment Date</strong></p>
      Appointment Date
                          
                            
                            <?php
                              $dtf2 = date_create($value['date']); 
                              echo date_format($dtf2,"F d, Y");  
                            ?>  
                        
                            Appointment Date
                        
                            <?php
                              echo date_format($dtf2,"h:i A");  
                            ?>  
                         
                            Trimester
                         
                            <?php
                              echo $value['trimester'];  
                            ?>  
                         
                  <?php 
                      } //foreach
                    } else if (date($appointments_list[0]['date']) > $yester_date) { 
                  ?> 
                      
                          <p class="card-text  mr-3 "><strong>   Appointment Date</strong></p>
                        
                          <p class="mr-3 ">
                          <?php
                            $dtf2 = date_create($appointments_list[0]['date']); 
                            echo date_format($dtf2,"F d, Y");  
                          ?>  
                        </p>
                          <p class="card-text  mr-3 "><strong> Appointment Time</strong></p>
                        <p class="mr-3 ">
                          <?php
                            echo date_format($dtf2,"h:i A");  
                          ?>  
                          </p>
                      <p class="card-text  mr-3 "><strong>
                          Trimester</strong></p>
                       <p class="">
                          <?php
                            echo $appointments_list[0]['trimester'];  
                          ?>  
                        </p>
                  <?php  
                    } else { ?>
                      No Appointment
                    <?php }
                  } else { ?> 
                      No Appointments
                  <?php } ?>
                  
                 
           
            
            <?php }?> 
  
      </div>
      <!-- <div class="modal-footer">
        <button class="btn btn-primary" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal">Open second modal</button>
      </div> -->
    </div>
  </div>
</div>
<!-- end upcoming appointment modal -->
<div class="modal fade" id="searchSchedule" tabindex="-1" aria-labelledby="searchSchedule" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5">Search Available Schedule</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div><br>
      <div class="modal-body">
        <form action="POST" id="search_availability">

          <input class="form-control pr-2 pl-2 search_date" type="date" name="s_date" required />
          <input type="hidden" name="role" value="patient">
          <div id="available_result" style="margin: 18px;"></div>
        </form>
      </div>

      <div class="modal-footer">
        <button class="btn btn-primary btn-sm" id="submit_appointment" type="submit" name="submit_appointment" form="search_availability">Search</button>
      </div>

    </div>
  </div>
</div>
</div>
<?php
include_once "../controller/onLoadController.php";
$onloadData = new onLoadController();
$date_sched_array = $onloadData->getAppointmentByAssignedMidwife();
?>
<script>
 
  $(document).ready(function() {

    $('#datatables').DataTable({
      "pagingType": "full_numbers",
      "lengthMenu": [
        [ 30, 50, -1],
        [ 30, 50, "All"]
      ],
      destroy: true,
      fixedColumns: true,
      responsive: true,
      language: {
        search: "_INPUT_",
        searchPlaceholder: "Search Appointments",
      }
    });

    var url = '../controller/appointmentController.php';

    $("#new_appointment").submit(function(e) {
      e.preventDefault();
      $('.btn-submit').prop('disabled', true);
      $('.btn-submit').html('Please wait...');
      var data = new FormData(this);
      var ptine = $('#patient_id_trimester').val();
      let path = url + `?command=addAppointmentFromPatient`;
      $.SystemScript.executePost(path, data).done((response) => {
        // console.log(response.data);
        if (response.data.status == 'success') {
          $.SystemScript.swalAlertMessage('Successfully', `${response.data.message}`, 'success');
          $('.swal2-confirm').click(function() {
            location.reload();
          });
        } else {
          $.SystemScript.swalAlertMessage('Error', `${response.data.message}`, 'error');
        }
        $('.btn-submit').prop('disabled', false);
        $('.btn-submit').html('Submit');
      });
    });
  });
</script>

<?php
include_once('../php-templates/admin-navigation-tail.php');
?>