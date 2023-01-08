<?php 
// header('location: ../'); 
@include '../includes/config.php';

session_start();

@include '../php-templates/redirect/admin-page-setter.php';
@include '../php-templates/redirect/midwife-only.php';


$session_id = $_SESSION['id'];
$session_id_str = ($admin==0?"":("AND u.user_id=". $session_id)) ;
// fetch consultation to edit 
$id_from_get = $_GET['id'];
$select_c_to_edit = "SELECT u.user_id u_id, c.consultation_id c_id,
    CONCAT(d.first_name,IF(d.middle_name='' OR d.middle_name IS NULL, '', CONCAT(' ',SUBSTRING(d.middle_name,1,1),'.')),' ',d.last_name) AS name,
    date, prescription, c.trimester, 
    gestation, blood_pressure, c.weight, c.height_ft, c.height_in, nutritional_status,
    status_analysis, advice, change_plan, date_return
FROM users u, user_details d, patient_details p, consultations c
WHERE u.user_id=d.user_id AND c.consultation_id=$id_from_get AND 
    c.patient_id=u.user_id $session_id_str";
// echo $select_c_to_edit;
if ($result_c_to_edit = mysqli_query($conn, $select_c_to_edit)) {
    foreach($result_c_to_edit as $row) {
        $m_name = $row['name'];   
        $m_u_id = $row['u_id'];   
        $m_c_id = $row['c_id'];   
        $m_trimester = $row['trimester'];   
        // $m_treatment_file = $row['treatment_file']==null?"":substr($row['treatment_file'],15); 
        $m_date = $row['date'];   
        // $m_treatment = $row['treatment'];   
        $m_gestation = $row['gestation'];    
        $m_prescription = $row['prescription'];    

        $m_blood_pressure = $row['blood_pressure'];    
        $m_weight = $row['weight'];    
        $m_height_ft = $row['height_ft'];    
        $m_height_in = $row['height_in']; 

        $m_nutritional_status = $row['nutritional_status'];    
        $m_status_analysis = $row['status_analysis'];    
        $m_advice = $row['advice'];    
        $m_change_plan = $row['change_plan'];    
        $m_date_return = $row['date_return'];    
    } 
    mysqli_free_result($result_c_to_edit);
} 
else  { 
    $error = 'Something went wrong fetching data from the database.'; 
}   

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
    $select1 = "SELECT users.user_id id, trimester, 
        CONCAT(d.first_name,IF(d.middle_name='' OR d.middle_name IS NULL, '', CONCAT(' ',SUBSTRING(d.middle_name,1,1),'.')),' ',d.last_name) AS name
        FROM users, user_details d, patient_details p
        WHERE role=-1 AND ($barangay_select) AND d.user_id=users.user_id AND p.user_id=users.user_id";
    
    // echo $select1;
    if ($result_patient = mysqli_query($conn, $select1)) {
        foreach($result_patient as $row) {
            $id = $row['id'];  
            array_push($patient_list, array('id' => $id));
        } 
        mysqli_free_result($result_patient);
    } 
    else  { 
        $error = 'Something went wrong fetching data from the database.'; 
    }    
}  
// update
if(isset($_POST['submit'])) {
    $_POST['submit'] = null;
    $error = ''; 

    if ((empty($_POST['date']) || empty($_POST['date_return'])))
        $error .= 'Fill up input fields that are required (with * mark)! ';
    else {
        // $patient_arr = explode("AND",$_POST['patient_id']);
        // $patient_id = mysqli_real_escape_string($conn, ($patient_arr[0]));
        // if ($admin==0) {
            // $treatment = empty($_POST['treatment'])?'NULL':("'".mysqli_real_escape_string($conn, $_POST['treatment'])."'");
        $trimester = mysqli_real_escape_string($conn, $_POST['trimester']); 
        $prescription = empty($_POST['prescription'])?'NULL':
            ("'".mysqli_real_escape_string($conn, $_POST['prescription'])."'");
        $date = mysqli_real_escape_string($conn, $_POST['date']); // ex: 2022-09-24T00:55
        $gestation = mysqli_real_escape_string($conn, $_POST['gestation']);
        $blood_pressure = mysqli_real_escape_string($conn, $_POST['blood_pressure']);
        $weight = mysqli_real_escape_string($conn, $_POST['weight']);
        $height_ft = mysqli_real_escape_string($conn, $_POST['height_ft']);
        $height_in = mysqli_real_escape_string($conn, $_POST['height_in']); 
        
        $nutritional_status = mysqli_real_escape_string($conn, $_POST['nutritional_status']);
        $status_analysis = mysqli_real_escape_string($conn, $_POST['status_analysis']);
        $advice = mysqli_real_escape_string($conn, $_POST['advice']);
        $change_plan = mysqli_real_escape_string($conn, $_POST['change_plan']);
        $date_return = mysqli_real_escape_string($conn, $_POST['date_return']); // ex: 2022-09-24T00:55
        // }
        // else {
            // $date = mysqli_real_escape_string($conn, $m_date); // ex: 2022-09-24T00:55
            // $date_arr = explode(' ',$date); // ex: ['2022-09-24', '00:55']
         
            // if (isset($_FILES['treatment_file']) && $_FILES['treatment_file']['error']!==4) { // error 4 is no file
            //     $tp_treatment_file = $_FILES['treatment_file'];
            //     // print_r($tp_treatment_file);
            //     $file_name_arr = explode('.', $tp_treatment_file['name']);
            //     $file_ext = end($file_name_arr);

            //     if ($tp_treatment_file['type']=='image/jpeg' || $tp_treatment_file['type']=='image/png') {
            //         if ($tp_treatment_file['error']===0) {
            //             // 5MB max file size 
            //             if ($tp_treatment_file['size']<=5000000) {
            //                 $destination_path = getcwd().DIRECTORY_SEPARATOR;
            //                 $new_file_name = 'treatment_file-'. $date_arr[0] . $m_u_id.$m_treatment.'.'.$file_ext ;
            //                 $treatment_file = "'". mysqli_real_escape_string($conn, $new_file_name) . "'";
            //                 $file_destination = "uploaded treatment files/" . $new_file_name;
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
            //     $treatment_file = 'NULL';
            // }
        // }
     
        
       
        // if ($error==='') {
        $up = "UPDATE consultations SET trimester=$trimester, 
            prescription=$prescription, date='$date',
            gestation='$gestation', blood_pressure='$blood_pressure', weight=$weight, height_ft=$height_ft, height_in=$height_in,
            nutritional_status='$nutritional_status', status_analysis='$status_analysis', 
            advice='$advice', change_plan='$change_plan', date_return='$date_return'
                WHERE consultation_id=$m_c_id;";
        $apply_changes = $_POST['apply_changes']==="apply";
        $up2 = $apply_changes ? 
            "UPDATE patient_details 
                SET weight=$weight, height_ft=$height_ft, height_in=$height_in, trimester=$trimester
                WHERE user_id=$m_u_id"
            : "";
        // $alert_str = $pr_page?'Prescription':'Treatment';
        //  echo "$up $up2";

        if (mysqli_multi_query($conn, "$up $up2"))  { 
            echo "<script>alert('Consultation ". ($apply_changes ? "& Patient Details ": "") ."Updated!');window.location.href='./view-consultations.php';</script>"; 
            // header("Location: view-consultations.php");
        }
        else {  
            $error .= 'Something went wrong updating the appointment to the database.';
        }  
        // }
       
    }  
} 

