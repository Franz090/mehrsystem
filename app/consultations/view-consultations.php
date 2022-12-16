<?php 

@include '../includes/config.php'; 

$page = 'view_consultations';

session_start();

@include '../php-templates/redirect/admin-page-setter.php';
@include '../php-templates/redirect/patient-status-checker.php';
@include '../php-templates/redirect/not-for-nurse.php';
 
// get assigned barangay of midwife
 
$session_id = $_SESSION['id']; 

@include '../php-templates/midwife/get-assigned-barangays.php';

$patient_list = []; 
$consultation_list = [];
if (count($_barangay_list)>0 && $admin==0 || $admin==-1) { 
  // $yester_date = date("Y-m-d", strtotime('-1 day'));
  // fetch consultations 
  $barangay_select = '';
  $barangay_list_length_minus_1 = count($_barangay_list)-1;
  foreach ($_barangay_list as $key => $value) { 
    if ($key==0) {
      $barangay_select .= "(";
    }
    $barangay_select .= "p.barangay_id=$value ";
   
    if ($key < $barangay_list_length_minus_1) {
      $barangay_select .= "OR ";
    } else {
      $barangay_select .= ") AND";
    }
  } 
  $patient_str = $admin==-1?"AND $session_id=d.user_id":"";
  $select = "SELECT c.patient_id id, consultation_id c_id, CONCAT(d.first_name, 
  IF(d.middle_name IS NULL OR d.middle_name='', '', 
      CONCAT(' ', SUBSTRING(d.middle_name, 1, 1), '.')), 
  ' ', d.last_name) name, health_center, date, treatment_file
  FROM consultations c, user_details d, barangays b, patient_details p
  WHERE c.patient_id=d.user_id AND b.barangay_id=p.barangay_id 
    AND $barangay_select p.user_id=d.user_id $patient_str;";
  
  // echo $yester_date; 

  // echo $select;
  if($result = mysqli_query($conn, $select))  {
    foreach($result as $row)  {
      $id = $row['id']; 
      $contact_num_select = "SELECT mobile_number FROM contacts WHERE type=1 AND owner_id=$id";
      if ($result_contact_num_select = mysqli_query($conn, $contact_num_select)) {
        if (mysqli_num_rows($result_contact_num_select)>0) {
          $_contact_num = "";
          foreach ($result_contact_num_select as $_key=>$__row) {
              $_contact_num .= ("(".$__row['mobile_number'].") "); 
          }
        }
      }
      $c_no = $_contact_num;  
      $c_id = $row['c_id'];  
      $name = $row['name'];   
      $treatment_file = $row['treatment_file']==null?"":substr($row['treatment_file'],15);   
      $date = $row['date'];  
      $bgy = $row['health_center'];  
      array_push($consultation_list, array(
        'id' => $id,
        'treatment_file' => $treatment_file,
        'c_id' => $c_id,
        'name' => $name,  
        'contact' => $c_no,
        'date' => $date,
        'barangay' => $bgy,
      ));
    } 
    mysqli_free_result($result);
  } 
  else  { 
    mysqli_free_result($result);
    $error = 'Something went wrong fetching data from the database.'; 
  }  

  // fetch patients 
  $select1 = "SELECT users.user_id id, trimester,
  CONCAT(d.first_name,IF(d.middle_name='' OR middle_name IS NULL, '', CONCAT(' ',SUBSTRING(d.middle_name,1,1),'.')),' ',d.last_name) AS name
  FROM users, user_details d, patient_details p
  WHERE role=-1 AND $barangay_select d.user_id=users.user_id AND p.user_id=users.user_id";
  // echo $select1;
  if ($result_patient = mysqli_query($conn, $select1)) {
    foreach($result_patient as $row) {
        $id = $row['id'];  
        $trimester = $row['trimester'];  
        $name = $row['name'];  
        array_push($patient_list, array('id' => $id,
        'name' => $name,
        'trimester' => $trimester
    ));
    } 
    mysqli_free_result($result_patient);
  } 
  else  { 
    $error = 'Something went wrong fetching data from the database.'; 
  }   
} 

// add  
if(isset($_POST['submit_consultation'])) {
  $_POST['submit_consultation'] = null;
  $error = ''; 

  if (empty($_POST['date']))
    $error .= 'Fill up input fields that are required (with * mark)! ';
  else {    
    $patient_arr = explode("AND",$_POST['patient_id']);
    $patient_id = mysqli_real_escape_string($conn, ($patient_arr[0]));
    $patient_trimester = mysqli_real_escape_string($conn, ($patient_arr[1]));

    $t = empty(trim($_POST['treatment']))?'NULL':("'" . mysqli_real_escape_string($conn, $_POST['treatment']) . "'");
    $m = empty(trim($_POST['prescription']))?'NULL':("'" . mysqli_real_escape_string($conn, $_POST['prescription']) . "'");
    $date = mysqli_real_escape_string($conn, $_POST['date']); // ex: 2022-09-24T00:55
    
  
    $insert = "INSERT INTO consultations(patient_id, date, treatment, prescription, treatment_file, midwife_appointed, trimester) 
        VALUES($patient_id, '$date', $t, $m, NULL, $session_id, $patient_trimester);";

    if (mysqli_query($conn, $insert))  { 
      echo "<script>alert('Consultation Added!');window.location.href='./view-consultations.php'; </script>"; 
    }
    else {  
      $error .= 'Something went wrong adding the appointment to the database.';
    }  
  }  
} 

$conn->close(); 

