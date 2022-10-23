<?php
header('location:../');
@include '../includes/config.php';

session_start();
 
@include '../php-templates/redirect/admin-page-setter.php';
@include '../php-templates/redirect/midwife-only.php';

$session_id = $_SESSION['id'];
@include '../php-templates/midwife/get-assigned-barangays.php';
 
// fetch barangays  
if (count($_barangay_list)>0) { 
  $barangay_select = '';
  $barangay_list_length_minus_1 = count($_barangay_list)-1;
  foreach ($_barangay_list as $key => $value) { 
    
    $barangay_select .= "barangay_id=$value ";
   
    if ($key < $barangay_list_length_minus_1) {
      $barangay_select .= "OR ";
    }  
  } 
  $select = "SELECT barangay_id id, health_center FROM barangays WHERE $barangay_select";

  $barangay_list = [];
  $result_barangay = mysqli_query($conn, $select);
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
} 

// register 
$valid_contact_exp = '/[0][9][0-9][0-9]-[0-9][0-9][0-9]-[0-9][0-9][0-9][0-9]/';

if(isset($_POST['submit'])) {
  $_POST['submit'] = null;
  $error = ''; 
  // next users id 
  $select_last_user_id = "SELECT user_id from users ORDER BY user_id DESC LIMIT 1";
  if ($result_next_user_id = mysqli_query($conn, $select_last_user_id)) {
    foreach ($result_next_user_id as $row) {
      $next_user_id = $row['user_id']+1;
    }
  }else {
    $error .= 'Something went wrong inserting patient into the database. (Error fetching next user_id)';
  }  

  if (empty($_POST['usermail']) || 
    empty($_POST['password']) || 
    empty($_POST['cpassword']) ||
    empty($_POST['first_name']) ||
    empty($_POST['last_name']) ||
    empty($_POST['civil_status']) ||  
    empty($_POST['height_ft']) ||
    empty($_POST['height_in']) ||
    empty($_POST['weight']) ||
    empty($_POST['blood_type']))
    $error .= 'Fill up input fields that are required (with * mark)! ';
  else if ($error=='') {
    $contact = mysqli_real_escape_string($conn,$_POST['contact']);

    $contacts = explode('\r\n',$contact);
    $new_contacts = [];
    // print_r($contacts);
    // check numbers  
    foreach ($contacts as $key => $mob_number) {
        // echo " mob_number: $mob_number ";
        $regex_check = preg_match($valid_contact_exp,$mob_number);
        // echo " regex check: $regex_check ";
        if ($mob_number==='') {
            unset($contacts[$key]);
        }
        else if ($regex_check===0) {
            $error .= 'Invalid contact number list provided. Please use the format 09XX-XXX-XXXX where X is a number from 0-9.';
        } else { 
            array_push($new_contacts,$mob_number);
        }
    }

    if ($error=='') {
      $email = mysqli_real_escape_string($conn, $_POST['usermail']);
      $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
      $mid_name = empty($_POST['mid_name'])?"NULL":"'".mysqli_real_escape_string($conn, $_POST['mid_name'])."'";
      $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
      $nickname = empty($_POST['nickname'])?"NULL":"'".mysqli_real_escape_string($conn, $_POST['nickname'])."'"; 
  
      $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
      $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
  
      $civil_status = mysqli_real_escape_string($conn,$_POST['civil_status']);
  
      $bgy_id = mysqli_real_escape_string($conn, $_POST['barangay_id']);
      $b_date = empty($_POST['b_date'])?"NULL":"'".mysqli_real_escape_string($conn, $_POST['b_date'])."'";
      $address = empty($_POST['address'])?"NULL":"'".mysqli_real_escape_string($conn, $_POST['address'])."'"; 
  
      $height_ft = mysqli_real_escape_string($conn, $_POST['height_ft']);
      $height_in = mysqli_real_escape_string($conn, $_POST['height_in']);
      $weight = mysqli_real_escape_string($conn, $_POST['weight']);
      $blood_type = mysqli_real_escape_string($conn, $_POST['blood_type']);
      $diagnosed_condition = empty($_POST['diagnosed_condition'])?"NULL":"'".mysqli_real_escape_string($conn, $_POST['diagnosed_condition'])."'";
      $family_history = empty($_POST['family_history'])?"NULL":"'".mysqli_real_escape_string($conn, $_POST['family_history'])."'";
      $allergies = empty($_POST['allergies'])?"NULL":"'".mysqli_real_escape_string($conn, $_POST['allergies'])."'";
      $trimester = mysqli_real_escape_string($conn, $_POST['trimester']);
      $tetanus = mysqli_real_escape_string($conn, $_POST['tetanus']);
  
      $select = "SELECT * FROM users WHERE email = '$email'"; 
      $result = mysqli_query($conn, $select);
    
      if(mysqli_num_rows($result) > 0 || $pass != $cpass)  {
        if (mysqli_num_rows($result) > 0)
            $error .= 'User already exists. '; 
        if ($pass != $cpass)
            $error .= 'Passwords do not match! '; 
        mysqli_free_result($result); 
        mysqli_free_result($result_next_user_id); 
      } 
      else  { 
        $insert1 = "INSERT INTO users VALUES ($next_user_id, '$email','$pass',NULL,-1); ";
        $insert2 = "INSERT INTO user_details VALUES (NULL, '$first_name',$mid_name,'$last_name',NULL,$next_user_id); ";
        $insert3 = "INSERT INTO patient_details 
          VALUES (NULL, $nickname, $bgy_id, $b_date, $address, '$civil_status', 
            $trimester, $tetanus, $diagnosed_condition, $family_history, $allergies, 
            '$blood_type', $weight, $height_ft, $height_in, $next_user_id); ";
        $add_contact_numbers = "";
        $contacts_count = count($new_contacts);
        $contacts_count_minus_one = $contacts_count-1;
        if ($contacts_count>0) {
            $add_contact_numbers .= "INSERT INTO contacts(mobile_number, owner_id, type) VALUES ";
            foreach ($new_contacts as $key => $value) { 
                $ins = "('".mysqli_real_escape_string($conn, $value)."', $next_user_id, 1)"; 
                $add_contact_numbers .= $ins;
                $add_contact_numbers .= ($key===$contacts_count_minus_one)?";":",";
            }
        }
        if (mysqli_multi_query($conn,"$insert1 $insert2 $insert3 $add_contact_numbers"))  {
          mysqli_free_result($result); 
          mysqli_free_result($result_next_user_id); 
          echo "<script>alert('Patient Added!');</script>"; 
        }
        else { 
            mysqli_free_result($result); 
            mysqli_free_result($result_next_user_id); 
            $error .= 'Something went wrong inserting patient into the database.';
        } 
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
  <div id="page-content-wrapper">
    <?php include_once('../php-templates/admin-navigation-right.php'); ?>

    <div class="container-fluid default">
      <?php if (count($_barangay_list) > 0) { ?>
        <div class="background-head row m-2 my-4"><h4 class="pb-3 m-3 fw-bolder ">Add Patient</h4><hr>
       <div class="container default table-responsive p-4">
            <div class="col-md-8 col-lg-5 ">
        <form class="form form-box px-3" style="padding-top: 100px;" action="" method="post" >
          <?php
            if(isset($error)) 
                echo '<span class="form__input-error-message">'.$error.'</span>'; 
          ?> 
          <!-- <div class="form__input-group">
            <input type="text" class="form__input" name="usermail" autofocus placeholder="Email Address*" required/>
          </div> -->
           <div class="form-input">
              <input type="email" class="form-input"  name="usermail" autofocus placeholder="Email Address*" tabindex="10" required>
            </div>
          <!-- <div class="form__input-group">
              <input type="text" class="form__input" name="first_name" placeholder="First Name*" required/> -->
           <div class="form-input">
              <input type="text" class="form-input"  name="first_name" autofocus placeholder="First Name*" tabindex="10" required>
              <input type="text" class="form-input" name="mid_name" autofocus placeholder="Middle Name" tabindex="10" required>
              <input type="text" class="form-input" name="last_name" autofocus placeholder="Last Name*" tabindex="10" required required/>
          </div> 
          <div class="form-input">
              <input type="text" class="form-input" name="nickname" autofocus  placeholder="Nickname" tabindex="10" required/>
          </div> 
          <div class="form-input">
            <label for="contact">Mobile Number(s): *Separate each with a nextline and use this format: 09XX-XXX-XXXX*</label><br/>
            <textarea id="contact" name="contact" class="form-control form-control-md w-100"></textarea> 
          </div><br>
          <div class="form-input">
            <label>Birth Date</label>
            <div class="form-input">
            <input type="date" name="b_date" required/>
        </div>
          </div>
          <div class="form-input">
            <label for="address">Address</label><br/>
            <textarea id="address" name="address" class="form-control form-control-md w-100"></textarea> 
          </div><br>
          <div class="form-input">
              <input type="text"  class="form-input" name="civil_status" autofocus  tabindex="10" placeholder="Civil Status*" required/>
          </div>  
          <div class="form_select">
              <label>Barangay</label>
              <select class="form_select_focus" name="barangay_id">
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
          <div class="form-input">
              <input type="password" class="form-input" name="password" placeholder="Password*" required/>
                </div>
            <div class="form-input">
              <input type="password" class="form-input" name="cpassword" placeholder="Confirm password*" required/>
          </div>
          <div class="form-input">
            <div class="form__text"><label>Medical History</label></div>
          </div>
          <div class="form_input-group" style="font-family:  'Open Sans', sans-serif;margin-bottom: 1rem;">
            Height* 
            <div class="d-flex input-group">
              <input value="0" min='0' type="number" 
                class="form__input form-control" name="height_ft" placeholder="Feet*" required/> 
              <div class="input-group-postpend">
                <div id="weight-height" class="input-group-text form__input text-white">ft</div>
              </div> 
              <input value="0" min='0' max='11' type="number" 
              class="form__input form-control" name="height_in" placeholder="Inches*" required/>
              <div class="input-group-postpend">
                <div id="weight-height" class=" input-group-text form__input text-white">inch(es)</div>
              </div> 
            </div>
          </div>
          <div class="form__input-group" style="font-family:  'Open Sans', sans-serif;margin-bottom: 1rem;">   
            Weight*   
            <div class="d-flex input-group">
              <input value="0" type="number" class="form__input form-control" name="weight" placeholder="Weight*" 
                required min="0"/>
                <div class="input-group-postpend">
                  <div id="weight-height" class="w-100 input-group-text form__input text-white">kg</div>
                </div> 
            </div>
          </div><br>
          <div class="form-input"> 
            <input type="text" class="form-input" name="blood_type" placeholder="Blood Type*" required/>  
          </div>
          <div class="form-input">  
            <input type="text" class="form-input" name="diagnosed_condition" placeholder="Diagnosed Condition" required/> 
            <input type="text" class="form__input" name="family_history" placeholder="Family History" required/> 
            <input type="text" class="form__input" name="allergies" placeholder="Allergies " required/>    
          </div>
          <div class="form_select">
              <label>Tetanus Toxoid Vaccinated</label>
              <select class="form_select_focus" name="tetanus">
                <option value="0" selected>Unvaccinated</option>
                <option value="1">Vaccinated</option> 
              </select>
          </div> 
          <div class="form_select">
              <label>Nth Trimester</label>
              <select class="form_select_focus" name="trimester">
                <option value="0" selected>N/A</option>
                <option value="1">1st (0-13 weeks)</option>
                <option value="2">2nd (14-27 weeks)</option>
                <option value="3">3rd (28-42 weeks)</option>
              </select>
          </div> 
          <button class="w-100 btn  text-capitalize" type="submit" name="submit">Register Patient</button> 
        </form>
          </div>
        </div>  
      </div>
      <?php } else { //print_r($_barangay_list);?>
        <span class="">You can not add a patient. There are no barangays assigned to you.</span>
      <?php } ?>
    </div>
  </div>
</div>
 
<?php include_once('../php-templates/admin-navigation-tail.php'); ?>