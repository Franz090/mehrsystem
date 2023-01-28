<?php 

@include '../includes/config.php';

session_start();

@include '../php-templates/redirect/admin-page-setter.php'; 
@include '../php-templates/redirect/nurse-only.php';

$id_from_get = $_GET['id']; 
$add_barangay_button = 0;
// fetch user 

$user_to_edit = "SELECT u.user_id id, 
CONCAT(ud.first_name,
  IF(ud.middle_name='' OR ud.middle_name IS NULL, '', CONCAT(' ',SUBSTRING(ud.middle_name,1,1),'.')),' ',ud.last_name) name
  FROM users u, user_details ud
  WHERE u.user_id = $id_from_get AND  u.user_id=ud.user_id";
// $user_to_edit = "SELECT u.user_id id, first_name, middle_name, last_name, email  
//   FROM users u, user_details ud
//   WHERE u.user_id = $id_from_get AND u.user_id = ud.user_id";
$user_from_db = mysqli_query($conn, $user_to_edit);

if (mysqli_num_rows($user_from_db) > 0) {
  foreach($user_from_db as $row)  {
    $c_id = $row['id'];  
    $c_name = $row['name'];  
    // $c_email = $row['email'];  
    // $c_first_name = $row['first_name'];  
    // $c_middle_name = $row['middle_name']==NULL ? '' : $row['middle_name'];  
    // $c_last_name = $row['last_name'];  
    // $select_c_no = "SELECT mobile_number FROM contacts WHERE owner_id=$c_id AND type=1";
    // if ($result_c_no = mysqli_query($conn, $select_c_no)) {
    //   $c_no = '';
    //   foreach ($result_c_no as $row2) {
    //     $c_no .= ($row2['mobile_number']."\r\n"); 
    //   }
    // } 
    // $c_b_date = $row['b_date'];   
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
  $select = "SELECT * FROM barangays WHERE (assigned_midwife=$c_id OR assigned_midwife IS NULL) AND archived=0; ";
  // echo $select;
  $result_barangay = mysqli_query($conn, $select);

  if(mysqli_num_rows($result_barangay)>0)  {
    foreach($result_barangay as $row)  {
      $id = $row['barangay_id'];  
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
    $error = 'Please add at least one barangay to assign the midwife.'; 
    $add_barangay_button = 1;
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

  // if (empty($_POST['usermail']) ||  
  //   empty($_POST['first_name']) ||
  //   empty($_POST['last_name']) ||
  //   empty($_POST['contact']) ||
  //   empty($_POST['b_date']) ||
 
  //   empty($_POST['status']))
  //   $error .= 'Fill up input fields that are required (with * mark)! ';
  // else {
    // $email = mysqli_real_escape_string($conn, $_POST['usermail']);
    // $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    // $mid_initial = mysqli_real_escape_string($conn, $_POST['mid_initial']);
    // $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    // $status = mysqli_real_escape_string($conn, ($_POST['status']=='Inactive'?0:1));
    // $details_id = mysqli_real_escape_string($conn, $_POST['details_id']);

    // $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    // $b_date = mysqli_real_escape_string($conn, $_POST['b_date']);
 
    // $barangay_id = mysqli_real_escape_string($conn,  
    //   (
    //     $admin==1? 
    //       $_POST['barangay_id']
    //     : 
    //       $c_barangay 
    //   )
    // );
 

    // $select = "SELECT * FROM users WHERE email = '$email'";

  
    // $result = mysqli_query($conn, $select);
  
    // if(mysqli_num_rows($result) > 1)  { 
    //   $error .= 'The email inputted was already used. ';  
    //   mysqli_free_result($result);
    // } 
    // else  {
      // foreach($result as $row)   
      //   $id_from_db = $row['id'];    
      // $up1 = "UPDATE users SET first_name='$first_name', mid_initial='$mid_initial', last_name='$last_name', 
      //   email='$email', status=$status WHERE id=$id_from_db;";
      // $up2 = "UPDATE details SET contact_no='$contact', b_date='$b_date'
      //   WHERE id=$details_id;";
      $update_brgy = '';
      for ($i=0; $i < count($barangay_list); $i++) { 
        $b_id = $barangay_list[$i]['id'];
        $null_update_str = "UPDATE barangays SET assigned_midwife=NULL WHERE barangay_id=$b_id ;";
        if (isset($_POST['barangay_id'])) {
          // check barangay id is in the post  
          if (in_array($b_id, $_POST['barangay_id'])) {
            $update_brgy .= "UPDATE barangays SET assigned_midwife=$c_id WHERE barangay_id=$b_id ;";
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
      echo $update_brgy;
      if (mysqli_multi_query($conn, $update_brgy))  {
        echo "<script>alert('Barangays Assigned!');</script>"; 
        $conn->close(); 
        header('location:view-midwife.php');  
      //   if (mysqli_query($conn, $up2)) { 
      //   }else {
      //     $error .= 'Something went wrong updating details of midwife into the database.';
      //   }  
      }
      else { 
        $error .= 'Something went wrong updating the record of midwife in the database.';
      } 
    // }  
  // } 
} 
 
$conn->close(); 

$page = 'edit_midwife';
include_once('../php-templates/admin-navigation-head.php');
?>
 
<div class="container_nu">
<style>
  input[type=checkbox]{
    width: 17px;
    height: 17px;
     accent-color: #28a685;

}


label{
  font-size: 17px;
  font-family: 'Open Sans',sans-serif;
  font-weight: 700;
  color: #352e35;
}
</style>
  <!-- Sidebar -->
  <?php include_once('../php-templates/admin-navigation-left.php'); ?>

  <!-- Page Content -->
  <div class="main_nu" >
    <?php include_once('../php-templates/admin-navigation-right.php'); ?>

    <div class="container-fluid">
      <div class="background-head row m-2 my-4"><h4 class="pb-3 m-3 fw-bolder ">Assign Barangays to <?php echo $c_name?></h4><br><br>
<br><br><br><br><br><br><br><br><br><br><br><br>
   
          <div class="col-md-8 col-lg-5 ">
        <?php
          if (isset($no_user))  
            echo '<span class="form__input-error-message">'.$no_user.'</span>';
          else   {
        ?>   
        <form class="form form-box px-3" style="" method="post">
          <?php 
            if (isset($error))  { 
              echo '<span class="form__input-error-message">'
              .$error.
              '</span> '.
              ($add_barangay_button?
              "<a href='../health-center/add-barangay.php'>
              <button type='button' style=\"color:whitesmoke;\" class=\"form__button btn bg-primary\">
              Add a barangay</button></a>":''); 
            }
            else { 
          ?> 
            
            <?php 
              if (count($barangay_list)>0) { 
            ?>   
              <div class="form__input-group">
                <!-- <label><h6 style="font-size: 18px;font-family:Open Sans,sans-serif;">List of Barangays</h6></label>  -->
                <fieldset style="text-align:center; border:1px solid #fefefe; padding:1rem; border-radius:5px;">      
                  <?php  
                    foreach ($barangay_list as $key => $value) {
                  ?>  
                    <input class="form-check-input"  type="checkbox" id="check<?php echo $key ?>" value="<?php echo $value['id'] ?>" <?php echo $value['checked'] ?> name="barangay_id[]"/>
                      <label class="form-check-label" for="check<?php echo $key ?>"><?php echo $value['name'] ?></label>
                    <br/> 
                  <?php 
                    } 
                  ?>     
                </fieldset>     
              </div> 
            <?php  
                }
            ?>  
            <div class="col-md-12 text-center">
            <button class="btn-primary btn btn-sm w-60" value="register now" type="submit" name="submit">
              Update Assigned Barangays</button> </div>
          <?php 
            } 
          ?>  
        </form>  
        <?php 
          }
        ?>
      
        </div>
      </div>
    </div>
  </div>
</div>
 
<?php 
include_once('../php-templates/admin-navigation-tail.php');
?>