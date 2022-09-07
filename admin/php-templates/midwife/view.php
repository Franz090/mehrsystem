<?php

@include '../includes/config.php';

session_start();

@include '../php-templates/redirect/admin-page-setter.php';
@include '../php-templates/redirect/not-for-patient.php';

$midwife_select = "SELECT u.id AS id, 
  CONCAT(u.first_name,IF(u.mid_initial='', '', CONCAT(' ',u.mid_initial,'.')),' ',u.last_name) AS name, u.email,  
  IF(u.status=0, 'Inactive', 'Active') AS status, d.contact_no, d.b_date,
  details_id 
  FROM users as u, details as d 
  WHERE u.admin = 0 AND d.id=u.details_id";
// fetch nurses 
$select = "SELECT main.id, name, email, main.status, contact_no, b_date, details_id, health_center
FROM 
	($midwife_select) as main 
LEFT JOIN barangay as b
ON main.id=b.assigned_midwife;";
$result = mysqli_query($conn, $admin==1?$select:$midwife_select);
$midwife_list = [];

if(mysqli_num_rows($result))  {
  foreach($result as $row)  {
    $id = $row['id'];  
    $name = $row['name'];  
    $e = $row['email'];  
    $s = $row['status'];  
    $c_no = $row['contact_no'];  
    $b_date = $row['b_date'];  
    $bgy = $admin==1?$row['health_center']:'';  
    $det_id = $row['details_id'];  
    array_push($midwife_list, array(
      'id' => $id,
      'name' => $name,  
      'email' => $e,
      'status' => $s,
      'contact' => $c_no,
      'b_date' => $b_date,
      'barangay' => $bgy,
      'details_id' => $det_id
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
<style>
  .table-condensed {
    width: 100% !important;
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
    font-family: arial,sans-serif;
  } 
</style>

<div class="d-flex" id="wrapper"> 
  <!-- Sidebar --> 
  <?php include_once('../php-templates/admin-navigation-left.php'); ?> 
  <!-- Page Content -->
  <div id="page-content-wrapper" >
    <?php include_once('../php-templates/admin-navigation-right.php'); ?>

    <div class="container-fluid">
      <div class="row bg-light m-3"><h3>View Midwife</h3>

        <div class="container default table-responsive-sm p-4">
          <div class="col-md-8 col-lg-12 table-responsive-md">
            <table class="table mt-5 table-striped table-lg table-bordered table-hover table-condensed display" id="datatables">
              <thead class="table-dark" colspan="3"> 
                <tr>
                  <th scope="col" class="col-sm-1">#</th>
                  <th scope="col">Midwife Name</th>
  
                  <!-- <?php if ($admin==1) { ?>
                    <th scope="col" >Email</th>
                  <?php } ?> -->

                  <th scope="col">Status</th>
                  <?php if ($admin==1) { ?>
                    <th scope="col">Contact No</th>
                    <!-- <th scope="col">Birthdate</th> -->
                    <th scope="col">Barangay</th>
                  <?php } ?>
                  <?php if ($admin==1) {?> 
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
  
                    <!-- <?php if ($admin==1) { ?>  
                      <td><?php echo $value['email']; ?></td>
                    <?php } ?> -->
                    <td><?php echo $value['status']; ?></td>
                    <?php if ($admin==1) { ?>
                      <td><?php echo $value['contact']; ?></td>
                      <!-- <td><?php //$dtf = date_create($value['b_date']); echo date_format($dtf,"F d, Y"); ?></td> -->
                      <td><?php echo $value['barangay']; ?></td>
                    <?php } ?>
                    <?php if ($admin==1) {?>
                      <td>
                        <a href="edit-midwife.php?id=<?php echo $value['id'] ?>">
                          <button class="edit btn btn-success btn-sm btn-inverse">Edit</button></a>
                        <?php //if ($value['id']!=$_SESSION['id']) { ?>
                          <!-- <a href="delete-midwife.php?id=<?php //echo $value['id'] ?>&details_id=<?php //echo $value['details_id'] ?>">  -->
                            <button class="del btn btn-danger btn-sm btn-inverse" onclick="temp_func()">
                            Delete</button> 
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