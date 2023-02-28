<?php 

@include '../includes/config.php'; 

$page = 'view_consultations';

session_start();

@include '../php-templates/redirect/admin-page-setter.php';
@include '../php-templates/redirect/patient-status-checker.php';
@include '../php-templates/redirect/not-for-nurse.php';
 
// get assigned barangay of midwife

if ($current_user_is_a_midwife) {
  $patient_id_from_get = $_GET['id'];
}

$session_id = $_SESSION['id']; 

@include '../php-templates/midwife/get-assigned-barangays.php';

$patient_list = []; 
$consultation_list = [];
if (count($_barangay_list)>0 && $admin==0 || $admin==-1) { 
  // fetch consultations 
  $barangay_select = '';
  $barangay_list_length_minus_1 = count($_barangay_list)-1;
  foreach ($_barangay_list as $key => $value) { 
    if ($key==0) {
      $barangay_select .= "(";
    }
    $barangay_select .= "p.barangay_id=$value ";
   
    if ($key < $barangay_list_length_minus_1) {
      $barangay_select .= "OR ";
    } else {
      $barangay_select .= ") AND";
    }
  } 
  $patient_str = $admin==-1?"AND $session_id=d.user_id":"AND $patient_id_from_get=d.user_id";
  $select = "SELECT consultation_id c_id, CONCAT(d.first_name, 
  IF(d.middle_name IS NULL OR d.middle_name='', '', 
      CONCAT(' ', SUBSTRING(d.middle_name, 1, 1), '.')), 
  ' ', d.last_name) name, health_center, date
  FROM consultations c, user_details d, barangays b, patient_details p
  WHERE c.patient_id=d.user_id AND b.barangay_id=p.barangay_id 
    AND $barangay_select p.user_id=d.user_id $patient_str;";
  // echo $select;

  // echo $select;
  if($result = mysqli_query($conn, $select))  {
    foreach($result as $row) { 
      $c_id = $row['c_id'];   
      $name = $row['name'];   
      $date = $row['date'];  
      array_push($consultation_list, array(
        'c_id' => $c_id,
        // 'name' => $name,  
        'date' => $date,
      ));
    } 
    mysqli_free_result($result);
  } 
  else  { 
    mysqli_free_result($result);
    $error = 'Something went wrong fetching data from the database.'; 
  }   
}  

$conn->close(); 

include_once('../php-templates/admin-navigation-head.php');
?> 

<div class="container_nu"> 
  <!-- Sidebar -->
  <?php include_once('../php-templates/admin-navigation-left.php');  ?> 
  <!-- Page Content -->
  <div class="main_nu">
    <?php include_once('../php-templates/admin-navigation-right.php'); ?>
    <div class="container-fluid default"> 
      <div class="background-head row m-2 my-4"><h4 class="pb-3 m-3 fw-bolder ">
          <?php echo $current_user_is_a_patient?'My ':''?>Consultations<?php echo $current_user_is_a_midwife?" of $name":''?></h4>
          <?php if ($current_user_is_a_midwife) {?> 
            <p><a href="view-consultations.php">Go to Consultations (List of Patients)</a></p>
          <?php } ?>
        <div class="table-padding table-responsive">
          <?php 
          if (count($_barangay_list)==0 && $admin==0){
            echo '<span class="">There are no barangays assigned to you.</span>';
          } else { ?> 
            <div class="pagination-sm  col-md-8 col-lg-12" id="table-position">
              <table  class="text-center  table mt-5  table-responsive table-lg table-hover display" id="datatables">
                <thead class="table-light" colspan="3">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Date and Time</th>
                    <th scope="col">Actions</th>
                  </tr>
                </thead>
                <tbody>
                    <?php 
                      if (isset($error)) {
                        echo '<span class="">'.$error.'</span>'; 
                      } 
                      else { 
                        foreach ($consultation_list as $key => $value) {
                    ?>    
                        <tr> 
                            <th scope="row" class="th-number"><span><?php echo $key+1; ?></span></th>
                            <td><?php $dtf = date_create($value['date']); 
                                echo date_format($dtf,'F d, Y h:i A'); ?></td>
                            <td>
                              <div class="p-1">
                                <?php if ($current_user_is_a_midwife) {?> 
                                  <a href="edit-consultation-record.php?id=<?php echo $value['c_id'] ?>"> 
                                    <button class=" btn btn-success btn-sm btn-inverse">
                                      Edit
                                    </button>
                                  </a>
                                <?php }?>
                                <a href="view-consultation-record.php?c_id=<?php echo $value['c_id'] ?>">
                                  <button type="button" class="text-center btn btn-primary btn-sm btn-inverse ">
                                    View Consultation</button></a>
                              </div>
                            </td>
                        </tr>
                    <?php 
                        }
                      }
                    ?> 
                </tbody>
              </table>
            </div>    
          <?php 
          } ?> 
        </div>              
      </div>
    </div>

  </div>
</div>
<script>
  $(document).ready( function () {
    $('#datatables').DataTable({
      "pagingType": "full_numbers",
      "lengthMenu":[
        [30,50, -1],
        [30,50, "All"]
      ],
      destroy: true,
      fixedColumns: true,
      responsive: true,
      language:{
        search: "_INPUT_",
        searchPlaceholder: "Search Consultation",
      }
    });
  } );
</script>

<?php 
include_once('../php-templates/admin-navigation-tail.php');
?>