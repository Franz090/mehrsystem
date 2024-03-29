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
  LEFT JOIN user_details USING(user_id) 
  WHERE archived=1";

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


$conn->close(); 

$page = 'archived_barangays';
include_once('../php-templates/admin-navigation-head.php');
?>
 

<div class="container_nu"> 
  <!-- Sidebar -->
  <?php include_once('../php-templates/admin-navigation-left.php'); ?> 
  <!-- Page Content -->
  <div class="main_nu"> 
    <?php include_once('../php-templates/admin-navigation-right.php'); ?>

    <div class="container-fluid default">
      <div class="background-head row m-2 my-4"><h4 class="pb-3 m-3 fw-bolder ">Archived Barangays</h4>
      <div class="d-flex flex-row-reverse">
            <a href="view-barangay.php"><button class="btn btn-outline-default btn-sm" > View Barangay</button></a>
        </div>

        <div class="table-padding table-responsive">
          <div class="pagination-sm col-md-8 col-lg-12 " id="table-position">
          <?php
            if (isset($_GET['error']))  
              echo '<span class="form__input-error-message">'.$_GET['error'].'</span>';
            
          ?> 
            <table class="text-center  table mt-5 table-responsive table-lg table-hover display" id="datatables">
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
                    <th scope="row"><?php echo $key+1; ?></th>
                    <td><?php echo $value['health_center']; ?></td>
                    <td><?php echo $value['midwife']; ?></td>
                    <!-- <td><?php //echo $value['status']; ?></td> -->
                    <td> 
                      <a href="restore-barangay.php?id=<?php echo $value['id'] ?>">
                        <button class="del btn btn-primary btn-sm btn-inverse" >Restore</button>
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

      </div<>
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