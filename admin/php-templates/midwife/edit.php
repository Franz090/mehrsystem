<?php 

@include '../includes/config.php';

session_start();

@include '../php-templates/redirect/admin-page-setter.php'; 
@include '../php-templates/redirect/nurse-only.php';

$id_from_get = $_GET['id']; 

// fetch user 

$user_to_edit = "SELECT users.id AS id, first_name, mid_initial, last_name, email, 
    IF(users.status=0, 'Inactive', 'Active') AS status, details_id, contact_no, b_date, barangay_id  
  FROM users, details
  WHERE users.id = $id_from_get AND users.details_id = details.id";
$user_from_db = mysqli_query($conn, $user_to_edit);

if (mysqli_num_rows($user_from_db) > 0) {
  foreach($user_from_db as $row)  {
    $c_id = $row['id'];  
    $c_email = $row['email'];  
    $c_first_name = $row['first_name'];  
    $c_mid_initial = $row['mid_initial'];  
    $c_last_name = $row['last_name'];  
    $c_status = $row['status'];   
    $c_contact = $row['contact_no'];   
    $c_b_date = $row['b_date'];   
    $c_barangay = $row['barangay_id'];   
    $c_details_id = $row['details_id'];   
  }  
  mysqli_free_result($user_from_db); 
} 
else {
  $no_user = 'No such user.'; 
  mysqli_free_result($user_from_db);
}


$barangay_list = [];
// if ($admin==1) { 

  // fetch barangays  
  $select = "SELECT * FROM barangay WHERE assigned_midwife=$c_id OR assigned_midwife IS NULL";
  // echo $select;
   $result_barangay = mysqli_query($conn, $select);

  if(mysqli_num_rows($result_barangay)>0)  {
    foreach($result_barangay as $row)  {
      $id = $row['id'];  
      $name = $row['health_center'];  
      $checked = $row['assigned_midwife']>0?'checked':'';  
      array_push($barangay_list, 
        array('id' => $id,'name' => $name, 'checked' => $checked)
      );
    } 
    mysqli_free_result($result_barangay);
    // print_r($result_barangay); 
  } 
  else  { 
    mysqli_free_result($result_barangay);
    $error = 'Something went wrong fetching data from the database.'; 
  }  
// } 
// else {
  // $session_id = $_SESSION['id'];
  // $barangay_id_to_be_used = $_SESSION['barangay_id'];
  // echo $session_id;
  // $select_b_id = "SELECT barangay_id FROM users,details WHERE users.id=$session_id AND users.details_id=details.id";
  // $result_barangay_id = mysqli_query($conn, $select_b_id);
  // echo "print this ";
  // print_r($result_barangay_id);
  // if(mysqli_num_rows($result_barangay_id)>0)  {
  //   foreach($result_barangay_id as $row)  {
  //     $barangay_id_to_be_used = $row['barangay_id'];    
  //   } 
  //   mysqli_free_result($result_barangay_id);
  //   // print_r($result_barangay);

  // } 
  // else  { 
  //   mysqli_free_result($result_barangay_id);
  //   $error = 'Something went wrong fetching data from the database.'; 
  // }  
// }

