<?php

session_start();

@include '../php-templates/redirect/admin-page-setter.php';
@include '../php-templates/redirect/midwife-only.php';

$pending = $page == 'pending_appointment';
// get assigned barangay of midwife
$session_id = $_SESSION['id'];

@include '../php-templates/midwife/get-assigned-barangays.php';

$appointment_list = [];
$patient_list = [];
if (count($_barangay_list) > 0) {
  $yester_date = date("Y-m-d", strtotime('-1 day'));
  $barangay_select = '';
  $barangay_list_length_minus_1 = count($_barangay_list) - 1;
  foreach ($_barangay_list as $key => $value) {
    $barangay_select .= "p.barangay_id=$value ";
    if ($key < $barangay_list_length_minus_1) {
      $barangay_select .= "OR ";
    }
  }
  // fetch appointments  
  $select = "SELECT a.patient_id id, a.appointment_id a_id, CONCAT(i.first_name, 
    IF(i.middle_name IS NULL OR i.middle_name='', '', 
        CONCAT(' ', SUBSTRING(i.middle_name, 1, 1), '.')), 
    ' ', i.last_name) name, health_center, date
  FROM appointments a, user_details i, barangays b, patient_details p
  WHERE a.patient_id=i.user_id AND b.barangay_id=p.barangay_id 
    AND p.user_id=i.user_id AND a.date>'$yester_date 23:59:59'
    AND ($barangay_select)  AND b.assigned_midwife=$session_id
    AND a.status=" . ($pending ? 0 : 1) . " ORDER BY a.date DESC;";


  if ($result = mysqli_query($conn, $select)) {
    foreach ($result as $row) {
      $id = $row['id'];
      $contact_num_select = "SELECT mobile_number FROM contacts WHERE type=1 AND owner_id=$id";
      if ($result_contact_num_select = mysqli_query($conn, $contact_num_select)) {
        if (mysqli_num_rows($result_contact_num_select) > 0) {
          $_contact_num = "";
          foreach ($result_contact_num_select as $_key => $__row) {
            $_contact_num .= ("(" . $__row['mobile_number'] . ") ");
          }
        }
      }
      $c_no = $_contact_num;

      $a_id = $row['a_id'];
      $name = $row['name'];
      // $e = $row['email'];  
      // $c_no = $row['contact_no'];  
      $date = $row['date'];
      $bgy = $row['health_center'];
      // $det_id = $row['details_id'];    
      array_push($appointment_list, array(
        'id' => $id,
        'a_id' => $a_id,
        'name' => $name,
        // 'email' => $e,
        'contact' => $c_no,
        'date' => $date,
        'barangay' => $bgy,
        // 'details_id' => $det_id,
      ));
    }
    mysqli_free_result($result);
  } else {
    mysqli_free_result($result);
    $error = 'Something went wrong fetching data from the database.';
  }

  // fetch patients 
  $select_patients = "SELECT u.user_id, trimester,
      CONCAT(ud.first_name, 
  IF(ud.middle_name IS NULL OR ud.middle_name='', '', 
      CONCAT(' ', SUBSTRING(ud.middle_name, 1, 1), '.')), 
  ' ', ud.last_name) name
      FROM users u, patient_details p, user_details ud
      WHERE role=-1 AND ($barangay_select) AND p.user_id=u.user_id AND ud.user_id=u.user_id";

  if ($result_patient = mysqli_query($conn, $select_patients)) {
    foreach ($result_patient as $row) {
      $id = $row['user_id'];
      $name = $row['name'];
      $trimester = $row['trimester'];
      array_push($patient_list, array('id' => $id, 'name' => $name, 'trimester' => $trimester));
    }
    mysqli_free_result($result_patient);
  } else {
    mysqli_free_result($result_patient);
    $error = 'Something went wrong fetching data from the database.';
  }
}

