<?php 

@include '../includes/config.php'; 

$page = 'view_consultations';

session_start();

@include '../php-templates/redirect/admin-page-setter.php';
@include '../php-templates/redirect/patient-status-checker.php';
@include '../php-templates/redirect/midwife-only.php';
 
// get assigned barangay of midwife
 
$session_id = $_SESSION['id']; 

@include '../php-templates/midwife/get-assigned-barangays.php';

$patient_list = []; 
$consultation_list = [];
if (count($_barangay_list)>0) {// && $admin==0 || $admin==-1) { 
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
  $select = "SELECT c.patient_id id, consultation_id c_id, CONCAT(d.first_name, 
  IF(d.middle_name IS NULL OR d.middle_name='', '', 
      CONCAT(' ', SUBSTRING(d.middle_name, 1, 1), '.')), 
  ' ', d.last_name) name, health_center, date
  FROM consultations c, user_details d, barangays b, patient_details p
  WHERE c.patient_id=d.user_id AND b.barangay_id=p.barangay_id 
    AND $barangay_select p.user_id=d.user_id";
  $final_select = "SELECT id, name, health_center, count(c_id) cons FROM ($select) con_list GROUP BY name;";
  // echo $final_select;
  // echo $yester_date;

  // echo $select;
  if($result = mysqli_query($conn, $final_select))  {
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
      $name = $row['name'];   
      $bgy = $row['health_center'];  
      $cons = $row['cons'];  
      array_push($consultation_list, array(
        'id' => $id,
        'name' => $name,  
        'contact' => $c_no,
        'barangay' => $bgy,
        'cons' => $cons,
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
    CONCAT(d.first_name,IF(d.middle_name='' OR d.middle_name IS NULL, '', CONCAT(' ',SUBSTRING(d.middle_name,1,1),'.')),' ',d.last_name) AS name
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

// create consultation  
if(isset($_POST['submit_consultation'])) {
  $_POST['submit_consultation'] = null;
  $error = ''; 

  if (empty($_POST['date']) || empty($_POST['date_return'])) 
    $error .= 'Fill up input fields that are required (with * mark)! ';
  else {    
    $patient_arr = explode("AND",$_POST['patient_id']);
    $patient_id = mysqli_real_escape_string($conn, $patient_arr[0]);
    $trimester = mysqli_real_escape_string($conn, $_POST['trimester']);

    // $t = empty(trim($_POST['treatment']))?'NULL':("'" . mysqli_real_escape_string($conn, $_POST['treatment']) . "'");
    $m = empty(trim($_POST['prescription']))?'NULL':("'" . mysqli_real_escape_string($conn, $_POST['prescription']) . "'");
    $date = mysqli_real_escape_string($conn, $_POST['date']); // ex: 2022-09-24T00:55
    
  
    $gestation = mysqli_real_escape_string($conn, $_POST['gestation']);
    $blood_pressure = mysqli_real_escape_string($conn, $_POST['blood_pressure']);
    $weight = mysqli_real_escape_string($conn, $_POST['weight']);
    $height_ft = mysqli_real_escape_string($conn, $_POST['height_ft']);
    $height_in = mysqli_real_escape_string($conn, $_POST['height_in']);
    
    $nutritional_status = mysqli_real_escape_string($conn, $_POST['nutritional_status']);
    $status_analysis = mysqli_real_escape_string($conn, $_POST['status_analysis']);
    $advice = mysqli_real_escape_string($conn, $_POST['advice']);
    $change_plan = mysqli_real_escape_string($conn, $_POST['change_plan']);
    $date_return = mysqli_real_escape_string($conn, $_POST['date_return']);

    $insert = "INSERT INTO consultations(
          patient_id, date, prescription, midwife_appointed, trimester,
          gestation, blood_pressure, weight, height_ft, height_in,
          nutritional_status, status_analysis, advice, change_plan, date_return
        ) 
        VALUES($patient_id, '$date',  $m, $session_id, $trimester,
          '$gestation', '$blood_pressure', $weight, $height_ft, $height_in, 
          '$nutritional_status', '$status_analysis', '$advice', '$change_plan', '$date_return'
        );";
    // update weight height_ft height_in trimester of patient
    $update_patient_based_on_consultation = 
      "UPDATE patient_details 
        SET weight=$weight, height_ft=$height_ft, height_in=$height_in, trimester=$trimester
        WHERE user_id=$patient_id";
    if (mysqli_multi_query($conn, "$insert $update_patient_based_on_consultation"))  { 
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
      <div class="modal-dialog modal-lg">
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
                
                <div class="row">
                  <div class="col-lg-6 col-md-6">
                <div class="form__input-group">
                  <div class="mb-3"> <!-- patient -->
                    <label>Patient</label>

                    <!-- <select class="form-select" name="patient_id">]
                      <?php
                        //if (count($patient_list)>0) {
                          //foreach ($patient_list as $key => $value) { 
                      ?> 
                        <option value="<?php //echo $value['id'];?>AND<?php //echo $value['trimester'];?>" <?php //echo $key===0?'selected':'';?>>
                          <?php//echo $value['name'];?></option>
                      <?php  
                        //  }    
                        //}
                      ?>  
                    </select> -->
                    <!-- searchable select  -->
                    <div class="wrapper_ss">
                      <div class="select-btn_ss">
                        <span>Select A Patient</span>
                        <i class="uil uil-angle-down"></i>
                      </div>
                      <input type="text" style="display:none;" name="patient_id" class="patient_id_trimester"/>
                      <div class="content_ss1">
                        <div class="search_ss1">
                        <ion-icon class="search-logo" name="search-outline"></ion-icon>
                          <input spellcheck="false" type="text" placeholder="Search" class="ss" >
                        </div>
                        <ul class="options_ss"></ul>
                      </div>
                    </div> 
                    </div>
                    </div>
                    <!-- end searchable select  --> 
                  </div> 
                  <div class="col-lg-6 col-md-6">
                  <div class=" mb-3" > <!-- trimester -->
                    <label>Nth Trimester</label>
                    <select class="form-select" name="trimester">
                      <option  class="option" value="0">N/A</option>
                      <option  class="option" value="1">1st (0-13 weeks)</option>
                      <option  class="option" value="2">2nd (14-27 weeks)</option>
                      <option  class="option" value="3">3rd (28-42 weeks)</option>
                    </select>
                  </div> 
              </div>
            </div>


              <div class="row">
                <div class="col-lg-6 col-md-6">
                  <div class=" mb-3"> <!-- gestation -->
                  <label>Age of Gestation*</label>
                    <input type="text" 
                        class="form-control mt-2 mb-2"  name="gestation" required/>    
                    
                    <!-- <input id="gestation" name="gestation" class="" type="text" required/>  -->
                  </div>
                  </div>
                  <div class="col-lg-6 col-md-6">
                  <div class="mb-3"> <!-- blood_pressure -->      
                    <label>Blood Pressure*</label>
                    <input  name="blood_pressure" class="form-control mt-2 mb-2" type="text" required/> 
                  </div>
                  </div>
                </div>
                  <!-- start -->
                  <div class="row">
                    <div class="col-lg-6 col-md-6">
                    <div class="form_input-group" style="font-family:  'Open Sans', sans-serif;margin-bottom: 1rem;">
                        <!-- Height -->
                        <label>Height*</label>
                      <div class="d-flex input-group">
                        <input  min='0' type="number" 
                          class="form__input form-control" id="height_ft" name="height_ft" placeholder="Height*" required/>
                          <div class="input-group-postpend">

                            <div id="weight-height" class="input-group-text form__input text-white">
                            ft</div>
                        </div>
          
                        <input  min='0' max='11' type="number" 
                          class="form__input form-control" id="height_in" name="height_in" placeholder="Inches*" required/> 
                          <div class="input-group-postpend">
                      <div id="weight-height" class=" input-group-text form__input text-white">inch(es) </div>
                      </div>
                    </div>
                  </div>
                          </div>
                  <div class="col-lg-6 col-md-6">
                  <div class="form__input-group" style="font-family:  'Open Sans', sans-serif;margin-bottom: 1rem;">  
                        <label>Weight*</label>
                    <div class="d-flex input-group">   
                        <input type="number" class="form__input form-control" id="weight" name="weight" 
                          placeholder="Weight*" required min='0'/>
                          <div class="input-group-postpend">
                        <div id="weight-height" class="w-100 input-group-text form__input text-white"> kg</div>
                      </div>
                      </div>
                          </div>
                          </div>
                          </div>
                      <!-- end -->
                    <div class="row">
                      <div class="col-lg-6 col-md-6">
                  <div class="mb-3"> <!-- date -->
                    <label>Consultation Date and Time*</label> 
                    <div class="input-group date" id="datepicker">
                      <input class="form-control option" type="datetime-local" name="date" required /></div> 
                  </div>  
                  </div>
                  <div class="col-lg-6 col-md-6">
                  <div class=" mb-3"> <!-- nutritional_status -->
                    <label>Nutritional Status*</label>
                    <select class="form-select" name="nutritional_status">
                      <option  class="option" value="Normal">Normal</option>
                      <option  class="option" value="Underweight">Underweight</option>
                      <option  class="option" value="Overweight">Overweight</option>
                    </select>
                  </div>
                </div> 
                </div>
                <div class="row">
                  <div class="col-lg-6 col-md-6">
                  <div class="mb-3"> <!-- status_analysis -->     
                    <label for="status_analysis">Status Analysis</label>
                    <textarea id="status_analysis" name="status_analysis" 
                      class="form-control form-control-md w-100"></textarea> 
                  </div>
                  </div>
                  <div class="col-lg-6 col-md-6">
                  <div class="mb-3"> <!-- advice -->     
                    <label for="advice">Advice</label>
                    <textarea id="advice" name="advice" 
                      class="form-control form-control-md w-100"></textarea> 
                  </div>
                    </div>
                </div>

                <div class="row">
                  <div class="col-lg-6 col-md-6">
                  <div class="mb-3"> <!-- change_plan -->     
                    <label for="change_plan">Changes in Birth Plan</label>
                    <textarea id="change_plan" name="change_plan" 
                      class="form-control form-control-md w-100"></textarea> 
                  </div>
                </div>
                <div class="col-lg-6 col-md-6">
                  <div class="mb-3"> <!-- prescription -->     
                    <label for="prescription">Prescription</label>
                    <textarea id="prescription" name="prescription" class="form-control form-control-md w-100"> 
                    </textarea> 
                    </div>
                  </div>
                </div>
                <div class="row">
                <div class="col-lg-6 col-md-6">
                  <div class="mb-3"> <!-- date_return -->
                    <label>Date of Return*</label> 
                    <div class="input-group date" id="datepicker_return">
                      <input class="form-control option" type="datetime-local" name="date_return" required/> 
                    </div>
                    </div> 
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
            <button class="btn btn-primary" id="submit" type="submit" 
              name="submit_consultation" form="new_consultation">Add Consultation</button>
          </div>
        </div>
      </div>
    </div>
    <!-- end modal --> 
    <div class="container-fluid default"> 
      <div class="background-head row m-2 my-4"><h4 class="pb-3 m-3 fw-bolder ">Consultations</h4>
      <?php 
      if ($current_user_is_a_midwife) { ?>
        <div class="card-body">
          <div class="row">
            <div class="d-flex p-1 justify-content-between">
              <button class="btn btn-primary"  data-bs-toggle="modal" data-bs-target="#add">Add Consultation</button>
            </div> 
          </div>
        </div> 
      <?php 
      } ?>
      <div class="table-padding table-responsive">
        <?php 
        if (count($_barangay_list)==0 && $admin==0){
          echo '<span class="">There are no barangays assigned to you.</span>';
        } else { ?> 
          <div class="pagination-sm  col-md-8 col-lg-12" id="table-position">
            <table  class="text-center  table mt-5  table-responsive table-lg table-hover display" id="datatables">
              <thead class="table-light" colspan="3">
                <tr>
                  <th scope="col"  >#</th>
                  <th scope="col" class="col-sm-2">Patient Name</th> 
                  <th scope="col">Barangay</th>  
                  <th scope="col" class="col-sm-2">Contact Number(s)</th>
                  <th scope="col" class="col-sm-2">Consultations</th>
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
                      <tr onclick="window.location='list.php?id=<?php echo $value['id']; ?>';"> 
                          <th scope="row" class="th-number"><span><?php echo $key+1; ?></span></th>
                          <td class="td-bold"><?php echo $value['name']; ?></td>
                          <td><?php echo $value['barangay']; ?></td>
                          <td><?php echo $value['contact']; ?></td> 
                          <td><?php echo $value['cons']; ?></td>  
                      </tr>
                  <?php 
                      }
                    }
                  ?> 
              </tbody>
            </table>
          </div>    
        <?php 
        } ?> 
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
        searchPlaceholder: "Search Consultation",
      }
    });
  } );
</script>

<?php 
include_once('../php-templates/admin-navigation-tail.php');
?>