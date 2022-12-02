<?php

@include '../includes/config.php';

session_start();

@include '../php-templates/redirect/admin-page-setter.php';
@include '../php-templates/redirect/nurse-only.php';

$midwife_select = "SELECT u.user_id AS user_id, 
CONCAT(ud.first_name,
  IF(ud.middle_name='' OR ud.middle_name IS NULL, '', CONCAT(' ',SUBSTRING(ud.middle_name,1,1),'.')),' ',ud.last_name) AS name, u.email 
FROM users as u, 
  user_details as ud 
WHERE u.role=0 AND ud.user_id=u.user_id";
// echo $midwife_select;
// fetch nurses 
$select = "SELECT main.user_id id, name, email, health_center
FROM 
	($midwife_select) as main 
LEFT JOIN barangays as b
ON main.user_id=b.assigned_midwife;";
// echo $select;

$result = mysqli_query($conn, $admin==1?$select:$midwife_select);
$midwife_list = [];

if(mysqli_num_rows($result))  {
  foreach($result as $row)  {
    $id = $row['id'];   
    $name = $row['name'];  
    $e = $row['email'];   
    $bgy = $admin==1?$row['health_center']:'';  
    // $det_id = $row['user_details_id'];  
    array_push($midwife_list, array(
      'id' => $id,
      'name' => $name,  
      'email' => $e,
      // 'status' => $s,
      // 'contact' => $c_no,
      // 'b_date' => $b_date,
      'barangay' => $bgy,
      // 'details_id' => $det_id
    ));
  } 
  mysqli_free_result($result);
  // print_r($midwife_list);

} 
else  { 
  mysqli_free_result($result);
  $error = 'Something went wrong fetching data from the database.'; 
}   

$conn->close(); 

$page = 'view_midwife';
include_once('../php-templates/admin-navigation-head.php');
?> 
<!-- style css -->


<div class="container_nu"> 
  <!-- Sidebar --> 
  <?php include_once('../php-templates/admin-navigation-left.php'); ?> 
  <!-- Page Content -->
  <div class="main_nu">
    <?php include_once('../php-templates/admin-navigation-right.php'); ?>

    <div class="container-fluid default">
      <div class="background-head row m-2 my-4"><h4 class="pb-3 m-3 fw-bolder ">View Midwife</h4>

        <div class="table-padding table-responsive">
          <div class="col-md-8 col-lg-12" id="table-position">
            <table class="text-center  table mt-5 table-striped table-responsive table-lg  table-hover display" id="datatables">
            <thead class="table-light" colspan="3"> 
                <tr>
                  <th scope="col" class="col-sm-1">#</th>
                  <th scope="col">Midwife Name</th> 
                  <!-- <th scope="col">Status</th> -->
                  <?php if ($admin==1) { ?>
                    <!-- <th scope="col">Contact No</th> -->
                    <!-- <th scope="col">Birthdate</th> -->
                    <th scope="col">Barangay</th> 
                    <th scope="col">Actions</th>
                  <?php }?>
                </tr>
              </thead>
              <tbody>
                <?php 
                  foreach ($midwife_list as $key => $value) {
                ?>    
                
                  <tr>
                    <th scope="row"><?php echo $key+1; ?></th>
                    <td><?php echo $value['name']; ?></td> 
                    <!-- <td><?php //echo $value['status']; ?></td> -->
                    <?php if ($admin==1) { ?>
                      <!-- <td><?php //echo $value['contact']; ?></td> -->
                      <td><?php echo $value['barangay']; ?></td> 
                      <td>
                        <a href="edit-midwife.php?id=<?php echo $value['id'] ?>">
                          <button class="edit btn btn-success btn-sm btn-inverse">Assign Barangays</button></a>
                        <?php //if ($value['id']!=$_SESSION['id']) { ?>
                          <!-- <a href="delete-midwife.php?id=<?php //echo $value['id'] ?>&details_id=<?php //echo $value['details_id'] ?>">  -->
                            <!-- <button class="del btn btn-danger btn-sm btn-inverse" onclick="temp_func()">
                            Delete</button>  -->
                            <!-- </a>     -->
                        <?php //} ?> 
                      </td>
                    <?php }?>
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
        searchPlaceholder: "Search Midwife",
      }
    });
  });
</script>
 
<?php 
include_once('../php-templates/admin-navigation-tail.php');
?>