<?php

@include '../includes/config.php';

session_start();

@include '../php-templates/redirect/admin-page-setter.php';
@include '../php-templates/redirect/patient-status-checker.php';

$session_id = $_SESSION['id'];


if ($current_user_is_a_patient) {
  $select_get_current_user = 
    "SELECT * 
    FROM users u 
    LEFT JOIN user_details ud USING(user_id)
    LEFT JOIN patient_details pd USING(user_id) WHERE u.user_id=$session_id";
  //  echo $select_get_current_user;

  if ($result_current_user = mysqli_query($conn, $select_get_current_user)) {
    foreach($result_current_user as $row)  {
      $c_first_name = $row['first_name'];
      $c_middle_name = $row['middle_name']==null?'':$row['middle_name'];
      $c_last_name = $row['last_name'];
      $c_nickname = $row['nickname']==null?'':$row['nickname'];
      $c_b_date = $row['b_date']==null?'':$row['b_date'];
      $c_address = $row['address']==null?'':$row['address'];
      $c_civil_status = $row['civil_status'];
      $c_diagnosed_condition = $row['diagnosed_condition']==null?'':$row['diagnosed_condition'];
      $c_family_history = $row['family_history']==null?'':$row['family_history'];
      $c_allergies = $row['allergies']==null?'':$row['allergies'];
      $c_blood_type = $row['blood_type'];
      $c_weight = $row['weight'];
      $c_height_ft = $row['height_ft'];
      $c_height_in = $row['height_in'];
      $c_profile_picture = $row['profile_picture']==null?'default.png':$row['profile_picture'];
      
      $select_c_no = "SELECT mobile_number FROM contacts WHERE owner_id=$session_id AND type=1";
      if ($result_c_no = mysqli_query($conn, $select_c_no)) {
        $c_no = '';
        foreach ($result_c_no as $row2) {
          $c_no .= ($row2['mobile_number']."\r\n"); 
        }
      } 
    }
    mysqli_free_result($result_current_user);
  } else {
    $error = 'Something went wrong fetching data from the database.'; 
  } 
} 
if ($current_user_is_a_midwife) {
  $select_get_current_user = 
    "SELECT * 
    FROM users u 
    LEFT JOIN user_details ud USING(user_id) WHERE u.user_id=$session_id";
  //  echo $select_get_current_user;

  if ($result_current_user = mysqli_query($conn, $select_get_current_user)) {
    foreach($result_current_user as $row)  {
      $c_first_name = $row['first_name'];
      $c_middle_name = $row['middle_name']==null?'':$row['middle_name'];
      $c_last_name = $row['last_name'];
      
      $select_c_no = "SELECT mobile_number FROM contacts WHERE owner_id=$session_id AND type=1";
      if ($result_c_no = mysqli_query($conn, $select_c_no)) {
        $c_no = '';
        foreach ($result_c_no as $row2) {
          $c_no .= ($row2['mobile_number']."\r\n"); 
        }
      } 
    }
    mysqli_free_result($result_current_user);
  } else {
    $error = 'Something went wrong fetching data from the database.'; 
  } 
} 

