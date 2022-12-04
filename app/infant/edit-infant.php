<?php
$page= "edit_infant";
@include '../includes/config.php';

session_start();

@include '../php-templates/redirect/admin-page-setter.php';  
@include '../php-templates/redirect/midwife-only.php';


$session_id = $_SESSION['id'];
$infant_id_from_get = $_GET['id']; 

@include '../php-templates/midwife/get-assigned-barangays.php';

if (count($_barangay_list)>0) {  
    $barangay_select = '';
    $barangay_list_length_minus_1 = count($_barangay_list)-1;
    foreach ($_barangay_list as $key => $value) { 
        $barangay_select .= "p.barangay_id=$value ";
        if ($key < $barangay_list_length_minus_1) {
            $barangay_select .= "OR ";
        }
    }
    // select for getting the infant 
    $select1 = "SELECT infant_id id, i.first_name, i.middle_name, i.last_name, i.nickname, sex, i.b_date, i.blood_type, legitimacy
        FROM infants i, patient_details p, users u 
        WHERE role=-1 AND ($barangay_select) AND p.user_id=u.user_id AND i.user_id=u.user_id AND infant_id=$infant_id_from_get";
    // echo $select1;
    if ($result_infant = mysqli_query($conn, $select1)) {
        foreach($result_infant as $row) {
            $c_id = $row['id'];  
            $c_first_name = $row['first_name'];  
            $c_middle_name = $row['middle_name']==NULL ? '' : $row['middle_name'];  
            $c_last_name = $row['last_name'];  
            $c_nickname = $row['nickname']==NULL ? '' : $row['nickname'];  
            $c_sex = $row['sex'];  
            $c_b_date = $row['b_date'];  
            $c_blood_type = $row['blood_type'];  
            $c_legitimacy = $row['legitimacy'];  
        } 
    } 
    else  { 
        mysqli_free_result($result_infant);
        $error = 'Something went wrong fetching data from the database.'; 
    }    
} 

//TODO: update infant record

 

$conn->close(); 

include_once('../php-templates/admin-navigation-head.php');
?>


<div class="container_nu"> 
  <!-- Sidebar -->
  <?php include_once('../php-templates/admin-navigation-left.php'); ?> 
  <!-- Page Content -->
  <div class="main_nu">
    <?php include_once('../php-templates/admin-navigation-right.php'); ?>

    <div class="container-fluid default">
      <div class="background-head row m-2 my-4"><h4 class="pb-3 m-3 fw-bolder ">Update Infant Record</h4><hr>

        <div class="container default table-responsive p-4">
          <div class="col-md-8 col-lg-5 ">
        <form class="form form-box px-3" style="padding-top: 4px;" action="" method="post">
            <?php
                if(isset($error)) 
                echo '<span class="form__input-error-message">'.$error.'</span>'; 
                else { 
            ?> 
            <div class="form-input">
                <input type="text" class="form-input" name="first_name" autofocus placeholder="First Name*" 
                    required value="<?php echo $c_first_name?>">
                <input type="text" class="form-input" name="middle_name" placeholder="Middle Name" 
                    value="<?php echo $c_middle_name?>">
                <input type="text" class="form-input" name="last_name" placeholder="Last Name*" 
                    required value="<?php echo $c_last_name?>">
                <input type="text" class="form-input" name="nickname" placeholder="Nickname" 
                    value="<?php echo $c_nickname?>">  
            </div>  
            <div class="form_select">
                <label>Sex</label>
                <select class="form_select_focus" name="sex">
                <option value="Male" <?php echo $c_sex=="Male"?"selected":""?>>Male</option>
                <option value="Female" <?php echo $c_sex=="Female"?"selected":""?>>Female</option> 
                <option value="Other" <?php echo $c_sex=="Other"?"selected":""?>>Other</option> 
                </select>
            </div> 
            <div class="form__select-group">
                <label>Birth Date*</label> 
                <div class="form-input">
                <input type="date" name="b_date" required value="<?php echo $c_b_date?>"/>
                </div>
            </div> 
            <div class="form-input">
                <input type="text" class="form-input" name="blood_type" placeholder="Blood Type*" required
                    value="<?php echo $c_blood_type?>">
            </div> 
            <div class="form_select">
                <label>Legitimacy</label>
                <select class="form_select_focus" name="legitimacy">
                <option value="1" <?php echo $c_legitimacy==1?"selected":""?>>Legitimate</option>
                <option value="0" <?php echo $c_legitimacy==0?"selected":""?>>Illegitimate</option> 
                </select>
            </div>  
            <button class="w-100 btn text-capitalize mb-5" type="submit" name="submit">Update Infant</button> 

            <hr/>
            <a target="_blank" href="../infant/infant-vacc-record.php?id=<?php echo $c_id?>" ><button class="w-100 btn text-capitalize" type="button">
                See Vaccination Record</button></a>
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