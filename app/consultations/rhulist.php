<?php 

@include '../includes/config.php'; 

$page = 'view_consultations';

session_start();

@include '../php-templates/redirect/admin-page-setter.php';
@include '../php-templates/redirect/nurse-only.php';
 
// get assigned barangay of midwife


$patient_list = []; 
$consultation_list = [];
$curr_date = date("Y-m-d");

$select = "SELECT consultation_id c_id, CONCAT(d.first_name, 
IF(d.middle_name IS NULL OR d.middle_name='', '', 
    CONCAT(' ', SUBSTRING(d.middle_name, 1, 1), '.')), 
' ', d.last_name) name, health_center, date
FROM consultations c, user_details d, barangays b, patient_details p
WHERE c.patient_id=d.user_id AND b.barangay_id=p.barangay_id 
AND p.user_id=d.user_id";
if (isset($_POST['custom_range_consultations'])) {

  $from = $_POST['date_from'];
  $to = $_POST['date_to'];
  $_POST['custom_range_consultations'] = null;
  $select = "$select AND (date BETWEEN '$from 00:00:00' AND '$to 23:59:59');";
  // echo $select;
}

if($result = mysqli_query($conn, $select))  {
    foreach($result as $row) { 
        $c_id = $row['c_id'];   
        $name = $row['name'];   
        $date = $row['date'];  
        array_push($consultation_list, array(
        'c_id' => $c_id,
        'name' => $name,  
        'date' => $date,
        ));
    } 
    mysqli_free_result($result);
} 
else  { 
    mysqli_free_result($result);
    $error = 'Something went wrong fetching data from the database.'; 
}   

$conn->close(); 

include_once('../php-templates/admin-navigation-head.php');
?> 

<div class="container_nu"> 
  <!-- Sidebar -->
  <?php include_once('../php-templates/admin-navigation-left.php');  ?> 
  <!-- Page Content -->
  <div class="main_nu">
    <?php include_once('../php-templates/admin-navigation-right.php'); ?>
    <div class="container-fluid default"> 
      <div class="background-head row m-2 my-4"><h4 class="pb-3 m-3 fw-bolder ">
          Consultations</h4> 
        <div class="table-padding table-responsive"> 
            <div class="pagination-sm  col-md-8 col-lg-12" id="table-position">
              <form method="post">
                <label class="text-bold pt-1 ">Start</label>
                <input type="date" class="form-control-md " name="date_from" required max="<?php echo $curr_date?>" > 

                <label  class="text-bold pt-1 ">End</label> 
                <input class="form-control-md" type="date" name="date_to" required max="<?php echo $curr_date?>">
              
                <button  type="submit" class="btn btn-primary btn-sm" style="margin-right: 5px;" name="custom_range_consultations">Filter</button> 
                <button type="reset" class="btn btn-danger btn-sm" >Reset</button> 
              </form>
              <table  class="text-center  table mt-5  table-responsive table-lg table-hover display" id="datatables">
                <thead class="table-light" colspan="3">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Date and Time</th>
                    <th scope="col">Actions</th>
                  </tr>
                </thead>
                <tbody>
                    <?php 
                      if (isset($error)) {
                        echo '<span class="">'.$error.'</span>'; 
                      } 
                      else { 
                        foreach ($consultation_list as $key => $value) {
                    ?>    
                        <tr> 
                            <th scope="row" class="th-number"><span><?php echo $key+1; ?></span></th>
                            <td><?php echo $value['name']; ?></td>
                            <td><?php $dtf = date_create($value['date']); 
                                echo date_format($dtf,'F d, Y h:i A'); ?></td>
                            <td>
                              <div class="p-1">
                                <?php if ($current_user_is_a_midwife) {?> 
                                  <a href="edit-consultation-record.php?id=<?php echo $value['c_id'] ?>"> 
                                    <button class=" btn btn-success btn-sm btn-inverse">
                                      Edit
                                    </button>
                                  </a>
                                <?php }?>
                                <a href="view-consultation-record.php?c_id=<?php echo $value['c_id'] ?>">
                                  <button type="button" class="text-center btn btn-primary btn-sm btn-inverse ">
                                    View Consultation</button></a>
                              </div>
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
        [30,50, -1],
        [30,50, "All"]
      ],
      destroy: true,
      fixedColumns: true,
      responsive: true,
      language:{
        search: "_INPUT_",
        searchPlaceholder: "Search Consultation",
      }
    });
  } );
</script>

<?php 
include_once('../php-templates/admin-navigation-tail.php');
?>