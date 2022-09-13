<?php

@include '../includes/config.php';

session_start();

@include '../php-templates/redirect/admin-page-setter.php';
@include '../php-templates/redirect/patient-only.php';

$session_id = $_SESSION['id'];
$appointment_list = [];
$yester_date = date("Y-m-d", strtotime('-1 day'));
  
$select = "SELECT CONCAT(u.first_name,IF(u.mid_initial='', '', CONCAT(' ',u.mid_initial,'.')),' ',u.last_name) AS name, 
    a.date a_date, health_center, a.status, contact_no, u.id u_id, a.id a_id
FROM appointment a, details d, users u, med_history m, barangay b
WHERE b.id=d.barangay_id AND u.details_id=d.id AND d.med_history_id=m.id AND a.date>='$yester_date 00:00:00' AND a.patient_id=u.id AND u.id=$session_id";

// echo $select;


if($result = mysqli_query($conn, $select))  {
    foreach($result as $row)  {
      $u_id = $row['u_id'];  
      $a_id = $row['a_id'];  
      $name = $row['name'];  
      $a_date = $row['a_date'];  
      $c_no = $row['contact_no'];  
      $status = $row['status'];  
      $bgy = $row['health_center'];  
      array_push($appointment_list, array(
        'u_id' => $u_id,
        'a_id' => $a_id,
        'name' => $name,  
        'a_date' => $a_date,
        'contact_no' => $c_no,
        'status' => $status,
        'barangay' => $bgy
      ));
    } 
    mysqli_free_result($result);
  } 
  else  { 
    mysqli_free_result($result);
    $error = 'Something went wrong fetching data from the database.'; 
  }  

$page = 'view_appointment';

$conn->close(); 

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
  <div id="page-content-wrapper">
    <?php include_once('../php-templates/admin-navigation-right.php'); ?>

    <div class="container-fluid">
      <div class="row bg-light m-3">Appointments
        <div class="container default table-responsive p-4">
     
        <div class="col-md-8 col-lg-12 ">
          <table class="table mt-5 table-striped table-responsive table-lg table-bordered table-hover display" id="datatables">
            <thead class="table-dark" colspan="3">
              <tr>
                <th scope="col" width="6%">#</th>
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
                        <td><?php $dtf = date_create($value['a_date']); 
                            echo date_format($dtf,'F d, Y h:i A'); ?></td>
                        <td><?php echo $value['contact_no']; ?></td>
                        <td>
                            <a href="../patients/med-patient.php?id=<?php echo $value['u_id'] ?>">
                                <button class="edit btn btn-info btn-sm btn-inverse">View Report</button></a> 
                        <?php if ($value['status']==0)  { ?>
                            <hr/>
                            <a href="delete-appointment.php?id=<?php echo $value['a_id'] ?>">
                              <button class="del btn btn-danger btn-sm btn-inverse">Delete</button></a>
                        <?php } ?>
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
        searchPlaceholder: "Search Appointments",
      }
    });
  } );
</script>

<?php 
include_once('../php-templates/admin-navigation-tail.php');
?>