$valid_contact_exp = '/[0][9][0-9][0-9]-[0-9][0-9][0-9]-[0-9][0-9][0-9][0-9]/';
if (isset($_POST['submit_profile'])) {
  $error = '';
  $_POST['submit_profile'] = null;
  $overlapping_condition  = empty(trim($_POST['first_name'])) || empty(trim($_POST['last_name']));
  $submit_profile_condition = $current_user_is_a_midwife ? $overlapping_condition : 
    $overlapping_condition || empty(trim($_POST['civil_status'])) ||
    empty(trim($_POST['weight'])) || empty(trim($_POST['blood_type']));
  if ($submit_profile_condition) {
    $error = 'Fill up input fields that are required (with * mark)! '; 
  } else {
    $contact = mysqli_real_escape_string($conn,$_POST['contact']);

    $contacts = explode('\r\n',$contact);
    $new_contacts = [];

    foreach ($contacts as $key => $mob_number) {
      $regex_check = preg_match($valid_contact_exp,$mob_number);
      if ($mob_number==='') {
          unset($contacts[$key]);
      }
      else if ($regex_check===0) {
          $error .= 'Invalid contact number list provided. Please use the format 09XX-XXX-XXXX where X is a number from 0-9.';
      } else { 
          array_push($new_contacts,$mob_number);
      }
    }

    if ($error == '') {
      $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
      $mid_name = empty($_POST['middle_name'])?"NULL":"'".mysqli_real_escape_string($conn, $_POST['middle_name'])."'";
      $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
      if ($current_user_is_a_patient) { 
        $nickname = empty($_POST['nickname'])?"NULL":"'".mysqli_real_escape_string($conn, $_POST['nickname'])."'"; 
        
        $civil_status = mysqli_real_escape_string($conn,$_POST['civil_status']);
  
        $b_date = empty($_POST['b_date'])?"NULL":"'".mysqli_real_escape_string($conn, $_POST['b_date'])."'";
        $address = empty($_POST['address'])?"NULL":"'".mysqli_real_escape_string($conn, $_POST['address'])."'"; 
        
        $height_ft = mysqli_real_escape_string($conn, $_POST['height_ft']);
        $height_in = mysqli_real_escape_string($conn, $_POST['height_in']);
        $weight = mysqli_real_escape_string($conn, $_POST['weight']);
  
        $blood_type = mysqli_real_escape_string($conn, $_POST['blood_type']);
        $diagnosed_condition = empty($_POST['diagnosed_condition'])?"NULL":"'".mysqli_real_escape_string($conn, $_POST['diagnosed_condition'])."'";
        $family_history = empty($_POST['family_history'])?"NULL":"'".mysqli_real_escape_string($conn, $_POST['family_history'])."'";
        $allergies = empty($_POST['allergies'])?"NULL":"'".mysqli_real_escape_string($conn, $_POST['allergies'])."'";
      }
      
      $update = '';
      $update .= "UPDATE user_details SET first_name='$first_name', middle_name=$mid_name, last_name='$last_name'
        WHERE user_id=$session_id; ";
      if ($current_user_is_a_patient) { 
        $update .= "UPDATE patient_details SET nickname=$nickname, civil_status='$civil_status', 
          b_date=$b_date, address=$address, height_ft=$height_ft, height_in=$height_in, weight=$weight,
          blood_type='$blood_type', diagnosed_condition=$diagnosed_condition, family_history=$family_history,
          allergies=$allergies
          WHERE user_id=$session_id; ";
      }
      $delete_contact_numbers = "DELETE FROM contacts 
        WHERE owner_id=$session_id;";
      $add_contact_numbers = "";
      $contacts_count = count($new_contacts);
      $contacts_count_minus_one = $contacts_count-1;
      if ($contacts_count>0) {
        $add_contact_numbers .= "INSERT INTO contacts(mobile_number, owner_id, type) VALUES ";
        foreach ($new_contacts as $key => $value) { 
          // echo " v: $value ";
          $ins = "('".mysqli_real_escape_string($conn, $value)."', $session_id, 1)"; 
          $add_contact_numbers .= $ins;
          $add_contact_numbers .= ($key===$contacts_count_minus_one)?";":",";
        }
      }
      // echo $update;
      if (mysqli_multi_query($conn, "$update $delete_contact_numbers $add_contact_numbers")) { 
        $_SESSION['name'] = 
          $first_name . " " 
            . ($mid_name=="NULL"?'': (substr($mid_name, 1, 1) . ". ")) 
            . $last_name;
        $conn->close(); 
        header('location:../dashboard');  
      }else {
        $error .= 'Something went wrong updating your account in the database.';
      }    
    }

  }

}


