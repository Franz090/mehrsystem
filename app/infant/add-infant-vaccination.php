<?php

@include '../includes/config.php';

session_start();

@include '../php-templates/redirect/admin-page-setter.php';
@include '../php-templates/redirect/midwife-only.php';

$id_from_get = $_GET['id'];
$session_id = $_SESSION['id'];
@include '../php-templates/midwife/get-assigned-barangays.php';

// MAX doses of vaccinations 
$type_max = [0,1,1,3,3,2,3,2]; 

function vaccine_name($num) {
    if ($num==1)
        return "BCG";
    if ($num==2)
        return "Hepatitis B";
    if ($num==3)
        return "Pentavalent";
    if ($num==4)
        return "Oral Polio";
    if ($num==5)
        return "Inactivated Polio";
    if ($num==6)
        return "Pnueumococcal Conjugate";
    if ($num==7)
        return "Measles, Mumps, and Rubelia";
    return "Error";
}

if (count($_barangay_list)>0) { 
    $barangay_select = '';
    $barangay_list_length_minus_1 = count($_barangay_list)-1;
    foreach ($_barangay_list as $key => $value) { 
        $barangay_select .= "p.barangay_id=$value ";
        if ($key < $barangay_list_length_minus_1) {
            $barangay_select .= "OR ";
        }
    }
    $select1 = "SELECT infant_id id, CONCAT(i.first_name,
    IF(i.middle_name='' OR i.middle_name IS NULL, '', CONCAT(' ',SUBSTRING(i.middle_name,1,1),'.')),' ',i.last_name) 
    AS name 
        FROM users u, patient_details p, infants i
        WHERE role=-1 AND ($barangay_select) AND p.user_id=u.user_id AND i.user_id=u.user_id
            AND infant_id=$id_from_get";
    // echo $select1;
    
    // $result_patient = mysqli_query($conn, $select1);
  
    $id_from_db = 0;
    if ($result_infant = mysqli_query($conn, $select1)) {
        foreach($result_infant as $row) {
            $id_from_db = $row['id'];  
            $name_from_db = $row['name'];  
        } 
        mysqli_free_result($result_infant);

        $select2 = "SELECT type, COUNT(infant_vac_rec_id) c FROM infant_vac_records WHERE infant_id=$id_from_db GROUP BY type;";
        if ($result_vacc_count = mysqli_query($conn, $select2)) {
            foreach($result_vacc_count as $row) {
                $type_max[$row['type']] -= $row['c'];  
            } 
            mysqli_free_result($result_vacc_count);
        }
        else  { 
            $error = 'Something went wrong fetching data from the database.'; 
        } 
    } 
    else  { 
        $error = 'Something went wrong fetching data from the database.'; 
    }    
} 


if (isset($_POST['submit'])) {
    $_POST['submit'] = null;
    $error = '';  

    if (empty(trim($_POST['date'])) || empty($_POST['type']))
        $error .= 'Fill up input fields that are required (with * mark)! ';
    else {
        $date = mysqli_real_escape_string($conn, $_POST['date']);
        $type = mysqli_real_escape_string($conn, $_POST['type']); 
     
      $insert = "INSERT INTO infant_vac_records(infant_id,date,type) 
        VALUES($id_from_db, '$date', $type)";
        // echo $insert;
        if (mysqli_query($conn, $insert))  {
            echo "<script>alert('Vaccination Added!');</script>";
            header("Location: ./infant-vaccinations.php");
        }
        else { 
            $error .= 'Something went wrong inserting into the database.';
        } 
    } 
}

$conn->close(); 

$page = "add_infant)vaccination";

include_once('../php-templates/admin-navigation-head.php');
?> 

<div class="container_nu"> 
  <!-- Sidebar -->
  <?php include_once('../php-templates/admin-navigation-left.php'); ?> 
  <!-- Page Content -->
  <div class="main_nu">
    <?php include_once('../php-templates/admin-navigation-right.php'); ?>

    <div class="container-fluid default">
      <div class="background-head row m-2 my-4"><h4 class="pb-3 m-3 fw-bolder ">Add Vaccination Record for <em><?php echo $name_from_db?></em></h4><hr>

        <div class="container default table-responsive p-4">
          <div class="col-md-8 col-lg-5 ">
        <form class="form form-box px-3" style="padding-top: 4px;" action="" method="post">
          <?php
            if(isset($error)) 
              echo '<span class="form__input-error-message">'.$error.'</span>'; 
            else if ($id_from_db==0) {
              echo '<span class="form__input-error-message">Infant does not exist.</span>'; 
            } else { 
          ?> 
          
            <div class="form__select-group">
                <label>Vaccination Date*</label> 
                <div class="form-input">
                    <input type="datetime-local" name="date" required />
                </div>
            </div>    

            <div class="form_select">
                <label>Type*</label>
                <select class="form_select_focus" name="type" require>
                    <option disabled selected>Select Vaccination Type</option>
                    <?php 
                    foreach ($type_max as $key => $value) {
                        if ($key!=0 && $value!=0) { ?> 
                            <option value="<?php echo $key?>"><?php echo vaccine_name($key)?></option> 
                        <?php } 
                    }?> 
                </select>
            </div> 
           
          <button class="w-100 btn  text-capitalize" type="submit" name="submit">Add Vaccination</button> 
          <?php } ?>  
        </form>  
          </div>
        </div>

      </div>
    </div>

  </div>
</div>
 
<?php 
include_once('../php-templates/admin-navigation-tail.php');
?>