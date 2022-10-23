<?php 
// header('location:../');
@include '../includes/config.php';

session_start();

@include '../php-templates/redirect/admin-page-setter.php';
@include '../php-templates/redirect/midwife-only.php';
 
// $barangay_id_to_be_used = $_SESSION['barangay_id'];
 
// fetch barangays  
// $barangay_list = [];

// $select = "SELECT * FROM barangay";
// $result_barangay = mysqli_query($conn, $select);

// if(mysqli_num_rows($result_barangay)>0)  {
//   foreach($result_barangay as $row)  {
//     $id = $row['id'];  
//     $name = $row['health_center'];  
//     array_push($barangay_list, array('id' => $id,'name' => $name));
//   } 
//   mysqli_free_result($result_barangay);
//   // print_r($result_barangay);

// } 
// else  { 
//   mysqli_free_result($result_barangay);
//   $error = 'Something went wrong fetching data from the database.'; 
// }  

// fetch user 
$id_from_get = $_GET['id'];
$user_to_edit = "SELECT  user_id id, family_history, civil_status, 
    height_ft, height_in, weight, blood_type, diagnosed_condition, allergies,
    tetanus, trimester 
   FROM users u, user_details ud, patient_details pd
   WHERE u.user_id = $id_from_get AND u.user_id = ud.user_id AND u.user_id = pd.user_id";
 

if ($user_from_db = mysqli_query($conn, $user_to_edit)) {
  foreach($user_from_db as $row)  {

    $c_id = $row['id'];
    $c_height_ft = $row['height_ft'];
    $c_height_in = $row['height_in'];
    $c_civil_status = $row['civil_status'];
    $c_weight = $row['weight'];
    $c_blood_type = $row['blood_type'];
    $c_diagnosed_condition = $row['diagnosed_condition'];
    $c_allergies = $row['allergies'];

    $c_tetanus = $row['tetanus'];
    $c_trimester = $row['trimester'];

  }  
  mysqli_free_result($user_from_db);
 
//   if ($barangay_id_to_be_used!=$c_barangay) { 
//     header('location: ./view-midwife.php?edit=0');
//   }  
 
} 
else {
  $no_user = 'No such user.'; 
}


