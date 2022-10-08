<?php 
@include '../includes/config.php';

session_start();

@include '../php-templates/redirect/admin-page-setter.php';
@include '../php-templates/redirect/midwife-only.php';


$session_id = $_SESSION['id'];

// fetch consultation to edit 
$id_from_get = $_GET['id'];
$select_c_to_edit = "SELECT 
    CONCAT(d.first_name,IF(d.middle_name='' OR middle_name IS NULL, '', CONCAT(' ',SUBSTRING(d.middle_name,1,1),'.')),' ',d.last_name) AS name,
    c.trimester, date, treatment_id, prescription_id
FROM users u, user_details d, patient_details p, consultations c
WHERE u.user_id=d.user_id AND c.consultation_id=$id_from_get AND 
    c.patient_id=u.user_id AND c.midwife_appointed=$session_id";

if ($result_c_to_edit = mysqli_query($conn, $select_c_to_edit)) {
    foreach($result_c_to_edit as $row) {
        $m_name = $row['name'];   
        $m_trimester = $row['trimester'];   
        $m_date = $row['date'];   
        $m_treatment_id = $row['treatment_id'];   
        $m_prescription_id = $row['prescription_id'];    
    } 
    mysqli_free_result($result_c_to_edit);
} 
else  { 
    $error = 'Something went wrong fetching data from the database.'; 
}   

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
// update
if(isset($_POST['submit'])) {
    $_POST['submit'] = null;
    $error = ''; 

    if (empty($_POST['date']))
        $error .= 'Fill up input fields that are required (with * mark)! ';
    else {    
        // $patient_arr = explode("AND",$_POST['patient_id']);
        // $patient_id = mysqli_real_escape_string($conn, ($patient_arr[0]));
        $trimester = mysqli_real_escape_string($conn, $_POST['trimester']);

        $treatment_id = mysqli_real_escape_string($conn, empty($_POST['treatment_id'])?'NULL':$_POST['treatment_id']);
        $prescription_id = mysqli_real_escape_string($conn, empty($_POST['prescription_id'])?'NULL':$_POST['prescription_id']);
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
            $up = "UPDATE consultations SET trimester=$trimester, treatment_id=$treatment_id, 
                prescription_id=$prescription_id, date='$date';";
       
            // $alert_str = $pr_page?'Prescription':'Treatment';
             // echo $insert;
            if (mysqli_query($conn, $up))  { 
                echo "<script>alert('Consultation Updated!');</script>"; 
                header("Location: view-consultations.php");
            }
            else {  
                $error .= 'Something went wrong updating the appointment to the database.';
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
      <div class="row bg-light m-3 "><h3>Update Consultation Record of <?php echo $m_name?></h3>
      <div class="container default table-responsive pt-4 pb-5">
        <div class="col-md-8 col-lg-5">
        
        <?php 
            if (count($_barangay_list)==0) { ?>
            You can't give consultations because you are not assigned to any barangay.
        <?php } else if (count($patient_list)>0) { ?>
        <form class="form" action="" method="post" enctype="multipart/form-data">
            <?php
                if(isset($error)) 
                    echo '<span class="form__input-error-message">'.$error.'</span>'; 
            ?> 
            <!-- <div class="form__input-group">
                <label>Patient</label>
                <select class="form__input" name="patient_id">
                    <?php
                        // if (count($patient_list)>0) {
                        //     foreach ($patient_list as $key => $value) { 
                    ?> 
                        <option value="<?php //echo $value['id'];?>AND<?php //echo $value['trimester'];?>" <?php //echo $key===0?'selected':'';?>>
                            <?php //echo $value['name'];?></option>
                    <?php  
                        //     }    
                        // }
                    ?>  
                </select>
            </div>  -->
            <div class="form__input-group">
                <label>Consultation Date and Time*</label> 
                <input type="datetime-local" name="date" required class="form__input" value="<?php echo $m_date?>"/>
                <label>Prescription</label> 
                <select class="form__input" name="prescription_id">
                    <option value="" selected>None</option>
                    <?php
                        if (count($prescription_list)>0) {
                            foreach ($prescription_list as $key => $value) { 
                    ?> 
                        <option value="<?php echo $value['id'];?>" 
                            <?php echo $value['id']==$m_prescription_id?"selected":"" ?>>
                            <?php echo $value['name'];?>
                        </option>
                    <?php  
                            }    
                        }  
                    ?>  
                </select> 
                <label>Treatment</label> 
                <select class="form__input" name="treatment_id">
                    <option value="" selected>None</option>
                    <?php
                        if (count($treatment_list)>0) {
                            foreach ($treatment_list as $key => $value) { 
                    ?> 
                        <option value="<?php echo $value['id'];?>"
                            <?php echo $value['id']==$m_treatment_id?"selected":"" ?>>
                        <?php echo $value['name'];?></option>
                    <?php  
                            }    
                        }  
                    ?>  
                </select> 

                <label>Trimester</label>   
                <select class="form__input" name="trimester">
                    <option value="0" <?php echo 0==$m_trimester?"selected":"" ?>>N/A</option>
                    <option value="1" <?php echo 1==$m_trimester?"selected":"" ?>>1st (0-13 weeks)</option>
                    <option value="2" <?php echo 2==$m_trimester?"selected":"" ?>>2nd (14-27 weeks)</option>
                    <option value="3" <?php echo 3==$m_trimester?"selected":"" ?>>3rd (28-42 weeks)</option>
                </select> 
                <!-- <label for='treatment_file'>Treatment File</label> 
                <input type="file" id="treatment_file" name="treatment_file"  class="form__input"/> -->
            </div>   

          
            <button class="form__button" type="submit" name="submit">Update Consultation Record</button> 
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