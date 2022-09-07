<?php

@include '../includes/config.php';

session_start();

@include '../php-templates/redirect/admin-page-setter.php';
@include '../php-templates/redirect/not-for-nurse.php';


$session_id = $_SESSION['id'];

$patient_list = []; 
$medicine_list = [];
$treatment_list = []; 
$midwife_list = [];  



// user is a patient
// if ($admin==-1) {
//     // fetch midwife  
//     $select0 = "SELECT id, 
//         CONCAT(first_name,IF(mid_initial='', '', CONCAT(' ',mid_initial,'.')),' ',last_name) AS name
//         FROM users 
//         WHERE admin=0";
//     $result_midiwife = mysqli_query($conn, $select0);

//     if (mysqli_num_rows($result_midiwife)) {
//         foreach($result_midiwife as $row) {
//             $id = $row['id'];  
//             $name = $row['name'];  
//             array_push($midwife_list, array('id' => $id,'name' => $name));
//         } 
//         mysqli_free_result($result_midiwife);
//     } 
//     else  { 
//         mysqli_free_result($result_midiwife);
//         $error = 'Something went wrong fetching data from the database.'; 
//     }   

// }

// user is a midwife 
if ($admin==0) {
    @include '../php-templates/midwife/get-assigned-barangays.php';
    if (count($_barangay_list)>0) {
        // fetch patients  
        $barangay_select = '';
        $barangay_list_length_minus_1 = count($_barangay_list)-1;
        foreach ($_barangay_list as $key => $value) { 
            $barangay_select .= "details.barangay_id=$value ";
            if ($key < $barangay_list_length_minus_1) {
                $barangay_select .= "OR ";
            }
        }
        $select1 = "SELECT users.id, 
            CONCAT(first_name,IF(mid_initial='', '', CONCAT(' ',mid_initial,'.')),' ',last_name) AS name
            FROM users, details
            WHERE admin=-1 AND ($barangay_select) AND details.id=users.details_id";
        $result_patient = mysqli_query($conn, $select1);
        
        if (mysqli_num_rows($result_patient)) {
            foreach($result_patient as $row) {
            $id = $row['id'];  
            $name = $row['name'];  
            array_push($patient_list, array('id' => $id,'name' => $name));
            } 
            mysqli_free_result($result_patient);
            // print_r($result_barangay); 
        } 
        else  { 
            mysqli_free_result($result_patient);
            $error = 'Something went wrong fetching data from the database.'; 
        }   

        // fetch medicine
        $select2 = "SELECT id, name
            FROM treat_med 
            WHERE category=0";
        $result_medicine = mysqli_query($conn, $select2);


        if (mysqli_num_rows($result_medicine)) {
            foreach($result_medicine as $row) {
                $id = $row['id'];  
                $name = $row['name'];  
                array_push($medicine_list, array('id' => $id,'name' => $name));
            } 
            mysqli_free_result($result_medicine);
            // print_r($result_barangay); 
        } 
        else  { 
            mysqli_free_result($result_medicine);
            $error = 'Something went wrong fetching data from the database.'; 
        }   

        // fetch treatment
        $select3 = "SELECT id, name
            FROM treat_med 
            WHERE category=1";
        $result_treatment = mysqli_query($conn, $select3);


        if (mysqli_num_rows($result_treatment)) {
            foreach($result_treatment as $row) {
                $id = $row['id'];  
                $name = $row['name'];  
                array_push($treatment_list, array('id' => $id,'name' => $name));
            } 
            mysqli_free_result($result_treatment);
            // print_r($result_barangay); 
        } 
        else  { 
            mysqli_free_result($result_treatment);
            $error = 'Something went wrong fetching data from the database.'; 
        }   
    } 
} 

