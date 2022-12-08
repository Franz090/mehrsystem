<?php 

@include '../includes/config.php'; 

$page = 'infant_vaccinations';

session_start();

@include '../php-templates/redirect/admin-page-setter.php';
@include '../php-templates/redirect/patient-status-checker.php';
@include '../php-templates/redirect/not-for-nurse.php';
 
// get assigned barangay of midwife
 
$session_id = $_SESSION['id']; 

@include '../php-templates/midwife/get-assigned-barangays.php';

// get infant vaccination records 

$complete_shots_of_vaccines = 15;
$infant_list = [];


if (count($_barangay_list)>0 && $admin==0 || $admin==-1) { 
    // $yester_date = date("Y-m-d", strtotime('-1 day'));
    // fetch consultations 
    $barangay_select = '';
    $patient_id = $current_user_is_a_midwife? '': "AND i.user_id=$session_id";
    $barangay_list_length_minus_1 = count($_barangay_list)-1;
    foreach ($_barangay_list as $key => $value) { 
        if ($key==0) {
        $barangay_select .= "AND (";
        }
        $barangay_select .= "b.barangay_id=$value ";
    
        if ($key < $barangay_list_length_minus_1) {
        $barangay_select .= "OR ";
        } else {
        $barangay_select .= ")";
        }
    } 

    $select_infant_list = "SELECT main.infant_id, infant_name, c_vaccinations, main.user_id
    FROM (SELECT i.infant_id, CONCAT(i.first_name, 
        IF(i.middle_name IS NULL OR i.middle_name='', '', 
            CONCAT(' ', SUBSTRING(i.middle_name, 1, 1), '.')), 
        ' ', i.last_name) infant_name, i.user_id
        FROM infants i, patient_details ud, barangays b WHERE i.user_id=ud.user_id AND ud.barangay_id=b.barangay_id AND b.archived=0 $patient_id $barangay_select) main
        LEFT JOIN 
        (SELECT infant_id, COUNT(infant_id) c_vaccinations FROM infant_vac_records GROUP BY infant_id) c
        USING (infant_id)"; 


    // echo $select_infant_list;
    if($result_infant_list = mysqli_query($conn, $select_infant_list))  {
    foreach($result_infant_list as $row)  {
        $id = $row['infant_id'];  
        $name = $row['infant_name'];  
        $c_vaccinations = $row['c_vaccinations'];   
        array_push($infant_list, array(
        'id' => $id,
        'name' => $name, 
        'status' => ($c_vaccinations==$complete_shots_of_vaccines
            ?'Completed':("Incomplete (" . ($c_vaccinations?$c_vaccinations:'0')."/$complete_shots_of_vaccines)"))));
    } 
    mysqli_free_result($result_infant_list);
    // print_r($nurse_list);

    } 
    else  { 
    $error = 'Something went wrong fetching data from the database.'; 
    }   
   
} 

$infant_vacc_list = [];
$past_6_months = date("Y-m-d", strtotime('-5 months'));

$select_infant_vacc = "SELECT date, type 
FROM infant_vac_records ivr, users u, infants i, patient_details p, barangays b 
WHERE date>='$past_6_months 00:00:00' AND u.user_id=i.user_id AND i.infant_id=ivr.infant_id 
    AND u.user_id=p.user_id AND p.barangay_id=b.barangay_id 
    AND b.assigned_midwife=$session_id AND p.status=1
    AND b.archived=0
ORDER BY date ASC";

// echo $select_infant_vacc;
if($result_infant_vacc = mysqli_query($conn, $select_infant_vacc))  {
    foreach($result_infant_vacc as $row)  { 
        $date = $row['date'];  
        $type = $row['type'];  
        array_push($infant_vacc_list, array(
            'date' => substr($date,0,7),
            'type' => $type
        ));
    } 
    mysqli_free_result($result_infant_vacc); 
} 
else  { 
    $error = 'Something went wrong fetching data from the database.'; 
}   

// $infants = [];



$conn->close(); 

include_once('../php-templates/admin-navigation-head.php');
?> 

<div class="container_nu"> 
  <!-- Sidebar -->
  <?php include_once('../php-templates/admin-navigation-left.php');  ?> 
  <!-- Page Content -->
  <div class="main_nu">
    <?php include_once('../php-templates/admin-navigation-right.php'); ?>

    <div class="container-fluid">
       <div class="background-head row m-2 my-4"><h4 class="pb-3 m-3 fw-bolder ">Infant Records</h4>
 
        <div class="table-padding table-responsive">
      <?php if (count($_barangay_list)==0 && $admin==0){
        echo '<span class="">There are no barangays assigned to you.</span>';
      } else { ?> 
            <div>
                <a href="./add-infant.php"><button class="btn btn-primary">
                    Add Infant
                </button> </a>
            </div>
            <br>
         <div class="pagination-sm  col-md-8 col-lg-12" id="table-position">
          <table  class="text-center  table mt-5 table-striped table-responsive table-lg  table-hover display" id="datatables">
            <thead class="table-light" colspan="3">
              <tr>
                <th scope="col" >#</th>
                <th scope="col">Infant Birth Names</th> 
                <th scope="col">Vaccination Status</th>
            <?php if ($current_user_is_a_midwife) { ?> 
                <th scope="col">Action</th>
            <?php } ?> 
              </tr>
            </thead>
            <tbody>
        <?php 
            if (isset($error)) {
                echo '<span class="">'.$error.'</span>'; 
            } 
            else { 
                foreach ($infant_list as $key => $value) {
        ?>    
            <tr>
                <th scope="row"><?php echo ($key+1);?></th>
                <td><?php echo $value['name'];?></td>
                <td><?php echo $value['status'];?></td>
            <?php   if ($current_user_is_a_midwife) { ?> 
                <td>
            <?php 
                        if ($value['status']!="Complete") { ?>
                    <a href="../infant/add-infant-vaccination.php?id=<?php echo $value['id'] ?>">
                        <button class="edit btn btn-primary btn-sm btn-inverse">Add Vaccination</button></a>
            <?php       } ?>
                    <a href="../infant/edit-infant.php?id=<?php echo $value['id'] ?>">
                        <button class="edit btn btn-success btn-sm btn-inverse">Edit</button></a>
                    <a target="_blank" href="../infant/infant-vacc-record.php?id=<?php echo $value['id']?>">
                        <button class="btn btn-dark btn-sm btn-inverse">
                            See Vaccination Record</button></a> 
                </td>
            <?php   } ?>  
            </tr> 
        <?php   }
            } ?> 
            </tbody>
          </table>
        </div>    
      <?php } ?> 
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
        searchPlaceholder: "Search Infant Record",
      }
    });
  } );
</script>

<?php 
include_once('../php-templates/admin-navigation-tail.php');
?>