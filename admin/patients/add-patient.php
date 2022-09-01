<?php

@include '../includes/config.php';

session_start();
 
@include '../php-templates/redirect/admin-page-setter.php';
@include '../php-templates/redirect/midwife-only.php';
 
 
// fetch barangays  
$select = "SELECT id, health_center FROM barangay";
$result_barangay = mysqli_query($conn, $select);
$barangay_list = [];

if(mysqli_num_rows($result_barangay))  {
  foreach($result_barangay as $row)  {
    $id = $row['id'];  
    $name = $row['health_center'];  
    array_push($barangay_list, array('id' => $id,'name' => $name));
  } 
  mysqli_free_result($result_barangay);
  // print_r($result_barangay);

} 
else  { 
  mysqli_free_result($result_barangay);
  $error = 'Something went wrong fetching data from the database.'; 
}   

// register
if(isset($_POST['submit'])) {
  // next details id 
  $select = "SELECT * from details";
  $details = mysqli_query($conn, $select);
  $rows = mysqli_num_rows($details)-1;
  mysqli_data_seek($details,$rows);
  // echo $rows;
  $row=mysqli_fetch_row($details);
  $next_details_id = $row[0] + 1;

  // next med_history id
  $select2 = "SELECT * from med_history";
  $med_history = mysqli_query($conn, $select2);
  $rows2 = mysqli_num_rows($med_history)-1;
  mysqli_data_seek($med_history,$rows2);
  // echo $rows2;
  $row2=mysqli_fetch_row($med_history);
  $next_med_history_id = $row2[0] + 1;

  // echo $next_details_id;
  // print_r($next_id);
  // // echo '<script>alert("'.$_POST['barangay_id'].'")</script>';
  $_POST['submit'] = null;
  $error = ''; 
  // if (true)
  if (empty($_POST['usermail']) || 
    empty($_POST['password']) || 
    empty($_POST['cpassword']) ||
    empty($_POST['first_name']) ||
    empty($_POST['last_name']) ||
    empty($_POST['contact']) ||
    empty($_POST['b_date']) ||
    
    empty($_POST['height']) ||
    empty($_POST['weight']) ||
    empty($_POST['blood_type']) ||
    empty($_POST['diagnosed_condition']) ||
    empty($_POST['allergies']))
    $error .= 'Fill up input fields that are required (with * mark)! ';
  else {
    $email = mysqli_real_escape_string($conn, $_POST['usermail']);
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $mid_initial = mysqli_real_escape_string($conn, $_POST['mid_initial']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $status = mysqli_real_escape_string($conn, ($_POST['status']=='Unvaccinated'?0:1));
    $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
    $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));

    $bgy_id = mysqli_real_escape_string($conn, $_POST['barangay_id']);
    $b_date = mysqli_real_escape_string($conn, $_POST['b_date']);
    $c_no = mysqli_real_escape_string($conn, $_POST['contact']);

    $height = mysqli_real_escape_string($conn, $_POST['height']);
    $weight = mysqli_real_escape_string($conn, $_POST['weight']);
    $blood_type = mysqli_real_escape_string($conn, $_POST['blood_type']);
    $diagnosed_condition = mysqli_real_escape_string($conn, $_POST['diagnosed_condition']);
    $allergies = mysqli_real_escape_string($conn, $_POST['allergies']);

    $select = "SELECT * FROM users WHERE email = '$email'";

  
    $result = mysqli_query($conn, $select);
  
    if(mysqli_num_rows($result) > 0 || $pass != $cpass)  {
      if (mysqli_num_rows($result) > 0)
          $error .= 'User already exists. '; 
      if ($pass != $cpass)
          $error .= 'Passwords do not match! '; 
      mysqli_free_result($result);
      mysqli_free_result($details);
      mysqli_free_result($med_history);
    } 
    else  { 
      $insert1 = "INSERT INTO users(first_name, mid_initial, last_name, email, password, status, admin, otp,details_id) 
        VALUES('$first_name', '$mid_initial', '$last_name', '$email','$pass', $status, -1, '',$next_details_id);  ";
      $insert2 = "INSERT INTO details(id, contact_no, b_date, barangay_id, med_history_id) 
        VALUES($next_details_id,'$c_no', '$b_date', $bgy_id, $next_med_history_id); ";
      $insert3 = "INSERT INTO med_history(id, height, weight, blood_type, diagnosed_condition, allergies) 
        VALUES($next_med_history_id,'$height', '$weight', '$blood_type', '$diagnosed_condition' , '$allergies');  ";
      if (mysqli_multi_query($conn,"$insert1 $insert2 $insert3"))  {
        mysqli_free_result($result);
        mysqli_free_result($details);
        mysqli_free_result($med_history); 
        echo "<script>alert('Patient Added!');</script>"; 
      }
      else { 
          mysqli_free_result($result);
          mysqli_free_result($details);
          mysqli_free_result($med_history);
          $error .= 'Something went wrong inserting patient into the database.';
      } 
    }  
  } 
}

