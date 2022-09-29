<?php

@include '../includes/config.php';

session_start();

@include '../php-templates/redirect/admin-page-setter.php';

// $session_id = $_SESSION['id'];
$id_from_get = $_GET['id'];
// if ($session_id==$id_from_get) {
$redirect_condition = "not-for-patient";
// } else {
//   $redirect_condition = "midwife-only";
// }

@include "../php-templates/redirect/$redirect_condition.php";

$yester_date = date("Y-m-d H:i:s", strtotime('-1 day'));
// fetch patient
$select = "SELECT  u.user_id,
  CONCAT(d.first_name,IF(d.middle_name='' OR middle_name IS NULL, '', CONCAT(' ',SUBSTRING(d.middle_name,1,1),'.')),' ',d.last_name) AS name,
  u.email,  
  IF(m.tetanus=0, 'Unvaccinated', 'Vaccinated') AS tetanus, m.b_date,  health_center,
  CONCAT(height_ft, '\'', height_in, '\"') as height, weight, blood_type, diagnosed_condition, allergies 
  FROM users as u, user_details as d, barangays as b, patient_details as m
  WHERE u.user_id=$id_from_get AND d.user_id=u.user_id AND m.barangay_id=b.barangay_id AND m.user_id=u.user_id";
// echo $select; 
if($result = mysqli_query($conn, $select))  {
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
$admin_b = $admin==1;
$order = $admin_b?'DESC':'ASC';
$date = $admin_b?'':"AND $yester_date<a.date";
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
$select2_b = "SELECT c.date, t.name treatment, t.description t_desc, treatment_file, 
  CONCAT(d.first_name,IF(d.middle_name='' OR middle_name IS NULL, '', CONCAT(' ',SUBSTRING(d.middle_name,1,1),'.')),' ',d.last_name) AS midwife,
  p.name prescription, p.description p_desc, trimester
  FROM (SELECT * FROM consultations WHERE $id=patient_id ORDER BY date DESC) c
  LEFT JOIN (SELECT * FROM treat_med WHERE type=1) t
    ON c.treatment_id=t.treat_med_id
  LEFT JOIN (SELECT * FROM treat_med WHERE type=0) p
    ON c.prescription_id=p.treat_med_id
  LEFT JOIN users u
    ON u.user_id=c.midwife_appointed
  LEFT JOIN user_details d
    USING(user_id);";

// echo $select2_b;  
if($result2_b = mysqli_query($conn, $select2_b))  {
  foreach($result2_b as $row)  {
    $date = $row['date'];  
    $trimester = $row['trimester'];  
    $treatment = $row['treatment'];  
    $t_desc = $row['t_desc'];  
    $treatment_file = $row['treatment_file'];  
    $midwife = $row['midwife'];  
    $prescription = $row['prescription'];  
    $p_desc = $row['p_desc'];  
    $trimester = $row['trimester'];  
    array_push($consultations_list, array(
      'date' => $date,
      'treatment' => $treatment,
      't_desc' => $t_desc,
      'midwife' => $midwife,
      'treatment_file' => $treatment_file,
      'prescription' => $prescription,
      'p_desc' => $p_desc,
      'date' => $date,
      'trimester' => $trimester==1?'1st Trimester':($trimester==2?'2nd Trimester':($trimester==3?'3rd Trimester':'N/A'))
    ));
  } 
  mysqli_free_result($result2_b);
} 
else  { 
  $error = 'Something went wrong fetching data from the database.'; 
}  


// fetch patient treatment records

// $select2_t = "SELECT tmr.date t_date, name t_type, description t_description
//   FROM treat_med_record tmr,  treat_med tm
//   WHERE $id_from_get=tmr.patient_id AND tmr.treat_med_id=tm.id AND category=1
//   ORDER BY t_date DESC LIMIT 1";

// // echo $select2; 
// if($result2_t = mysqli_query($conn, $select2_t))  {
//   foreach($result2_t as $row)  {
//     $t_type = $row['t_type'];   
//     $t_description = $row['t_description'];   
//     $t_date = $row['t_date'];    
//   } 
//   mysqli_free_result($result2_t);
// } 
// else  { 
//   mysqli_free_result($result2_t);
//   $error = 'Something went wrong fetching data from the database.'; 
// }  

// fetch patient prescription records

// $select2_m = "SELECT tmr.date m_date, name m_name, description m_description
//   FROM treat_med_record tmr, treat_med tm
//   WHERE $id_from_get=tmr.patient_id AND tmr.treat_med_id=tm.id AND category=0
//   ORDER BY m_date DESC LIMIT 1";

// // echo $select2; 
// if($result2_m = mysqli_query($conn, $select2_m))  {
//   foreach($result2_m as $row)  {  
//     $m_name = $row['m_name'];   
//     $m_description = $row['m_description'];   
//     $m_date = $row['m_date'];    
//   } 
//   mysqli_free_result($result2_m);
// } 
// else  { 
//   mysqli_free_result($result2_m);
//   $error = 'Something went wrong fetching data from the database.'; 
// }  

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
<div class="d-flex" id="wrapper">

  <!-- Sidebar -->
  <?php include_once('../php-templates/admin-navigation-left.php');  ?>

  <!-- Page Content -->
  <div id="page-content-wrapper">
    <?php include_once('../php-templates/admin-navigation-right.php'); ?>

    <div class="container-fluid">
      <?php
        if(isset($error)) 
            echo '<span class="">'.$error.'</span>'; 
        else {
      ?>   
        <div class="row bg-light m-3"><h3>View Patient Report</h3>

        <div class="default table-responsive">
          <div class="col-md-8 col-lg-12 ">
        <table class="table mt-4 table-striped table-responsive table-lg table-bordered table-hover display">
            <thead class="table-dark text-center" colspan="3">
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
                echo date_format($dtf1,"F d, Y");  
              ?></td>
              </tr>
        </tbody>
           </table> 
        
          <table class="table mt-4 table-striped table-responsive table-lg table-bordered table-hover display">
            <thead class="table-dark text-center" colspan="3">
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
              <td  class="col-md-3"><?php echo $weight ?></td>
              <td  class="col-md-3 fw-bold">Allergies</td>
              <td  class="col-md-3"><?php echo $allergies ?></td>
            </tr >
            <tr  class="row col-xs-3 col-md-12 col-centered">
              <td  class="col-md-3 fw-bold">Blood Type</td>
              <td class="col-md-3"><?php echo $blood_type ?></td> 
              <tr>
            </tbody>
           </table> 
         
          <table class="table mt-4 table-striped table-responsive table-lg table-bordered table-hover display">
            <thead class="table-dark text-center" colspan="3">
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
          <table class="table mt-4 table-striped table-responsive table-lg table-bordered table-hover display">
            <thead class="table-dark text-center" colspan="3">
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
                      <!-- details  -->
                      <?php if ($value['treatment']!='') {?>
                      <?php }?>
                      <?php if ($value['treatment']!='') {?>
                        <td class="col-md-3 fw-bold">
                          Treatment
                        </td>
                        <td  class="col-md-3">
                          <?php
                            echo $value['treatment'];  
                          ?>  
                        </td>
                        <td class="col-md-3 fw-bold">
                          Description
                        </td>
                        <td  class="col-md-3">
                          <?php
                            echo $value['t_desc'];  
                          ?>  
                        </td>
                        <?php if ($value['treatment_file']!='') {?> 
                          <td class="col-md-6 fw-bold">
                            Treatment File
                          </td>
                          <td  class="col-md-6">
                            <?php
                              echo $value['treatment_file'];  
                            ?>  
                          </td>
                        <?php }?>
                      <?php }?>
                      <?php if ($value['prescription']!='') {?>
                        <td class="col-md-3 fw-bold">
                          Prescription
                        </td>
                        <td  class="col-md-3">
                          <?php
                            echo $value['prescription'];  
                          ?>  
                        </td>
                        <td class="col-md-3 fw-bold">
                          Description
                        </td>
                        <td  class="col-md-3">
                          <?php
                            echo $value['p_desc'];  
                          ?>  
                        </td>
                      <?php }?>
                     
                    </tr>   
              <?php 
                  } //foreach
                 
              } else { ?> 
                  No Consultations
              <?php } ?>
                </tr>
            </tbody>
          </table> 


          <!-- <table class="table mt-4 table-striped table-responsive table-lg table-bordered table-hover display">
            <thead class="table-dark text-center" colspan="3">
            <tr>
            <th scope="col">Treatment Record</th>
        </tr>
            </thead>
            <tbody>
            <?php //if (isset($t_date)) {?>
              <tr  class="row col-xs-3 col-md-12 col-centered">
                <td  class="col-md-6 fw-bold">
                  Treatment Type
                </td>
                <td  class="col-md-6">
                  <?php //echo $t_type; ?>  
                </td>
              </tr> 
              <tr class="row col-xs-3 col-md-12 col-centered">
                <td class="col-md-6 fw-bold">
                  Treatment Date
               </td>
                <td  class="col-md-6">
                  <?php
                    //$dtf3 = date_create($t_date); 
                    //echo date_format($dtf3,"F d, Y");  
                  ?>  
                </td>
              </td> 
              <tr  class="row col-xs-3 col-md-12 col-centered">
                <td class="col-md-6 fw-bold">
                  Treatment Time
                </td>
                <td  class="col-md-6">
                  <?php
                    //echo date_format($dtf3,"h:i A");  
                  ?>  
                </td>
              </tr>  
            <?php //} else { ?> 
                No Treatment Record
            <?php //} ?>
          </tbody>
          </table> 

           <table class="table mt-4 table-striped table-responsive table-lg table-bordered table-hover display">
            <thead class="table-dark text-center" colspan="3">
            <tr>
            <th scope="col">Prescription Record</th>
        </tr>
            </thead>
            <tbody>
            <?php //if (isset($m_date)) {?>
              <tr  class="row col-xs-3 col-md-12 col-centered">
                <td  class="col-md-6 fw-bold">
                  Prescription Type
                </td>
                <td  class="col-md-6">
                  <?php
                    //echo $m_name;  
                  ?>  
                </td>
              </tr> 
              <tr  class="row col-xs-3 col-md-12 col-centered">
                <td  class="col-md-6 fw-bold">
                  Prescription Date
                </td>
                <td  class="col-md-6">
                  <?php
                    //$dtf4 = date_create($m_date); 
                    //echo date_format($dtf4,"F d, Y");  
                  ?>  
                </td>
              </tr> 
              <tr  class="row col-xs-3 col-md-12 col-centered">
                <td  class="col-md-6 fw-bold">
                  Prescription Time
                </td>
                <td  class="col-md-6">
                  <?php
                    //echo date_format($dtf4,"h:i A");  
                  ?>  
                </td>
              </tr>  
              <?php //} else { ?> 
                No Prescription Record
            <?php //} ?>
            </tbody>
          </table> 
          </div> 
        </div>     
        </div> -->
      <?php
          }
      ?>  
  
    </div>
  </div>
 
</div>   <!-- wrapper --> 
 
<?php 
include_once('../php-templates/admin-navigation-tail.php');
?>