if (isset($_POST['submit_cred'])) {
  $error = '';
  $_POST['submit_cred'] = null;
  if (!empty($_POST['new']) && (empty($_POST['current'])) ||
    !empty($_POST['new_email']) && empty($_POST['current']) || 
    empty($_POST['new_email']) && empty($_POST['new']))   
    $error = 'Please enter your current password and your desired change(s).'; 
  else if ($_POST['new'] != $_POST['cnew']) {
    $error = 'New Password fields do not match.';
  }
  else { 
    $cemail = mysqli_real_escape_string($conn, $_SESSION['usermail']);
    $current_password = mysqli_real_escape_string($conn, md5($_POST['current']));
 
    $select = "SELECT * FROM users WHERE email = '$cemail' && password = '$current_password'";

    $result = mysqli_query($conn, $select);

    if(mysqli_num_rows($result) > 0) {  
      $update_str = '';
      if (!empty($_POST['new'])) {
        $new_password = mysqli_real_escape_string($conn, md5($_POST['new']));
        $update_str .= ("password='$new_password'" . ((!empty($_POST['new_email']))?", ":""));
      }
      if (!empty($_POST['new_email'])) {
        $new_email = mysqli_real_escape_string($conn, ($_POST['new_email']));
        $update_str .= "email='$new_email'";
      } 

        foreach($result as $row)  
            $id_from_db = $row['user_id'];  

        $update_sql = "UPDATE users SET $update_str WHERE user_id=$id_from_db";
        // echo $update_sql;

        if (mysqli_query($conn, $update_sql)) {

          $error= '';
          if (!empty($_POST['new_email'])) $_SESSION['usermail'] = $new_email;

          echo "<script>alert('Account updated!');window.location.href='./update-account.php';</script>";
        }   
        else  {
          $error = 'Something went wrong updating your account.';
        } 

        mysqli_free_result($result); 
    } else { 
        $error = 'Wrong current password.';
    } 
  }
}

if(isset($_POST['submit_pic'])) { 
  $error = '';
  if(isset($_FILES['profile_picture']) && $_FILES['profile_picture']['size'] > 0) { 
    $extension = pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION);  

    $allowed_extensions = array("jpg", "jpeg", "png", "gif");
    if(!in_array(strtolower($extension), $allowed_extensions)) {
      $error = "Invalid file type. Please select a JPG, JPEG, PNG, or GIF file.";
    }  
    $max_file_size = 5 * 1024 * 1024; // 5MB
    if($_FILES['profile_picture']['size'] > $max_file_size) {
      $error = "File size too large. Maximum file size is 5MB.";
    } 
    $file_name = $session_id . "." . $extension; 
    // Move the uploaded file to the uploads folder
    $upload_path = "../img/profile/" . $file_name;
    if(!move_uploaded_file($_FILES['profile_picture']['tmp_name'], $upload_path)) {
      $error = 'File upload failed!';
    } 
    else {
      // Save the file name to the database
      $query = "UPDATE user_details SET profile_picture = '$file_name' WHERE user_id = '$session_id'";
      if(!mysqli_query($conn, $query)) {
        $error = "Error updating database: " . mysqli_error($conn);
      } 
      $_SESSION['profile_picture'] = $file_name;
      echo "<script>alert('Profile Picture Updated');window.location.href='./update-account.php';</script>";
    } 
  }
}
 
$conn->close(); 

$page = 'update_account';
include_once('../php-templates/admin-navigation-head.php');
?>
 
