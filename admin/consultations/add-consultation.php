<?php 
@include '../includes/config.php';

session_start();

@include '../php-templates/redirect/admin-page-setter.php';
@include '../php-templates/redirect/midwife-only.php';


$session_id = $_SESSION['id'];

$patient_list = [];  
$treatment_list = []; 
$prescription_list = []; 
 
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
    $select1 = "SELECT users.user_id id, trimester,
        CONCAT(d.first_name,IF(d.middle_name='' OR middle_name IS NULL, '', CONCAT(' ',SUBSTRING(d.middle_name,1,1),'.')),' ',d.last_name) AS name
        FROM users, user_details d, patient_details p
        WHERE role=-1 AND ($barangay_select) AND d.user_id=users.user_id AND p.user_id=users.user_id";
    
    // echo $select1;
    if ($result_patient = mysqli_query($conn, $select1)) {
        foreach($result_patient as $row) {
            $id = $row['id'];  
            $trimester = $row['trimester'];  
            $name = $row['name'];  
            array_push($patient_list, array('id' => $id,
            'name' => $name,
            'trimester' => $trimester
        ));
        } 
        mysqli_free_result($result_patient);
    } 
    else  { 
        $error = 'Something went wrong fetching data from the database.'; 
    }   

    // fetch medicine
    $select2 = "SELECT treat_med_id id, name
        FROM treat_med 
        WHERE type=0;";  

    if ($result_m = mysqli_query($conn, $select2)) {
        foreach($result_m as $row) {
            $id = $row['id'];  
            $name = $row['name'];  
            array_push($prescription_list, array('id' => $id,'name' => $name));
        } 
        mysqli_free_result($result_m);
    } 
    else  {  
        $error = 'Something went wrong fetching data from the database.'; 
    }    
    // fetch treatment
    $select3 = "SELECT treat_med_id id, name
        FROM treat_med 
        WHERE type=1;";  

    if ($result_t = mysqli_query($conn, $select3)) {
        foreach($result_t as $row) {
            $id = $row['id'];  
            $name = $row['name'];  
            array_push($treatment_list, array('id' => $id,'name' => $name));
        } 
        mysqli_free_result($result_t);
    } 
    else  {  
        $error = 'Something went wrong fetching data from the database.'; 
    }    
}  
// add  
if(isset($_POST['submit'])) {
    $_POST['submit'] = null;
    $error = ''; 

    if (empty($_POST['date']))
        $error .= 'Fill up input fields that are required (with * mark)! ';
    else {    
        $patient_arr = explode("AND",$_POST['patient_id']);
        $patient_id = mysqli_real_escape_string($conn, ($patient_arr[0]));
        $patient_trimester = mysqli_real_escape_string($conn, ($patient_arr[1]));

        $t_id = mysqli_real_escape_string($conn, empty($_POST['treatment_id'])?'NULL':$_POST['treatment_id']);
        $m_id = mysqli_real_escape_string($conn, empty($_POST['prescription_id'])?'NULL':$_POST['prescription_id']);
        $date = mysqli_real_escape_string($conn, $_POST['date']); // ex: 2022-09-24T00:55
        //$date_arr = explode('T',$date); // ex: ['2022-09-24', '00:55']
         
        // if (isset($_FILES['treatment_file']) && $_FILES['treatment_file']['error']!==4) { // error 4 is no file
        //     $tp_treatment_file = $_FILES['treatment_file'];
        //     // print_r($tp_treatment_file);
        //     $file_name_arr = explode('.', $tp_treatment_file['name']);
        //     $file_ext = end($file_name_arr);

        //     if ($tp_treatment_file['type']=='image/jpeg' || $tp_treatment_file['type']=='image/png') {
        //         if ($tp_treatment_file['error']===0) {
        //             // 5MB max file size 
        //             if ($tp_treatment_file['size']<=5000000) {
        //                 $new_file_name = 'treatment_file-'. $date_arr[0] . $patient_id.$tm_id.'.'.$file_ext ;
        //                 $treatment_file = mysqli_real_escape_string($conn, $new_file_name);
        //                 $file_destination = 'uploaded treatment files/'. $new_file_name;
        //                 move_uploaded_file($tp_treatment_file['tmp_name'], $file_destination);
        //             } else {
        //                 $error .= "File size too big. We only accept 5MB files or lower.";
        //             }
        //         } else {
        //             $error .= "Error: (".$tp_treatment_file['error'].")";
        //         }
        //     }else {
        //         $error .= 'We only accept image/jpeg or image/png.';
        //     }
        // }
        // // no file selected
        // else { 
        //    $treatment_file = NULL;
        //}
        
       
        if ($error==='') {
            
            // $alert_str = $pr_page?'Prescription':'Treatment';
            $insert = "INSERT INTO consultations(patient_id, date, treatment_id, prescription_id, treatment_file, midwife_appointed, trimester) 
            VALUES($patient_id, '$date', $t_id, $m_id, NULL, $session_id, $patient_trimester);";
            // echo $insert;
            if (mysqli_query($conn, $insert))  { 
                echo "<script>alert('Consultation Added!');</script>"; 
            }
            else {  
                $error .= 'Something went wrong adding the appointment to the database.';
            }  
        }
       
    }  
} 

