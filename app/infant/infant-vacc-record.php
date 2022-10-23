<?php

@include '../includes/config.php';

session_start();

@include '../php-templates/redirect/admin-page-setter.php';
@include '../php-templates/redirect/not-for-patient.php';




//1 $BCG
//2 $hepatitis_B
//3 $pentavalent
//4 $oral_polio 
//5 $inactivated_polio
//6 $pnueumococcal_conjugate
//7 $measles_mumps_rubelia
function vaccine_name($num) {
    if ($num==1)
        return "BCG";
    if ($num==2)
        return "Hepatitis B";
    if ($num==3)
        return "Pentavalent";
    if ($num==4)
        return "Oral Polio";
    if ($num==5)
        return "Inactivated Polio";
    if ($num==6)
        return "Pnueumococcal Conjugate";
    if ($num==7)
        return "Measles, Mumps, and Rubelia";
    return "Error";
}

$id_from_get = $_GET['id'];
$infant_select = "SELECT infant_id id, CONCAT(i.first_name,
  IF(i.middle_name='' OR i.middle_name IS NULL, '', CONCAT(' ',SUBSTRING(i.middle_name,1,1),'.')),' ',i.last_name) 
  AS name 
  FROM infants i WHERE infant_id=$id_from_get";

if($infant_result = mysqli_query($conn, $infant_select))  { 
  foreach($infant_result as $row)  { 
    $infant_id = $row['id'];   
    $infant_name = $row['name'];   
  }
  mysqli_free_result($infant_result);
} else  {  
    $error = 'Something went wrong fetching data from the database.'; 
}   
$vacc_rec_select = "SELECT type, date, infant_vac_rec_id id
FROM infants AS i, infant_vac_records AS ivr 
WHERE i.infant_id=ivr.infant_id AND i.infant_id=$infant_id"; 

$vacc_list = [];

if($result = mysqli_query($conn, $vacc_rec_select))  { 
  foreach($result as $row)  {
    $id = $row['id'];  
    $date = $row['date'];  
    $type = vaccine_name($row['type']);   
    array_push($vacc_list, array(
      'id' => $id,
      'date' => $date,
      'type' => $type 
    ));
  } 

} 
else  { 
  mysqli_free_result($result);
  $error = 'Something went wrong fetching data from the database.'; 
}   

$conn->close(); 

$page = 'view_infant_vacc_rec';
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

    <div class="container-fluid default">
      <div class="background-head row m-2 my-4"><h4 class="pb-3 m-3 fw-bolder ">Vaccinations of <?php echo $infant_name ?></h4><hr>

        <div class="table-padding table-responsive">
          <div class="col-md-8 col-lg-12" id="table-position">
            <table class="text-center  table mt-5 table-striped table-responsive table-lg table-bordered table-hover display" id="datatables">
            <thead class="table-dark" colspan="3"> 
                <tr>
                    <th scope="col" class="col-sm-1">#</th>
                    <th scope="col">Type</th>  
                    <th scope="col">Date</th> 
                    <th scope="col">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                  foreach ($vacc_list as $key => $value) {
                ?>     
                    <tr>
                        <th scope="row"><?php echo $key+1; ?></th>
                        <td><?php echo $value['type']; ?></td>  
                        <td><?php echo $value['date']; ?></td> 
                        <td> 
                            <a href="delete-infant-vaccination-record.php?id=<?php echo $value['id'] ?>&infant_id=<?php echo $infant_id ?>">   
                                <button class="del btn btn-danger btn-sm btn-inverse">
                                Delete</button>
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
        searchPlaceholder: "Search Midwife",
      }
    });
  });
</script>
 
<?php 
include_once('../php-templates/admin-navigation-tail.php');
?>