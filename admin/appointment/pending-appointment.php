<?php

@include '../includes/config.php';

session_start();

@include '../php-templates/redirect/admin-page-setter.php';
@include '../php-templates/redirect/midwife-only.php';

$yester_date = date("Y-m-d", strtotime('-1 day'));
// fetch appointments 
$select = "SELECT a.id AS id,
  CONCAT(u.first_name,IF(u.mid_initial='', '', CONCAT(' ',u.mid_initial,'.')),' ',u.last_name) AS name, u.email,  
  d.contact_no, health_center, a.date,
  details_id, med_history_id
  FROM users as u, details as d, barangay as b, appointment as a
  WHERE a.patient_id = u.id AND d.id=u.details_id AND d.barangay_id=b.id AND a.date>='$yester_date' AND a.status=0;";
// echo $yester_date; 
$appointment_list = [];

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


$conn->close(); 

$page = 'pending_appointment';
include_once('../php-templates/admin-navigation-head.php');
?>
  <style>
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
  

  </style>
<div class="d-flex" id="wrapper">

  <!-- Sidebar -->
  <?php include_once('../php-templates/admin-navigation-left.php');  ?>

  <!-- Page Content -->
  <div id="page-content-wrapper" >
    <?php include_once('../php-templates/admin-navigation-right.php'); ?>

    <div class="container-fluid">
      <div class="row bg-light m-3"><h3>Pending Appointments</h3>

        <div class="container default table-responsive p-4">
          <div class="col-md-8 col-lg-12 ">
          <table class="table mt-5 table-striped table-responsive table-lg table-bordered table-hover display" id="datatables">
            <thead class="table-dark" colspan="3">
              <tr>
                <th scope="col" width="6%">#</th>
                <th scope="col">Patient Name</th> 
                <th scope="col">Barangay</th>  
                <th scope="col">Date and Time</th>
                <th scope="col" >Contact Number</th>
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
                        <td>
                            <a href="approve-appointment.php?id=<?php echo $value['id'] ?>">
                                <button class="edit">Approve</button></a>
                            <a href="delete-appointment.php?id=<?php echo $value['id'] ?>">
                                <button class="del">Delete</button></a>
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
            searchPlaceholder: "Search Pending",
          }
        });
      } );
  </script>
 
<?php 
include_once('../php-templates/admin-navigation-tail.php');
?>