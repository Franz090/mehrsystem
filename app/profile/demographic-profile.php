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
  CONCAT(height_ft, '\'', height_in, '\"') as height, weight, blood_type, diagnosed_condition, allergies,family_history, profile_picture
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
     $c_family_history = $row['family_history']==null?'':$row['family_history'];
    $diagnosed_condition = $row['diagnosed_condition'];   
    $allergies = $row['allergies'];    
    $profile_picture = $row['profile_picture']==null?'default.png':$row['profile_picture']; 
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
        
         
          <!-- <button type="button" style="width: 20%;padding:2px;font-size:14px;color: white;" class="btn btn-primary text-right"> 
            <a href="./update-account.php" class="text-light" style=""> 
              Update Account Information
            </a>
          </button> -->
  <div class=" row m-2 my-4">
          <div class="row ">
  <div class="col-sm-6">
    <div class="card px-3">
      <div class="card-body">
            <div class="container-fluid d-flex justify-content-center ">
            <img  style="border: 1px solid #e5e5e5;width:50%;height:40%;" class="rounded-circle mb-2" src="../img/profile/<?php echo $profile_picture; ?>" 
              alt="<?php echo $name; ?>" width="500" height="600">
        </div>
        <h5 class="card-title  fw-bold text-center  mb-4 mt-2">Patient Profile</h5>
        <div class="row mb-2">
          <div class="col-md-6">
        <p class="card-text mr-3"> <strong>Patient Name</strong></p>
         <p class="card-text"> <?php echo $name ?></p>
        </div>
        <div class="col-md-6">
           <p class="card-text"> <strong> Patient ID</strong> </p>
         <p class="card-text">  <?php echo $id ?></p>
        </div>
        </div>
        <div class="row mb-2">
          <div class="col">
           <p class="card-text"><strong> Barangay</strong> </p>
         <p class="card-text"> <?php echo $bgy ?></p>
        </div>
        <div class="col">
           <p class="card-text"><strong> Tetanus Toxoid</strong></p>
         <p class="card-text"> <?php echo $s ?></p>
        </div>
      </div>
      <div class="row mb-2">
        <div class="col">
          <p class="card-text"><strong>  Contact Number</strong> </p>
         <p class="card-text">   <?php echo $c_no ?></p>
        </div>
        <div class="col">
          <p class="card-text"><strong>  Date of Birth</strong> </p>
         <p class="card-text">  <?php  
                  $dtf1 = date_create($b_date); 
                  echo $b_date?date_format($dtf1,"F d, Y"):"No Data";  
                ?></p>
          </div>
       </div>  
      </div>
    </div>
  </div>


  <!-- patient medical history -->

  <div class="col-sm-6 ">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title fw-bold text-center  mb-4 mt-2">Patient Medical History </h5>
        <!-- paragraphp text -->
        <div class="row mb-2">
          <div class="col">
         <p class="card-text"><strong> Height</strong> </p>
          <p class="card-text"><?php echo $height ?></p>
        </div>

         <div class="col">
          <p class="card-text"><strong>    Weight</strong> </p>
          <p class="card-text"> <?php echo $weight ?> kg</p>
        </div>
      </div>
      <div class="row  mb-2">
        <div class="col">
           <p class="card-text"><strong>Diagnosed Condition</strong> </p>
          <p class="card-text"> <?php echo $diagnosed_condition ?></p>
        </div>
        <div class="col">
           <p class="card-text"><strong>  Allergies</strong> </p>
          <p class="card-text">  <?php echo $allergies ?></p>
        </div>
      </div>
      <div class="row  mb-2">
      <div class="col">
           <p class="card-text"><strong> Blood Type</strong> </p>
          <p class="card-text"> <?php echo $blood_type ?></p>
        </div>
        <div class="col">
           <p class="card-text"><strong>  Family History</strong> </p>
          <p class="card-text"> <?php echo $c_family_history ?></p>
           </div>
      </div>
      </div>
    </div>
  </div>
</div>
        

      
           
             


  
         



          
            </div> 
          </div>     
        </div>
      <?php
            }
      ?>   
    </div>
          </div>
  </div>
</div>   <!-- wrapper --> 
 
<?php 
include_once('../php-templates/admin-navigation-tail.php');
?>