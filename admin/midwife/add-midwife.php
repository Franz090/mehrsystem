<?php

@include '../includes/config.php';

session_start();

if(!isset($_SESSION['usermail'])) 
  header('location:../');
 
// fetch barangays  
$select = "SELECT * FROM barangay";
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
  $select = "SELECT * from details";
  $details = mysqli_query($conn, $select);
  $rows = mysqli_num_rows($details)-1;
  mysqli_data_seek($details,$rows);
  // echo $rows;
  $row=mysqli_fetch_row($details);
  $next_details_id = $row[0] + 1;
  echo $next_details_id;
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
    empty($_POST['barangay_id']) ||
    empty($_POST['status']))
    $error .= 'Fill up input fields that are required (with * mark)! ';
  else {
    $email = mysqli_real_escape_string($conn, $_POST['usermail']);
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $mid_initial = mysqli_real_escape_string($conn, $_POST['mid_initial']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $status = mysqli_real_escape_string($conn, ($_POST['status']=='Inactive'?0:1));
    $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
    $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));

    $bgy_id = mysqli_real_escape_string($conn, $_POST['barangay_id']);
    $b_date = mysqli_real_escape_string($conn, $_POST['b_date']);
    $c_no = mysqli_real_escape_string($conn, $_POST['contact']);

    $select = "SELECT * FROM users WHERE email = '$email'";

  
    $result = mysqli_query($conn, $select);
  
    if(mysqli_num_rows($result) > 0 || $pass != $cpass)  {
      if (mysqli_num_rows($result) > 0)
          $error .= 'User already exists. '; 
      if ($pass != $cpass)
          $error .= 'Passwords do not match! '; 
      mysqli_free_result($result);
      mysqli_free_result($details);
    } 
    else  { 
      $insert1 = "INSERT INTO users(first_name, mid_initial, last_name, email, password, status, admin, otp,details_id) 
        VALUES('$first_name', '$mid_initial', '$last_name', '$email','$pass', $status, 0, '',$next_details_id);  ";
      $insert2 = "INSERT INTO details(id, contact_no, b_date, barangay_id, med_history_id) 
        VALUES($next_details_id,'$c_no', '$b_date', $bgy_id, null); ";
      if (mysqli_query($conn, $insert1))  {
        mysqli_free_result($result);
        mysqli_free_result($details);
        if (mysqli_query($conn, $insert2)) { 
          echo "<script>alert('Midwife Added!');</script>";
        }else {
          $error .= 'Something went wrong inserting details of midwife into the database.';
        }
      }
      else { 
          mysqli_free_result($result);
          mysqli_free_result($details);
          $error .= 'Something went wrong inserting midwife into the database.';
      } 
    }  
  } 
}

$conn->close(); 

$page = 'add_midwife';
include_once('../php-templates/admin-navigation-head.php');
?>
 
<div class="d-flex" id="wrapper">

  <!-- Sidebar -->
  <?php include_once('../php-templates/admin-navigation-left.php'); ?>

  <!-- Page Content -->
  <div id="page-content-wrapper" style="background-color: #f0cac4">
    <?php include_once('../php-templates/admin-navigation-right.php'); ?>

    <div class="container">
      <div class="row bg-light m-3 con1 container">add-midwife
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
            <label>Birth Date</label>
            <input type="date" name="b_date" placeholder="Birth Date*" required class="form__input"/>
          </div>
          <div class="form__input-group">
              <label>Status</label>
              <select class="form__input" name="status">
                <option value="Inactive" selected>Inactive</option>
                <option value="Active">Active</option>
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
          <button class="form__button" value="register now" type="submit" name="submit">Register Nurse</button> 
        </form>  
      </div>
    </div>
  </div>
</div>
 
<?php 
include_once('../php-templates/admin-navigation-tail.php');
?>