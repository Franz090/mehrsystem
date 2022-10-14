<?php 
@include '../includes/config.php';

session_start();

@include '../php-templates/redirect/admin-page-setter.php';
@include '../php-templates/redirect/midwife-only.php';


$session_id = $_SESSION['id'];

$patient_list = [];  
$treat_med_list = []; 
 
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

    // fetch treatment/medicine
    $select2 = "SELECT id, name
        FROM treat_med 
        WHERE category=".($pr_page?'0':'1').";";
    $result_tm = mysqli_query($conn, $select2);


    if (mysqli_num_rows($result_tm)) {
        foreach($result_tm as $row) {
            $id = $row['id'];  
            $name = $row['name'];  
            array_push($treat_med_list, array('id' => $id,'name' => $name));
        } 
        mysqli_free_result($result_tm);
    } 
    else  { 
        mysqli_free_result($result_tm);
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
        $patient_id = mysqli_real_escape_string($conn, ($_POST['patient_id']));
        $tm_id = mysqli_real_escape_string($conn, $_POST['medicine_id']);
        $date = mysqli_real_escape_string($conn, $_POST['date']); // ex: 2022-09-24T00:55
        $date_arr = explode('T',$date); // ex: ['2022-09-24', '00:55']
        if (!$pr_page) {
            if (isset($_FILES['treatment_file']) && $_FILES['treatment_file']['error']!==4) { // error 4 is no file
                $tp_treatment_file = $_FILES['treatment_file'];
                // print_r($tp_treatment_file);
                $file_name_arr = explode('.', $tp_treatment_file['name']);
                $file_ext = end($file_name_arr);
    
                if ($tp_treatment_file['type']=='image/jpeg' || $tp_treatment_file['type']=='image/png') {
                    if ($tp_treatment_file['error']===0) {
                        // 5MB max file size 
                        if ($tp_treatment_file['size']<=5000000) {
                            $new_file_name = 'treatment_file-'. $date_arr[0] . $patient_id.$tm_id.'.'.$file_ext ;
                            $treatment_file = mysqli_real_escape_string($conn, $new_file_name);
                            $file_destination = 'uploaded treatment files/'. $new_file_name;
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
                $treatment_file = NULL;
            }
        
        }
        // not treatment  
        else {
            $treatment_file = NULL;
        }
        if ($error==='') {
            
            $alert_str = $pr_page?'Prescription':'Treatment';
            $insert = "INSERT INTO treat_med_record(patient_id, date, treat_med_id, treatment_file) 
            VALUES($patient_id, '$date', $tm_id, '$treatment_file');";
            if (mysqli_query($conn, $insert))  { 
                echo "<script>alert('$alert_str Added!');</script>"; 
            }
            else {  
                $error .= 'Something went wrong adding the appointment to the database.';
            }  
        }
       
    }  
} 

$conn->close(); 


include_once('../php-templates/admin-navigation-head.php');
?>


<div class="d-flex" id="wrapper"> 
  <!-- Sidebar -->
  <?php include_once('../php-templates/admin-navigation-left.php'); ?> 
  <!-- Page Content -->
  <div id="page-content-wrapper" >
    <?php include_once('../php-templates/admin-navigation-right.php'); ?>

    <div class="container-fluid">
      <div class="row bg-light m-3 "><h3>Add <?php echo $pr_page?'Prescription':'Treatment';?> Record</h3>
      <div class="container default table-responsive pt-4 pb-5">
        <div class="col-md-8 col-lg-5">
        
        <?php 
            if (count($_barangay_list)==0) { ?>
            You can't give <?php echo $pr_page?'prescriptions':'treatments';?> because you are not assigned to any barangay.
        <?php } else if (count($patient_list)>0) { ?>
        <form class="form" action="" method="post" enctype="multipart/form-data">
            <?php
                if(isset($error)) 
                    echo '<span class="form__input-error-message">'.$error.'</span>'; 
            ?> 
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
            <div class="form__input-group">
                <label><?php echo $pr_page?'Prescription':'Treatment';?> Date and Time*</label> 
                <input type="datetime-local" name="date" required class="form__input"/>
                <label><?php echo $pr_page?'Medicine':'Treatment';?></label> 
                <select class="form__input" name="medicine_id">
                    <?php
                        if (count($treat_med_list)>0) {
                            foreach ($treat_med_list as $key => $value) { 
                    ?> 
                        <option value="<?php echo $value['id'];?>" <?php echo $key===0?'selected':'';?>><?php echo $value['name'];?></option>
                    <?php  
                            }    
                        }  
                    ?>  
                </select> 
                <?php if (!$pr_page) { ?>
                    <label for='treatment_file'>Treatment File</label> 
                    <input type="file" id="treatment_file" name="treatment_file"  class="form__input"/>
                <?php } ?>
            </div>   

          
            <button class="form__button" type="submit" name="submit">Add <?php echo $pr_page?'Prescription':'Treatment';?> Record</button> 
        </form> 
        <?php }else {   ?>
            There should be at least one patient (under your assigned barangay) and <?php echo $pr_page?'medicine':'treatment';?> available in the database.
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