<?php

@include '../includes/config.php';

session_start();

@include '../php-templates/redirect/admin-page-setter.php';
@include '../php-templates/redirect/not-for-nurse.php';


$session_id = $_SESSION['id'];

$patient_list = [];  



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
        $status = $current_user_is_a_midwife?1:0; 
        $a_date = mysqli_real_escape_string($conn, $_POST['date']);
        $patient_id = mysqli_real_escape_string($conn, ($current_user_is_a_midwife?$_POST['patient_id']:$session_id));
 
        

        $insert1 = "INSERT INTO appointment(patient_id, date, status) 
            VALUES($patient_id, '$a_date', $status);";
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
        <div class="col-md-8 col-lg-5">
        
        <?php 
            if ($admin==0 && count($_barangay_list)==0) { ?>
            You can't book an appointment because you are not assigned to any barangay.
        <?php } else if ($admin==0 && count($patient_list)>0 || $admin==-1) { ?>
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
            ?> 
            <div class="form__input-group">
                <label>Appointment Date and Time*</label> 
                <input type="datetime-local" name="date" required class="form__input"/>
            </div>  
           
            <button class="form__button" type="submit" name="submit">Add Appointment</button> 
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