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
    $barangay_select .= "d.barangay_id=$value ";
    if ($key < $barangay_list_length_minus_1) {
      $barangay_select .= "OR ";
    }
  } 
  $select = "SELECT p.id AS id, (IF(name IS NULL, 'Deleted Patient',name)) as name, (IF(email IS NULL, 'Deleted Patient', email))as email, (IF(contact_no IS NULL, 'Deleted Patient', contact_no)) as contact_no,
  (IF(health_center IS NULL, 'Deleted Patient', health_center)) as health_center,
  (IF(details_id IS NULL, 'Deleted Patient', details_id)) as details_id,
  (IF(med_history_id IS NULL, 'Deleted Patient', med_history_id)) as med_history_id, 
  a.date
  FROM appointment AS a
  LEFT JOIN (SELECT u.id AS id, CONCAT(u.first_name,IF(u.mid_initial='', '', CONCAT(' ',u.mid_initial,'.')),' ',u.last_name) AS name, u.email, d.contact_no, health_center,  details_id, med_history_id FROM users as u, details as d, barangay as b 
  WHERE  d.id=u.details_id AND ($barangay_select) AND d.barangay_id=b.id) AS p
  ON a.patient_id=p.id WHERE a.date>='$yester_date' AND a.status=".($pending?0:1).";";
  // echo $yester_date; 

  // echo $select;
  if($result = mysqli_query($conn, $select))  {
    foreach($result as $row)  {
      $id = $row['id'];  
      $name = $row['name'];  
      $e = $row['email'];  
      $c_no = $row['contact_no'];  
      $date = $row['date'];  
      $bgy = $row['health_center'];  
      $det_id = $row['details_id'];    
      array_push($appointment_list, array(
        'id' => $id,
        'name' => $name,  
        'email' => $e,
        'contact' => $c_no,
        'date' => $date,
        'barangay' => $bgy,
        'details_id' => $det_id,
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
  <div id="page-content-wrapper" style="background-color: #f0cac4">
    <?php include_once('../php-templates/admin-navigation-right.php'); ?>

    <div class="container">
      <div class="row bg-light m-3"><?php echo $pending?'Pending':'Approved'?>-appointments

      <?php if (count($_barangay_list)==0){
        echo '<span class="">There are no barangays assigned to you.</span>';
      } else { ?>
        <div class="container default">
          <table class="table mt-5 table-striped table-sm ">
            <thead class="table-dark">
              <tr>
                <th scope="col">#</th>
                <th scope="col">Patient Name</th> 
                <th scope="col">Barangay</th>  
                <th scope="col">Date and Time</th>
                <th scope="col">Contact Number</th>
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
                            <a href="approve-appointment.php?id=<?php echo $value['id'] ?>">
                                <button class="edit">Approve</button></a>
                            <a href="delete-appointment.php?id=<?php echo $value['id'] ?>">
                                <button class="del">Delete</button></a>
                          </td> 
                        <?php }else {?> 
                            <td>
                                <a href="../patients/med-patient.php?id=<?php echo $value['id'] ?>">
                                    <button class="">View Report</button></a> 
                            </td>
                        <?php }?> 
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
 
<?php 
include_once('../php-templates/admin-navigation-tail.php');
?>