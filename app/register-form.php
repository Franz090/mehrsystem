<?php

@include 'includes/config.php';

session_start();

// redirect if there is a logged in user
if (isset($_SESSION['usermail'])) 
   header('Location: ./dashboard');

$page_for_midwife = isset($_GET['type']) && $_GET['type']=="midwife";

if (!$page_for_midwife) { 
   $barangay_list = [];
   $select_brgy = "SELECT barangay_id id, health_center FROM barangays WHERE archived=0";
   $result_barangay = mysqli_query($conn, $select_brgy);
   if(mysqli_num_rows($result_barangay)>0)  {
      foreach($result_barangay as $row)  {
         $id = $row['id'];  
         $name = $row['health_center'];  
         array_push($barangay_list, array('id' => $id,'name' => $name));
      } 
      mysqli_free_result($result_barangay); 
   
   } 
   else  { 
      mysqli_free_result($result_barangay);
      $error = 'Something went wrong fetching data from the database.'; 
   }   
}

// register
if(isset($_POST['submit'])) { 
   $_POST['submit'] = null;
   $error = ''; 

   // get next user id
   $select_next_user_id = "SELECT COUNT(user_id) c FROM users;";  
   if($result_next_user_id =  mysqli_query($conn, $select_next_user_id) )   
      foreach ($result_next_user_id as $row)  
         $next_user_id = $row['c']+1; 
   
   $empty_user_details = empty(trim($_POST['usermail'])) || 
      empty(trim($_POST['password'])) || 
      empty(trim($_POST['cpassword'])) ||
      empty(trim($_POST['first_name'])) ||
      empty(trim($_POST['last_name']));
   // $empty_patient_details = empty(trim($_POST['civil_status'])) || 
   //    empty(trim($_POST['blood_type'])) || 
   //    empty(trim($_POST['weight'])) || 
   //    empty(trim($_POST['height_ft'])) || 
   //    empty(trim($_POST['height_in']));
   // $condition = $page_for_midwife?
   //    $empty_user_details:($empty_user_details || $empty_patient_details);
   if ($empty_user_details)
      $error .= 'Fill up input fields that are required (with * mark)! ';
   else { 
      $email = mysqli_real_escape_string($conn, $_POST['usermail']);
      $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
      $mid_name = mysqli_real_escape_string($conn, $_POST['mid_name']);
      $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
      $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
      $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword'])); 
      if (!$page_for_midwife) { 
         $civil_status = mysqli_real_escape_string($conn, ""); 
         $blood_type = mysqli_real_escape_string($conn, ""); 
         $weight = mysqli_real_escape_string($conn, 0); 
         $height_ft = mysqli_real_escape_string($conn, 0); 
         $height_in = mysqli_real_escape_string($conn, 0); 
         $barangay_id = mysqli_real_escape_string($conn, $_POST['barangay_id']);  
      }

      $select = "SELECT user_id FROM users WHERE email = '$email'";  
      $result = mysqli_query($conn, $select);
   
      if(mysqli_num_rows($result) > 0 || $pass != $cpass)  {
         if (mysqli_num_rows($result) > 0)
            $error .= 'User already exists. '; 
         if ($pass != $cpass)
            $error .= 'Passwords do not match! ';
         mysqli_free_result($result);
      } 
      else  {
         $insert = "";
         $insert .= ("INSERT INTO users(user_id, email, password, role)
         VALUES($next_user_id, '$email','$pass', ". ($page_for_midwife?"0":"-1")."); ");
         $insert .= "INSERT INTO user_details(user_id, first_name, middle_name, last_name)
            VALUES($next_user_id, '$first_name', '$mid_name', '$last_name'); ";
         if (!$page_for_midwife) { 
            $insert .= "INSERT INTO patient_details(user_id, civil_status, blood_type, weight, height_ft, height_in, barangay_id, status)
            VALUES($next_user_id, '$civil_status', '$blood_type', $weight, $height_ft, $height_in, $barangay_id, 0); ";
         }
         // echo $insert;
         if (mysqli_multi_query($conn, $insert))  {
            mysqli_free_result($result);
            header('location:index.php');  
         }
         else { 
            mysqli_free_result($result);
            $error .= 'Something went wrong registering user into the database.';
         }

      }  
   } 
}

$conn->close(); 

include_once('php-templates/admin-head.php');
include_once('php-templates/css/black-bg-remover.php');
?>
<!-- <style>
   #weight-height{
      background: #039b72;
      font-family: 'Open Sans',
         sans-serif;
         height: 100%;
      font-weight: 400;
   }
</style> -->