// @include '../php-templates/appointments/submit-add-appointment.php';


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
    if (count($_barangay_list)) {
      if (count($patient_list) > 0) { ?>
        <div class="modal fade" id="add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add a New Appointment</h1>
                <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form class="m-5" action="" method="POST" id="new_appointment">
                  <?php
                  if (isset($error))
                    echo '<span class="form__input-error-message">' . $error . '</span>';
                  ?>

                  <!-- searchable select  -->
                  <div class="wrapper_ss">
                    <div class="select-btn_ss">
                      <span>Select A Patient</span>
                      <i class="uil uil-angle-down"></i>
                    </div>
                    <input type="text" style="display:none;" name="patient_id_trimester" id="patient_id_trimester" class="patient_id_trimester" />
                    <div class="content_ss">
                      <div class="search_ss">
                        <ion-icon class="search-logo" name="search-outline"></ion-icon>
                        <input spellcheck="false" type="text" placeholder="Search" class="ss">
                      </div>
                      <ul class="options_ss"></ul>
                    </div>
                  </div>
                  <br>
                  <div class="mb-3" style="text-align:center;">
                    <label>Appointment Date and Time*</label>
                    <div class="input-group date" id="datepicker">
                      <input class="form-control option pt-2 pb-2" type="datetime-local" name="date" id="date" />
                    </div>
                  </div>

                </form>
              </div>
              <div class="modal-footer">
                <button class="btn btn-primary btn-submit" id="submit" type="submit" name="submit_appointment" form="new_appointment">Add Appointments</button>
              </div>
            </div>
          </div>
        </div>
      <?php
      } else { ?>
        There should be at least one patient (under your assigned barangay) available in the database.
      <?php
      }
    } else { ?>
      You can't book an appointment because you are not assigned to any barangay.
    <?php
    }
    ?>

    <!-- End Modal -->

    <div class="container-fluid default">

      <div class="background-head row m-2 my-4">
        <br>
        <h4 class="fw-bolder"><?php echo $pending ? 'Pending' : 'Approved' ?> Appointments</h4>
        <br>
        <div class="float-start">
          <div class="d-flex justify-content-between">
            <div class="d-flex bd-highlight">
              <div class="p-1 bd-highlight">
                <button class="btn btn-sm btn-primary pull-right" data-bs-toggle="modal" data-bs-target="#searchSchedule">Search Availability</button>
              </div>

              <div class="p-1 bd-highlight">
                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#add"> Add Appointment </button>
              </div>
            </div>
            <div class="float-end">
              <div class="p-1 flex-grow-1 bd-highlight">
                <select class="form-select" aria-label="Default select example" name="s01" onChange="SelectRedirect();" id="s01">
                  <option value="" hidden><?php echo $pending ? 'Pending' : 'Approved' ?></option>
                  <option value="Approved">Approved</option>
                  <option value="Pending">Pending</option>
                </select>
              </div>
            </div>
          </div>
        </div>
        <!-- <a href="./<?php echo $pending ? 'approved' : 'pending' ?>-appointment.php">See <?php echo $pending ? 'Approved' : 'Pending' ?> Appointments</a> -->



        <div class="table-padding table-responsive mt-1 px-2">
          <?php if (count($_barangay_list) == 0) {
            echo '<span class="">There are no barangays assigned to you.</span>';
          } else { ?>
            <div class="pagination-sm  col-md-8 col-lg-12" id="table-position">
              <table class="text-center table mt-5  table-responsive table-lg table-hover display" id="datatables">
                <thead class="table-light" colspan="3">
                  <tr>
                    <th scope="col" width="6%">#</th>
                    <th scope="col">Patient Name</th>
                    <th scope="col">Barangay</th>
                    <th scope="col">Date and Time</th>
                    <th scope="col">Contact Number(s)</th>
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
                        <td class="td-bold"><?php echo $value['name']; ?></td>
                        <td><?php echo $value['barangay']; ?></td>
                        <td class="col-2"><?php $dtf = date_create($value['date']);
                                          echo date_format($dtf, 'F d, Y h:i A'); ?></td>
                        <td class="col-2"><?php echo $value['contact']; ?></td>
                        <?php if ($value['name'] == 'Deleted Patient') { ?>
                          <td>
                            Deleted Patient
                          </td>
                        <?php } else if ($pending) { ?>
                          <td>
                            <!-- <a href="approve-appointment.php?id=<?php echo $value['a_id'] ?>"> -->
                            <button class=" btn btn-primary mt-3 btn-sm btn-inverse approve-appointment col-xs-2 margin-left" data-id="<?php echo $value['a_id'] ?>" data-date="<?php echo $value['date']; ?>" data-patient="<?php echo $value['id'] ?>">
                              Approve
                            </button>
                            <!-- </a> -->
                            <!-- <a href="delete-appointment.php?id=<?php //echo $value['a_id'] 
                                                                    ?>">
                                <button class="del btn btn-danger btn-sm btn-inverse">Delete</button></a>
                          </td>  -->
                          <?php } else { ?>
                          <td>
                            <!-- <a href="../patients/med-patient.php?id=<?php echo $value['id'] ?>">
                                  <button class="edit btn btn-primary btn-sm btn-inverse">View Report</button></a> -->

                          <?php } ?>
                          <style>
                            .margin-left {
                              margin-left: 5px !important;
                            }
                          </style>
                          <button class="btn btn-danger btn-sm btn-inverse mt-3 cancel-appointment col-xs-2 margin-left" data-id="<?php echo $value['a_id'] ?>" data-date="<?php echo date_format($dtf, 'F d, Y h:i A'); ?>" data-patient="<?php echo $value['id'] ?>">
                            Cancel
                          </button>
                          </td>
                      </tr>
                  <?php
                    }
                  }
                  ?>
                </tbody>
              </table>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="searchSchedule" tabindex="-1" aria-labelledby="searchSchedule" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5">Search Available Schedule</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <form action="POST" id="search_availability">
          <input class="pr-2 pl-2 form-control search_date" type="date" name="s_date" required />
          <input type="hidden" name="role" value="midwife">
          <div id="available_result" style="margin: 18px;"></div>

        </form>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary  btn-submit  pt-1 pb-1 " id="submit_appointment" type="submit" name="submit_appointment" form="search_availability">Search</button>
      </div>

    </div>
  </div>