<div class="container_nu"> 
  <!-- Sidebar -->
  <?php include_once('../php-templates/admin-navigation-left.php'); ?>
  <!-- Page Content -->
  <div class="main_nu">
    <?php include_once('../php-templates/admin-navigation-right.php'); ?>

    <div class="container-fluid default" >
      <div class="background-head row m-2 my-4" >
   
        <h4 class="pb-3 m-3 fw-bolder ">Update Account</h4>
       
      
            <form>
              <?php
                if(isset($error)) 
                    echo '<span class="form__input-error-message">'.$error.'</span><br/>'; 
              ?>
            </form>
       
            <?php if (!$current_user_is_an_admin) { ?>
<br><br>
        
              <?php if ($current_user_is_a_patient) { ?>
                <form class="form form-box  px-2 text-center" style=""  action="" method="post" enctype="multipart/form-data">
                  <div class="upload">
                    <img src="../img/profile/<?php echo $c_profile_picture; ?>" 
                    alt="<?php echo "$c_last_name, $c_first_name $c_middle_name"?>" width = "100" height = "100" alt="">
                    <div class="round">
                      <input type="file" name="profile_picture" id="profile_picture" accept="image/png, image/gif, image/jpeg" />
                      <ion-icon name="camera"></ion-icon></ion-icon>
                    </div>
                  </div>
                  <!-- <img style="border: 1px solid #e5e5e5;" class="rounded-circle" src="../img/profile/<?php echo $c_profile_picture; ?>" 
                    alt="<?php echo "$c_last_name, $c_first_name $c_middle_name"?>" width="300" height="600">
                  <br/><br/>
                  <div class="col-md-12 justify-content-center d-flex ">
              
                  <input type="file" name="profile_picture" id="profile_picture" style="width:100%;position:relative;top: 10px;left: 40px;" size="50">
                 </div>

                 <br> -->
                 <br>
                 <div style="position:relative;left: 7px;" class="col-md-12 col-lg-12 text-center">
                    <button class="text-capitalize btn-outline-danger btn-sm  btn" type="submit" name="submit_pic">Update Profile Picture</button>
             </div>

                </form> 
               
                <hr>
              <?php } ?>
               <div class="col-md-12 justify-content-center d-flex ">
              <form class="form form-box px-3 py-5" style=""  action="" method="post">
              
                <?php if ($current_user_is_a_patient) { ?> <div class="row"> <?php } ?>
                   <?php if ($current_user_is_a_patient) { ?>
                  <div class="col-md-3">
                    <?php } ?>
                    <div class="mb-4"> 

                <label>First Name</label>
                  <input type="text" class="form-control" value="<?php echo $c_first_name?>"   name="first_name" placeholder="First Name" tabindex="11">
                </div>
              <?php if ($current_user_is_a_patient) { ?></div><?php } ?>
              <?php if ($current_user_is_a_patient) { ?>
              <div class="col-md-3">
                 <?php } ?>
                <div class="mb-3 ">
                  <label>Middle Name</label>
                  <input type="text" class="form-control" value="<?php echo $c_middle_name?>"  name="middle_name" placeholder="Middle Name" tabindex="11">
                  </div>
                <?php if ($current_user_is_a_patient) { ?></div><?php } ?>
                   <?php if ($current_user_is_a_patient) { ?>
                <div class="col-md-3">
                   <?php } ?>
                 <div class="mb-3 ">
                  <label>Last Name</label>
                  <input type="text" class="form-control" value="<?php echo $c_last_name?>" id="floatingInputInvalid"  name="last_name" placeholder="Last Name" tabindex="11">
                  </div>
                <?php if ($current_user_is_a_patient) { ?></div> <?php } ?>
             
                <?php if ($current_user_is_a_patient) { ?>
              <div class="col-md-3">
               <div class="text-start mb-3">
                <label>Nick Names</label>
                    <input type="text" value="<?php echo $c_nickname?>"
                        class="form-control"  name="nickname"  placeholder="Nickname"/>
                   </div>   
                  </div>  
                <?php if ($current_user_is_a_patient) { ?></div><?php } ?>
                <?php } ?>
                 <?php if ($current_user_is_a_patient) { ?><div class="row"> <?php } ?>
                   <?php if ($current_user_is_a_patient) { ?>
                  <div class="col-md-6">
                     <?php } ?>

                <div class="mb-3">
                <div class="form-input ">
                  <label>Mobile Number(s): *use this format: 09XX-XXX-XXXX*</label>
                  <textarea name="contact" class="form-control"><?php echo $c_no?></textarea> 
                  </div>
                </div>
              <?php if ($current_user_is_a_patient) { ?></div>   <?php } ?>

               <?php if ($current_user_is_a_patient) { ?>
              <div class="col-md-6">
                <div class="mb-3">
              <div class="form-input">
                    <label for="address">Address*</label>
                    <textarea id="address" name="address" class="form-control"><?php echo $c_address?></textarea> 
                  </div>
               </div>
                </div>

              <?php if ($current_user_is_a_patient) { ?> </div> <?php } ?>
                  <?php } ?>
                <?php if ($current_user_is_a_patient) { ?>
                  <div class="row">
                    <div class="col-md-6">
                  <div class="mb-3">
                    <label>Birth Date</label>
                    <div class="input-group date" id="datepicker">
                      <input class="form-control option pt-2 pb-2" type="date" name="b_date" value="<?php echo $c_b_date?>"/>
                    </div>
                  </div>
                  </div>
                <div class="col-md-6">
                  <div class="mb-3">
                    <label>Civil Status*</label>
                      <input type="text" value="<?php echo $c_civil_status?>" class="form-control pt-2 pb-2"  name="civil_status" placeholder="Civil Status*" required/>
                      </div>
                  </div>  
               </div> <br>
                  <div class="form-input">
                    <div class="form__text mb-3"><label style="font-weight: bold;color:#352e35;">Medical History</label></div>
                  </div>
                 
                  <div class="row">
                    <div class="col-md-4">
                  <div class="form_input-group" style="font-family:  'Open Sans', sans-serif;margin-bottom: 1rem;">
                    Height* 
                    <div class="d-flex input-group">
                      <input value="<?php echo $c_height_ft?>" min='0' type="number" 
                        class="form__input form-control" name="height_ft" placeholder="Feet*" required/> 
                      <div class="input-group-postpend">
                        <div id="weight-height" class="input-group-text form__input text-white">ft</div>
                      </div> 
                      <input value="<?php echo $c_height_in?>" min='0' max='11' type="number" 
                      class="form__input form-control" name="height_in" placeholder="Inches*" required/>
                      <div class="input-group-postpend">
                        <div id="weight-height" class=" input-group-text form__input text-white">inch(es)</div>
                      </div> 
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form__input-group" style="font-family:  'Open Sans', sans-serif;margin-bottom: 1rem;">   
                    Weight*   
                    <div class="d-flex input-group">
                      <input value="<?php echo $c_weight?>" type="number" class="form__input form-control" name="weight" placeholder="Weight*" 
                        required min="0"/>
                        <div class="input-group-postpend">
                          <div id="weight-height" class="w-100 input-group-text form__input text-white">kg</div>
                        </div> 
                    </div>
                  </div>
                </div>
               <div class="col-md-4">
                  <div class="mb-3">
                    <label>Blood Type*</label>
                    <input type="text" class="form-control" value="<?php echo $c_blood_type?>"
                       name="blood_type" placeholder="Blood Type*" required/>  
                       </div> 
                      </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4">
                 <div class="mb-3">
                  <label>Diagnosed Condition*</label>
                    <input type="text" class="form-control" value="<?php echo $c_diagnosed_condition?>"
                      name="diagnosed_condition" placeholder="Diagnosed Condition"/>
                    </div> 
                </div>
                <div class="col-md-4">
                  <div class=" mb-3">
                    <label>Family History*</label>
                    <input type="text" class="form-control" value="<?php echo $c_family_history?>"
                       name="family_history" placeholder="Family History"/> 
                      </div>
                </div>
                <div class="col-md-4">
                  <div class="mb-3 ">
                    <label for="floatingInput">Allergies*</label> 
                    <input type="text" value="<?php echo $c_allergies?>"
                     class="form-control" name="allergies" placeholder="Allergies"/>  
                    </div>
                  </div> 
                </div>
                   
                <?php } ?>
            
                <div class="col-md-12 text-center mt-3">
                <?php if (!$current_user_is_an_admin) { ?> 
                 
                  
                <button class="w-30  btn btn-primary text-capitalize" type="submit" name="submit_profile" onclick="showAlerts()">Update Profile</button>
                 <a  style="position:relative;top: 0px;padding:5px;" class=" w-30  btn btn-danger text-capitalize"  href="../dashboard">Cancel</a>
                </div>
               <?php } ?> 
              
              </form> 
              <?php if ($current_user_is_a_patient) { ?>
               </div>
             <?php } ?>
            <?php } ?>

    
      </div> 
    </div>

  </div> 
</div>


 
<?php include_once('../php-templates/admin-navigation-tail.php'); ?>