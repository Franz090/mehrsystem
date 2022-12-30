<?php

@include '../includes/config.php';

session_start();

@include '../php-templates/redirect/admin-page-setter.php';

$id_from_get = $_GET['id'];
// $redirect_condition = "not-for-patient"; 

$admin_b = $admin==1;

$yester_date = date("Y-m-d H:i:s", strtotime('-1 day'));
$midwife_sql = $admin==-1?'':($admin_b?'':"AND b.assigned_midwife=".$_SESSION['id']);
// fetch patient
$select = "SELECT  u.user_id,
  CONCAT(d.first_name,IF(d.middle_name='' OR middle_name IS NULL, '', CONCAT(' ',SUBSTRING(d.middle_name,1,1),'.')),' ',d.last_name) AS name,
  u.email,  
  IF(m.tetanus=0, 'Unvaccinated', 'Vaccinated') AS tetanus, m.b_date,  health_center,
  CONCAT(height_ft, '\'', height_in, '\"') as height, weight, blood_type, diagnosed_condition, allergies 
  FROM users as u, user_details as d, barangays as b, patient_details as m
  WHERE u.user_id=$id_from_get AND d.user_id=u.user_id 
    AND m.barangay_id=b.barangay_id AND m.user_id=u.user_id AND b.archived=0 $midwife_sql";
