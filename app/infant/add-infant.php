<?php
$page= "add_infant";
@include '../includes/config.php';

session_start();

@include '../php-templates/redirect/admin-page-setter.php';  
@include '../php-templates/redirect/midwife-only.php';


$session_id = $_SESSION['id'];
@include '../php-templates/midwife/get-assigned-barangays.php';


$patient_list = [];  
if (count($_barangay_list)>0) { 
  // fetch patients  
  $barangay_select = '';
  $barangay_list_length_minus_1 = count($_barangay_list)-1;
  foreach ($_barangay_list as $key => $value) { 
      $barangay_select .= "p.barangay_id=$value ";
      if ($key < $barangay_list_length_minus_1) {
          $barangay_select .= "OR ";
      }
  }
  $select1 = "SELECT u.user_id, trimester,
      CONCAT(ud.first_name, 
  IF(ud.middle_name IS NULL OR ud.middle_name='', '', 
      CONCAT(' ', SUBSTRING(ud.middle_name, 1, 1), '.')), 
  ' ', ud.last_name) name
      FROM users u, patient_details p, user_details ud
      WHERE role=-1 AND ($barangay_select) AND p.user_id=u.user_id AND ud.user_id=u.user_id";
  
  if ($result_patient = mysqli_query($conn, $select1)) {
      foreach($result_patient as $row) {
          $id = $row['user_id'];  
          $name = $row['name'];  
          $trimester = $row['trimester'];  
          array_push($patient_list, array('id' => $id,'name' => $name,'trimester'=>$trimester));
      } 
      mysqli_free_result($result_patient);
      // print_r($result_barangay); 
  } 
  else  { 
      mysqli_free_result($result_patient);
      $error = 'Something went wrong fetching data from the database.'; 
  }    
} 

// register infant
if(isset($_POST['submit'])) {
  $_POST['submit'] = null;
  $error = '';  
  if (
    empty(trim($_POST['first_name'])) ||
    empty(trim($_POST['last_name'])) || 
    empty($_POST['b_date']) ||
    empty(trim($_POST['blood_type']))  
  )
    $error .= 'Fill up input fields that are required (with * mark)! ';
  else {
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']); 
    $middle_name = empty(trim($_POST['middle_name']))?"NULL":"'".mysqli_real_escape_string($conn, $_POST['middle_name'])."'";
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']); 
    $nickname = empty(trim($_POST['nickname']))?"NULL":"'".mysqli_real_escape_string($conn, $_POST['nickname'])."'";
    $sex = mysqli_real_escape_string($conn, $_POST['sex']); 
    $b_date = mysqli_real_escape_string($conn, $_POST['b_date']); 
    $blood_type = mysqli_real_escape_string($conn, $_POST['blood_type']); 
    $legitimacy = mysqli_real_escape_string($conn, $_POST['legitimacy']); 
    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']); 
   
    $insert = "INSERT INTO infants(first_name, middle_name, last_name, nickname, sex, b_date, blood_type, legitimacy, user_id) 
      VALUES('$first_name', $middle_name, '$last_name', $nickname, '$sex', '$b_date', '$blood_type', $legitimacy, $user_id)";
    // echo $insert;
    
    if (mysqli_query($conn, $insert))  {
      echo "<script>alert('Infant Added!');window.location.href='./add-infant.php';</script>";
    }
    else { 
        $error .= 'Something went wrong inserting into the database.';
    } 
  } 
} 

$conn->close(); 

include_once('../php-templates/admin-navigation-head.php');
?>
 

