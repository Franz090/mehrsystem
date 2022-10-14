<?php 
@include '../includes/config.php';

session_start();

@include '../php-templates/redirect/admin-page-setter.php';
@include '../php-templates/redirect/midwife-only.php';

$session_id = $_SESSION['id'];
$id_from_get = $_GET['id'];  

$treat_med_list = []; 
$delete_treatment_file_flag = FALSE;

@include '../php-templates/midwife/get-assigned-barangays.php';
if (count($_barangay_list)>0) {
    $barangay_select = '';
    $barangay_list_length_minus_1 = count($_barangay_list)-1;
    foreach ($_barangay_list as $key => $value) { 
        $barangay_select .= "d.barangay_id=$value ";
        if ($key < $barangay_list_length_minus_1) {
            $barangay_select .= "OR ";
        }
    }  
    
    // fetch treatment/medicine
    $select2 = "SELECT id, name
        FROM treat_med 
        WHERE category=".($pr_page?'0':'1').";";
    $result_tm = mysqli_query($conn, $select2); 
    // echo $select2;
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

    $treatment_file_str = $pr_page?"":"treatment_file,";

    // fetch user  
    $record_to_edit = "SELECT tmr.id id, u.id patient_id,
        CONCAT(first_name,IF(mid_initial='', '', CONCAT(' ',mid_initial,'.')),' ',last_name) AS name,
        tmr.date, $treatment_file_str tmr.treat_med_id  
        FROM users u, treat_med_record tmr, treat_med tm, details d
        WHERE tmr.patient_id=u.id AND tm.id=tmr.treat_med_id 
            AND ($barangay_select) AND d.id=u.details_id AND tmr.id=$id_from_get ";
//    echo $record_to_edit;
   $record_from_db = mysqli_query($conn, $record_to_edit);

    if (mysqli_num_rows($record_from_db) > 0) {
        foreach($record_from_db as $row)  {
            $patient_id = $row['patient_id'];  
            $c_id = $row['id'];  
            $c_name = $row['name'];
            $c_date = $row['date'];
            if (!$pr_page && $row['treatment_file']!=NULL)
                $c_treatment_file = substr($row['treatment_file'],15);  
            $c_treat_med_id = $row['treat_med_id'];
        }
        mysqli_free_result($record_from_db);
    }
    else {
        $no_rec = 'No such record.';
        mysqli_free_result($record_from_db);
    }
}

