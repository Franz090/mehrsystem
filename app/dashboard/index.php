<?php

@include '../includes/config.php';

session_start();

@include '../php-templates/redirect/admin-page-setter.php';

// $vaccine_list = [];
$infant_list = [];
$title = ''; // pie chart title
$curr_date = date("Y-m-d");
$curr_year = substr($curr_date,0,4);
// echo "curr yewar: $curr_year";
$complete_shots_of_vaccines = 15;

$session_id = $_SESSION['id'];
$current_user_is_a_patient = $admin==-1; 

if ($admin==1) {
  // $title = "Patient Vaccine Monitoring Pie Chart"; 
  // get last 6 months of appointments 
  $bar_chart_data_multi_d_arr = array();
 
  // echo $past_6_months; 
} 
if ($admin==0) {
  // $title = "Infant Vaccine Monitoring Pie Chart";
  // $av_vaccine = 0;
  // $used_vaccine = 0;
  // $exp_vaccine = 0;
  // $up_vaccine = 0;

  // fetch infants  
  
  // //fetch people vaccinated with tetanus
  // $select2_1 = "SELECT tetanus, COUNT(u.id) as p_count  
  //   FROM users u, details d, barangay b, med_history m  
  //   WHERE u.details_id=d.id AND b.assigned_midwife=$session_id AND d.barangay_id=b.id AND d.med_history_id=m.id
  //   GROUP BY tetanus"; 
  // // echo $select2_1;
  // if($result2_1 = mysqli_query($conn, $select2_1))  {
  //   $total_patients = 0; 
  //   foreach($result2_1 as $row)  {
  //     if ($row['tetanus']==1) {
  //       $total_vacc = $row['p_count'];
  //     }
  //     $total_patients += $row['p_count'];  
  //   } 
  //   mysqli_free_result($result2_1);
  //   // print_r($nurse_list); 
  // } 
  // else  { 
  //   mysqli_free_result($result2_1);
  //   $error = 'Something went wrong fetching data from the database.'; 
  // }  

  // fetch appointments today 

  // $select2_2 = "SELECT COUNT(u.id) as a_count  
  //   FROM users u, barangay b, appointment a, details d
  //   WHERE u.details_id=d.id AND b.assigned_midwife=$session_id AND d.barangay_id=b.id AND A.patient_id=u.id
  //     AND date BETWEEN '$curr_date 00:00:00' AND '$curr_date 23:59:59'"; 
   
  // echo $select2_2;
  // if($result2_2 = mysqli_query($conn, $select2_2))  {
  //   foreach($result2_2 as $row)  { 
  //     $appointments_today = $row['a_count'];  
  //   } 
  //   mysqli_free_result($result2_2);
  //   // print_r($nurse_list);
  
  // } 
  // else  { 
  //   mysqli_free_result($result2_2);
  //   $error = 'Something went wrong fetching data from the database.'; 
  // }  

  // fetch infant vaccines 
  // $select2_3 = "SELECT *  
  //   FROM vaccine WHERE type=0";   

  // if($result2_3 = mysqli_query($conn, $select2_3))  {
  //   foreach($result2_3 as $row)  { 
  //     $id = $row['id'];  
  //     $batch = $row['batch'];  
  //     $count = $row['count'];  
  //     $used_count = $row['used_count'];  
  //     $status = $row['status'];  
  //     $expiration = $row['expiration'];   
  //     array_push($vaccine_list, array(
  //       'id' => $id,
  //       'batch' => $batch,  
  //       'count' => $count,  
  //       'used_count' => $used_count,  
  //       'status' => $status,  
  //       'expired' => "$curr_date 00:00:00">=$expiration?1:0,   
  //       'expiration' => $expiration
  //     ));
  //   } 
  //   // segregate vaccine count 
  //   foreach ($vaccine_list as $key => $value) {
  //     $count = $value['count'];
  //     if ($value['status']) {
  //       $used_count = $value['used_count'];

  //       $used_vaccine += $used_count;

  //       $unused_count = $count-$used_count;
  //       if ($value['expired'])  
  //         $exp_vaccine += $unused_count;
  //       else  
  //         $av_vaccine += $unused_count;   
  //     } 
  //     else  
  //       $up_vaccine += $count; 
  //   } 
  //   mysqli_free_result($result2_3); 
  // } 
  // else  { 
  //   mysqli_free_result($result2_3);
  //   $error = 'Something went wrong fetching data from the database.'; 
  // }  
}
// patient 
if ($current_user_is_a_patient) {

  $select3 = "SELECT height_ft, height_in, weight, status
    FROM users u, user_details d, patient_details m
    WHERE u.user_id=$session_id AND u.user_id=d.user_id AND u.user_id=m.user_id" ;
  

  if($result3 = mysqli_query($conn, $select3))  {
    foreach($result3 as $row)  {
      $height_ft = $row['height_ft'];  
      $height_in = $row['height_in'];  
      $weight = $row['weight'];  
      $_SESSION['status'] = $row['status'];  
    } 

    mysqli_free_result($result3);
    $status = $_SESSION['status']; 

    if ($status) {
      // print_r($nurse_list);
      $in_to_m_conversion = 0.0254;
      $ft_to_in_conversion = 12;
      $m = ($height_ft * $ft_to_in_conversion + $height_in) * $in_to_m_conversion; 
      // echo $m. "<br>";
      // echo $height_ft. "<br>";
      // echo $height_in. "<br>";
      // https://www.diabetes.ca/managing-my-diabetes/tools---resources/body-mass-index-(bmi)-calculator#:~:text=Body%20Mass%20Index%20is%20a,most%20adults%2018%2D65%20years.
      // BMI = kg/m2
      $bmi = $weight/$m**2;
      // https://www.nhlbi.nih.gov/health/educational/lose_wt/BMI/bmicalc.htm
      // Underweight = <18.5
      // Normal weight = 18.5–24.9
      // Overweight = 25–29.9
      // Obesity = BMI of 30 or greater
      if ($bmi<=18.5) {
        $bmi_desc = 'Underweight';
      } else if ($bmi<25 && $bmi>18.5) {
        $bmi_desc = 'Normal weight';
      } else if ($bmi<30 && $bmi>=25) {
        $bmi_desc = 'Overweight';
      } else if ($bmi>=30) {
        $bmi_desc = 'Obese';
      }
    }
  } 
  else  { 
    mysqli_free_result($result3);
    $error = 'Something went wrong fetching data from the database.'; 
  }  

  $select_get_current_user = 
    "SELECT * 
    FROM users u 
    LEFT JOIN user_details ud USING(user_id)
    LEFT JOIN patient_details pd USING(user_id) WHERE u.user_id=$session_id";

  if ($result_current_user = mysqli_query($conn, $select_get_current_user)) {
    foreach($result_current_user as $row)  {
      $c_first_name = $row['first_name'];
      $c_middle_name = $row['middle_name']==null?'':$row['middle_name'];
      $c_last_name = $row['last_name'];
      $c_nickname = $row['nickname']==null?'':$row['nickname'];
      $c_b_date = $row['b_date']==null?'':$row['b_date'];
      $c_address = $row['address']==null?'':$row['address'];
      $c_civil_status = $row['civil_status'];
      // $c_trimester = $row['trimester'];
      // $c_tetanus = $row['tetanus'];
      $c_diagnosed_condition = $row['diagnosed_condition']==null?'':$row['diagnosed_condition'];
      $c_family_history = $row['family_history']==null?'':$row['family_history'];
      $c_allergies = $row['allergies']==null?'':$row['allergies'];
      $c_blood_type = $row['blood_type'];
      $c_weight = $row['weight'];
      $c_height_ft = $row['height_ft'];
      $c_height_in = $row['height_in'];
      
      $select_c_no = "SELECT mobile_number FROM contacts WHERE owner_id=$session_id AND type=1";
      if ($result_c_no = mysqli_query($conn, $select_c_no)) {
        $c_no = '';
        foreach ($result_c_no as $row2) {
          $c_no .= ($row2['mobile_number']."\r\n"); 
        }
      } 
    }
    mysqli_free_result($result_current_user);
  } else {
    $error = 'Something went wrong fetching data from the database.'; 
  } 

}
else {
  $session_id_sql = $admin==1?"":"AND b.assigned_midwife=$session_id";
  $select2 = "SELECT main.infant_id, infant_name, c_vaccinations, main.user_id
  FROM (SELECT i.infant_id, CONCAT(i.first_name, 
        IF(i.middle_name IS NULL OR i.middle_name='', '', 
            CONCAT(' ', SUBSTRING(i.middle_name, 1, 1), '.')), 
        ' ', i.last_name) infant_name, i.user_id
      FROM infants i, patient_details ud, barangays b WHERE i.user_id=ud.user_id AND ud.barangay_id=b.barangay_id AND b.archived=0 $session_id_sql) main
         LEFT JOIN 
      (SELECT infant_id, COUNT(infant_id) c_vaccinations FROM infant_vac_records GROUP BY infant_id) c
        USING (infant_id)"; 
  
// echo $select2;
  if($result2 = mysqli_query($conn, $select2))  {
    foreach($result2 as $row)  {
      $id = $row['infant_id'];  
      $name = $row['infant_name'];  
      $c_vaccinations = $row['c_vaccinations'];   
      array_push($infant_list, array(
        'id' => $id,
        'name' => $name, 
        'status' => ($c_vaccinations==$complete_shots_of_vaccines
          ?'Completed':("Incomplete (" . ($c_vaccinations?$c_vaccinations:'0')."/$complete_shots_of_vaccines)"))));
    } 
    mysqli_free_result($result2);
    // print_r($nurse_list);
  
  } 
  else  { 
    $error = 'Something went wrong fetching data from the database.'; 
  }   

  // chart data 
  $past_6_months = date("Y-m-d", strtotime('-5 months'));
  $bar_chart_month_list = [];
  $bar_chart_month_list_label = [];
  // generate months to chart
  for ($i=5; $i > -1; $i--) { 
    $str_to_time = strtotime("-$i months");
    array_push($bar_chart_month_list, date("Y-m",  $str_to_time));
    array_push($bar_chart_month_list_label,  date("M", $str_to_time));
  }
  $bar_chart_data = [];
}

 
$valid_contact_exp = '/[0][9][0-9][0-9]-[0-9][0-9][0-9]-[0-9][0-9][0-9][0-9]/';
if (isset($_POST['submit'])) {
  $error = '';
  $_POST['submit'] = null;

  $submit_profile_condition = 
    empty(trim($_POST['civil_status'])) || empty(trim($_POST['weight'])) || 
    empty(trim($_POST['height_ft'])) && empty(trim($_POST['height_in'])) ||
    empty(trim($_POST['blood_type']));
  if ($submit_profile_condition) {
    $error = 'Fill up input fields that are required (with * mark)! '; 
  } else {
    $contact = mysqli_real_escape_string($conn,$_POST['contact']);

    $contacts = explode('\r\n',$contact);
    $new_contacts = [];

    foreach ($contacts as $key => $mob_number) {
      $regex_check = preg_match($valid_contact_exp,$mob_number);
      if ($mob_number==='') {
          unset($contacts[$key]);
      }
      else if ($regex_check===0) {
          $error .= 'Invalid contact number list provided. Please use the format 09XX-XXX-XXXX where X is a number from 0-9.';
      } else { 
          array_push($new_contacts,$mob_number);
      }
    }

    if ($error == '') {
      $nickname = empty($_POST['nickname'])?"NULL":"'".mysqli_real_escape_string($conn, $_POST['nickname'])."'"; 
      
      $civil_status = mysqli_real_escape_string($conn,$_POST['civil_status']);

      $b_date = empty($_POST['b_date'])?"NULL":"'".mysqli_real_escape_string($conn, $_POST['b_date'])."'";
      $address = empty($_POST['address'])?"NULL":"'".mysqli_real_escape_string($conn, $_POST['address'])."'"; 
      
      $height_ft = mysqli_real_escape_string($conn, $_POST['height_ft']);
      $height_in = mysqli_real_escape_string($conn, $_POST['height_in']);
      $weight = mysqli_real_escape_string($conn, $_POST['weight']);

      $blood_type = mysqli_real_escape_string($conn, $_POST['blood_type']);
      $diagnosed_condition = empty($_POST['diagnosed_condition'])?"NULL":"'".mysqli_real_escape_string($conn, $_POST['diagnosed_condition'])."'";
      $family_history = empty($_POST['family_history'])?"NULL":"'".mysqli_real_escape_string($conn, $_POST['family_history'])."'";
      $allergies = empty($_POST['allergies'])?"NULL":"'".mysqli_real_escape_string($conn, $_POST['allergies'])."'";
      // $trimester = mysqli_real_escape_string($conn, $_POST['trimester']);
      // $tetanus = mysqli_real_escape_string($conn, $_POST['tetanus']);

      $update = '';
      // $update .= "UPDATE user_details SET first_name='$first_name', middle_name=$mid_name, last_name='$last_name'
      //   WHERE user_id=$session_id; ";
      //, trimester=$trimester, tetanus=$tetanus
      $update .= "UPDATE patient_details SET nickname=$nickname, civil_status='$civil_status', 
        b_date=$b_date, address=$address, height_ft=$height_ft, height_in=$height_in, weight=$weight,
        blood_type='$blood_type', diagnosed_condition=$diagnosed_condition, family_history=$family_history,
        allergies=$allergies
        WHERE user_id=$session_id; ";
      $delete_contact_numbers = "DELETE FROM contacts 
        WHERE owner_id=$session_id;";
      $add_contact_numbers = "";
      $contacts_count = count($new_contacts);
      $contacts_count_minus_one = $contacts_count-1;
      if ($contacts_count>0) {
        $add_contact_numbers .= "INSERT INTO contacts(mobile_number, owner_id, type) VALUES ";
        foreach ($new_contacts as $key => $value) { 
          // echo " v: $value ";
          $ins = "('".mysqli_real_escape_string($conn, $value)."', $session_id, 1)"; 
          $add_contact_numbers .= $ins;
          $add_contact_numbers .= ($key===$contacts_count_minus_one)?";":",";
        }
      }
      // echo $update;
      if (mysqli_multi_query($conn, "$update $delete_contact_numbers $add_contact_numbers")) {
        $conn->close(); 
        header('location:../profile/demographic-profile.php');  
      }else {
        $error .= 'Something went wrong updating your account in the database.';
      }    
    }

  }
}
 
