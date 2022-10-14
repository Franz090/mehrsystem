<?php 
@include '../includes/config.php';

session_start();

@include '../php-templates/redirect/admin-page-setter.php';
@include '../php-templates/redirect/midwife-only.php';


$session_id = $_SESSION['id'];

$treat_med_records = [];
@include '../php-templates/midwife/get-assigned-barangays.php';
if (count($_barangay_list)>0) {
    // fetch patients  
    $barangay_select = '';
    $barangay_list_length_minus_1 = count($_barangay_list)-1;
    foreach ($_barangay_list as $key => $value) { 
        $barangay_select .= "d.barangay_id=$value ";
        if ($key < $barangay_list_length_minus_1) {
            $barangay_select .= "OR ";
        }
    }
    $select1 = "SELECT tmr.id, 
        CONCAT(first_name,IF(mid_initial='', '', CONCAT(' ',mid_initial,'.')),' ',last_name) AS patient,
        tm.name, tmr.date, health_center, description, treatment_file
        FROM users u, details d, treat_med_record tmr, treat_med tm, barangay b
        WHERE admin=-1 AND ($barangay_select) AND d.id=u.details_id AND
            tmr.treat_med_id=tm.id AND tmr.patient_id=u.id AND b.id=d.barangay_id AND
            category=".($pr_page?'0':'1').";";
    
    if ($result_treat_med_records = mysqli_query($conn, $select1)) {
        foreach($result_treat_med_records as $row) {
            $id = $row['id'];  
            $patient = $row['patient'];  
            $name = $row['name'];  
            $description = $row['description'];  
            $date = $row['date'];  
            $health_center = $row['health_center'];  
            if (!$pr_page) 
                $treatment_file = $row['treatment_file']==NULL?NULL:substr($row['treatment_file'],15); 
            array_push($treat_med_records, 
                array(
                    'id' => $id,
                    'patient' => $patient,
                    'date' => $date,
                    'health_center' => $health_center,
                    'description' =>$description,
                    'treatment_file' => $pr_page?'':$treatment_file,
                    'name' => $name
                ));
        } 
        mysqli_free_result($result_treat_med_records);
        // print_r($result_barangay); 
    } 
    else  { 
        mysqli_free_result($result_treat_med_records);
        $error = 'Something went wrong fetching data from the database.'; 
    }    
}   

$conn->close(); 


include_once('../php-templates/admin-navigation-head.php');
?><!-- css internal style -->
<style>


</style>
<div class="d-flex" id="wrapper"> 
<!-- Sidebar -->
<?php include_once('../php-templates/admin-navigation-left.php'); ?> 
<!-- Page Content -->
<div id="page-content-wrapper">
  <?php include_once('../php-templates/admin-navigation-right.php'); ?>

  <div class="container-fluid">
    <div class="row bg-light m-3"><h3>View <?php echo $pr_page?'Prescription':'Treatment';?> Records</h3>
    <div class="container default table-responsive">
        <div class="pagination-sm  col-md-8 col-lg-12 ">
          
        <?php
          if (isset($error))  
            echo '<span class="form__input-error-message">'.$error.'</span>'; 
        ?> 
        <table class="table mt-5 table-striped table-responsive table-lg table-bordered table-hover display" id="datatables" >
          <thead class="table-dark" colspan="3">
            <tr>
              <th scope="col">#</th>
              <th scope="col">Patient</th> 
              <th scope="col"><?php echo $pr_page?'Medicine Name':'Treatment Type';?></th>
              <th scope="col">Description</th>
              <?php if (!$pr_page) { ?>  
                <th scope="col">Treatment File</th>
              <?php } ?> 
              <th scope="col"><?php echo $pr_page?'Prescription':'Treatment';?> Date</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php 
              foreach ($treat_med_records as $key => $value) {
            ?>    
              <tr>
                <th scope="row"><?php echo $key+1; ?></th>
                <td><?php echo $value['patient']; ?></td>
                <td><?php echo $value['name']; ?></td>
                <td><?php echo $value['description']; ?></td>
                <?php if (!$pr_page) { 
                    if ($value['treatment_file']==NULL) {?>  
                        <td>No File</td> 
                    <?php } else {?>  
                        <td> <a target="_blank" style="color:#000;"
                            href="./view-treatment-file.php?id=<?php echo $value['treatment_file']?>">
                            View Photo</a> </td> 
                    <?php } 
                } ?> 
                <td><?php echo $value['date']; ?></td> 
                <td> 
                    <a href="edit-<?php echo $pr_page?'prescription':'treatment' ?>-record.php?id=<?php echo $value['id'] ?>">
                        <button class="edit btn btn-success btn-sm btn-inverse">Update</button></a>
                    <!-- <a href="delete-treatment-record.php?id=<?php //echo $value['id'] ?>">  -->
                    <!-- <button class="del btn btn-danger btn-sm btn-inverse" onclick="temp_func()">
                    Delete</button>  -->
                    <!-- </a>     -->
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
          searchPlaceholder: "Search <?php echo $pr_page?'Prescription':'Treatment';?> Record",
        }
      });
    } );
</script>

<?php 
include_once('../php-templates/admin-navigation-tail.php');
?>