// if (isset($_FILES['treatment_file'])){
//     print_r($_FILES['treatment_file']);
// }
// update 
if(isset($_POST['submit'])) {
    $_POST['submit'] = null;
    $error = ''; 
    print_r ($_POST);
    print_r ($_FILES);
    if (empty($_POST['date']))
        $error .= 'Fill up input fields that are required (with * mark)! ';
    else {    
        // $patient_id = mysqli_real_escape_string($conn, ($_POST['patient_id']));
        $tm_id = mysqli_real_escape_string($conn, $_POST['treat_med_id']);
        $date = mysqli_real_escape_string($conn, $_POST['date']); // ex: 2022-09-24T00:55
        $date_arr = explode('T',$date); // ex: ['2022-09-24', '00:55']
        // $ treatment_file set to default to later tell if the user did some changes to the treatment file
        $treatment_file = 'default'; 
        if (!$pr_page) {
            if (isset($_FILES['treatment_file']) && $_FILES['treatment_file']['error']!==4) { // error 4 is no file
                // print_r($_FILES['treatment_file']);
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
            // wants to removed file
            else if (isset($_POST['delete_treatment_file'])) {
                $treatment_file = NULL;
            }    
        } 
        // not treatment 
        else {
            $treatment_file = NULL;
        }
        if ($error==='') {
            
            $alert_str = $pr_page?'Prescription':'Treatment';
            $loc_str = $pr_page?'prescription':'treatment';
            $treatment_file_sql_string = $treatment_file==='default'?"":
                ($treatment_file==NULL?"treatment_file=NULL,":"treatment_file='$treatment_file',");
            $update = "UPDATE treat_med_record 
                SET date='$date', $treatment_file_sql_string treat_med_id=$tm_id 
                WHERE id=$c_id;";
            // echo $update;
            if (mysqli_query($conn, $update))  { 
                echo "<script>alert('$alert_str Updated!');</script>"; 
                header('location: view-'.$loc_str.'-records.php');
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
      <div class="row bg-light m-3 "><h3>Update <?php echo $pr_page?'Prescription':'Treatment';?> Record for <?php echo $c_name ?></h3>
      <div class="container default table-responsive pt-4 pb-5">
        <div class="col-md-8 col-lg-5">
        
        <?php 
            if (count($_barangay_list)==0) { ?>
            You can't give <?php echo $pr_page?'prescriptions':'treatments';?> because you are not assigned to any barangay.
        <?php } else  { ?>
        <form class="form" action="" method="post" enctype="multipart/form-data">
            <?php
                if(isset($error)) 
                    echo '<span class="form__input-error-message">'.$error.'</span>'; 
            ?>  
            <div class="form__input-group">
                <label><?php echo $pr_page?'Prescription':'Treatment';?> Date and Time*</label> 
                <input type="datetime-local" name="date" required class="form__input" value="<?php echo $c_date?>"/>
                <label><?php echo $pr_page?'Medicine':'Treatment';?></label> 
                <select class="form__input" name="treat_med_id">
                    <?php
                        if (count($treat_med_list)>0) {
                            foreach ($treat_med_list as $key => $value) { 
                    ?> 
                        <option value="<?php echo $value['id'];?>" <?php echo $value['id']==$c_treat_med_id?'selected':'';?>><?php echo $value['name'];?></option>
                    <?php  
                            }    
                        }  
                    ?>  
                </select> 
                <?php if (!$pr_page) { ?>
                    <label>Treatment File</label> <br/>
                    <!-- <label for='treatment_file' style="cursor:pointer; font-weight:bold">Update File</label>  -->

                    <input onchange="display_image(this)" style="display:none;" type="file" id="treatment_file" name="treatment_file"   class="form__input"/>
                    <!-- Selected  -->
                    
                    <img src="" 
                        id="file_display" 
                        style="width:50%;height:auto"/>
                        
                    <button id="upload_button" class="form__button" onclick="trigger_click()" type="button"> 
                        <?php echo (isset($c_treatment_file))?"Change":"Choose"  ?>  Image
                    </button> 
                   <hr/>
                    <?php if (isset($c_treatment_file)) { ?> 
                        <br/>
                        <a href="./view-treatment-file.php?id=<?php echo $c_treatment_file?>" 
                            style="color:#000; font-weight:bold"
                            target="_blank">View Current Uploaded Photo</a> 
                        <div id="delete_treatment_file_div">
                            <input type="checkbox" name="delete_treatment_file" id="delete_treatment_file" value='1'/>
                            <label for="delete_treatment_file">
                                Delete Current Uploaded Photo
                            </label>
                        </div>
                    <?php } else { ?>
                        No Photo Uploaded
                    <?php } ?>
                <?php } ?>
            </div>    
            <button class="form__button" type="submit" name="submit">Update <?php echo $pr_page?'Prescription':'Treatment';?> Record</button> 
        </form>   

        <?php } ?>
        </div>
        </div>  
      </div>
    </div>
  </div>
</div>
<!-- preview image  -->
<script>
    function trigger_click() {
        document.querySelector( '#treatment_file' ).click() ;
    }
    function display_image(e) {
        if (e.files[0]) {  
            var reader = new FileReader() ;
            reader.onload = function (e) {
                document.querySelector('#file_display').setAttribute ( 'src' , e.target.result ) ;
            }
            reader.readAsDataURL ( e.files[0]) ;
            console.log(`eh ${e.files[0]}`)
            document.querySelector('#delete_treatment_file_div').innerHTML = ''
        } else {
            document.querySelector('#delete_treatment_file_div').innerHTML=`
            <input type="checkbox" name="delete_treatment_file" value='1'/>
                            Delete Current Uploaded Photo
            ` 
        }
    }
</script>


<?php 
include_once('../php-templates/admin-navigation-tail.php');
?>