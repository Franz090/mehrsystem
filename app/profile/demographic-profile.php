<?php

@include '../includes/config.php';

session_start();

@include '../php-templates/redirect/admin-page-setter.php';
@include '../php-templates/redirect/patient-only.php';
 
$session_id = $_SESSION['id'];

// fetch patient
$select = "SELECT u.user_id AS id, 
  CONCAT(first_name, 
                IF(middle_name IS NULL OR middle_name='', '', CONCAT(' ', SUBSTRING(middle_name, 1, 1), '.')), 
                ' ', last_name) name, 
  u.email,  
  IF(m.tetanus=0, 'Unvaccinated', 'Vaccinated') AS tetanus, m.b_date,  health_center,
  CONCAT(height_ft, '\'', height_in, '\"') as height, weight, blood_type, diagnosed_condition, allergies
  FROM users as u, user_details as d, barangays as b, patient_details as m
  WHERE u.user_id=$session_id AND d.user_id=u.user_id AND m.barangay_id=b.barangay_id AND m.user_id=u.user_id";
// echo $select;
if ($result = mysqli_query($conn, $select)){
  if(mysqli_num_rows($result) == 0)  {
    header('location: ../');
  }
  foreach($result as $row)  {
    $id = $row['id'];  
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
  mysqli_free_result($result);
  $error = 'Something went wrong fetching data from the database.'; 
}   

$conn->close(); 

$page = 'demo_profile';

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

    <div class="container-fluid default">
      <?php
        if(isset($error)) 
            echo '<span class="">'.$error.'</span>'; 
        else {
      ?>   
        <div class="background-head row m-2 my-4"><h4 class="pb-3 m-3 fw-bolder ">Demographic Profile</h4>
          <button type="button"> 
            <a href="./update-account.php"> 
              Update Account Information
            </a>
          </button>
        
          <div class="table-padding table-responsive">
            <div class="col-md-8 col-lg-12 " id="table-position">
          <table class="text-center  table mt-5 table-striped table-responsive table-lg  table-hover display" id="datatables">
            <thead class="table-light" colspan="3">
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
        
          <table class="text-center  table mt-5 table-striped table-responsive table-lg table-hover display" id="datatables">
            <thead class="table-light" colspan="3">
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
          
            </div> 
          </div>     
        </div>
      <?php
            }
      ?>   
    </div>
 
  </div>
</div>   <!-- wrapper --> 
 
<?php 
include_once('../php-templates/admin-navigation-tail.php');
?>