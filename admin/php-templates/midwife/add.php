<?php

@include '../includes/config.php';

session_start();
 
@include '../php-templates/redirect/admin-page-setter.php';
 
@include '../php-templates/redirect/nurse-only.php';
// TODO: update code for having only one midwife assigned to a barangay 
$barangay_list = [];
// if ($admin==1) {

// fetch barangays  
$select_b = "SELECT * FROM barangay WHERE assigned_midwife IS NULL";
$result_barangay = mysqli_query($conn, $select_b);


if(mysqli_num_rows($result_barangay)>0)  {
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
// } 

// else {
//   $session_id = $_SESSION['id'];
//   // echo $session_id;
//   $select_b_id = "SELECT barangay_id FROM users,details WHERE users.id=$session_id AND users.details_id=details.id";
//   $result_barangay_id = mysqli_query($conn, $select_b_id);
//   // echo "print this ";
//   // print_r($result_barangay_id);
//   if(mysqli_num_rows($result_barangay_id)>0)  {
//     foreach($result_barangay_id as $row)  {
//       $barangay_id_to_be_used = $row['barangay_id'];    
//     } 
//     mysqli_free_result($result_barangay_id);
//     // print_r($result_barangay);

//   } 
//   else  { 
//     mysqli_free_result($result_barangay_id);
//     $error = 'Something went wrong fetching data from the database.'; 
//   }  
// }
 


// register
if(isset($_POST['submit'])) {
  // get next id for users
  $select_u = "SELECT * from users";
  $users = mysqli_query($conn, $select_u);
  $rows_u = mysqli_num_rows($users)-1;
  mysqli_data_seek($users,$rows_u);
  $row_u=mysqli_fetch_row($users);
  $next_users_id = $row_u[0] + 1;

  // get next id for details
  $select = "SELECT * from details";
  $details = mysqli_query($conn, $select);
  $rows = mysqli_num_rows($details)-1;
  mysqli_data_seek($details,$rows);
  // echo $rows;
  $row=mysqli_fetch_row($details);
  $next_details_id = $row[0] + 1;

  // echo $next_details_id;
  // print_r($next_id);
  // // echo '<script>alert("'.$_POST['barangay_id'].'")</script>';
  $_POST['submit'] = null;
  $error = ''; 

  // if (false)
  if (empty($_POST['usermail']) || 
    empty($_POST['password']) || 
    empty($_POST['cpassword']) ||
    empty($_POST['first_name']) ||
    empty($_POST['last_name']) ||
    empty($_POST['contact']) ||
    empty($_POST['b_date']) ||
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
 
    // nurse 
    // if ($admin==1) { 
    // $bgy_id = mysqli_real_escape_string($conn, $_POST['barangay_id']);
    // } 
    // midwife 
    // else {
    //   $bgy_id = mysqli_real_escape_string($conn, $barangay_id_to_be_used);
    // }
 
    $b_date = mysqli_real_escape_string($conn, $_POST['b_date']);
    $c_no = mysqli_real_escape_string($conn, $_POST['contact']);
    // $checkedOptions = '';
    // foreach($_POST["barangay_id"] as $checkbox)
    // { 
    //   $checkedOptions .= $checkbox;

    // }
    // echo $checkedOptions;
    // print_r($_POST);
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
      $insert1 = "INSERT INTO users(id, first_name, mid_initial, last_name, email, password, status, admin, otp, details_id) 
        VALUES($next_users_id, '$first_name', '$mid_initial', '$last_name', '$email','$pass', $status, 0, '', $next_details_id);  ";
      $insert2 = "INSERT INTO details(id, contact_no, b_date, barangay_id, med_history_id) 
        VALUES($next_details_id,'$c_no', '$b_date', null, null); ";
      $update_sql = '';
      if (isset($_POST['barangay_id']))
        foreach($_POST["barangay_id"] as $b_id)
        { 
          $bgy_id = mysqli_real_escape_string($conn, $b_id);
          $update_sql .= "UPDATE barangay SET assigned_midwife=$next_users_id WHERE id=$b_id; "; 
        } 
//  echo "$insert1 $insert2 $update_sql";
      if (mysqli_multi_query($conn, "$insert1 $insert2 $update_sql"))  {
        mysqli_free_result($result);
        mysqli_free_result($details);
        mysqli_free_result($users);
        echo "<script>alert('Midwife Added!');</script>";
      //   if (mysqli_query($conn, $insert2)) { 
      //     echo "<script>alert('Midwife Added!');</script>";
      //   } else {
      //     $error .= 'Something went wrong inserting details of midwife into the database.';
      //   }
      }
      else { 
          mysqli_free_result($result);
          mysqli_free_result($details);
          mysqli_free_result($users);
          $error .= 'Something went wrong adding midwife to the database.';
      } 
    }  
  } 
}

$conn->close(); 

$page = 'add_midwife';
include_once('../php-templates/admin-navigation-head.php');
?>
 <style>
   label {
    font-family: Arial, Helvetica, sans-serif;
  }
  .bg-primary{
    background-color:pink;
  }
  
 </style>
<div class="d-flex" id="wrapper">
  <!-- Sidebar -->
  <?php include_once('../php-templates/admin-navigation-left.php'); ?>
  <!-- Page Content -->
  <div id="page-content-wrapper">
    <?php include_once('../php-templates/admin-navigation-right.php'); ?>

    <div class="container-fluid">
      <div class="row bg-light m-3"><h3>Add New Midwife</h3>
        <?php if (count($barangay_list)>0) { ?>
          <div class="container default table-responsive p-4">
            <div class="col-md-8 col-lg-5 ">
              <form class="form" action="" method="post" >
                <?php
                  if(isset($error)) 
                      echo '<span class="form__input-error-message">'.$error.'</span>'; 
                ?> 
                <div class="form__input-group">
                  <input type="email" class="form__input" name="usermail" autofocus placeholder="Email Address*" required/>
                </div>
                <div class="form__input-group">
                    <input type="text" class="form__input" name="first_name" placeholder="First Name*" required/>
                    </div>
                <div class="form__input-group">
                    <input type="text" class="form__input" name="mid_initial" placeholder="Middle Initial">
                  </div>
                <div class="form__input-group">
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
                  <fieldset>      
                    <?php  
                      foreach ($barangay_list as $key => $value) {
                    ?>  
                      <input type="checkbox" id="check<?php echo $key ?>" value="<?php echo $value['id'] ?>" name="barangay_id[]"/>
                        <label for="check<?php echo $key ?>"><?php echo $value['name'] ?></label>
                      <br/> 
                    <?php 
                      } 
                    ?>     
                  </fieldset>      
                </div>  
      
                <div class="form__input-group">
                    <input type="password" class="form__input" name="password" placeholder="Password*" required/>
                </div>
                <div class="form__input-group">
                    <input type="password" class="form__input" name="cpassword" placeholder="Confirm password*" required/>
                </div>
      
                <button class="form__button" type="submit" name="submit">Register Midwife</button>  
              </form>
            </div>
          </div>
        <?php } else { ?>
      
            <div class="container default ">
              <div class="col-md-8 col-lg-5 ">
          <h6 style="text-align: center;" class="mt-5">There must be at least one barangay that has no assigned midwife to be able to add a midwife.</h6> 
         <button style="color:whitesmoke;" class="form__button btn bg-primary"><a href='../health-center/add-barangay.php'>Add a barangay</a></button>
        </div>
        </div>
       
        <?php }?>
       
      </div>
    </div>

  </div>
</div>
<?php 
include_once('../php-templates/admin-navigation-tail.php');
?>