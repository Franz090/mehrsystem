<?php

@include '../includes/config.php';

session_start();

@include '../php-templates/redirect/admin-page-setter.php';
@include '../php-templates/redirect/patient-status-checker.php';

$session_id = $_SESSION['id'];
$current_user_is_a_patient = $admin==-1;


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
      // $c_trimester = $row['trimester'];
      // $c_tetanus = $row['tetanus'];
      $c_diagnosed_condition = $row['diagnosed_condition']==null?'':$row['diagnosed_condition'];
      $c_family_history = $row['family_history']==null?'':$row['family_history'];
      $c_allergies = $row['allergies']==null?'':$row['allergies'];
      $c_blood_type = $row['blood_type'];
      $c_weight = $row['weight'];
      $c_height_ft = $row['height_ft'];
      $c_height_in = $row['height_in'];
      
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
  $submit_profile_condition = 
    empty(trim($_POST['first_name'])) || empty(trim($_POST['last_name'])) || 
    empty(trim($_POST['civil_status'])) || empty(trim($_POST['weight'])) || 
    empty(trim($_POST['blood_type']));
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
      // $trimester = mysqli_real_escape_string($conn, $_POST['trimester']);
      // $tetanus = mysqli_real_escape_string($conn, $_POST['tetanus']);
      //, trimester=$trimester, tetanus=$tetanus
      $update = '';
      $update .= "UPDATE user_details SET first_name='$first_name', middle_name=$mid_name, last_name='$last_name'
        WHERE user_id=$session_id; ";
      $update .= "UPDATE patient_details SET nickname=$nickname, civil_status='$civil_status', 
        b_date=$b_date, address=$address, height_ft=$height_ft, height_in=$height_in, weight=$weight,
        blood_type='$blood_type', diagnosed_condition=$diagnosed_condition, family_history=$family_history,
        allergies=$allergies
        WHERE user_id=$session_id; ";
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
        $conn->close(); 
        header('location:demographic-profile.php');  
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
          echo "<script>alert('Accout updated!');</script>";
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
 
$conn->close(); 

$page = 'update_account';
include_once('../php-templates/admin-navigation-head.php');
?>
 