<div class="container_nu"> 
  <!-- Sidebar -->
  <?php include_once('../php-templates/admin-navigation-left.php'); ?> 
  <!-- Page Content -->
  <div class="main_nu">
    <?php include_once('../php-templates/admin-navigation-right.php'); ?>

    <div class="container-fluid default">
      <div class="background-head row m-2 my-4">

        <h4 class="pb-3 m-3 fw-bolder ">Add Infant</h4>
        <br>
            <form class="form form-box px-3" action="" method="post">
              
              <?php
                if(isset($error)) 
                  echo '<span class="form__input-error-message">'.$error.'</span>'; 
                else if (count($patient_list)==0) {
                  echo '<span class="form__input-error-message">There should be at least one patient (under your assigned barangay) available in the database.</span>'; 
                } else { 
              ?> 
              <div class="row">
                <div class="col-sm-4">
                  <label >First Name</label>
                  <div class="mb-3">
                    <input type="text" class="form-control" name="first_name" autofocus placeholder="First Name*" required>
                  </div>
                </div>
                <div class="col-sm-4">
                  <label>Middle Name</label>
                  <div class="mb-3">
                    <input type="text" class="form-control"   name="middle_name" placeholder="Middle Name*">
                  </div>
                </div>
                <div class="col-sm-4">
                  <label>Last Name</label>
                  <div class="mb-3">
                    <input type="text" class="form-control" name="last_name" placeholder="Last Name*" required>
                  </div>
                </div> 
                </div>
                 <div class="row">
                  <div class="col-sm-4">
                  <label>Nick Name</label>
                  <div class="mb-3">
                    <input type="text" class="form-control"  name="nickname" placeholder="Nickname"> 
                  </div>
                </div>  
                <div class="col-sm-4">
                 <label>Gender</label>
                  <div class=" mb-3"> 
                    <select class="form-select pt-2 pb-2" name="sex">
                      <option value="Male" disabled>Gender</option>
                      <option value="Male" selected>Male</option>
                      <option value="Female">Female</option> 
                      <option value="Other">Other</option> 
                    </select>
                  </div>
               </div>
               <div class="col-sm-4">
               <label>Birth Date</label> 
                  <div class="mb-3">
                    <div class="input-group date" id="datepicker">
                      <input class="form-control option pt-2 pb-2" type="date" name="b_date" required />
                    </div>
                  </div>
                </div>
                </div>
                <div class="row">
                  <div class="col-sm-4">
               <label >Blood Type</label>
                  <div class="mb-3">
                    <input type="text"  class="form-control"  name="blood_type" placeholder="Blood Type*" required>
                  </div>
                </div>
                <div class="col-sm-4">
                <label >Legitimacy</label>
                  <div class="mb-3"> 
                    <select class="form-select pt-2 pb-2" name="legitimacy" required>
                      <option value="" selected disabled>Select Legitimacy</option>
                      <option value="1">Legitimate</option>
                      <option value="0">Illegitimate</option> 
                    </select>
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="mb-2">
                    <label>Parent</label>
                    <!-- <select class="form-select pt-2 pb-2" name="user_id">
                      <option selected disabled>Select Parent Name</option>
                      <?php 
                        //foreach ($patient_list as $key => $value) { 
                      ?> 
                        <option value="<?php //echo $value['id'];?>" 
                          <?php //echo $key===0?'selected':'';?>>
                            <?php //echo $value['name'];?>
                        </option>
                      <?php  
                        //}   
                      ?>  
                    </select> -->
                    <!-- searchable select  -->
                    <div class="wrapper_ss">
                      <div class="select-btn_ss">
                        <span>Select A Patient</span>
                        <i class="uil uil-angle-down"></i>
                      </div>
                      <input type="text" style="display:none;" name="user_id" class="patient_id_trimester"/>
                      <div class="content_ss2">
                        <div class="search_ss2">
                          <ion-icon  name="search-outline"></ion-icon>
                          <input spellcheck="false" type="text" placeholder="Search" class="ss">
                        </div>
                        <ul class="options_ss"></ul>
                      </div>
                    </div> 
                  </div>
                </div>
              </div>
              <div class="col-md-12 text-center pt-4">
                  <button style="" class="w-40 btn btn-primary  text-capitalize" type="submit" name="submit">Register Infant</button> 
              </div>
              <?php } ?>  
            </form>  
          

      </div>
    </div>

  </div>
</div>
 
<?php 
include_once('../php-templates/admin-navigation-tail.php');
?>