// edit
if(isset($_POST['submit'])) {
  $_POST['submit'] = null;
  $error = ''; 

  if ( 
    empty($_POST['height_ft']) &&
    empty($_POST['height_in']) ||
    empty($_POST['weight']) ||
    empty($_POST['civil_status']) ||
    empty($_POST['blood_type'])  
    )
    $error .= 'Fill up input fields that are required (with * mark)! ';
  else {  
    $height_ft = mysqli_real_escape_string($conn, $_POST['height_ft']);
    $height_in = mysqli_real_escape_string($conn, $_POST['height_in']);
    $weight = mysqli_real_escape_string($conn, $_POST['weight']);
    $blood_type = mysqli_real_escape_string($conn, $_POST['blood_type']);
    $civil_status = mysqli_real_escape_string($conn, $_POST['civil_status']);
    $diagnosed_condition = 
      empty($_POST['diagnosed_condition'])?"NULL":
      "'".mysqli_real_escape_string($conn, $_POST['diagnosed_condition'])."'"; 
    $family_history = 
      empty($_POST['family_history'])?"NULL":
      "'".mysqli_real_escape_string($conn, $_POST['family_history'])."'"; 
    $allergies = 
      empty($_POST['allergies'])?"NULL":
      "'".mysqli_real_escape_string($conn, $_POST['allergies'])."'"; 

    $tetanus = mysqli_real_escape_string($conn, $_POST['tetanus']);
    $trimester = mysqli_real_escape_string($conn, $_POST['trimester']); 
    
    $up = "";
     
    $up .= "UPDATE patient_details SET civil_status='$civil_status', 
      height_ft=$height_ft, height_in=$height_in, weight=$weight,
      blood_type='$blood_type', diagnosed_condition=$diagnosed_condition, family_history=$family_history,
      allergies=$allergies, trimester=$trimester, tetanus=$tetanus
      WHERE user_id=$c_id ; "; 

    $delete_contact_numbers = "DELETE FROM contacts 
      WHERE owner_id=$c_id;"; 

    $add_contact_numbers = "";
    $contacts_count = count($new_contacts);
    $contacts_count_minus_one = $contacts_count-1;
    if ($contacts_count>0) {
      $add_contact_numbers .= "INSERT INTO contacts(mobile_number, owner_id, type) VALUES ";
      foreach ($new_contacts as $key => $value) { 
        // echo " v: $value ";
        $ins = "('".mysqli_real_escape_string($conn, $value)."', $c_id, 1)"; 
        $add_contact_numbers .= $ins;
        $add_contact_numbers .= ($key===$contacts_count_minus_one)?";":",";
      }
    }

    if (mysqli_multi_query($conn, "$up $delete_contract_numbers $add_contact_numbers"))  {
        // echo "<script>alert('Patient Record Updated!');</script>"; 
        $conn->close(); 
        header('location:view-patients.php');  
    }else {
        $error .= 'Something went wrong updating the patient in the database.';
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
  <div id="page-content-wrapper" >
    <?php include_once('../php-templates/admin-navigation-right.php'); ?>

    <div class="container-fluid">
      <div class="row bg-light m-3"><h3>Update Patient Record</h3>
        <?php
          if (isset($no_user))  
            echo '<span class="text-danger">'.$no_user.'</span>';
          else   {
        ?> 
            <div class="container default table-responsive p-4">
              <div class="col-md-8 col-lg-5 ">  
                <form class="form" action="" method="post">
                  <?php 
                    if (isset($error))  
                      echo '<span class="form__input-error-message">'.$error.'</span>'; 
                  ?>  
                  <!-- <div class="form__input-group">
                    <div class="form__text"><label>Medical History</label></div>
                  </div> -->
                  <div class="form__input-group">
                    Height*
                    <input value="<?php echo $c_height_ft?>" min='0' type="number" 
                      class="form__input" name="height_ft" placeholder="Feet*" required/> ft
                    <input value="<?php echo $c_height_in?>" min='0' max='11' type="number" 
                      class="form__input" name="height_in" placeholder="Inches*" required/> inch(es) 
                  </div>
                  <div class="form__input-group"> 
                    Weight*   
                    <input value="<?php echo $c_weight?>" type="number" class="form__input" name="weight" 
                      placeholder="Weight*" required min='0'/> kg
                  </div>
                  <div class="form__input-group">    
                    <input value="<?php echo $c_civil_status?>" type="text" 
                      class="form__input" name="civil_status" placeholder="Civil Status*" required/>
                  </div>
                  <div class="form__input-group">    
                    <input value="<?php echo $c_blood_type?>" type="text" 
                      class="form__input" name="blood_type" placeholder="Blood Type*" required/>
                  </div>
                  <div class="form__input-group">    
                    <input value="<?php echo $c_diagnosed_condition?>" type="text" 
                      class="form__input" name="diagnosed_condition" placeholder="Diagnosed Condition" />
                  </div>
                  <div class="form__input-group">    
                    <input value="<?php echo $c_family_history?>" type="text" 
                      class="form__input" name="family_history" placeholder="Family History" />
                  </div>
                  <div class="form__input-group"> 
                    <input value="<?php echo $c_allergies?>" type="text" 
                      class="form__input" name="allergies" placeholder="Allergies" />    
                  </div>
                  <div class="form__input-group">
                      <label>Tetanus Toxoid Vaccinated</label>
                      <select class="form__input" name="tetanus">
                        <option value="0" <?php echo $c_tetanus==0?'selected':''?> >Unvaccinated</option>
                        <option value="1" <?php echo $c_tetanus==1?'selected':''?> >Vaccinated</option> 
                      </select>
                  </div> 
                  <div class="form__input-group">
                      <label>Nth Trimester</label>
                      <select class="form__input" name="trimester">
                        <option value="0" <?php echo $c_trimester==0?'selected':''?> >N/A</option>
                        <option value="1" <?php echo $c_trimester==1?'selected':''?> >1st (0-13 weeks)</option>
                        <option value="2" <?php echo $c_trimester==2?'selected':''?> >2nd (14-27 weeks)</option>
                        <option value="3" <?php echo $c_trimester==3?'selected':''?> >3rd (28-42 weeks)</option>
                      </select>
                  </div> 
                  <button class="form__button" type="submit" name="submit">Update Patient Record</button> 
                </form> 
              </div>
            </div>
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