<div class="d-flex" id="wrapper"> 
  <!-- Sidebar -->
  <?php include_once('../php-templates/admin-navigation-left.php'); ?>
  <!-- Page Content -->
  <div id="page-content-wrapper">
    <?php include_once('../php-templates/admin-navigation-right.php'); ?>

    <div class="container-fluid default" >
      <div class="background-head row m-2 my-4" ><h4 class="pb-3 m-3 fw-bolder ">Update Account</h4><hr>
        
        <div class="container default p-4 ">
          <div class="col-md-8 col-lg-5">
            <form>
              <?php
                if(isset($error)) 
                    echo '<span class="form__input-error-message">'.$error.'</span><br/>'; 
              ?>
            </form>
       
            <?php if ($current_user_is_a_patient) { ?>
              <form class="form form-box px-3 py-5" style=""  action="" method="post">
            
                <div class="form-input">
                  First Name
                  <input type="text" value="<?php echo $c_first_name?>"
                      name="first_name" placeholder="First Name*" required>
                  Middle Name
                  <input type="text" value="<?php echo $c_middle_name?>"
                    class="form-input" name="middle_name" placeholder="Middle Name">
                  Last Name
                  <input type="text" value="<?php echo $c_last_name?>"
                    class="form-input" name="last_name" placeholder="Last Name*" required required/>
                </div> 
                <div class="form-input">
                  Nickname
                  <input type="text" value="<?php echo $c_nickname?>"
                      class="form-input" name="nickname"  placeholder="Nickname"/>
                </div> 
                <div class="form-input">
                  <label for="contact">Mobile Number(s): *Separate each with a nextline and use this format: 09XX-XXX-XXXX*</label><br/>
                  <textarea id="contact" name="contact" class="form-control form-control-md w-100"><?php echo $c_no?></textarea> 
                </div><br>
                <div class="form-input">
                  <label>Birth Date</label>
                  <div class="form-input">
                    <input type="date" name="b_date" value="<?php echo $c_b_date?>"/>
                  </div>
                </div>
                <div class="form-input">
                  <label for="address">Address</label><br/>
                  <textarea id="address" name="address" class="form-control form-control-md w-100"><?php echo $c_address?></textarea> 
                </div><br>
                Civil Status*
                <div class="form-input">
                    <input type="text" value="<?php echo $c_civil_status?>" class="form-input" name="civil_status" placeholder="Civil Status*" required/>
                </div>  
  
                <div class="form-input">
                  <div class="form__text"><label>Medical History</label></div>
                </div>
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
                <div class="form__input-group" style="font-family:  'Open Sans', sans-serif;margin-bottom: 1rem;">   
                  Weight*   
                  <div class="d-flex input-group">
                    <input value="<?php echo $c_weight?>" type="number" class="form__input form-control" name="weight" placeholder="Weight*" 
                      required min="0"/>
                      <div class="input-group-postpend">
                        <div id="weight-height" class="w-100 input-group-text form__input text-white">kg</div>
                      </div> 
                  </div>
                </div><br>
                Blood Type*
                <div class="form-input"> 
                  <input type="text" value="<?php echo $c_blood_type?>"
                    class="form-input" name="blood_type" placeholder="Blood Type*" required/>  
                </div>
                <div class="form-input">  
                  Diagnosed Condition
                  <input type="text" value="<?php echo $c_diagnosed_condition?>"
                    class="form-input" name="diagnosed_condition" placeholder="Diagnosed Condition"/> 
                  Family History
                  <input type="text" value="<?php echo $c_family_history?>"
                    class="form__input" name="family_history" placeholder="Family History"/> 
                  Allergies
                  <input type="text" value="<?php echo $c_allergies?>"
                    class="form__input" name="allergies" placeholder="Allergies"/>    
                </div>
                <!-- <div class="form_select">
                  <label>Tetanus Toxoid Vaccinated</label>
                  <select class="form_select_focus" name="tetanus">
                    <option value="0" <?php //echo $c_tetanus==0?'selected':''?>>Unvaccinated</option>
                    <option value="1" <?php //echo $c_tetanus==1?'selected':''?>>Vaccinated</option> 
                  </select>
                </div> 
                <div class="form_select">
                  <label>Nth Trimester</label>
                  <select class="form_select_focus" name="trimester">
                    <option value="0" <?php //echo $c_trimester==0?'selected':''?>>N/A</option>
                    <option value="1" <?php //echo $c_trimester==1?'selected':''?>>1st (0-13 weeks)</option>
                    <option value="2" <?php //echo $c_trimester==2?'selected':''?>>2nd (14-27 weeks)</option>
                    <option value="3" <?php //echo $c_trimester==3?'selected':''?>>3rd (28-42 weeks)</option>
                  </select>
                </div>  -->
                <button class="w-100 btn  text-capitalize" type="submit" name="submit_profile">Update Profile Data</button>
              </form> 
              
              <hr/>
            <?php } ?>

            <form class="form form-box px-3 pt-5" style=""  action="" method="post">
              <?php
                //if(isset($error)) 
                    //echo '<span class="form__input-error-message">'.$error.'</span><br/>'; 
              ?> 
              
              Put your current password to authorize the change(s)
              <div class="form-input">
                  <input type="password" class="form-input"  name="current" placeholder="Current Password" tabindex="10" required>
                </div>
              
              Current Email: <?php echo $_SESSION['usermail']?><br/>Leave blank if you do not want to change the email
              <div class="form-input">
                  <input type="email" class="form-input"  name="new_email" placeholder="New Email" tabindex="11" >
                </div>

              
              Leave blank if you do not want to change the password
              <div class="form-input">
                  <input type="password" class="form-input"  
                    name="new" placeholder="New Password" tabindex="12" />
                </div> 
              <div class="form-input">
                  <input type="password" class="form-input"  
                    name="cnew" placeholder="Confirm New Password" tabindex="13" />
                </div>
              <button class="w-100 btn  text-capitalize" type="submit" name="submit_cred">Update Credentials</button>
            </form> 
          </div>
        </div>

      </div> 
    </div>

  </div> 
</div>


 
<?php include_once('../php-templates/admin-navigation-tail.php'); ?>