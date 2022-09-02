<?php

@include '../includes/config.php';

session_start();

@include '../php-templates/redirect/admin-page-setter.php';
@include '../php-templates/redirect/midwife-only.php';


// fetch patients 
$select = "SELECT u.id AS id, 
  CONCAT(u.first_name,IF(u.mid_initial='', '', CONCAT(' ',u.mid_initial,'.')),' ',u.last_name) AS name, u.email,  
  IF(u.status=0, 'Inactive', 'Active') AS status, d.contact_no, d.b_date,  health_center,
  details_id, med_history_id
  FROM users as u, details as d, barangay as b
  WHERE u.admin = -1 AND d.id=u.details_id AND d.barangay_id=b.id;";
$result = mysqli_query($conn, $select);
$patient_list = [];

if(mysqli_num_rows($result))  {
  foreach($result as $row)  {
    $id = $row['id'];  
    $name = $row['name'];  
    $e = $row['email'];  
    $s = $row['status'];  
    $c_no = $row['contact_no'];  
    $b_date = $row['b_date'];  
    $bgy = $row['health_center'];  
    $det_id = $row['details_id'];   
    $med_id = $row['med_history_id'];   
    array_push($patient_list, array(
      'id' => $id,
      'name' => $name,  
      'email' => $e,
      'status' => $s,
      'contact' => $c_no,
      'b_date' => $b_date,
      'barangay' => $bgy,
      'details_id' => $det_id,
      'med_history_id' => $med_id
    ));
  } 
  mysqli_free_result($result);
} 
else  { 
  mysqli_free_result($result);
  $error = 'Something went wrong fetching data from the database.'; 
}  


$conn->close(); 

$page = 'view_patient';
include_once('../php-templates/admin-navigation-head.php');
?>
 
<div class="d-flex" id="wrapper">

  <!-- Sidebar -->
  <?php include_once('../php-templates/admin-navigation-left.php');  ?>

  <!-- Page Content -->
  <div id="page-content-wrapper" style="background-color: #f0cac4">
    <?php include_once('../php-templates/admin-navigation-right.php'); ?>

    <div class="container">
      <div class="row bg-light m-3">view-patient

        <div class="container default">
          <table class="table mt-5 table-striped table-sm ">
            <thead class="table-dark">
              <tr>
                <th scope="col">#</th>
                <th scope="col">Patient Name</th> 
                <th scope="col">Email</th>  
                <th scope="col">Status</th> 
                <th scope="col">Contact Number</th>
                <th scope="col">Birthdate</th>
                <th scope="col">Barangay</th> 
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
                <?php 
                  if (isset($error)) {
                    echo '<span class="">'.$error.'</span>'; 
                  }
                  else { 
                    foreach ($patient_list as $key => $value) {
                ?>    
                    <tr>
                        <th scope="row"><?php echo $key+1; ?></th>
                        <td><?php echo $value['name']; ?></td>
                        <td><?php echo $value['email']; ?></td>
                        <td><?php echo $value['status']; ?></td>
                        <td><?php echo $value['contact']; ?></td>
                        <td><?php $dtf = date_create($value['b_date']); echo date_format($dtf,"F d, Y"); ?></td>
                        <td><?php echo $value['barangay']; ?></td>
                        <td>
                          <a href="edit-patient.php?id=<?php echo $value['id'] ?>">
                            <button class="edit">Edit</button></a>
                          <a href="delete-patient.php?id=<?php echo $value['id'] ?>&details_id=<?php echo $value['details_id'] ?>&med_history_id=<?php echo $value['med_history_id'] ?>">
                            <button class="del">Delete</button></a>
                          <hr/>
                          <a href="med-patient.php?id=<?php echo $value['id'] ?>">
                            <button class="med">View Report</button></a>
                        </td>
                    </tr>
                <?php 
                    }
                  }
                ?> 
            </tbody>
          </table>
        </div>

      </div>
    </div>
  </div>
</div>
 
<?php 
include_once('../php-templates/admin-navigation-tail.php');
?>