include_once('../php-templates/admin-navigation-head.php');
?> 

<div class="container_nu"> 
  <!-- Sidebar -->
  <?php include_once('../php-templates/admin-navigation-left.php');  ?> 
  <!-- Page Content -->
  <div class="main_nu">
    <?php include_once('../php-templates/admin-navigation-right.php'); ?>

<!-- modal -->
<div class="modal fade" id="add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add a New Consultation</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        <div class="modal-body">
        <form class="m-5" action="" method="POST" id="new_consultation">
          <?php
            if (count($_barangay_list)==0) {
          ?> 
            You can't give consultations because you are not assigned to any barangay.
          <?php
            } else  if (count($patient_list)>0) { 
              if(isset($error)) 
                echo '<span class="form__input-error-message">'.$error.'</span>'; 
            ?> 
            <div class="form__input-group">
              <div class="mb-3">
                <label>Patient</label>
                <select class="form-select" name="patient_id">]
              <?php
                if (count($patient_list)>0) {
                  foreach ($patient_list as $key => $value) { 
              ?> 
                    <option value="<?php echo $value['id'];?>AND<?php echo $value['trimester'];?>" <?php echo $key===0?'selected':'';?>>
                      <?php echo $value['name'];?></option>
              <?php  
                  }    
                }
              ?>  
                </select>
              </div> 
              <div class="mb-3">
                <label>Consultation Date and Time*</label> 
                 <div class="input-group date" id="datepicker">
                <input class="form-control option" type="datetime-local" name="date" required />
              </div>
              </div>
              <div class="mb-3">     
                <label for="prescription">Prescription</label>
                <textarea id="prescription" name="prescription" class="form-control form-control-md w-100"></textarea> 
              </div>
              <div class="mb-3">     
                <label for="treatment">Treatment</label>
                <textarea id="treatment"  name="treatment" 
                class="form-control form-control-md w-100"></textarea>
              </div> 
            </div>  
          <?php
            } else {
              ?>
              There should be at least one patient (under your assigned barangay) available in the database.
              <?php
            }
          
          
          ?>  
        </form>
      </div>
      <div class="modal-footer">
       
        <button class="btn btn-primary" id="submit" type="submit" name="submit_consultation" form="new_consultation">Add Consultation</button>
      
      </div>
    </div>
  </div>
</div>
<!-- end modal -->


    <div class="container-fluid default">
       <div class="background-head row m-2 my-4"><h4 class="pb-3 m-3 fw-bolder ">Consultations</h4>
       <div class="card-body">
          <div class="row">
               <div class="d-flex p-1 justify-content-between">
              <button class="btn btn-primary"  data-bs-toggle="modal" data-bs-target="#add">Add Consultation</button>
          </div>
          </div>
        </div>
        <div class="table-padding table-responsive">
      <?php if (count($_barangay_list)==0 && $admin==0){
        echo '<span class="">There are no barangays assigned to you.</span>';
      } else { ?> 
         <div class="pagination-sm  col-md-8 col-lg-12" id="table-position">
          <table  class="text-center  table mt-5 table-striped table-responsive table-lg  table-hover display" id="datatables">
            <thead class="table-light" colspan="3">
              <tr>
                <th scope="col" >#</th>
                <?php if ($admin==0) { ?>  
                  <th scope="col">Patient Name</th> 
                <?php } ?>  
                <th scope="col">Treatment File</th>  
                <th scope="col">Barangay</th>  
                <th scope="col" >Date and Time</th>
                <?php if ($admin==0) { ?>  
                  <th scope="col">Contact Number(s)</th>
                <?php } ?>  
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
                <?php 
                  if (isset($error)) {
                    echo '<span class="">'.$error.'</span>'; 
                  } 
                  else { 
                    foreach ($consultation_list as $key => $value) {
                ?>    
                    <tr>
                        <th scope="row"><?php echo $key+1; ?></th>
                        <?php if ($admin==0) { ?>  
                          <td><?php echo $value['name']; ?></td>
                        <?php } ?> 
                        <?php if ($value['treatment_file']=='') { ?>  
                          <td>No File</td> 
                        <?php } else {?>  
                          <td> <a target="_blank" style="color:#000;"
                              href="./view-treatment-file.php?id=<?php echo $value['treatment_file']?>">
                              View Photo</a> 
                          </td> 
                        <?php } ?> 
                        <td><?php echo $value['barangay']; ?></td>
                        <td><?php $dtf = date_create($value['date']); 
                            echo date_format($dtf,'F d, Y h:i A'); ?></td>
                        <?php if ($admin==0) { ?>  
                          <td><?php echo $value['contact']; ?></td> 
                        <?php } ?> 
                        <td>
                          <a href="edit-consultation-record.php?id=<?php echo $value['c_id'] ?>">
                           <div class="p-1">
                            <button class="mb-2 edit btn btn-success btn-sm btn-inverse">Update</button></a>
                          <a href="../patients/med-patient.php?id=<?php echo $value['id'] ?>">
                            <button type="button" class="text-center btn btn-primary btn-sm btn-inverse ">View Report</button></a>
                            <!-- <a href="cancel-appointment.php?id=<?php //echo $value['c_id'] ?>">
                              <button class="btn btn-danger btn-sm btn-inverse">Cancel</button></a>  -->
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
      <?php } ?> 
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
        searchPlaceholder: "Search Consultation",
      }
    });
  } );
</script>

<?php 
include_once('../php-templates/admin-navigation-tail.php');
?>