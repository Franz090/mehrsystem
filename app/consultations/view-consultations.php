<?php 

@include '../includes/config.php'; 

$page = 'view_consultations';

session_start();

@include '../php-templates/redirect/admin-page-setter.php';
@include '../php-templates/redirect/not-for-nurse.php';

// get assigned barangay of midwife
 
$session_id = $_SESSION['id']; 

@include '../php-templates/midwife/get-assigned-barangays.php';

$consultation_list = [];
if (count($_barangay_list)>0 && $admin==0 || $admin==-1) { 
  // $yester_date = date("Y-m-d", strtotime('-1 day'));
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
  $patient_str = $admin==-1?"AND $session_id=d.user_id":"";
  $select = "SELECT c.patient_id id, consultation_id c_id, CONCAT(d.first_name, 
  IF(d.middle_name IS NULL OR d.middle_name='', '', 
      CONCAT(' ', SUBSTRING(d.middle_name, 1, 1), '.')), 
  ' ', d.last_name) name, health_center, date, treatment_file
  FROM consultations c, user_details d, barangays b, patient_details p
  WHERE c.patient_id=d.user_id AND b.barangay_id=p.barangay_id 
    AND $barangay_select p.user_id=d.user_id $patient_str;";
  
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
      $c_id = $row['c_id'];  
      $name = $row['name'];   
      $treatment_file = $row['treatment_file']==null?"":substr($row['treatment_file'],15);   
      $date = $row['date'];  
      $bgy = $row['health_center'];  
      array_push($consultation_list, array(
        'id' => $id,
        'treatment_file' => $treatment_file,
        'c_id' => $c_id,
        'name' => $name,  
        'contact' => $c_no,
        'date' => $date,
        'barangay' => $bgy,
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

<!-- <style>
  .table {
   margin: auto;
   width: 100%!important;
   padding-top: 13px;
   
  }
  .btn{
    border-radius: 3px;
    margin: 2px 4px;
  }
  
  h3{
    font-weight: 900;  
    background-color: #ececec;  
    padding-top: 10px;
    position: relative;
    top: 8px;
  }
  a{
    text-decoration: none;
    color: white;
  }
  a:hover{
    color: #e2e5de;
  }
  .btn{
    font-weight: 400;
    font-size: 15px;
    
  } 
</style> -->

<div class="d-flex" id="wrapper"> 
  <!-- Sidebar -->
  <?php include_once('../php-templates/admin-navigation-left.php');  ?> 
  <!-- Page Content -->
  <div id="page-content-wrapper">
    <?php include_once('../php-templates/admin-navigation-right.php'); ?>

    <div class="container-fluid">
       <div class="background-head row m-2 my-4"><h4 class="pb-3 m-3 fw-bolder ">Consultations</h4><hr>
        <div class="table-padding table-responsive">
      <?php if (count($_barangay_list)==0 && $admin==0){
        echo '<span class="">There are no barangays assigned to you.</span>';
      } else { ?> 
         <div class="pagination-sm  col-md-8 col-lg-12" id="table-position">
          <table  class="text-center  table mt-5 table-striped table-responsive table-lg  table-hover display" id="datatables">
            <thead class="table-light" colspan="3">
              <tr>
                <th scope="col" >#</th>
                <?php if ($admin==0) { ?>  
                  <th scope="col">Patient Name</th> 
                <?php } ?>  
                <th scope="col">Treatment File</th>  
                <th scope="col">Barangay</th>  
                <th scope="col">Date and Time</th>
                <?php if ($admin==0) { ?>  
                  <th scope="col">Contact Number(s)</th>
                <?php } ?>  
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
                        <th scope="row"><?php echo $key+1; ?></th>
                        <?php if ($admin==0) { ?>  
                          <td><?php echo $value['name']; ?></td>
                        <?php } ?> 
                        <?php if ($value['treatment_file']=='') { ?>  
                          <td>No File</td> 
                        <?php } else {?>  
                          <td> <a target="_blank" style="color:#000;"
                              href="./view-treatment-file.php?id=<?php echo $value['treatment_file']?>">
                              View Photo</a> 
                          </td> 
                        <?php } ?> 
                        <td><?php echo $value['barangay']; ?></td>
                        <td><?php $dtf = date_create($value['date']); 
                            echo date_format($dtf,'F d, Y h:i A'); ?></td>
                        <?php if ($admin==0) { ?>  
                          <td><?php echo $value['contact']; ?></td> 
                        <?php } ?> 
                        <td>
                          <a href="edit-consultation-record.php?id=<?php echo $value['c_id'] ?>">
                           <div class="p-1">
                            <button class="edit btn btn-success btn-sm btn-inverse">Update</button></a>
                          <a href="../patients/med-patient.php?id=<?php echo $value['id'] ?>">
                            <button type="button" class="text-center btn btn-primary btn-sm btn-inverse ">View Report</button></a>
                            <!-- <a href="cancel-appointment.php?id=<?php //echo $value['c_id'] ?>">
                              <button class="btn btn-danger btn-sm btn-inverse">Cancel</button></a>  -->
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