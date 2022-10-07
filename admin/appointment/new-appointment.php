<?php

@include '../includes/config.php';

session_start();

@include '../php-templates/redirect/admin-page-setter.php';
@include '../php-templates/redirect/not-for-nurse.php';


$session_id = $_SESSION['id'];

$patient_list = [];    

// user is a midwife 
if ($admin==0) {
    @include '../php-templates/midwife/get-assigned-barangays.php';
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
        $result_patient = mysqli_query($conn, $select1);
        
        if (mysqli_num_rows($result_patient)) {
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
} // user is patient 
else {
    $select_trimester = "SELECT trimester FROM users u, patient_details p, user_details ud
        WHERE u.user_id=$session_id AND p.user_id=u.user_id AND ud.user_id=u.user_id";
    $result_trimester = mysqli_query($conn, $select_trimester);
// echo $select_trimester;
    if (mysqli_num_rows($result_trimester)) {
        foreach($result_trimester as $row) {  
        $trimester_from_db = $row['trimester'];  
        } 
        mysqli_free_result($result_trimester);
    } 
    else  { 
        mysqli_free_result($result_trimester);
        $error = 'Something went wrong fetching data from the database.'; 
    }    
}


$current_user_is_a_midwife = $admin==0;
// add appointment
if(isset($_POST['submit'])) {
    $_POST['submit'] = null;
    $error = ''; 

    if (empty($_POST['date']))
        $error .= 'Fill up input fields that are required (with * mark)! ';
    else {   
        if ($current_user_is_a_midwife) { 
            $id_trimester_split = explode('AND',$_POST['patient_id_trimester']); 
            // echo $id_trimester_split[0];
            // echo $id_trimester_split[1];
        }
        $status = $current_user_is_a_midwife?1:0; 
        $a_date = mysqli_real_escape_string($conn, $_POST['date']);
        $patient_id = mysqli_real_escape_string($conn, ($current_user_is_a_midwife?$id_trimester_split[0]:$session_id));
        $trimester_post = mysqli_real_escape_string($conn, ($current_user_is_a_midwife?$id_trimester_split[1]:$trimester_from_db));
 
        

        $insert1 = "INSERT INTO appointments(patient_id, date, status, trimester) 
            VALUES($patient_id, '$a_date', $status, $trimester_post);";
        if (mysqli_query($conn,"$insert1"))  { 
        echo "<script>alert('Appointment Added!');</script>"; 
        }
        else {  
            $error .= 'Something went wrong adding the appointment to the database.';
        }  
    }  
} 

$conn->close(); 

$page = 'add_appointment';
include_once('../php-templates/admin-navigation-head.php');
?>



<div class="d-flex" id="wrapper"> 
  <!-- Sidebar -->
  <?php include_once('../php-templates/admin-navigation-left.php'); ?> 
  <!-- Page Content -->
  <div id="page-content-wrapper" >
    <?php include_once('../php-templates/admin-navigation-right.php'); ?>

    <div class="container-fluid">
      <div class="background-head row m-2 my-4"><h4 class="m-2 fw-bolder ">Add Appointment</h4>
      <div class="container default p-4">
        <div class="col-md-8 col-lg-5">
        
        <?php 
            if ($admin==0 && count($_barangay_list)==0) { ?>
            You can't book an appointment because you are not assigned to any barangay.
        <?php } else if ($admin==0 && count($patient_list)>0 || $admin==-1) { ?>
        <form class="form form-box px-3" style="bottom:100px; action="" method="post" >
            <?php
                if(isset($error)) 
                    echo '<span class="form__input-error-message">'.$error.'</span>'; 
            ?> 
            <?php if($admin==0) { ?>
            <div class="form_select-group">
                <label>Patient</label>
                <div class="form_select">
                <select class="form_select_focus" autofocus name="patient_id_trimester">
                    <?php
                        if (count($patient_list)>0) {
                            foreach ($patient_list as $key => $value) { 
                    ?> 
                        <option value="<?php echo $value['id']."AND".$value['trimester'];?>" <?php echo $key===0?'selected':'';?>>
                            <?php echo $value['name'];?></option>
                    <?php  
                            }    
                        }
                    ?>  
                </select>
                    </div>
            </div> 
            <?php }  
            ?> 
            <div class="form__select-group">
                <label>Appointment Date and Time*</label> 
                <div class="form-input">
                <input type="datetime-local" name="date" required />
                    </div>
            </div>  
           
            <button class="w-100 btn  text-capitalize" type="submit" name="submit">Add Appointment</button> 
        </form> 
        <?php }else {
            if ($admin==0)  ?>
            There should be at least one patient (under your assigned barangay) available in the database.
        <?php }   
        ?>

 
        </div>
        </div>  
      </div>
    </div>
  </div>
</div>

<?php 
include_once('../php-templates/admin-navigation-tail.php');
?>