<?php 

@include '../includes/config.php';

session_start();

@include '../php-templates/redirect/admin-page-setter.php';
@include '../php-templates/redirect/midwife-only.php';
 
// $barangay_id_to_be_used = $_SESSION['barangay_id'];
 
// fetch barangays  
$barangay_list = [];

$select = "SELECT * FROM barangay";
$result_barangay = mysqli_query($conn, $select);

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

// fetch user 
$id_from_get = $_GET['id'];
$user_to_edit = "SELECT first_name, mid_initial, last_name, email, 
    IF(users.status=0, 'Unvaccinated', 'Vaccinated') AS status, details_id, contact_no, b_date, barangay_id,
    height, weight, blood_type, diagnosed_condition, allergies, med_history_id 
  FROM users, details, med_history
  WHERE users.id = $id_from_get AND users.details_id = details.id AND details.med_history_id = med_history.id";
$user_from_db = mysqli_query($conn, $user_to_edit);

if (mysqli_num_rows($user_from_db) > 0) {
  foreach($user_from_db as $row)  {
    $c_email = $row['email'];  
    $c_first_name = $row['first_name'];  
    $c_mid_initial = $row['mid_initial'];  
    $c_last_name = $row['last_name'];  
    $c_status = $row['status'];   

    $c_contact = $row['contact_no'];   
    $c_b_date = $row['b_date'];   
    $c_barangay = $row['barangay_id'];   
    $c_details_id = $row['details_id'];   

    $c_height = $row['height'];
    $c_weight = $row['weight'];
    $c_blood_type = $row['blood_type'];
    $c_diagnosed_condition = $row['diagnosed_condition'];
    $c_allergies = $row['allergies'];
    $c_med_history_id = $row['med_history_id'];

  }  
  mysqli_free_result($user_from_db);
 
//   if ($barangay_id_to_be_used!=$c_barangay) { 
//     header('location: ./view-midwife.php?edit=0');
//   }  
 
} 
else {
  $no_user = 'No such user.'; 
  mysqli_free_result($user_from_db);
}


