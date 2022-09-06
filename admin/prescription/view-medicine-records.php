<?php

@include '../includes/config.php';

session_start();

@include '../php-templates/redirect/admin-page-setter.php';
@include '../php-templates/redirect/patient-only.php';

$session_id = $_SESSION['id'];

// fetch treatment records 
$select = "SELECT name, description, tmr.date 
    FROM treat_med_record AS tmr, treat_med AS tm, appointment AS a
    WHERE category=0 && $session_id=patient_id && medicine_record_id=tmr.id && tm.id=tmr.treat_med_id";
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
 
<div class="d-flex" id="wrapper"> 
  <!-- Sidebar -->
  <?php include_once('../php-templates/admin-navigation-left.php'); ?> 
  <!-- Page Content -->
  <div id="page-content-wrapper" style="background-color: #f0cac4">
    <?php include_once('../php-templates/admin-navigation-right.php'); ?>

    <div class="container">
      <div class="row bg-light m-3">view-medicine-records

        <div class="container default">
            
          <?php
            if (isset($_GET['error']))  
              echo '<span class="form__input-error-message">'.$_GET['error'].'</span>'; 
          ?> 
          <table class="table mt-5 table-striped table-sm ">
            <thead class="table-dark">
              <tr>
                <th scope="col">#</th>
                <th scope="col">Medicine Type</th>
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
 
<?php 
include_once('../php-templates/admin-navigation-tail.php');
?>