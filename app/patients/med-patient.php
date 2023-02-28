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
  CONCAT(d.first_name,IF(d.middle_name='' OR d.middle_name IS NULL, '', CONCAT(' ',SUBSTRING(d.middle_name,1,1),'.')),' ',d.last_name) AS name,
  u.email,  
  IF(m.tetanus=0, 'Unvaccinated', 'Vaccinated') AS tetanus, m.b_date,  health_center,
  CONCAT(height_ft, '\'', height_in, '\"') as height, weight, blood_type, diagnosed_condition, allergies, family_history,profile_picture 
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
    $user_id = $row['user_id'];  
    $name = $row['name'];  
    $e = $row['email'];  
    $s = $row['tetanus']; 
    $select_c_no = "SELECT mobile_number FROM contacts WHERE owner_id=$user_id AND type=1";
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
    $c_family_history = $row['family_history']==null?'':$row['family_history']; 
    $allergies = $row['allergies'];  
    $profile_picture = $row['profile_picture']==null?'default.png':$row['profile_picture'];   
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
  WHERE $user_id=a.patient_id AND a.status=1 $date
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
$select2_b = "SELECT c.date, prescription, consultation_id id, gestation, blood_pressure, weight, height_ft, 
  height_in, nutritional_status, status_analysis, advice, change_plan, date_return,
  CONCAT(d.first_name,IF(d.middle_name='' OR d.middle_name IS NULL, '', CONCAT(' ',SUBSTRING(d.middle_name,1,1),'.')),' ',d.last_name) AS midwife,
   trimester
  FROM (SELECT * FROM consultations WHERE $user_id=patient_id ORDER BY date DESC) c 
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
    $gestation = $row['gestation'];
    $blood_pressure = $row['blood_pressure'];
    $weight = $row['weight'];
    $height_ft = $row['height_ft'];
    $height_in = $row['height_in'];
    $nutritional_status = $row['nutritional_status'];
    $status_analysis = $row['status_analysis'];
    $advice = $row['advice'];
    $change_plan = $row['change_plan'];
    $date_return = $row['date_return'];
    array_push($consultations_list, array(
      'id' => $id,
      'date' => $date,
      // 'treatment' => $treatment,
      'midwife' => $midwife,
      // 'treatment_file' => $treatment_file,
      'prescription' => $prescription,
      'trimester' => $trimester==1?'1st Trimester':($trimester==2?'2nd Trimester':($trimester==3?'3rd Trimester':'N/A')),
      'gestation' => $gestation,
      'blood_pressure' => $blood_pressure,
      'weight' => $weight,
      'height_ft' => $height_ft,
      'height_in' => $height_in,
      'nutritional_status' => $nutritional_status,
      'status_analysis' => $status_analysis,
      'advice' => $advice,
      'change_plan' => $change_plan,
      'date_return' => $date_return,
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
      <div class=" row m-2 my-4">
       
              
        
           <div class="row">
            <!-- Patient Profile -->
    <div class="row row-cols-1 row-cols-md-3 g-4">
  <div class="col-md-6">
    <div class="card px-5">
     
        <div class="container-fluid d-flex justify-content-center mb-1">
              <img style="border: 1px solid #e5e5e5;width:50%;height:40%;" class="rounded-circle" src="../img/profile/<?php echo $profile_picture; ?>" 
                alt="<?php echo $name; ?>" width="500" height="600">
        </div>
      <div class="card-body">
        <h5 class="card-title fw-bold text-center  mb-4 mt-2">Patient Profile </h5> 
         <div class="row">
          <div class="col">
        <p  class="card-text mr-3"><strong> Patient Name</strong></p>
        <p class=""><?php echo $name ?></p>
        </div>
        <div class="col">
        <p   class="card-text mr-3"><strong>  Patient ID</strong></p>
        <p> <?php echo $user_id ?></p>
        </div>
      </div>
       <div class="row">
         <div class="col">
         <p   class="card-text mr-3"><strong>Barangay</strong></p>
        <p> <?php echo $bgy ?></p>
        </div>
         <div class="col">
         <p   class="card-text mr-3"><strong> Tetanus Toxoid</strong></p>
        <p>  <?php echo $s ?></p>
        </div>
        </div>
        <div class="row">
            <div class="col">
         <p   class="card-text mr-3"><strong>Contact Number</strong></p>
        <p>  <?php echo $c_no ?></p>
        </div>
        <div class="col">
          <p   class="card-text mr-3"><strong> Date of Birth</strong></p>
        <p>  <?php  
                      $dtf1 = date_create($b_date); 
                      echo $b_date?date_format($dtf1,"F d, Y"):"No Data";  
                    ?></p>
        
                    </div>
            </div>
            <?php if (!$current_user_is_an_admin) {?>
            <div class="col mb-3" style="border-bottom: 1px solid #c8c9ca;">
            </div>
            <h5 class="card-title fw-bold text-center ">Patient Medical History </h5> 
             <div class="row">
          <div class="col">
        <p class="card-text  mr-3"><strong>Height</strong></p>
          <p><?php echo $height ?></p> 
         </div> 
         <div class="col">
           <p class="card-text  mr-3"><strong>Weight</strong></p>
          <p><?php echo $weight ?> kg</p>
        </div>
      </div>
      <div class="row">
        <div class="col">
         <p class="card-text  mr-3"><strong> Family History</strong></p>
          <p><?php echo $c_family_history ?> </p> 
        </div>
        <div class="col">
          <p class="card-text  mr-3"><strong> Diagnosed Condition</strong></p>
          <p><?php echo $diagnosed_condition ?></p>
          </div>
        </div>
        <div class="row">
          <div class="col">
          <p class="card-text  mr-3"><strong>  Allergies</strong></p>
          <p><?php echo $allergies ?></p>
        </div>
        <div class="col">
          <p class="card-text  mr-3"><strong>  Blood Type</strong></p>
          <p><?php echo $blood_type ?> </p>
      </div>
    </div>
     <?php if ($current_user_is_a_patient) {?>
                  
            <div class="col-md-12 text-center">
            <a href='../profile/update-account.php' class="btn btn-outline-default mb-5 ">Update Profile</a>
          </div>
          <?php }?>
      <div class="col mb-3" style="border-bottom: 1px solid #c8c9ca;">
            </div>
            <?php }?>
    <h5 class="card-title fw-bold text-center"> <?php if (!$current_user_is_an_admin) {?>
              
                    <?php echo $admin_b?"Appointment Records":"Upcoming Appointment" ?>
                 </h5>
                  <?php if (count($appointments_list) > 0) {
                    // if (FALSE) {
                    if ($admin_b) {
                      foreach ($appointments_list as $key => $value) { 
                  ?> 
    <p class="card-text  mr-3"><strong> Appointment Date</strong></p>
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
    </div>
  </div>
  <!-- Patient Medical History Admin Only -->
  <?php if ($current_user_is_an_admin) {?>
  <div class="col-md-6">
    <div class="card h-100">
      <div class="card-body px-5">
        <h5 class="card-title fw-bold px-5 text-center mt-4 mb-5">Patient Medical History</h5>
        <div class="row ">
          <div class="col">
        <p class="card-text  mr-3"><strong>Height</strong></p>
          <p><?php echo $height ?></p> 
         </div> 
         <div class="col">
           <p class="card-text  mr-3"><strong>Weight</strong></p>
          <p><?php echo $weight ?> kg</p>
        </div>
      </div>
      <div class="row">
        <div class="col">
         <p class="card-text  mr-3"><strong> Family History</strong></p>
          <p><?php echo $c_family_history ?> </p> 
        </div>
        <div class="col">
          <p class="card-text  mr-3"><strong> Diagnosed Condition</strong></p>
          <p><?php echo $diagnosed_condition ?></p>
          </div>
        </div>
        <div class="row">
          <div class="col">
          <p class="card-text  mr-3"><strong>  Allergies</strong></p>
          <p><?php echo $allergies ?></p>
        </div>
        <div class="col">
          <p class="card-text  mr-3"><strong>  Blood Type</strong></p>
          <p><?php echo $blood_type ?> </p>
      </div>
    </div> 
    
      </div>
    </div>
  </div>
  <?php }?>
 <!-- Upcoming Appointment -->
           
                        
   <?php if (!$current_user_is_an_admin) {?>                     
  <div class="col-md-6">
    <div class="card px-5">
      <div class="card-body">
        <h5 class="card-title fw-bold text-center mb-5 mt-5">Consultation Records</h5>
         <?php if (count($consultations_list) > 0) { 
                      foreach ($consultations_list as $key => $value) { 
                  ?> 
        <div class="row">
          <div class="col">
        <p class="card-text"><strong>Consultation Date</strong></p>
         <p>  <?php
                              $dtf2 = date_create($value['date']); 
                              echo date_format($dtf2,"F d, Y");  
                            ?>  
                          </p>
                        </div>
           <div class="col">
         <p class="card-text"><strong>Consultation Time</strong></p>  
          <p> <?php echo date_format($dtf2,"h:i A"); ?>  </p>
         </div> 
        </div>
        <div class="row">
          <div class="col">
          <p class="card-text"><strong>Trimester</strong></p>  
          <p><?php echo $value['trimester']; ?>   
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
                          
                          <?php //}?></p>
                        </div>
                        <div class="col">
                <p class="card-text"><strong>Prescription</strong></p>  
                <p> <?php if ($value['prescription']!='') {?>
                              <?php
                                echo $value['prescription'];  
                              ?>  
                          
                          <?php }?>
                        </p> 
                      </div>
                      </div>
                  <div class="row">
                    <div class="col">
                <p class="card-text"><strong>Gestation</strong></p>  
                <p><?php echo $value['gestation']; ?> </p>
              </div>
              <div class="col">
                 <p class="card-text"><strong>Blood Pressure</strong></p>  
                <p> <?php echo $value['blood_pressure']; ?>  </p>
              </div>
              </div>
              <div class="row">
                <div class="col">
                 <p class="card-text"><strong>Weight</strong></p>  
                <p><?php echo $value['weight']; ?> kg   </p>
              </div>
              <div class="col">
                 <p class="card-text"><strong>Height</strong></p>  
                <p>   <?php echo $value['height_ft']."'".$value['height_in']."\""; ?></p>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <p class="card-text"><strong> Nutritional Status</strong></p>  
                <p> <?php echo $value['nutritional_status']; ?> </p>
              </div>
              <div class="col">
                <p class="card-text"><strong> Status Analysis</strong></p>  
                <p><?php echo $value['status_analysis']; ?> </p>
               </div>
            </div>
            <div class="row">
              <div class="col">
                <p class="card-text"><strong> Advice</strong></p>  
                <p> <?php echo $value['advice']; ?>   </p>
              </div>
              <div class="col">
                <p class="card-text"><strong> Change Plan</strong></p>  
                <p><?php echo $value['change_plan']; ?>   </p>
              </div>
            </div>
            <div class="row">
              <div class="col">
                 <p class="card-text"><strong> Return Date</strong></p>  
                <p><?php $dtf2 = date_create($value['date_return']); echo date_format($dtf2,"F d, Y");  ?></p>
              </div>
              <div class="col">
                <p class="card-text"><strong> Return Time</strong></p> 
                <p><?php echo date_format($dtf2,"h:i A"); ?> </p>
              </div>
            </div>
             
 <?php if ($current_user_is_a_midwife) { ?>
                            
                           <!-- tinanggal ko yung add consultation dito -->
                            <!-- <td class="col-md-12 fw-bold">
                              <a href="../consultations/edit-consultation-record.php?id=<?php echo $value['id']?>">Update Consultation</a>
                            </td> -->
                          <?php } ?>
                        </tr> 
                   
                  <?php 
                      } //foreach 
                  } else { ?> 
                      No Consultations
                  <?php } ?>
                <?php }?>
         <!-- nag add ako ng print button dito -->
           <?php if (!$current_user_is_an_admin) {?>
            <div class="col-md-12 text-center">
            <a href='print.php?user_details_id=<?php echo $user_id?>' class="btn btn-primary">Print</a>
          </div>
          <?php }?>
             
          <br>
      <?php
          }
      ?>  
      </div>
    </div>
  </div>
  
 
                  <!-- End -->
             
           
           
           
  
    </div>
  </div>
 
</div>   <!-- wrapper --> 
 
<?php 
include_once('../php-templates/admin-navigation-tail.php');
?>