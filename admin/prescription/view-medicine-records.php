<?php

@include '../includes/config.php';

session_start();

@include '../php-templates/redirect/admin-page-setter.php';
@include '../php-templates/redirect/patient-only.php';

$session_id = $_SESSION['id'];

// fetch treatment records 
$select = "SELECT name, description, tmr.date 
    FROM treat_med_record AS tmr, treat_med AS tm 
    WHERE category=0 && $session_id=patient_id && tm.id=tmr.treat_med_id";
$result = mysqli_query($conn, $select);
// echo $select;
$medicine_list_record = [];

if(mysqli_num_rows($result))  {
  foreach($result as $row)  {
    $name = $row['name'];    
    $description = $row['description'];    
    $date = $row['date'];  
    array_push($medicine_list_record, 
      array('name' => $name, 'description' => $description, 'date' => $date)
    );
  } 
  mysqli_free_result($result);  
} 
else  { 
  mysqli_free_result($result);
  $error = 'Something went wrong fetching data from the database.'; 
}  


$conn->close(); 

$page = 'view_medicine_record';
include_once('../php-templates/admin-navigation-head.php');
?>
 <!-- css internal style -->
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
  <?php include_once('../php-templates/admin-navigation-left.php'); ?> 
  <!-- Page Content -->
  <div id="page-content-wrapper">
    <?php include_once('../php-templates/admin-navigation-right.php'); ?>

    <div class="container-fluid">
      <div class="row bg-light m-3"><h3>View Medicine Records</h3>
      <div class="container default table-responsive">
          <div class="col-md-8 col-lg-12 ">
            
          <?php
            if (isset($_GET['error']))  
              echo '<span class="form__input-error-message">'.$_GET['error'].'</span>'; 
          ?> 
          <table class="table mt-5 table-striped table-responsive table-lg table-bordered table-hover display" id="datatables" >
            <thead class="table-dark" colspan="3">
              <tr>
                <th scope="col">#</th>
                <th scope="col">Medicine Name</th>
                <th scope="col">Description</th>
                <th scope="col">Prescription Date</th>
              </tr>
            </thead>
            <tbody>
              <?php 
                foreach ($medicine_list_record as $key => $value) {
              ?>    
                <tr>
                  <th scope="row"><?php echo $key+1; ?></th>
                  <td><?php echo $value['name']; ?></td>
                  <td><?php echo $value['description']; ?></td>
                  <td><?php echo $value['date']; ?></td> 
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
            searchPlaceholder: "Search Treatment",
          }
        });
      } );
  </script>
 
<?php 
include_once('../php-templates/admin-navigation-tail.php');
?>