<?php 
@include '../includes/config.php';

session_start();

@include '../php-templates/redirect/admin-page-setter.php';
@include '../php-templates/redirect/not-for-nurse.php';


$session_id = $_SESSION['id'];
$session_id_str = ($admin==0?"c.midwife_appointed=":"u.user_id=") . $session_id;
// fetch consultation to edit 
$id_from_get = $_GET['id'];
$select_c_to_edit = "SELECT u.user_id u_id, c.consultation_id c_id, treatment_file,
    CONCAT(d.first_name,IF(d.middle_name='' OR middle_name IS NULL, '', CONCAT(' ',SUBSTRING(d.middle_name,1,1),'.')),' ',d.last_name) AS name,
    c.trimester, date, treatment_id, prescription_id
FROM users u, user_details d, patient_details p, consultations c
WHERE u.user_id=d.user_id AND c.consultation_id=$id_from_get AND 
    c.patient_id=u.user_id AND $session_id_str";
// echo $select_c_to_edit;
if ($result_c_to_edit = mysqli_query($conn, $select_c_to_edit)) {
    foreach($result_c_to_edit as $row) {
        $m_name = $row['name'];   
        $m_u_id = $row['u_id'];   
        $m_c_id = $row['c_id'];   
        $m_trimester = $row['trimester'];   
        $m_treatment_file = $row['treatment_file']==null?"":substr($row['treatment_file'],15); 
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

    if ((empty($_POST['date']) && $admin==0))
        $error .= 'Fill up input fields that are required (with * mark)! ';
    else {    
        // $patient_arr = explode("AND",$_POST['patient_id']);
        // $patient_id = mysqli_real_escape_string($conn, ($patient_arr[0]));
        if ($admin==0) {
            $trimester = mysqli_real_escape_string($conn, $_POST['trimester']);
            
            $treatment_id = mysqli_real_escape_string($conn, empty($_POST['treatment_id'])?'NULL':$_POST['treatment_id']);
            $prescription_id = mysqli_real_escape_string($conn, empty($_POST['prescription_id'])?'NULL':$_POST['prescription_id']);
            $date = mysqli_real_escape_string($conn, $_POST['date']); // ex: 2022-09-24T00:55
        }
        else {
            $date = mysqli_real_escape_string($conn, $m_date); // ex: 2022-09-24T00:55
            $date_arr = explode(' ',$date); // ex: ['2022-09-24', '00:55']
         
            if (isset($_FILES['treatment_file']) && $_FILES['treatment_file']['error']!==4) { // error 4 is no file
                $tp_treatment_file = $_FILES['treatment_file'];
                // print_r($tp_treatment_file);
                $file_name_arr = explode('.', $tp_treatment_file['name']);
                $file_ext = end($file_name_arr);

                if ($tp_treatment_file['type']=='image/jpeg' || $tp_treatment_file['type']=='image/png') {
                    if ($tp_treatment_file['error']===0) {
                        // 5MB max file size 
                        if ($tp_treatment_file['size']<=5000000) {
                            $destination_path = getcwd().DIRECTORY_SEPARATOR;
                            $new_file_name = 'treatment_file-'. $date_arr[0] . $m_u_id.$m_treatment_id.'.'.$file_ext ;
                            $treatment_file = "'". mysqli_real_escape_string($conn, $new_file_name) . "'";
                            $file_destination = "uploaded treatment files/" . $new_file_name;
                            move_uploaded_file($tp_treatment_file['tmp_name'], $file_destination);
                        } else {
                            $error .= "File size too big. We only accept 5MB files or lower.";
                        }
                    } else {
                        $error .= "Error: (".$tp_treatment_file['error'].")";
                    }
                }else {
                    $error .= 'We only accept image/jpeg or image/png.';
                }
            }
            // no file selected
            else { 
                $treatment_file = 'NULL';
            }
        }
     
        
       
        if ($error==='') {
            if ($admin==0)
                $up = "UPDATE consultations SET trimester=$trimester, treatment_id=$treatment_id, 
                    prescription_id=$prescription_id, date='$date' WHERE consultation_id=$m_c_id;";
            else 
                $up = "UPDATE consultations SET treatment_file=$treatment_file WHERE consultation_id=$m_c_id;";
            // $alert_str = $pr_page?'Prescription':'Treatment';
            //  echo $up;
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

$page = 'edit_consultation';

include_once('../php-templates/admin-navigation-head.php');
?>


<div class="d-flex" id="wrapper"> 
  <!-- Sidebar -->
  <?php include_once('../php-templates/admin-navigation-left.php'); ?> 
  <!-- Page Content -->
  <div id="page-content-wrapper" >
    <?php include_once('../php-templates/admin-navigation-right.php'); ?>

    <div class="container-fluid">
      <div class="background-head row m-2 my-4"><h4 class="pb-3 m-3 fw-bolder ">Update Consultation Record of <?php echo $m_name?></h4><hr>
      <div class="container default table-responsive p-4">
        <div class="col-md-8 col-lg-5">
        
        <?php 
            if (count($_barangay_list)==0 && $admin==0) { ?>
            You can't give consultations because you are not assigned to any barangay.
        <?php } else if (count($patient_list)>0 && $admin==0 || $admin==-1) { ?>
        <form class="form form-box px-3" style="padding-top: 4px;" action="" method="post" enctype="multipart/form-data">
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
                <?php if ($admin==0) { ?> 
                <div class="form-input">
                <label>Consultation Date and Time*</label> 
                <input type="datetime-local" name="date"  value="<?php echo $m_date?>" required/>
                </div>
            <div class="form_select">
                <label>Prescription</label> 
                <select class="form_select_focus" name="prescription_id">
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
                    </div>
              <div class="form_select"> 
                <label>Treatment</label> 
                <select class="form_select_focus" name="treatment_id">
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
            </div>
             <div class="form_select"> 
                <label>Trimester</label>   
                <select class="form_select_focus" name="trimester">
                    <option value="0" <?php echo 0==$m_trimester?"selected":"" ?>>N/A</option>
                    <option value="1" <?php echo 1==$m_trimester?"selected":"" ?>>1st (0-13 weeks)</option>
                    <option value="2" <?php echo 2==$m_trimester?"selected":"" ?>>2nd (14-27 weeks)</option>
                    <option value="3" <?php echo 3==$m_trimester?"selected":"" ?>>3rd (28-42 weeks)</option>
                </select> 
                    </div>
                <?php } ?>  
                <?php if ($m_treatment_file!='') { ?> 
                    <label for='treatment_file'>Treatment File</label>
                    <a target="_blank" style="color:#000;"
                        href="./view-treatment-file.php?id=<?php echo $m_treatment_file?>">
                        View Photo</a>   
                <?php } 
                if ($admin==-1) { ?>  
                    <input type="file" id="treatment_file" name="treatment_file"  class="form__input"/>
                <?php }  ?> 
            </div> 
            <button  class="w-100 btn  text-capitalize" type="submit" name="submit">
                Update <?php echo $admin==0?"Consultation Record":"Treatment File" ?>  
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
</div>

<?php 
include_once('../php-templates/admin-navigation-tail.php');
?>