</div>
</div>
<script>
  $(document).ready(function() {
    var url = '../controller/appointmentController.php';
    $('#datatables').DataTable({
      "pagingType": "full_numbers",
      "lengthMenu": [
        [30, 50, -1],
        [30, 50, "All"]
      ],
      destroy: true,
      fixedColumns: true,
      responsive: true,
      language: {
        search: "_INPUT_",
        searchPlaceholder: "Search Appointment",
      }
    });
  });
</script>
<!-- js file to sa option dropdown dun sa dropdown na may nakalagay na pending at approved -->
<script src="../js/option-dropdown.js"></script>
<?php
include_once "../controller/onLoadController.php";
$onloadData = new onLoadController();
$date_sched_array = $onloadData->getMidwifeAppointment();
include_once('../php-templates/admin-navigation-tail.php');
?>

<script>
  $(document).ready(function() {
    var url = '../controller/appointmentController.php';
    $("#new_appointment").submit(function(e) {
      e.preventDefault();
      $('.btn-submit').prop('disabled', true);
      $('.btn-submit').html('Please wait...');
      var data = new FormData(this);
      var ptine = $('#patient_id_trimester').val();
      let path = url + `?command=addAppointment`;
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


    $('.approve-appointment').on('click', function() {
      const appointment_id = $(this).data("id");
      const appointment_date = $(this).data("date");
      const patient = $(this).data("patient");
      $(this).prop('disabled', true);
      $(this).html('Please wait...');
      $.SystemScript.swalConfirmMessage('Are you sure',
        'Do you want to approve this appointment?', 'question').done(function(response) {
        if (response) {
          let path = url + `?command=approveAppointment&appointment_id=${appointment_id}&appointment_date=${appointment_date}&patient=${patient}`;
          $.SystemScript.executeGet(path).done((res) => {
            // console.log(res);
            if (res.data.status == 'success') {
              $.SystemScript.swalAlertMessage('Successfully', `${res.data.message}`, 'success');
              $('.swal2-confirm').click(function() {
                location.reload();
              });
            } else {
              $.SystemScript.swalAlertMessage('Error', `${res.data.message}`, 'error');
              $('.approve-appointment').prop('disabled', false);
              $('.approve-appointment').html('Approve');
            }
          });

        } else {
          $('.approve-appointment').prop('disabled', false);
          $('.approve-appointment').html('Approve');
        }

      });
    });

  });
</script>