// echo $select; 
if($result = mysqli_query($conn, $select))  {
  // user does not exist, go to dashboard
  if (mysqli_num_rows($result)==0) {
    header('location: ../'); 
  }
  foreach($result as $row)  {
    $id = $row['user_id'];  
    $name = $row['name'];  
    $e = $row['email'];  
    $s = $row['tetanus']; 
    $select_c_no = "SELECT mobile_number FROM contacts WHERE owner_id=$id AND type=1";
    if ($result_c_no = mysqli_query($conn, $select_c_no)) {
      $c_no = '';
      foreach ($result_c_no as $row2) {
        $c_no .= '('.$row2['mobile_number'].') '; 
      }
    } 
    // $c_no = $row['contact_no'];  
    $b_date = $row['b_date'];  
    $bgy = $row['health_center'];     
    $height = $row['height'];   
    $weight = $row['weight'];   
    $blood_type = $row['blood_type'];   
    $diagnosed_condition = $row['diagnosed_condition'];   
    $allergies = $row['allergies'];    
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
  WHERE $id=a.patient_id AND a.status=1 $date
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
  mysqli_free_result($result2_a);
} 
else  { 
  $error = 'Something went wrong fetching data from the database.'; 
}  

// all consultations
// $yester_date = date("Y-m-d H:i:s", strtotime('-1 day'));
$consultations_list = [];
// fetch patient consultations 
$select2_b = "SELECT c.date, prescription, consultation_id id,
  CONCAT(d.first_name,IF(d.middle_name='' OR middle_name IS NULL, '', CONCAT(' ',SUBSTRING(d.middle_name,1,1),'.')),' ',d.last_name) AS midwife,
   trimester
  FROM (SELECT * FROM consultations WHERE $id=patient_id ORDER BY date DESC) c 
  LEFT JOIN users u
    ON u.user_id=c.midwife_appointed
  LEFT JOIN user_details d
    USING(user_id);";

// echo $select2_b;  
if($result2_b = mysqli_query($conn, $select2_b))  {
  foreach($result2_b as $row)  {
    $id = $row['id'];  
    $date = $row['date'];  
    $trimester = $row['trimester'];  
    // $treatment = $row['treatment'];  
    // $treatment_file = $row['treatment_file']==null?"":substr($row['treatment_file'],15);
    $midwife = $row['midwife'];  
    $prescription = $row['prescription'];  
    $trimester = $row['trimester'];  
    array_push($consultations_list, array(
      'id' => $id,
      'date' => $date,
      // 'treatment' => $treatment,
      'midwife' => $midwife,
      // 'treatment_file' => $treatment_file,
      'prescription' => $prescription,
      'trimester' => $trimester==1?'1st Trimester':($trimester==2?'2nd Trimester':($trimester==3?'3rd Trimester':'N/A'))
    ));
  } 
  mysqli_free_result($result2_b);
} 
else  { 
  $error = 'Something went wrong fetching data from the database.'; 
}   

$conn->close(); 

$page = 'med_patient';
include_once('../php-templates/admin-navigation-head.php');
?>

<!-- css -->
<style>
  .col-centered{
    float: none;
    margin: 0 auto
  }
</style>

<div class="container_nu">

  <!-- Sidebar -->
  <?php include_once('../php-templates/admin-navigation-left.php');  ?>

  <!-- Page Content -->
  <div class="main_nu">
    <?php include_once('../php-templates/admin-navigation-right.php'); ?>

    <div class="container-fluid">
      <?php
        if(isset($error)) 
            echo '<span class="">'.$error.'</span>'; 
        else {
      ?>   
        <div class="background-head row m-2 my-4"><h4 class="pb-3 m-3 fw-bolder ">View Patient Report</h4>

        <div class="default table-responsive">
          <div class="col-md-8 col-lg-12 ">
        <table class="table mt-4 table-striped table-responsive table-lg  table-hover display">
            <thead class="table-light text-center" colspan="3">
            <tr>
            <th scope="col">Patient Profile </th>
        </tr>
            </thead>
            <tbody>
            <tr class="row col-xs-3 col-md-12 col-centered">
              <td class="col-md-3 fw-bold">Patient Name</td>
              <td class="col-md-3"><?php echo $name ?></td>
              <td  class="col-md-3 fw-bold">Patient ID</td>
              <td  class="col-md-3"><?php echo $id ?></td>
        </tr>
       
       
            <tr class="row col-xs-3 col-md-12 col-centered">
              <td  class="col-md-3 fw-bold">Barangay</td>
              <td class="col-md-3"><?php echo $bgy ?></td>
              <td  class="col-md-3 fw-bold">Tetanus Toxoid</td>
              <td  class="col-md-3"><?php echo $s ?></td>
        </tr>
      
        
            <tr class="row col-xs-3 col-md-12 col-centered">
              <td  class="col-md-3 fw-bold">Contact Number</td>
              <td  class="col-md-3"><?php echo $c_no ?></td>
              <td  class="col-md-3 fw-bold">Date of Birth</td>
              <td class="col-md-3"><?php  
                $dtf1 = date_create($b_date); 
                echo $b_date?date_format($dtf1,"F d, Y"):"No Data";  
              ?></td>
              </tr>
        </tbody>
           </table> 
        
          <table class="table mt-4 table-striped table-responsive table-lg  table-hover display">
            <thead class="table-light text-center" colspan="3">
            <tr>
            <th scope="col">Patient Medical History </th>
        </tr>
            </thead>
            <tbody>
            <tr class="row col-xs-3 col-md-12 col-centered">
              <td  class="col-md-3 fw-bold">Height</td>
              <td class="col-md-3"><?php echo $height ?></td>
              <td  class="col-md-3 fw-bold">Diagnosed Condition</td>
              <td class="col-md-3"><?php echo $diagnosed_condition ?></td>
           </tr>
            <tr class="row col-xs-3 col-md-12 col-centered">
              <td  class="col-md-3 fw-bold">Weight</td>
              <td  class="col-md-3"><?php echo $weight ?> kg</td>
              <td  class="col-md-3 fw-bold">Allergies</td>
              <td  class="col-md-3"><?php echo $allergies ?></td>
            </tr >
            <tr  class="row col-xs-3 col-md-12 col-centered">
              <td  class="col-md-3 fw-bold">Blood Type</td>
              <td class="col-md-3"><?php echo $blood_type ?></td> 
              <tr>
            </tbody>
           </table> 
         
          <table class="table mt-4 table-striped table-responsive table-lg  table-hover display">
            <thead class="table-light text-center" colspan="3">
              <tr>
                  <th scope="col"><?php echo $admin_b?"Appointment Records":"Upcoming Appointment" ?></th>
              </tr>
            </thead>
            <tbody>
              <?php if (count($appointments_list) > 0) {
                // if (FALSE) {
                if ($admin_b) {
                  foreach ($appointments_list as $key => $value) { 
              ?> 
                    <tr  class="row col-xs-3 col-md-12 col-centered">
                      <td class="col-md-6 fw-bold">
                        Appointment Date
                      </td>
                      <td class="col-md-6">
                        
                        <?php
                          $dtf2 = date_create($value['date']); 
                          echo date_format($dtf2,"F d, Y");  
                        ?>  
                      </td>
                      <td class="col-md-6 fw-bold">
                        Appointment Date
                      </td>
                      <td  class="col-md-6">
                        <?php
                          echo date_format($dtf2,"h:i A");  
                        ?>  
                      </td>
                      <td class="col-md-6 fw-bold">
                        Trimester
                      </td>
                      <td  class="col-md-6">
                        <?php
                          echo $value['trimester'];  
                        ?>  
                      </td>
                    </tr>   
              <?php 
                  } //foreach
                } else if (date($appointments_list[0]['date']) > $yester_date) { 
              ?> 
                  <tr  class="row col-xs-3 col-md-12 col-centered">
                    <td class="col-md-6 fw-bold">
                      Appointment Date
                    </td>
                    <td class="col-md-6">
                      
                      <?php
                        $dtf2 = date_create($appointments_list[0]['date']); 
                        echo date_format($dtf2,"F d, Y");  
                      ?>  
                    </td>
                    <td class="col-md-6 fw-bold">
                      Appointment Time
                    </td>
                    <td  class="col-md-6">
                      <?php
                        echo date_format($dtf2,"h:i A");  
                      ?>  
                    </td>
                    <td class="col-md-6 fw-bold">
                      Trimester
                    </td>
                    <td  class="col-md-6">
                      <?php
                        echo $appointments_list[0]['trimester'];  
                      ?>  
                    </td>
                  </tr>  
              <?php  
                } else { ?>
                  No Appointment
                <?php }
              } else { ?> 
                  No Appointments
              <?php } ?>
                </tr>
            </tbody>
          </table> 
          <table class="table mt-4 table-striped table-responsive table-lg  table-hover display">
            <thead class="table-light text-center" colspan="3">
              <tr>
                  <th scope="col">Consultation Records</th>
              </tr>
            </thead>
            <tbody>
              <?php if (count($consultations_list) > 0) { 
                  foreach ($consultations_list as $key => $value) { 
              ?> 
                    <tr  class="row col-xs-3 col-md-12 col-centered">
                      <td class="col-md-6 fw-bold">
                        Consultation Date
                      </td>
                      <td class="col-md-6">
                        
                        <?php
                          $dtf2 = date_create($value['date']); 
                          echo date_format($dtf2,"F d, Y");  
                        ?>  
                      </td>
                      <td class="col-md-6 fw-bold">
                        Consultation Time
                      </td>
                      <td  class="col-md-6">
                        <?php
                          echo date_format($dtf2,"h:i A");  
                        ?>  
                      </td>
                      <td class="col-md-6 fw-bold">
                        Trimester
                      </td>
                      <td  class="col-md-6">
                        <?php
                          echo $value['trimester'];  
                        ?>  
                      </td> 
                      <?php //if ($value['treatment']!='') {?>
                        <!-- <td class="col-md-6 fw-bold">
                          Treatment
                        </td>
                        <td  class="col-md-6">
                          <?php
                            //echo $value['treatment'];  
                          ?>  
                        </td> -->
                         
                        <?php //if ($value['treatment_file']!='') {?> 
                          <!-- <td class="col-md-6 fw-bold">
                            Treatment File
                          </td>
                          <td  class="col-md-6">
                            <a target="_blank" style="color:#000;"
                              href="../consultations/view-treatment-file.php?id=<?php //echo $value['treatment_file']?>">
                              View Photo</a>  
                          </td> -->

                        <?php //} ?>
                       
                      <?php //}?>
                      <?php if ($value['prescription']!='') {?>
                        <td class="col-md-6 fw-bold">
                          Prescription
                        </td>
                        <td  class="col-md-6">
                          <?php
                            echo $value['prescription'];  
                          ?>  
                        </td> 
                      <?php }?>
                      <?php if (!$current_user_is_an_admin) { ?>
                        <td class="col-md-12 fw-bold">
                          <a href="../consultations/edit-consultation-record.php?id=<?php echo $value['id']?>">Update Consultation</a>
                        </td>
                      <?php } ?>
                    </tr>   
              <?php 
                  } //foreach
                 
              } else { ?> 
                  No Consultations
              <?php } ?>
                </tr>
            </tbody>
          </table>  
      <?php
          }
      ?>  
  
    </div>
  </div>
 
</div>   <!-- wrapper --> 
 
<?php 
include_once('../php-templates/admin-navigation-tail.php');
?>