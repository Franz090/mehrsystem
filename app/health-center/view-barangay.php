<?php

@include '../includes/config.php';

session_start();

@include '../php-templates/redirect/admin-page-setter.php';
@include '../php-templates/redirect/nurse-only.php';


    
// fetch barangays 
$select = "SELECT barangay_id, health_center, 
  IF(assigned_midwife IS NULL, 'None', CONCAT(first_name, 
    IF(middle_name IS NULL OR middle_name='', '', 
        CONCAT(' ', SUBSTRING(middle_name, 1, 1), '.')), 
    ' ', last_name)) midwife
  FROM barangays 
  LEFT JOIN users ON assigned_midwife=user_id 
  LEFT JOIN user_details USING(user_id) WHERE archived=0";

  // echo $select;
$result = mysqli_query($conn, $select);
$barangay_list = [];

if(mysqli_num_rows($result))  {
  foreach($result as $row)  {
    $id = $row['barangay_id'];  
    $h_center = $row['health_center'];    
    $midwife = $row['midwife'];    
    array_push($barangay_list, array('id' => $id,'health_center' => $h_center, 'midwife' => $midwife));
  } 
  mysqli_free_result($result);
  // print_r($barangay_list);

} 
else  { 
  mysqli_free_result($result);
  $error = 'Something went wrong fetching data from the database.'; 
}  

// register
if(isset($_POST['submit'])) {
  $_POST['submit'] = null;
  $error = '';  
  if (empty($_POST['health_center']))
    $error .= 'Fill up input fields that are required (with * mark)! ';
  else {
    $health_center = mysqli_real_escape_string($conn, $_POST['health_center']); 
   
    $insert = "INSERT INTO barangays(health_center, assigned_midwife, archived) 
      VALUES('$health_center', NULL, 0)";
    if (mysqli_query($conn, $insert))  {
      echo "<script>alert('Barangay Added!');window.location.href='./view-barangay.php';</script>";
    }
    else { 
        $error .= 'Something went wrong inserting into the database.';
    } 
  } 
} 

$conn->close(); 
$page = 'view_barangay';
include_once('../php-templates/admin-navigation-head.php');
?>
 

<div class="container_nu"> 
  <!-- Sidebar -->
  <?php include_once('../php-templates/admin-navigation-left.php'); ?> 
  <!-- Page Content -->
  <div class="main_nu"> 
    <?php include_once('../php-templates/admin-navigation-right.php'); ?>


<!-- Modal -->
<div class="modal fade" id="add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Barangay</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        <div class="modal-body">
        <form class="m-3" action="" method="POST" id="add_barangay_form">
            
          <div >
             <label>Barangay Health Center</label>
            <input type="text" class="form-control" name="health_center"  placeholder="Barangay Health Center" id="floatingPassword"  >
            
          </div> 
        </form>
      </div>
      <div class="modal-footer">
       
        <button class="btn btn-primary" type="submit" name="submit" form="add_barangay_form">Register Barangay</button>
      </div>
    </div>
  </div>
</div>

    <div class="container-fluid default">
      <div class="background-head row m-2 my-4"><h4 class="pb-3 m-3 fw-bolder ">View Barangay</h4>
 <div class="d-flex justify-content-between"> 
  <div class="d-flex align-items-start">
            <button class="btn btn-primary btn-sm"  data-bs-toggle="modal" data-bs-target="#add"> Add Barangay </button>
        </div>
          <div class="d-flex align-items-end">
            <a href="archived-barangays.php"><button class="btn btn-outline-default btn-sm" >  See Archived Barangays</button></a>
        </div>
     </div>
      <div  class="table-padding table-responsive mt-1 px-2">
          <div class="col-md-8 col-lg-12 pagination-sm " id="table-position">
          <?php
            if (isset($_GET['error']))  
              echo '<span class="form__input-error-message">'.$_GET['error'].'</span>';
            
          ?> 
            <table  class="text-center  table mt-5  table-responsive table-lg  table-hover display" id="datatables">
            <thead class="table-light" colspan="3">
                <tr>
                  <th scope="col" class="col-sm-2">#</th>
                  <th scope="col" class="col-md-5">Barangay</th>
                  <th scope="col" class="col-md-3">Assigned Midwife</th>
                  <!-- <th scope="col" class="col-sm-2">Status</th> -->
                  <th scope="col" class="col-lg-6">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                  foreach ($barangay_list as $key => $value) {
                ?>    
                  <tr>
                    <th scope="row" class="th-number"><span><?php echo $key+1; ?></span></th>
                    <td><?php echo $value['health_center']; ?></td>
                    <td class="td-bold"><?php echo $value['midwife']; ?></td>
                    <!-- <td><?php //echo $value['status']; ?></td> -->
                    <td>
                      <a href="edit-barangay.php?id=<?php echo $value['id'] ?>">
                        <button class="edit btn btn-success btn-sm btn-inverse">Edit</button></a>
                      <a href="delete-barangay.php?id=<?php echo $value['id'] ?>">
                        <button class="del btn btn-danger btn-sm btn-inverse" >Archive</button>
                      </a>
                    </td>
                  </tr>
                <?php 
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
        searchPlaceholder: "Search Barangay",
      }
    });
  } );
</script> 
<?php 
include_once('../php-templates/admin-navigation-tail.php');
?>