$conn->close(); 

$page = 'add_patient';
include_once('../php-templates/admin-navigation-head.php');
?>
 
<div class="d-flex" id="wrapper">

  <!-- Sidebar -->
  <?php include_once('../php-templates/admin-navigation-left.php'); ?>

  <!-- Page Content -->
  <div id="page-content-wrapper" style="background-color: #f0cac4">
    <?php include_once('../php-templates/admin-navigation-right.php'); ?>

    <div class="container">
      <div class="row bg-light m-3 con1 container">add-patient
        <form class="form wider" action="" method="post" >
          <?php
            if(isset($error)) 
                echo '<span class="form__input-error-message">'.$error.'</span>'; 
          ?> 
          <div class="form__input-group">
            <input type="text" class="form__input" name="usermail" autofocus placeholder="Email Address*" required/>
          </div>
          <div class="form__input-group">
              <input type="text" class="form__input" name="first_name" placeholder="First Name*" required/>
    
              <input type="text" class="form__input" name="mid_initial" placeholder="Middle Initial">
          
              <input type="text" class="form__input" name="last_name" placeholder="Last Name*" required/>
          </div> 
          <div class="form__input-group">
            <input type="tel" name="contact" class="form__input" placeholder="Contact Num* (Format:09XX-XXX-XXXX)" 
              pattern="[0-9]{4}-[0-9]{3}-[0-9]{4}" required/>
          </div>
          <div class="form__input-group">
            <label>Birth Date*</label>
            <input type="date" name="b_date" required class="form__input"/>
          </div>
          <div class="form__input-group">
              <label>Status</label>
              <select class="form__input" name="status">
                <option value="Unvaccinated" selected>Unvaccinated</option>
                <option value="Vaccinated">Vaccinated</option>
              </select>
          </div> 
          <div class="form__input-group">
              <label>Barangay</label>
              <select class="form__input" name="barangay_id">
              <?php ?>
                <?php
                  if (count($barangay_list)>0) {
                    foreach ($barangay_list as $key => $value) {
                ?>  
                  <option value="<?php echo $value['id'] ?>" <?php echo $key===0?'selected':'' ?>>
                    <?php echo $value['name'] ?>
                  </option>  
                <?php
                    }
                  }
                ?> 
              </select>
          </div> 
          <div class="form__input-group">
              <input type="password" class="form__input" name="password" placeholder="Password*" required/>
          
              <input type="password" class="form__input" name="cpassword" placeholder="Confirm password*" required/>
          </div>
          <div class="form__input-group">
            <div class="form__text"><h3>Medical History</h3></div>
            <input type="text" class="form__input" name="height" placeholder="Height*" required/>    
            <input type="text" class="form__input" name="weight" placeholder="Weight*" required/>    
            <input type="text" class="form__input" name="blood_type" placeholder="Blood Type*" required/>    
            <input type="text" class="form__input" name="diagnosed_condition" placeholder="Diagnosed Condition*" required/>    
            <input type="text" class="form__input" name="allergies" placeholder="Allergies*" required/>    
          </div>
          <button class="form__button" type="submit" name="submit">Register Patient</button> 
        </form>  
      </div>
    </div>
  </div>
</div>
 
<?php include_once('../php-templates/admin-navigation-tail.php'); ?>