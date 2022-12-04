<?php

@include '../includes/config.php';

session_start();

@include '../php-templates/redirect/admin-page-setter.php';
@include '../php-templates/redirect/patient-status-checker.php';
@include '../php-templates/redirect/not-for-nurse.php';
 

$session_id = $_SESSION['id']; 


// user is a midwife  
if ($current_user_is_a_midwife) {
    $patient_list = [];  
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
    @include '../php-templates/appointments/patient/trimester.php';
}


@include '../php-templates/appointments/submit-add-appointment.php';

$conn->close(); 

$page = 'add_appointment';
include_once('../php-templates/admin-navigation-head.php');
?>



<div class="container_nu"> 
  <!-- Sidebar -->
  <?php include_once('../php-templates/admin-navigation-left.php'); ?> 
  <!-- Page Content -->
  <div class="main_nu" >
    <?php include_once('../php-templates/admin-navigation-right.php'); ?>

    <div class="container-fluid">
      <div class="background-head row m-2 my-4"><h4 class="pb-3 m-3 fw-bolder ">Add Appointment</h4>
      <div class="container default p-4">
        <div class="col-md-8 col-lg-5">
        
        <?php 
            if ($current_user_is_a_midwife && count($_barangay_list)==0) { ?>
            You can't book an appointment because you are not assigned to any barangay.
        <?php } else if ($current_user_is_a_midwife && count($patient_list)>0 || $current_user_is_a_patient) { ?>
        <form class="form form-box px-3" style="bottom:100px;" action="" method="post" >
            <?php
                if(isset($error)) 
                    echo '<span class="form__input-error-message">'.$error.'</span>'; 
            ?> 
            <?php if($current_user_is_a_midwife) { ?>
            <div class=" mb-3">
                <label>Patient</label>
                <select  class="form-select"  name="patient_id_trimester">
                    <?php
                        if (count($patient_list)>0) {
                            foreach ($patient_list as $key => $value) { 
                    ?> 
                        <option class="option" value="<?php echo $value['id']."AND".$value['trimester'];?>" <?php echo $key===0?'selected':'';?>>
                            <?php echo $value['name'];?></option>
                    <?php  
                            }    
                        }
                    ?>  
                </select>
    
            </div> 
            <?php }  
            ?> 
            <div class="mb-3">
                <label>Appointment Date and Time*</label> 
                <div class="input-group date" id="datepicker">
                <input class="form-control option" type="datetime-local" name="date"/>
                    </div>
            </div>  
           
            <button class="w-100 btn  text-capitalize" type="submit" name="submit_appointment">Add Appointment</button> 
        </form> 
        <?php } else {
                if ($current_user_is_a_midwife) { ?>
            There should be at least one patient (under your assigned barangay) available in the database.
        <?php 
                } 
            }   
        ?>

 
        </div>
        </div>  
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
        $(function() {
            $('#datepicker').datepicker();
        });
    </script>


<?php 
include_once('../php-templates/admin-navigation-tail.php');
?>