$page = 'dashbaord';
include_once('../php-templates/admin-navigation-head.php');

if ($admin!=-1) {
?>

<?php } ?> 

<div class="container_nu">
  <!-- Sidebar --> 
  <?php include_once('../php-templates/admin-navigation-left.php'); ?>
  <!-- /#sidebar-wrapper --> 
  <!-- Page Content -->
  <div class="main_nu" > 
    <?php include_once('../php-templates/admin-navigation-right.php');  
   
      if (isset($error)) {
        echo '<span class="p-5" style="color:red;">'.$error.'</span>'; 
      }  
      include_once('../php-templates/dashboard/nurse.php'); 
      include_once('../php-templates/dashboard/midwife.php');
      //include_once('../php-templates/dashboard/patient.php');
      if ($current_user_is_a_patient) { // patient
        if ($status) {
    ?>
    Patient <br/>
    BMI: <?php echo round($bmi,2). " ($bmi_desc)"?>  

    <div class="container py-5" id="page-container">
      <div class="row">
        <div class="col-md-9">
            <div id="calendar"></div>
        </div>
        <div class="col-md-3">
          <div class="cardt rounded-0 shadow">
            <div class="card-header bg-gradient bg-primary text-light">
              <h5 class="card-title">Book an Appointment</h5>
            </div>
              <div class="card-body">
                  <div class="container-fluid">
                      <form action="save_schedule.php" method="post" id="schedule-form">
                          <input type="hidden" name="id" value="">
                          <!-- <div class="form-group mb-2">
                              <label for="title" class="control-label">Title</label>
                              <input type="text" class="form-control form-control-sm rounded-0" name="title" id="title" required>
                          </div>
                          <div class="form-group mb-2">
                              <label for="description" class="control-label">Description</label>
                              <textarea rows="3" class="form-control form-control-sm rounded-0" name="description" id="description" required></textarea>
                          </div> -->
                          <div class="form-group mb-2">
                              <label for="start_datetime" class="control-label">Appointment Date</label>
                              <input type="datetime-local" class="form-control form-control-sm rounded-0" name="start_datetime" id="start_datetime" required>
                          </div>
                          <!-- <div class="form-group mb-2">
                              <label for="end_datetime" class="control-label">End</label>
                              <input type="datetime-local" class="form-control form-control-sm rounded-0" name="end_datetime" id="end_datetime" required>
                          </div> -->
                      </form>
                  </div>
              </div>
              <div class="card-footer">
                  <div class="text-center">
                      <button class="btn btn-primary btn-sm rounded-0" type="submit" form="schedule-form"><i class="fa fa-save"></i> Save</button>
                      <button class="btn btn-default border btn-sm rounded-0" type="reset" form="schedule-form"><i class="fa fa-reset"></i> Cancel</button>
                  </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Event Details Modal -->
      <div class="modal fade" tabindex="-1" data-bs-backdrop="static" id="event-details-modal">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content rounded-0">
            <div class="modal-header rounded-0">
                <h5 class="modal-title">Schedule Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body rounded-0">
                <div class="container-fluid">
                    <dl>
                        <dt class="text-muted">Title</dt>
                        <dd id="title" class="fw-bold fs-4"></dd>
                        <dt class="text-muted">Description</dt>
                        <dd id="description" class=""></dd>
                        <dt class="text-muted">Start</dt>
                        <dd id="start" class=""></dd>
                        <!-- <dt class="text-muted">End</dt>
                        <dd id="end" class=""></dd> -->
                    </dl>
                </div>
            </div>
            <div class="modal-footer rounded-0">
                <div class="text-end">
                    <button type="button" class="btn btn-primary btn-sm rounded-0" id="edit" data-id="">Edit</button>
                    <button type="button" class="btn btn-danger btn-sm rounded-0" id="delete" data-id="">Delete</button>
                    <button type="button" class="btn btn-secondary btn-sm rounded-0" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
          </div>
        </div>
      </div>  
    </div> 
    <script>
      var scheds = {
        1: { id:'2',
          description:"asdf",
          // edate:"October 11, 2022 06:00 PM",
          // end_datetime:"2022-10-11 18:00:00", 
          sdate:"October 10, 2022 10:30 AM",
          start_datetime:"2022-10-10 10:30:00",
          title: "Sample 101"}}
    </script>
    <?php
        } else {
    ?>  
    <div class="container-fluid default" >
      <div class="background-head row m-2 my-4" >
        <h6 class="pb-3 m-3 fw-bolder ">
          Fill up all the required information (the one's with *) to let the assigned Midwife approve your account.
        </h6><hr>
  
        <div class="container default p-4 ">
          <div class="col-md-8 col-lg-5">         
            <form method="post" action="" class="form form-box px-3 py-5">
        
              <div class="form-input">
                Nickname
                <input type="text" value="<?php echo $c_nickname?>"
                    class="form-input" name="nickname"  placeholder="Nickname"/>
              </div> 
              <div class="form-input">
                <label for="contact">Mobile Number(s): *Separate each with a nextline and use this format: 09XX-XXX-XXXX*</label><br/>
                <textarea id="contact" name="contact" class="form-control form-control-md w-100"><?php echo $c_no?></textarea> 
              </div><br>
              <div class="form-input">
                <label>Birth Date</label>
                <div class="form-input">
                  <input type="date" name="b_date" value="<?php echo $c_b_date?>"/>
                </div>
              </div>
              <div class="form-input">
                <label for="address">Address</label><br/>
                <textarea id="address" name="address" class="form-control form-control-md w-100"><?php echo $c_address?></textarea> 
              </div><br>
              Civil Status*
              <div class="form-input">
                  <input type="text" value="<?php echo $c_civil_status?>" class="form-input" name="civil_status" placeholder="Civil Status*" required/>
              </div>  

              <div class="form-input">
                <div class="form__text"><label>Medical History</label></div>
              </div>
              <div class="form_input-group" style="font-family:  'Open Sans', sans-serif;margin-bottom: 1rem;">
                Height* 
                <div class="d-flex input-group">
                  <input value="<?php echo $c_height_ft?>" min='0' type="number" 
                    class="form__input form-control" name="height_ft" placeholder="Feet*" required/> 
                  <div class="input-group-postpend">
                    <div id="weight-height" class="input-group-text form__input text-white">ft</div>
                  </div> 
                  <input value="<?php echo $c_height_in?>" min='0' max='11' type="number" 
                  class="form__input form-control" name="height_in" placeholder="Inches*" required/>
                  <div class="input-group-postpend">
                    <div id="weight-height" class=" input-group-text form__input text-white">inch(es)</div>
                  </div> 
                </div>
              </div>
              <div class="form__input-group" style="font-family:  'Open Sans', sans-serif;margin-bottom: 1rem;">   
                Weight*   
                <div class="d-flex input-group">
                  <input value="<?php echo $c_weight?>" type="number" class="form__input form-control" name="weight" placeholder="Weight*" 
                    required min="0"/>
                    <div class="input-group-postpend">
                      <div id="weight-height" class="w-100 input-group-text form__input text-white">kg</div>
                    </div> 
                </div>
              </div><br>
              Blood Type*
              <div class="form-input"> 
                <input type="text" value="<?php echo $c_blood_type?>"
                  class="form-input" name="blood_type" placeholder="Blood Type*" required/>  
              </div>
              <div class="form-input">  
                Diagnosed Condition
                <input type="text" value="<?php echo $c_diagnosed_condition?>"
                  class="form-input" name="diagnosed_condition" placeholder="Diagnosed Condition"/> 
                Family History
                <input type="text" value="<?php echo $c_family_history?>"
                  class="form__input" name="family_history" placeholder="Family History"/> 
                Allergies
                <input type="text" value="<?php echo $c_allergies?>"
                  class="form__input" name="allergies" placeholder="Allergies"/>    
              </div>
      
              <button class="w-100 btn  text-capitalize" type="submit" name="submit">Update Profile</button>
            </form> 
            
          </div> 
        </div> 
      </div> 
    </div> 
    <?php 
        }
      }
      if ($admin!=-1) {
    ?> 
    <div class="px-5" style="margin-bottom:20vh;">
      <table class="table mt-5 table-striped table-responsive table-lg table-bordered table-hover display" id="datatables">
        <thead class="table-dark">
          <tr>
            <th scope="col">#</th>
            <th scope="col">Infant Birth Names</th>
            <th scope="col">Vaccination Status</th>
            <?php if ($admin==0) { ?> 
                <th scope="col">Action</th>
            <?php } ?> 
          </tr>
        </thead>
        <tbody> 
        <?php if (count($infant_list)==0) { ?> 
          <tr> 
            <td colspan='4' style="text-align:center">No Infant Records</td> 
          </tr> 
        <?php } else 
              foreach ($infant_list as $key => $value) { ?> 
          <tr>
            <th scope="row"><?php echo ($key+1);?></th>
            <td><?php echo $value['name'];?></td>
            <td><?php echo $value['status'];?></td>
            <?php if ($admin==0) { ?> 
            <td>
                <?php if ($value['status']!="Complete") { ?>
                  <a href="../infant/add-infant-vaccination.php?id=<?php echo $value['id'] ?>">
                    <button class="edit btn btn-primary btn-sm btn-inverse">Add Vaccination</button></a>
                <?php } ?>
                <a href="../infant/edit-infant.php?id=<?php echo $value['id'] ?>">
                    <button class="edit btn btn-success btn-sm btn-inverse">Edit</button></a>
                <a target="_blank" href="../infant/infant-vacc-record.php?id=<?php echo $value['id']?>">
                  <button class="btn btn-dark btn-sm btn-inverse">
                  See Vaccination Record</button></a> 
            </td>
            <?php } ?>  
          </tr> 
        <?php } ?> 
        </tbody>
      </table>
    </div> 
    <?php } ?> 
  </div>  
</div>
                          
                           

<?php 
include_once('../php-templates/admin-navigation-tail.php');
?>