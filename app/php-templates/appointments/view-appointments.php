<?php 

session_start();

@include '../php-templates/redirect/admin-page-setter.php';
@include '../php-templates/redirect/midwife-only.php';

$pending = $page=='pending_appointment';
// get assigned barangay of midwife
$session_id = $_SESSION['id'];

@include '../php-templates/midwife/get-assigned-barangays.php';

$appointment_list = [];
if (count($_barangay_list)>0) { 
  $yester_date = date("Y-m-d", strtotime('-1 day'));
  // fetch appointments 
  $barangay_select = '';
  $barangay_list_length_minus_1 = count($_barangay_list)-1;
  foreach ($_barangay_list as $key => $value) { 
    $barangay_select .= "p.barangay_id=$value ";
    if ($key < $barangay_list_length_minus_1) {
      $barangay_select .= "OR ";
    }
  } 
  $select = "SELECT a.patient_id id, a.appointment_id a_id, CONCAT(i.first_name, 
  IF(i.middle_name IS NULL OR i.middle_name='', '', 
      CONCAT(' ', SUBSTRING(i.middle_name, 1, 1), '.')), 
  ' ', i.last_name) name, health_center, date
FROM appointments a, user_details i, barangays b, patient_details p
WHERE a.patient_id=i.user_id AND b.barangay_id=p.barangay_id 
  AND p.user_id=i.user_id AND a.date>='$yester_date 00:00:00'
  AND ($barangay_select)  AND b.assigned_midwife=$session_id
  AND a.status=".($pending?0:1).";";
  
  // echo $yester_date; 

  // echo $select;
  if($result = mysqli_query($conn, $select))  {
    foreach($result as $row)  {
      $id = $row['id'];  
      $contact_num_select = "SELECT mobile_number FROM contacts WHERE type=1 AND owner_id=$id";
      if ($result_contact_num_select = mysqli_query($conn, $contact_num_select)) {
        if (mysqli_num_rows($result_contact_num_select)>0) { 
          $_contact_num = "";
          foreach ($result_contact_num_select as $_key=>$__row) {
              $_contact_num .= ("(".$__row['mobile_number'].") "); 
          }
        } 
      } 
      $c_no = $_contact_num; 
     
      $a_id = $row['a_id'];  
      $name = $row['name'];  
      // $e = $row['email'];  
      // $c_no = $row['contact_no'];  
      $date = $row['date'];  
      $bgy = $row['health_center'];  
      // $det_id = $row['details_id'];    
      array_push($appointment_list, array(
        'id' => $id,
        'a_id' => $a_id,
        'name' => $name,  
        // 'email' => $e,
        'contact' => $c_no,
        'date' => $date,
        'barangay' => $bgy,
        // 'details_id' => $det_id,
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


<div class="d-flex" id="wrapper"> 
  <!-- Sidebar -->
  <?php include_once('../php-templates/admin-navigation-left.php');  ?> 
  <!-- Page Content -->
  <div id="page-content-wrapper">
    <?php include_once('../php-templates/admin-navigation-right.php'); ?>

    <div class="container-fluid default">
      <div  class="background-head row m-2 my-4" ><h4 class="pb-3 m-3 fw-bolder "><?php echo $pending?'Pending':'Approved'?> Appointments</h4><hr>
        <div class="table-padding table-responsive">
      <?php if (count($_barangay_list)==0){
        echo '<span class="">There are no barangays assigned to you.</span>';
      } else { ?> 
        <div class="pagination-sm  col-md-8 col-lg-12" id="table-position">
           <table  class="text-center table mt-5 table-striped table-responsive table-lg table-bordered table-hover display" id="datatables">
            <thead class="table-light" colspan="3">
              <tr>
                <th scope="col" width="6%">#</th>
                <th scope="col">Patient Name</th> 
                <th scope="col">Barangay</th>  
                <th scope="col">Date and Time</th>
                <th scope="col">Contact Number(s)</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
                <?php 
                  if (isset($error)) {
                    echo '<span class="">'.$error.'</span>'; 
                  } 
                  else { 
                    foreach ($appointment_list as $key => $value) {
                ?>    
                    <tr>
                        <th scope="row"><?php echo $key+1; ?></th>
                        <td><?php echo $value['name']; ?></td>
                        <td><?php echo $value['barangay']; ?></td>
                        <td><?php $dtf = date_create($value['date']); 
                            echo date_format($dtf,'F d, Y h:i A'); ?></td>
                        <td><?php echo $value['contact']; ?></td>
                        <?php if ($value['name']=='Deleted Patient') {?>
                            <td>
                              Deleted Patient
                            </td>
                        <?php } else if ($pending) {?>
                          <td>
                            <a href="approve-appointment.php?id=<?php echo $value['a_id'] ?>">
                                <button class="edit btn btn-success btn-sm btn-inverse">Approve</button></a>
                            <!-- <a href="delete-appointment.php?id=<?php //echo $value['a_id'] ?>">
                                <button class="del btn btn-danger btn-sm btn-inverse">Delete</button></a>
                          </td>  -->
                        <?php }else {?> 
                            <td>
                                <a href="../patients/med-patient.php?id=<?php echo $value['id'] ?>">
                                  <button class="edit btn btn-info btn-sm btn-inverse">View Report</button></a>
                               
                        <?php }?> 
                            <a href="cancel-appointment.php?id=<?php echo $value['a_id'] ?>">
                                  <button class="btn btn-danger btn-sm btn-inverse">Cancel</button></a> 
                          </td>
                    </tr>
                <?php 
                    }
                  }
                ?> 
            </tbody>
          </table>
        </div>    
      <?php } ?> 
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
        [10, 25, 30,50, -1],
        [10, 25, 30,50, "All"]
      ],
      responsive: true,
      destroy: true,
      fixedColumns: true,
      responsive: true,
      language:{
        search: "_INPUT_",
        searchPlaceholder: "Search <?php echo $pending?'Pending':'Approved' ?>",
      }
    });
  } );
</script>

<?php 
include_once('../php-templates/admin-navigation-tail.php');
?>