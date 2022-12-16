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
      <div class="background-head row m-2 my-4">
        <div class="box">
        <h4 class="pb-3 m-3 fw-bolder ">Update Infant Record</h4>
        <div class="box p-5">

          <div class="col-md-8 col-lg-5 ">
        <form class="form form-box px-3" style="padding-top: 4px;" action="" method="post">
        <style type="text/css">
    form {
        text-align: center;
       
    }
    input {
        width: 100px;
    }
    </style>
            <?php
                if(isset($error)) 
                echo '<span class="form__input-error-message">'.$error.'</span>'; 
                else { 
            ?> 
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingInputInvalid" name="first_name" autofocus placeholder="First Name*" 
                    required value="<?php echo $c_first_name?>">
                    <label for="floatingInput">First Name</label>
                </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingInputInvalid" name="middle_name" placeholder="Middle Name" 
                    value="<?php echo $c_middle_name?>">
                    <label for="floatingInput">Middle Name</label>
                </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingInputInvalid" name="last_name" placeholder="Last Name*" 
                    required value="<?php echo $c_last_name?>">
                    <label for="floatingInput">Last Name</label>
                </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingInputInvalid" name="nickname" placeholder="Nickname" 
                    value="<?php echo $c_nickname?>">
                    <label for="floatingInput">Nick Name</label>  
            </div>  
            <div class="mb-3">
                
                <select class="form-select pt-2 pb-2" name="sex">
                    <option selected disabled>Gender</option>
                <option value="Male" <?php echo $c_sex=="Male"?"selected":""?>>Male</option>
                <option value="Female" <?php echo $c_sex=="Female"?"selected":""?>>Female</option> 
                <option value="Other" <?php echo $c_sex=="Other"?"selected":""?>>Other</option> 
                </select>
            </div> 
            <div class="mb-3">
                <label>Birth Date*</label> 
                <div class="input-group date" id="datepicker">
                <input class="form-control option pt-2 pb-2" type="date" name="b_date" required value="<?php echo $c_b_date?>"/>
                </div>
            </div> 
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingInputInvalid" name="blood_type" placeholder="Blood Type*" required
                    value="<?php echo $c_blood_type?>">
                    <label for="floatingInput">Blood Type</label>
            </div> 
            <div class="mb-3">
                <select class="form-select pt-2 pb-2" name="legitimacy">
                <option selected disabled>Select Legitimacy</option>
                <option value="1" <?php echo $c_legitimacy==1?"selected":""?>>Legitimate</option>
                <option value="0" <?php echo $c_legitimacy==0?"selected":""?>>Illegitimate</option> 
                </select>
            </div>  
            <button class="w-100 btn text-capitalize mb-5" type="submit" name="submit">Update Infant</button> 

            <hr/>
            <a target="_blank" href="../infant/infant-vacc-record.php?id=<?php echo $c_id?>" ><button class="w-100 btn btn-primary text-center text-capitalize" type="button">
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