<div class="container" >
   <div class="row px-4"> 
      <div class="col-lg-12 col-xl-12 card flex-row mx-auto px-0" style="height: 550px;">

         <div class="img-left d-none col-sm-7 d-md-flex"></div>

         <div class="card-body d-flex flex-column ">
            <h4 class="title text-center mt-1" style="position: relative;top: 20px;">
               Create <?php echo $page_for_midwife?"Midwife":"Patient"; ?> Account
            </h4>
            
    
            <form class="form form-box px-3 d-flex flex-column" action="" method="post">
               
               <div class="text-center">
               <?php
                  if(isset($error)) 
                     echo '<span class="form__input-error-message">'.$error.'</span>'; 
               ?>
               </div>
               <div class="form-input-group mb-3" >
                  <input type="text"  class="rounded form-control form-control-md pb-2 pt-2" name="usermail" autofocus placeholder="Email Address*"  
                     tabindex="10" required>
               </div> 
 
               <!-- <div class="form-input"> --> 
               <div class="form-input-group mb-2" > 
                  <input class="rounded form-control form-control-md pb-2 pt-2 mb-1" type="text" name="first_name" placeholder="First Name*" 
                     tabindex="11" required>
                  <input class="rounded form-control form-control-md pb-2 pt-2 mb-1" type="text" name="mid_name" placeholder="Middle Name" 
                     tabindex="12" required>
                  <input type="text" class="rounded form-control form-control-md pb-2 pt-2 mb-1" name="last_name" placeholder="Last Name*" 
                     tabindex="13" required>
               </div>  
               <div class="form-input-group mb-2"> 
                  <input  class="rounded form-control form-control-md pb-2 pt-2 mb-1" type="password" name="password" 
                     placeholder="Password*" tabindex="14" required>
                  <input class="rounded form-control form-control-md pb-2 pt-2 mb-2" type="password"  name="cpassword" 
                     placeholder="Confirm password*" tabindex="15" required>
               </div>
               
               <?php if (!$page_for_midwife) {?>
                        <select class="form-select pb-2 pt-2" style="position: relative;bottom: 8px;" name="barangay_id" tabindex="16" >
                        <option selected disabled>Select Barangay Name</option>
                           <?php if (count($barangay_list)>0) {
                              foreach ($barangay_list as $key => $value) { ?>  
                                 <option value="<?php echo $value['id'] ?>" <?php echo $key===0?>>
                                    <?php echo $value['name'] ?>
                                 </option>  
                              <?php }
                           } ?> 
                        </select>
                     
                     <!-- <div class="form_select">
                        <label style="color:#333;">Tetanus Toxoid Vaccinated</label>
                        <select class="form_select_focus" name="tetanus">
                           <option value="0" selected>Unvaccinated</option>
                           <option value="1">Vaccinated</option> 
                        </select>
                     </div> 
                     <div class="form_select">
                        <label style="color:#333;">Nth Trimester</label>
                        <select class="form_select_focus" name="trimester">
                           <option value="0" selected>N/A</option>
                           <option value="1">1st (0-13 weeks)</option>
                           <option value="2">2nd (14-27 weeks)</option>
                           <option value="3">3rd (28-42 weeks)</option>
                        </select>
                     </div> 
                    <input class="mb-1" type="text" name="civil_status" 
                        placeholder="Civil Status*" tabindex="17" required>
                     <input class="mb-1" type="text"  name="blood_type" 
                        placeholder="Blood Type*" tabindex="18" required>
                     <div class="form_input-group" style="font-family:  'Open Sans', sans-serif;margin-bottom: 1rem;">
                        <label style="color:#333;">Height*</label>
                        <div class="d-flex input-group">
                        <input value="0" min='0' type="number" 
                           class="form__input form-control" name="height_ft" placeholder="Feet*" required/> 
                        <div class="input-group-postpend mb-3">
                           <div id="weight-height" class="input-group-text form__input text-white">ft</div>
                        </div> 
                        <input value="0" min='0' max='11' type="number" 
                        class="form__input form-control" name="height_in" placeholder="Inches*" required/>
                        <div class="input-group-postpend  mb-3">
                           <div id="weight-height" class=" input-group-text form__input text-white">inch(es)</div>
                        </div> 
                        </div>
                     </div>
                     <div class="form__input-group" style="font-family:  'Open Sans', sans-serif;margin-bottom: 1rem;">   
                        <label style="color:#333;">Weight*</label>
                        <div class="d-flex input-group">
                        <input value="0" type="number" class="form__input form-control" name="weight" placeholder="Weight*" 
                           required min="0"/>
                           <div class="input-group-postpend  mb-3">
                              <div id="weight-height" class="w-100 input-group-text form__input text-white">kg</div>
                           </div> 
                        </div>
                     </div> -->
                  
               <?php }?>

               <button  class="btn btn-primary w-100 btn text-capitalize btn-primary-md" 
                  value="register now" type="submit" name="submit">
                  Register <?php echo $page_for_midwife?"Midwife":"Patient"; ?></button> 

               
            </form>

            <div class="text-center mb-2 have-account" style="position: relative;top: 10px;">
               Already have an account?
               <a class="register-link text-decoration-none" href="index.php" id="linkLogin">
                  Sign in</a>
            </div> 
         </div>

      </div> 
   </div>
</div>

<?php include_once('php-templates/admin-tail.php'); ?>