// edit
if(isset($_POST['submit'])) {
  $_POST['submit'] = null;
  $error = ''; 

  if (empty($_POST['usermail']) ||  
    empty($_POST['first_name']) ||
    empty($_POST['last_name']) ||
    empty($_POST['contact']) ||
    empty($_POST['b_date']) ||
 
    empty($_POST['status']))
    $error .= 'Fill up input fields that are required (with * mark)! ';
  else {
    $email = mysqli_real_escape_string($conn, $_POST['usermail']);
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $mid_initial = mysqli_real_escape_string($conn, $_POST['mid_initial']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $status = mysqli_real_escape_string($conn, ($_POST['status']=='Inactive'?0:1));
    $details_id = mysqli_real_escape_string($conn, $_POST['details_id']);

    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $b_date = mysqli_real_escape_string($conn, $_POST['b_date']);
 
    // $barangay_id = mysqli_real_escape_string($conn,  
    //   (
    //     $admin==1? 
    //       $_POST['barangay_id']
    //     : 
    //       $c_barangay 
    //   )
    // );
 

    $select = "SELECT * FROM users WHERE email = '$email'";

  
    $result = mysqli_query($conn, $select);
  
    if(mysqli_num_rows($result) > 1)  { 
      $error .= 'The email inputted was already used. ';  
      mysqli_free_result($result);
    } 
    else  {
      foreach($result as $row)   
        $id_from_db = $row['id'];    
      $up1 = "UPDATE users SET first_name='$first_name', mid_initial='$mid_initial', last_name='$last_name', 
        email='$email', status=$status WHERE id=$id_from_db;";
      $up2 = "UPDATE details SET contact_no='$contact', b_date='$b_date'
        WHERE id=$details_id;";
      $update_brgy = '';
      for ($i=0; $i < count($barangay_list); $i++) { 
        $b_id = $barangay_list[$i]['id'];
        $null_update_str = "UPDATE barangay SET assigned_midwife=NULL WHERE id=$b_id;";
        if (isset($_POST['barangay_id'])) {
          // check barangay id is in the post  
          if (in_array($b_id, $_POST['barangay_id'])) {
            $update_brgy .= "UPDATE barangay SET assigned_midwife=$id_from_db WHERE id=$b_id;";
            // echo "bid: $b_id";
          } else { 
            $update_brgy .= $null_update_str;
          }
        } else { 
          $update_brgy .= $null_update_str;
        }
      }
      // foreach($_POST["barangay_id"] as $b_id)
      // { 
      //   $bgy_id = mysqli_real_escape_string($conn, $b_id);
      //   $update_brgy .= "UPDATE barangay SET assigned_midwife=$next_users_id WHERE id=$b_id; "; 
      // } 
      echo "$up1 $up2 $update_brgy";
      if (mysqli_multi_query($conn, "$up1 $up2 $update_brgy"))  {
        mysqli_free_result($result);
        echo "<script>alert('Midwife Record Updated!');</script>"; 
        $conn->close(); 
        header('location:view-midwife.php');  
      //   if (mysqli_query($conn, $up2)) { 
      //   }else {
      //     $error .= 'Something went wrong updating details of midwife into the database.';
      //   }  
      }
      else { 
        mysqli_free_result($result);
        $error .= 'Something went wrong updating the record of midwife in the database.';
      } 
    }  
  } 
} 
 
$conn->close(); 

$page = 'edit_midwife';
include_once('../php-templates/admin-navigation-head.php');
?>
 
<div class="d-flex" id="wrapper">

  <!-- Sidebar -->
  <?php include_once('../php-templates/admin-navigation-left.php'); ?>

  <!-- Page Content -->
  <div id="page-content-wrapper" >
    <?php include_once('../php-templates/admin-navigation-right.php'); ?>

    <div class="container-fluid">
      <div class="row bg-light m-3"><h3>Update Midwife Record</h3>
      <div class="container default table-responsive p-4">
          <div class="col-md-8 col-lg-5 ">
        <?php
          if (isset($no_user))  
            echo '<span class="form__input-error-message">'.$no_user.'</span>';
          else   {
        ?>   
        <form class="form" action="" method="post">
          <input type='hidden' name='details_id' value="<?php echo $c_details_id?>"/>
          <?php 
            if (isset($error))  
              echo '<span class="form__input-error-message">'.$error.'</span>'; 
          ?> 
          <div class="form__input-group">
              <input value="<?php echo $c_email?>" type="text" class="form__input" name="usermail" autofocus placeholder="Email Address*" required>
          </div>
          <div class="form__input-group">
              <input value="<?php echo $c_first_name?>" type="text" class="form__input" name="first_name" placeholder="First Name*" required>
          </div>
          <div class="form__input-group">
              <input value="<?php echo $c_mid_initial?>" type="text" class="form__input" name="mid_initial" placeholder="Middle Initial">
          </div>
          <div class="form__input-group">
              <input value="<?php echo $c_last_name?>" type="text" class="form__input" name="last_name" placeholder="Last Name*" required>
          </div> 
          <div class="form__input-group">
            <input value="<?php echo $c_contact?>"
              type="tel" name="contact" class="form__input" placeholder="Contact Num* (Format:09XX-XXX-XXXX)" 
              pattern="[0-9]{4}-[0-9]{3}-[0-9]{4}" required/>
          </div>
          <div class="form__input-group">
            <label>Birth Date*</label>
            <input value="<?php echo $c_b_date?>"
            type="date" name="b_date" required class="form__input"/>
          </div>
          <div class="form__input-group">
              <label>Status</label>
              <select class="form__input" name="status" >
                  <option value="Inactive" <?php echo $c_status=='Inactive' ? 'selected':''?>>Inactive</option>
                  <option value="Active" <?php echo $c_status=='Active' ? 'selected':''?>>Active</option>
              </select>
          </div>  
 
          <?php
            if (count($barangay_list)>0) { 
          ?>  
 
          <div class="form__input-group">
            <label>Barangay</label>
            <fieldset>      
              <?php  
                foreach ($barangay_list as $key => $value) {
              ?>  
                <input type="checkbox" id="check<?php echo $key ?>" value="<?php echo $value['id'] ?>" <?php echo $value['checked'] ?> name="barangay_id[]"/>
                  <label for="check<?php echo $key ?>"><?php echo $value['name'] ?></label>
                <br/> 
              <?php 
                } 
              ?>     
            </fieldset>     
          </div> 
          <?php 
              }
          ?>  
          <button class="form__button" value="register now" type="submit" name="submit">Update Midwife Record</button> 
        </form> 

        <?php
          }
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