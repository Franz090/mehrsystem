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
                echo " v: $value ";
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
<style>
    .text_area {
        width: 100%;
        height: 100px;
        border-radius: 5px;
        padding: 1rem;
    }
</style>
<?php if (isset($_GET['updated']) && $_GET['updated'] && (!isset($error) || $error=='')) { echo "<script>alert('Footer Updated!');</script>";}?>
<div class="d-flex" id="wrapper"> 
  <!-- Sidebar -->
  <?php include_once('../php-templates/admin-navigation-left.php'); ?>
  <!-- Page Content -->
  <div id="page-content-wrapper">
    <?php include_once('../php-templates/admin-navigation-right.php'); ?>

    <div class="container-fluid">
      <div class="row bg-light m-3"><h3>Update Footer</h3>
        <div class="container default table-responsive p-4">
          <div class="col-md-8 col-lg-5 ">
        <form class="form" action="" method="post">
            <?php
                if(isset($error)) 
                    echo '<span class="form__input-error-message">'.$error.'</span><br/>'; 
            ?> 
            Contact Information:<br/>
            <label>Email:</label><br/>
            <div class="form__input-group">
                <input type="email" class="form__input" name="email" value="<?php echo $c_email?>"
                placeholder="Email"> 
            </div>
            <div class="form__input-group">
                <label for="contact">Mobile Number(s): *Separate each with a nextline and use this format: 09XX-XXX-XXXX*</label><br/>
                <textarea id="contact" name="contact" class=" text_area"><?php echo ($c_contact_num)?></textarea> 
            </div>
            Address:
            <div class="form__input-group"> 
                <textarea name="address" class="form_input text_area" ><?php echo $c_address?></textarea> 
            </div>
            Schedule:
            <div class="form__input-group"> 
                <textarea name="schedule" class="form_input text_area" ><?php echo $c_schedule?></textarea> 
            </div> 
            Facebook:
            <div class="form__input-group"> 
                <input type="text" class="form__input" name="fb_link" value="<?php echo $c_fb_link?>"
                    placeholder="Facebook Link"> 
            </div> 
          <button class="form__button" type="submit" name="submit">Update Footer</button>
        </form> 
      </div>
    </div>
      </div> 
    </div>

  </div> 
</div>
 
<?php include_once('../php-templates/admin-navigation-tail.php'); ?>