$conn->close(); 

$page = 'add_consultation';

include_once('../php-templates/admin-navigation-head.php');
?>


<div class="d-flex" id="wrapper"> 
  <!-- Sidebar -->
  <?php include_once('../php-templates/admin-navigation-left.php'); ?> 
  <!-- Page Content -->
  <div id="page-content-wrapper" >
    <?php include_once('../php-templates/admin-navigation-right.php'); ?>

    <div class="container-fluid">
      <div class="background-head row m-2 my-4"><h4 class="pb-3 m-3 fw-bolder ">Create Consultation Record</h4><hr>
      <div class="container default table-responsive p-4">
            <div class="col-md-8 col-lg-5 ">
        
        <?php 
            if (count($_barangay_list)==0) { ?>
            You can't give consultations because you are not assigned to any barangay.
        <?php } else if (count($patient_list)>0) { ?>
        <form class="form form-box px-3" action="" method="post" enctype="multipart/form-data">
            <?php
                if(isset($error)) 
                    echo '<span class="form__input-error-message">'.$error.'</span>'; 
            ?> 
            <div class="form__input-group">
                <div class="form_select">
                <label>Patient</label>
                <select class="form_select_focus" name="patient_id">
        </div>
                    <?php
                        if (count($patient_list)>0) {
                            foreach ($patient_list as $key => $value) { 
                    ?> 
                        <option value="<?php echo $value['id'];?>AND<?php echo $value['trimester'];?>" <?php echo $key===0?'selected':'';?>>
                            <?php echo $value['name'];?></option>
                    <?php  
                            }    
                        }
                    ?>  
                </select>
            </div> 
            <div class="form-input">
                <label>Consultation Date and Time*</label> 
                <input type="datetime-local" name="date" required />
                    </div>
            <div class="form_select">     
                <label>Prescription</label> 
                <select class="form__select_focus" name="prescription_id">
                    <option value="" selected>None</option>
                    <?php
                        if (count($prescription_list)>0) {
                            foreach ($prescription_list as $key => $value) { 
                    ?> 
                        <option value="<?php echo $value['id'];?>"><?php echo $value['name'];?></option>
                    <?php  
                            }    
                        }  
                    ?>  
                </select> 
                    </div>
              <div class="form_select">             
                <label>Treatment</label> 
                <select class="form__input" name="treatment_id">
                    <option value="" selected>None</option>
                    <?php
                        if (count($treatment_list)>0) {
                            foreach ($treatment_list as $key => $value) { 
                    ?> 
                        <option value="<?php echo $value['id'];?>"><?php echo $value['name'];?></option>
                    <?php  
                            }    
                        }  
                    ?>  
                </select> 
                <!-- <label for='treatment_file'>Treatment File</label> 
                <input type="file" id="treatment_file" name="treatment_file"  class="form__input"/> -->
                    </div>
            </div>   

          
            <button class="w-100 btn  text-capitalize" type="submit" name="submit">Create Consultation Record</button> 
        </form> 
        <?php } else {   ?>
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