// add appointment
if(isset($_POST['submit'])) {
    $_POST['submit'] = null;
    $error = ''; 

    if (empty($_POST['date']) || 
    empty($_POST['t_date']) ||
    empty($_POST['p_date']))
    $error .= 'Fill up input fields that are required (with * mark)! ';
    else {  
        $current_user_is_a_midwife = $admin==0;
        $status = $current_user_is_a_midwife?1:0;
        // next treat_med_record id 
        $select_tmr = "SELECT * from treat_med_record";
        $treat_med_record = mysqli_query($conn, $select_tmr);
        $rows_tmr = mysqli_num_rows($treat_med_record)-1;
        mysqli_data_seek($treat_med_record,$rows_tmr);
        $row_tmr=mysqli_fetch_row($treat_med_record);
        $next_treat_r_id = $row_tmr[0] + 1;
        $next_med_r_id = $row_tmr[0] + 2; 
        // TODO: fix code for  patient 
        $a_date = mysqli_real_escape_string($conn, $_POST['date']);
        $patient_id = mysqli_real_escape_string($conn, ($current_user_is_a_midwife?$_POST['patient_id']:$session_id));
        $treatment_id = mysqli_real_escape_string($conn, $_POST['treatment_id']);
        $medicine_id = mysqli_real_escape_string($conn, $_POST['medicine_id']);
        $t_date = mysqli_real_escape_string($conn, $_POST['t_date']);
        $p_date = mysqli_real_escape_string($conn, $_POST['p_date']); 
        

        $insert1 = "INSERT INTO appointment(patient_id, midwife_id, treatment_record_id, medicine_record_id, date, status) 
        VALUES($patient_id, $session_id, $next_treat_r_id, $next_med_r_id, '$a_date', $status);";
        // treatment 
        $insert2 = "INSERT INTO treat_med_record(id, treat_med_id, date) 
        VALUES($next_treat_r_id, $treatment_id, '$t_date'); ";
        // medicine
        $insert3 = "INSERT INTO treat_med_record(id, treat_med_id, date) 
        VALUES($next_med_r_id, $medicine_id, '$p_date'); ";
        if (mysqli_multi_query($conn,"$insert1 $insert2 $insert3"))  { 
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
<style>
     h3{
    font-weight: 900;  
    background-color: #ececec;  
    padding-top: 10px;
    position: relative;
    top: 8px;
  }
  label {
    font-family: Arial, Helvetica, sans-serif;
  }  
  
  </style>


<div class="d-flex" id="wrapper"> 
  <!-- Sidebar -->
  <?php include_once('../php-templates/admin-navigation-left.php'); ?> 
  <!-- Page Content -->
  <div id="page-content-wrapper" >
    <?php include_once('../php-templates/admin-navigation-right.php'); ?>

    <div class="container-fluid">
      <div class="row bg-light m-3 "><h3>Add Appointment</h3>
      <div class="container default table-responsive pt-4 pb-5">
        <div class="col-md-8 col-lg-5 ">
        
        <?php if (count($_barangay_list)==0) { ?>
            You can't book an appointment because you are not assigned to any barangay.
        <?php } else if (count($patient_list)>0 && count($medicine_list)>0 && count($treatment_list)>0) { ?>
        <form class="form" action="" method="post" >
            <?php
                if(isset($error)) 
                    echo '<span class="form__input-error-message">'.$error.'</span>'; 
            ?> 
            <?php if($admin==0) { ?>
            <div class="form__input-group">
                <label>Patient</label>
                <select class="form__input" name="patient_id">
                    <?php
                        if (count($patient_list)>0) {
                            foreach ($patient_list as $key => $value) { 
                    ?> 
                        <option value="<?php echo $value['id'];?>" <?php echo $key===0?'selected':'';?>>
                            <?php echo $value['name'];?></option>
                    <?php  
                            }    
                        }
                    ?>  
                </select>
            </div> 
            <?php } 
                // else { 
            ?>
                <!-- <div class="form__input-group">
                    <label>Midwife</label>
                    <select class="form__input" name="midwife_id">
                        <?php
                            //if (count($midwife_list)>0) {
                                //foreach ($midwife_list as $key => $value) { 
                        ?> 
                            <option value="<?php //echo $value['id'];?>" <?php //echo $key===0?'selected':'';?>>
                                <?php //echo $value['name'];?></option>
                        <?php  
                                //}    
                            //}
                        ?>  
                    </select>
                </div>   -->
            <?php // } ?>
            <div class="form__input-group">
                <label>Appointment Date and Time*</label> 
                <input type="datetime-local" name="date" required class="form__input"/>
            </div>  
            <?php if($admin==0) { ?>
                <div class="form__input-group">
                
                    <label>Treatment Date*</label> 
                    <input type="date" name="t_date" required class="form__input"/>
                    <label>Treatment Type</label> 
                    <select class="form__input" name="treatment_id">
                        <?php
                            if (count($treatment_list)>0) {
                                foreach ($treatment_list as $key => $value) { 
                        ?> 
                            <option value="<?php echo $value['id'];?>" <?php echo $key===0?'selected':'';?>><?php echo $value['name'];?></option>
                        <?php  
                                }    
                            }
                        ?>  
                    </select>
                </div>  
                <div class="form__input-group">
                 
                    <label>Prescription Date*</label> 
                    <input type="date" name="p_date" required class="form__input"/>
                    <label>Medicine</label> 
                    <select class="form__input" name="medicine_id">
                        <?php
                            if (count($medicine_list)>0) {
                                foreach ($medicine_list as $key => $value) { 
                        ?> 
                            <option value="<?php echo $value['id'];?>" <?php echo $key===0?'selected':'';?>><?php echo $value['name'];?></option>
                        <?php  
                                }    
                            }
                        ?>  
                    </select>
                </div>  
            <?php } ?>
            <button class="form__button" type="submit" name="submit">Add Appointment</button> 
        </form> 
        <?php }else {  ?>
            There should be at least one patient, medicine, and treatment available in the database.
        <?php }  ?>
        </div>
        </div>  
      </div>
    </div>
  </div>
</div>

<?php 
include_once('../php-templates/admin-navigation-tail.php');
?>