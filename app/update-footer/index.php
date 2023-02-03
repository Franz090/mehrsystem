<?php
@include '../includes/config.php';

session_start();

@include '../php-templates/redirect/admin-page-setter.php';
// for admin only 
@include '../php-templates/redirect/nurse-only.php';

// fetch footer data 
$select = "SELECT * FROM footer WHERE footer_id=1";

if ($result = mysqli_query($conn, $select)) {
    foreach($result as $row)  {
        // $c_id = $row['footer_id'];  
        $c_email = $row['email'];  
        $c_address = $row['address'];  
        $c_fb_link = $row['fb_link'];  
        $c_schedule = $row['schedule'];  
        $c_contact_num_select = "SELECT mobile_number FROM contacts WHERE type=0";
        if ($result_c_no = mysqli_query($conn, $c_contact_num_select)) {
            $c_contact_num = '';
            foreach ($result_c_no as $row2) {
            $c_contact_num .= ($row2['mobile_number']."\r\n"); 
            }
        } 
      }  
mysqli_free_result($result);

} else {
    $error = "Something went wrong with your database connection.";
mysqli_free_result($result);
}
$valid_contact_exp = '/[0-9][0-9][0-9][0-9]-[0-9][0-9][0-9]-[0-9][0-9][0-9][0-9]/';
if (isset($_POST['submit'])) {
    $_POST['submit'] = null;
    $error = ''; 
  
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $schedule = mysqli_real_escape_string($conn, $_POST['schedule']);
    $fb_link = mysqli_real_escape_string($conn, $_POST['fb_link']);
    
    $contact = mysqli_real_escape_string($conn,$_POST['contact']);

    $contacts = explode('\r\n',$contact);
    $new_contacts = [];
    // print_r($contacts);
    // check numbers  
    foreach ($contacts as $key => $mob_number) {
        // echo " mob_number: $mob_number ";
        $regex_check = preg_match($valid_contact_exp,$mob_number);
        // echo " regex check: $regex_check ";
        if ($mob_number==='') {
            unset($contacts[$key]);
        }
        else if ($regex_check===0) {
            $error .= 'Invalid contact number list provided. Please use the format 09XX-XXX-XXXX where X is a number from 0-9.';
        } else { 
            array_push($new_contacts,$mob_number);
        }
    }
    // echo "<br/>";
    // $contacts = array($contacts);
    // print_r($contacts);
    if ($error=='') {
        
        $delete_contact_numbers = "DELETE FROM contacts 
        WHERE owner_id=1;";
        $add_contact_numbers = "";
        $contacts_count = count($new_contacts);
        $contacts_count_minus_one = $contacts_count-1;
        if ($contacts_count>0) {
            $add_contact_numbers .= "INSERT INTO contacts(mobile_number, owner_id, type) VALUES ";
            foreach ($new_contacts as $key => $value) { 
                // echo " v: $value ";
                $ins = "('".mysqli_real_escape_string($conn, $value)."', 1, 0)"; 
                $add_contact_numbers .= $ins;
                $add_contact_numbers .= ($key===$contacts_count_minus_one)?";":",";
            }
        }
        $update_footer_sql = "UPDATE footer SET email='$email', address='$address', schedule='$schedule', fb_link='$fb_link';";
        // echo "$delete_contact_numbers $add_contact_numbers $update_footer_sql";
        if (mysqli_multi_query($conn, "$delete_contact_numbers $add_contact_numbers $update_footer_sql"))  {
            header('location:../update-footer/index.php?updated=TRUE');  
            // echo "<script>alert('Footer Updated!');</script>";
            // $conn->close(); 
        }
        else { 
            $error .= 'Something went wrong updating the record in the database.';
        }   
    }
    // print_r( mysqli_real_escape_string($conn, $_POST['contact']));
}



$conn->close(); 

$page = 'update_footer';
include_once('../php-templates/admin-navigation-head.php');
?>

<?php if (isset($_GET['updated']) && $_GET['updated'] && (!isset($error) || $error=='')) { echo "<script>alert('Footer Updated!');</script>";}?>
<div class="container_nu"> 
  <!-- Sidebar -->
  <?php include_once('../php-templates/admin-navigation-left.php'); ?>
  <!-- Page Content -->
  <div class="main_nu">
    <?php include_once('../php-templates/admin-navigation-right.php'); ?>

    <div class="container-fluid">
      <div class="background-head row m-2 my-4"><h4 class="pb-3 m-3 fw-bolder ">Contact Information</h4>
        <div class="container default table-responsive p-4">
          <div class="col-md-8 col-lg-5 ">
        <form class="form form-box px-3" style="padding-top: 100px;position:relative;bottom: 90px;" action="" method="post">
            <?php
                if(isset($error)) 
                    echo '<span class="form__input-error-message">'.$error.'</span><br/>'; 
            ?> 
            <label>Email</label>
            <div  class="mb-3">
                <input type="email" class="form-control" name="email" value="<?php echo $c_email?>"
                placeholder="Email" /> 
                
            </div>
           <label> Mobile Number(s): *Separate each with a nextline and use this format: 09XX-XXX-XXXX*</label><br/>
            <div class="mb-3">
                <textarea  class="form-control" placeholder="Mobile Number" id="floatingTextarea2" name="contact"><?php echo ($c_contact_num)?></textarea> 
                
            </div>
            <label >Address</label>
            <div class="mb-3"> 
                <textarea name="address" class="form-control" placeholder="Address" id="floatingTextarea2"><?php echo $c_address?></textarea> 
                
            </div>
           
            <label>Schedule</label>
            <div class="mb-3"> 
                <textarea name="schedule" class="form-control" placeholder="Schedule" id="floatingTextarea2"><?php echo $c_schedule?></textarea> 
                 
            </div> 
           <label >Facebook</label>
            <div class="mb-3"> 
                <input type="text" class="form-control" name="fb_link" value="<?php echo $c_fb_link?>" placeholder="Facebook Link" /> 
                
            </div> 
          <button class="w-40 btn-primary btn  text-capitalize" type="submit" name="submit">Update Footer</button>
        </form> 
      </div>
    </div>
      </div> 
    </div>

  </div> 
</div>
 
<?php include_once('../php-templates/admin-navigation-tail.php'); ?>