$conn->close(); 

$page = 'edit_consultation';

include_once('../php-templates/admin-navigation-head.php');
?>
<style>
    form{
        text-align: center;
    }
    h6{
    font-size: 20px;
  }
</style>

<div class="container_nu"> 
  <!-- Sidebar -->
  <?php include_once('../php-templates/admin-navigation-left.php'); ?> 
  <!-- Page Content -->
  <div class="main_nu" >
    <?php include_once('../php-templates/admin-navigation-right.php'); ?>

    <div class="container-fluid">
      <div class="background-head row m-2 my-4">
        <h6 class="pb-3 m-3 fw-bolder ">Update Consultation Record of <em><?php echo $m_name?></em></h6>
      
    
        <div class="col-md-8 col-lg-5">  
        <br>
        <?php 
            if (count($_barangay_list)==0) { ?>
            You can't give consultations because you are not assigned to any barangay.
        <?php } else if (count($patient_list)>0) { ?>
        <form class="form form-box px-3" style="padding-top: 4px;" action="" method="post" enctype="multipart/form-data">
            <?php
                if(isset($error)) 
                    echo '<span class="form__input-error-message">'.$error.'</span>'; 
            ?> 
            
            <div class="form__input-group">
                <div class=" mb-3"> <!-- trimester -->
                    <label>Nth Trimester</label>
                    <select class="form-select" name="trimester">
                        <option  class="option" value="0" <?php echo $m_trimester==="0"?"selected":""?>>N/A</option>
                        <option  class="option" value="1" <?php echo $m_trimester==="1"?"selected":""?>>1st (0-13 weeks)</option>
                        <option  class="option" value="2" <?php echo $m_trimester==="2"?"selected":""?>>2nd (14-27 weeks)</option>
                        <option  class="option" value="3" <?php echo $m_trimester==="3"?"selected":""?>>3rd (28-42 weeks)</option>
                    </select>
                </div> 
                <div class="mb-3"> <!-- gestation -->    
                    <label for="gestation">Age of Gestation</label>
                    <input id="gestation" name="gestation" class="" type="text" required
                        value="<?php echo $m_gestation?>"/> 
                </div>
                <div class="mb-3"> <!-- blood_pressure -->      
                    <label for="blood_pressure">Blood Pressure</label>
                    <input id="blood_pressure" name="blood_pressure" class="" type="text" required
                        value="<?php echo $m_blood_pressure?>"/> 
                </div>
                <div class="mb-3"> <!-- weight -->     
                    <label for="weight">Weight</label>
                    <input id="weight" name="weight" class="" type="number" required
                        value="<?php echo $m_weight?>"/>kg 
                </div>
                <div class="mb-3"> <!-- height  -->     
                    <label for="height">Height</label>
                    <input id="height_ft" name="height_ft" class="" type="number" required
                        value="<?php echo $m_height_ft?>"/>ft 
                    <input id="height_in" name="height_in" class="" type="number" required
                        value="<?php echo $m_height_in?>"/>in
                </div>
                <div class="mb-3"> <!-- date -->
                    <label>Consultation Date and Time*</label> 
                    <input class="form-control option" type="datetime-local" name="date"  value="<?php echo $m_date?>" required/>
                </div>
                <div class=" mb-3"> <!-- nutritional_status --> 
                    <label>Nutritional Status*</label>
                    <select class="form-select" name="nutritional_status">
                    <option  class="option" value="Normal" 
                        <?php echo $m_nutritional_status==="Normal"?"selected":""?>>Normal</option>
                    <option  class="option" value="Underweight" 
                        <?php echo $m_nutritional_status==="Underweight"?"selected":""?>>Underweight</option>
                    <option  class="option" value="Overweight" 
                        <?php echo $m_nutritional_status==="Overweight"?"selected":""?>>Overweight</option>
                    </select>
                </div> 
                <div class="mb-3"> <!-- status_analysis -->     
                    <label for="status_analysis">Status Analysis</label>
                    <textarea id="status_analysis" name="status_analysis" 
                    class="form-control form-control-md w-100"><?php echo $m_status_analysis?></textarea> 
                </div>
                <div class="mb-3"> <!-- advice -->     
                    <label for="advice">Advice</label>
                    <textarea id="advice" name="advice" 
                    class="form-control form-control-md w-100"><?php echo $m_advice?></textarea> 
                </div>
                <div class="mb-3"> <!-- change_plan -->     
                    <label for="change_plan">Changes in Birth Plan</label>
                    <textarea id="change_plan" name="change_plan" 
                    class="form-control form-control-md w-100"><?php echo $m_change_plan?></textarea> 
                </div>
                <div class="mb-3">     
                    <label for="prescription">Prescription</label>
                    <!-- <input type="text" name="prescription" value="<?php echo $m_prescription?>" 
                    placeholder="Prescription"/>   -->
                    <textarea  id="prescription" name="prescription" class="form-control form-control-md w-100" placeholder="Prescription" ><?php echo $m_prescription?></textarea>
                </div>
                <div class="mb-3"> <!-- date_return -->
                    <label>Date of Return*</label> 
                    <div class="input-group date" id="datepicker_return">
                        <input class="form-control option" type="datetime-local" name="date_return" required
                            value="<?php echo $m_date_return?>"/> 
                    </div> 
                </div>   
                <div class=" mb-3"> <!-- apply changes to patient -->
                    <label>Apply Changes to Patient Record</label>
                    <select class="form-select" name="apply_changes">
                        <option  class="option" value="ignore">Do Not Affect Patient Record</option>
                        <option  class="option" value="apply">Apply Changes to Patient Record</option>
                    </select>
                </div> 
                               <!-- <div class="mb-3">     
                    <label for="treatment">Treatment</label>
                    <textarea  id="treatment" name="treatment" class="form-control form-control-md w-100" placeholder="Prescription" ><?php echo $m_treatment?></textarea>
                </div> -->
                <!-- <div class="form_select"> 
                    <label>Trimester</label>   
                    <select class="form_select_focus" name="trimester">
                        <option value="0" <?php //echo 0==$m_trimester?"selected":"" ?>>N/A</option>
                        <option value="1" <?php //echo 1==$m_trimester?"selected":"" ?>>1st (0-13 weeks)</option>
                        <option value="2" <?php //echo 2==$m_trimester?"selected":"" ?>>2nd (14-27 weeks)</option>
                        <option value="3" <?php //echo 3==$m_trimester?"selected":"" ?>>3rd (28-42 weeks)</option>
                    </select> 
                </div> -->
                 
                <?php //if ($m_treatment_file!='') { ?> 
                    <!-- <label for='treatment_file'>Treatment File</label>
                    <a target="_blank" style="color:#000;"
                        href="./view-treatment-file.php?id=<?php //echo $m_treatment_file?>">
                        View Photo</a>    -->
                <?php //} 
                //if ($admin==-1) { ?>  
                    <!-- <input type="file" id="treatment_file" name="treatment_file"  class="form__input"/> -->
                <?php //}  ?> 
            </div> 
            <button  class=" w-100 btn btn-primary  text-capitalize" type="submit" name="submit">
                Update <?php echo "Consultation Record" ?>  
            </button> 
        </form> 
        <?php } else {   ?>
            There should be at least one patient (under your assigned barangay) available in the database.
        <?php }  ?> 

        </div>
        </div>  
      </div>
    </div>
  </div>


<?php 
include_once('../php-templates/admin-navigation-tail.php');
?>