// edit
if(isset($_POST['submit'])) {
  $_POST['submit'] = null;
  $error = ''; 

  if (empty($_POST['usermail']) ||  
    empty($_POST['first_name']) ||
    empty($_POST['last_name']) ||

    empty($_POST['contact']) ||
    empty($_POST['b_date']) ||

    empty($_POST['height']) ||
    empty($_POST['weight']) ||
    empty($_POST['blood_type']) ||
    empty($_POST['diagnosed_condition']) ||
    empty($_POST['allergies'])
    )
    $error .= 'Fill up input fields that are required (with * mark)! ';
  else {
    $email = mysqli_real_escape_string($conn, $_POST['usermail']);
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $mid_initial = mysqli_real_escape_string($conn, $_POST['mid_initial']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $status = mysqli_real_escape_string($conn, ($_POST['status']=='Inactive'?0:1));

    $details_id = mysqli_real_escape_string($conn, $_POST['details_id']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $b_date = mysqli_real_escape_string($conn, $_POST['b_date']); 
    $barangay_id = mysqli_real_escape_string($conn, $_POST['barangay_id']);
    
    
    $med_history_id = mysqli_real_escape_string($conn, $_POST['med_history_id']);
    $height = mysqli_real_escape_string($conn, $_POST['height']);
    $weight = mysqli_real_escape_string($conn, $_POST['weight']);
    $blood_type = mysqli_real_escape_string($conn, $_POST['blood_type']);
    $diagnosed_condition = mysqli_real_escape_string($conn, $_POST['diagnosed_condition']);
    $allergies = mysqli_real_escape_string($conn, $_POST['allergies']);

    $select2 = "SELECT * FROM users WHERE email = '$email'";

  
    $result2 = mysqli_query($conn, $select2);
  
    if(mysqli_num_rows($result2) > 1)  { 
      $error .= 'The email inputted was already used. ';  
      mysqli_free_result($result2);
    } 
    else  {
        foreach($result2 as $row)   
            $id_from_db = $row['id'];    
        $up1 = "UPDATE users SET first_name='$first_name', mid_initial='$mid_initial', last_name='$last_name', 
            email='$email',  status=$status WHERE id=$id_from_db;";
        $up2 = "UPDATE details SET contact_no='$contact', b_date='$b_date', barangay_id=$barangay_id
            WHERE id=$details_id;";
        $up3 = "UPDATE med_history SET height='$height', weight='$weight', diagnosed_condition='$diagnosed_condition', blood_type='$blood_type', allergies='$allergies'
            WHERE id=$med_history_id;";
            echo $up3;
        if (mysqli_multi_query($conn, "$up1 $up2 $up3"))  {
            mysqli_free_result($result2); 
            echo "<script>alert('Patient Record Updated!');</script>"; 
            $conn->close(); 
            header('location:view-patients.php');  
        }else {
            mysqli_free_result($result2); 
            $error .= 'Something went wrong updating the patient in the database.';
        }      
    }  
  } 
} 
 
$conn->close(); 

$page = 'edit_patient';
include_once('../php-templates/admin-navigation-head.php');
?>
 
<div class="d-flex" id="wrapper">

  <!-- Sidebar -->
  <?php include_once('../php-templates/admin-navigation-left.php'); ?>

  <!-- Page Content -->
  <div id="page-content-wrapper" style="background-color: #f0cac4">
    <?php include_once('../php-templates/admin-navigation-right.php'); ?>

    <div class="container">
      <div class="row bg-light m-3">Update Patient Record
        <?php
          if (isset($no_user))  
            echo '<span class="form__input-error-message">'.$no_user.'</span>';
          else   {
        ?>   
        <form class="form" action="" method="post">
          <input type='hidden' name='details_id' value="<?php echo $c_details_id?>"/>
          <input type='hidden' name='med_history_id' value="<?php echo $c_med_history_id?>"/>
          <?php 
            if (isset($error))  
              echo '<span class="form__input-error-message">'.$error.'</span>'; 
          ?> 
          <div class="form__input-group">
              <input value="<?php echo $c_email?>" type="text" class="form__input" name="usermail" autofocus placeholder="Email Address*" required>
          </div>
          <div class="form__input-group">
              <input value="<?php echo $c_first_name?>" type="text" class="form__input" name="first_name" placeholder="First Name*" required>
      
              <input value="<?php echo $c_mid_initial?>" type="text" class="form__input" name="mid_initial" placeholder="Middle Initial">
          
              <input value="<?php echo $c_last_name?>" type="text" class="form__input" name="last_name" placeholder="Last Name*" required>
          </div> 
          <div class="form__input-group">
            <input value="<?php echo $c_contact?>"
              type="tel" name="contact" class="form__input" placeholder="Contact Num* (Format:09XX-XXX-XXXX)" 
              pattern="[0-9]{4}-[0-9]{3}-[0-9]{4}" required/>
          </div>
          <div class="form__input-group">
            <label>Birth Date*</label>
            <input value="<?php echo $c_b_date?>"
            type="date" name="b_date" required class="form__input"/>
          </div>
          <div class="form__input-group">
              <label>Status</label>
              <select class="form__input" name="status" >
                  <option value="Unvaccinated" <?php echo $c_status=='Unvaccinated' ? 'selected':''?>>Unvaccinated</option>
                  <option value="Vaccinated" <?php echo $c_status=='Vaccinated' ? 'selected':''?>>Vaccinated</option>
              </select>
          </div>  
 
         
 
          <div class="form__input-group">
          <label>Barangay</label>
              <select class="form__input" name="barangay_id">
                <?php
                  if (count($barangay_list)>0) {
                    foreach ($barangay_list as $key => $value) {
                ?>  
                  <option value="<?php echo $value['id'] ?>" <?php echo $value['id']==$c_barangay?'selected':'' ?>>
                    <?php echo $value['name'] ?>
                  </option>  
                <?php
                    }
                  }
                ?> 
              </select> 
          </div>  
          <div class="form__input-group">
            <div class="form__text"><h3>Medical History</h3></div>
            <input value="<?php echo $c_height?>" type="text" class="form__input" name="height" placeholder="Height*" required/>    
            <input value="<?php echo $c_weight?>" type="text" class="form__input" name="weight" placeholder="Weight*" required/>    
            <input value="<?php echo $c_blood_type?>" type="text" class="form__input" name="blood_type" placeholder="Blood Type*" required/>    
            <input value="<?php echo $c_diagnosed_condition?>" type="text" class="form__input" name="diagnosed_condition" placeholder="Diagnosed Condition*" required/>    
            <input value="<?php echo $c_allergies?>" type="text" class="form__input" name="allergies" placeholder="Allergies*" required/>    
          </div>
          <button class="form__button" type="submit" name="submit">Update Patient Record</button> 
        </form> 

        <?php
          }
        ?>
        
      </div>
    </div>
  </div>
</div>
 
<?php 
include_once('../php-templates/admin-navigation-tail.php');
?>