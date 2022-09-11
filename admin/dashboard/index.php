<?php

@include '../includes/config.php';

session_start();

@include '../php-templates/redirect/admin-page-setter.php';

$vaccine_list = [];
$infant_list = [];
$title = ''; // pie chart title

$session_id = $_SESSION['id'];

if ($admin==1) {
  $title = "Patient Vaccine Monitoring Pie Chart";
  // fetch vaccines  
  $select1 = "SELECT * FROM vaccine";
  $result1 = mysqli_query($conn, $select1);

  if(mysqli_num_rows($result1))  {
    foreach($result1 as $row)  {
      $id = $row['id'];  
      $count = $row['count'];  
      $type = $row['type'];  
      $status = $row['status'];  
      $expiration = $row['expiration'];     
      array_push($vaccine_list, array('id' => $id,
      'count' => $count, 
      'type' => $type, 
      'status' => $status, 
      'expiration' => $expiration));
    } 
    mysqli_free_result($result1);
    // print_r($nurse_list);
  
  } 
  else  { 
    mysqli_free_result($result1);
    $error = 'Something went wrong fetching data from the database.'; 
  }  
} 
if ($admin==0) {
  $title = "Infant Vaccine Monitoring Pie Chart";
  // fetch infants 
  
  $select2 = "SELECT * FROM infant_record"; 
  $result2 = mysqli_query($conn, $select2);

  if(mysqli_num_rows($result2))  {
    foreach($result2 as $row)  {
      $id = $row['id'];  
      $name = $row['name'];  
      $date = $row['date'];  
      $status = $row['status'];  
      $legitimacy = $row['legitimacy'];     
      array_push($infant_list, array('id' => $id,
      'name' => $name, 
      'date' => $date, 
      'status' => $status, 
      'legitimacy' => $legitimacy));
    } 
    mysqli_free_result($result2);
    // print_r($nurse_list);
  
  } 
  else  { 
    mysqli_free_result($result2);
    $error = 'Something went wrong fetching data from the database.'; 
  }   

  $select2_1 = "SELECT tetanus, COUNT(u.id) as p_count  
    FROM users u, details d, barangay b, med_history m  
    WHERE u.details_id=d.id AND b.assigned_midwife=$session_id AND d.barangay_id=b.id AND d.med_history_id=m.id
    GROUP BY tetanus"; 
  // echo $select2_1;
  if($result2_1 = mysqli_query($conn, $select2_1))  {
    $total_patients = 0; 
    foreach($result2_1 as $row)  {
      if ($row['tetanus']==1) {
        $total_vacc = $row['p_count'];
      }
      $total_patients += $row['p_count'];  
    } 
    mysqli_free_result($result2_1);
    // print_r($nurse_list);
  
  } 
  else  { 
    mysqli_free_result($result2_1);
    $error = 'Something went wrong fetching data from the database.'; 
  }  

  // appointments today 
  $curr_date = date("Y-m-d");
  $select2_2 = "SELECT COUNT(u.id) as a_count  
    FROM users u, barangay b, appointment a, details d
    WHERE u.details_id=d.id AND b.assigned_midwife=$session_id AND d.barangay_id=b.id AND A.patient_id=u.id
      AND date BETWEEN '$curr_date 00:00:00' AND '$curr_date 23:59:59'"; 
   
  // echo $select2_2;
  if($result2_2 = mysqli_query($conn, $select2_2))  {
    foreach($result2_2 as $row)  { 
      $appointments_today = $row['a_count'];  
    } 
    mysqli_free_result($result2_2);
    // print_r($nurse_list);
  
  } 
  else  { 
    mysqli_free_result($result2_2);
    $error = 'Something went wrong fetching data from the database.'; 
  }  
}
// patient 
if ($admin==-1) {

  $select3 = "SELECT height_ft, height_in, weight
    FROM users u, details d, med_history m
    WHERE u.id=$session_id AND u.details_id=d.id AND d.med_history_id=m.id" ;
  $result3 = mysqli_query($conn, $select3);

  if(mysqli_num_rows($result3))  {
    foreach($result3 as $row)  {
      $height_ft = $row['height_ft'];  
      $height_in = $row['height_in'];  
      $weight = $row['weight'];   
    } 
    mysqli_free_result($result3);
    // print_r($nurse_list);
    $in_to_m_conversion = 0.0254;
    $ft_to_in_conversion = 12;
    $m = ($height_ft * $ft_to_in_conversion + $height_in) * $in_to_m_conversion; 
    // echo $m. "<br>";
    // echo $height_ft. "<br>";
    // echo $height_in. "<br>";
    // https://www.diabetes.ca/managing-my-diabetes/tools---resources/body-mass-index-(bmi)-calculator#:~:text=Body%20Mass%20Index%20is%20a,most%20adults%2018%2D65%20years.
    // BMI = kg/m2
    $bmi = $weight/$m**2;
    // https://www.nhlbi.nih.gov/health/educational/lose_wt/BMI/bmicalc.htm
    // Underweight = <18.5
    // Normal weight = 18.5–24.9
    // Overweight = 25–29.9
    // Obesity = BMI of 30 or greater
    if ($bmi<=18.5) {
      $bmi_desc = 'Underweight';
    } else if ($bmi<=24.9 && $bmi>18.5) {
      $bmi_desc = 'Normal weight';
    } else if ($bmi<30 && $bmi>24.9) {
      $bmi_desc = 'Overweight';
    } else if ($bmi>=30) {
      $bmi_desc = 'Obese';
    }

  } 
  else  { 
    mysqli_free_result($result3);
    $error = 'Something went wrong fetching data from the database.'; 
  }  
}


$conn->close(); 

$page = 'dashbaord';
include_once('../php-templates/admin-navigation-head.php');

if ($admin!=-1) {
?>

<!-- Pie chart script ito-->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
  google.charts.load("current", { packages: ["corechart"] });
  google.charts.setOnLoadCallback(drawChart);

  function drawChart() {
    var data = google.visualization.arrayToDataTable([
      ["Task", "<?php echo $title; ?>"],
      ["Available Vaccine", 50],
      ["Vaccinated", 10],
      ["Expired Vaccine", 20],
      ["Upcoming Vaccine", 20],
    ]);

    var options = {

      backgroundColor: 'transparent',
      is3D: 'true',
      display: 'true',
      pieSliceTextStyle: {
        color: 'white',
      },
      legendTextStyle: { color: '#000000' },
      legend: { position: 'bottom' },
      title: "<?php echo $title; ?>",
      titleTextStyle: {
        color: '#000000', fontSize: 17,
        bold: false, italic: false
      },
      hAxis: {
        color: '#000000'
      },
    };

    var chart = new google.visualization.PieChart(
      document.getElementById("piechart")
    );

    chart.draw(data, options);
  }
</script>

<!-- Column chart script to-->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
  google.charts.load("current", { packages: ["bar"] });
  google.charts.setOnLoadCallback(drawChart);

  function drawChart() {
    var data = google.visualization.arrayToDataTable([
      ["Month", "Number of Patients", "Teenage Pregnancy", "Adolescent Pregnancy"],
      ["April-22", 1000, 400, 200],
      ["May-22", 1170, 460, 250],
      ["June-22", 660, 1120, 300],
      ["July-22", 1030, 540, 350],
    ]);

    var options = {
      title: 'Maternity Monthly Report',
      is3D: 'true',
      backgroundColor: 'transparent',
      legendTextStyle: { color: '#303030' },
      legend: { position: "right", maxLines: 9, alignment: 'center' },
      titleTextStyle: {
        color: '#303030', family: "Helvetica Neue", fontSize: 18, lineHeight: '1.8',
        bold: false,
      },
      hAxis: {
        color: '#303030'
      }

    };

    var chart = new google.charts.Bar(
      document.getElementById("columnchart_material")
    );

    chart.draw(data, google.charts.Bar.convertOptions(options));
  }
</script>

<?php } ?> 



<div class="d-flex" id="wrapper">
  <!-- Sidebar --> 
  <?php include_once('../php-templates/admin-navigation-left.php'); ?>
  <!-- /#sidebar-wrapper --> 
  <!-- Page Content -->
  <div id="page-content-wrapper"> 
    <?php include_once('../php-templates/admin-navigation-right.php'); ?>
    <?php echo $admin==1?'Nurse':($admin==0?'Midwife':'Patient'); 
      if ($admin!=-1) {
    ?> 
    
    <div class="container default">
      <div class="row mt-5">
        <div class="col-md-6 col-sm-12 d-flex justify-content-center">
          <div id="piechart" class="chart"
            style="bottom:200px;width: 400px;height 200px;"></div>
        </div>
        <div class="col-md-6 col-sm-12 d-flex justify-content-center">
          <div id="columnchart_material" class="columnchart">
          </div>
        </div>
      </div>

      <div>
      <?php if ($admin==0) { ?> 
        <div>  
          Total Number of Patients: <?php echo $total_patients ?>  
        </div>
        <div>  
          Appointments Today: <?php echo $appointments_today ?>  
        </div>
        <div>  
          Tetanus Toxoid Vaccinated Patients: <?php echo $total_vacc ?>  
        </div>

      <?php } ?> 
      </div>
    </div>

    <div class="container default">
      <table class="table mt-5 table-striped table-sm ">
        <thead class="table-dark">
          <tr>
            <th scope="col">#</th>
            <th scope="col">First</th>
            <th scope="col">Last</th>
            <th scope="col">Handle</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row">1</th>
            <td>Mark</td>
            <td>Otto</td>
            <td>@mdo</td>
          </tr>
          <tr>
            <th scope="row">2</th>
            <td>Jacob</td>
            <td>Thornton</td>
            <td>@fat</td>
          </tr>
          <tr>
            <th scope="row">3</th>
            <td>Larry</td>
            <td>the Bird</td>
            <td>@twitter</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="container">
      <div class="row bg-light m-3 con1"></div>
    </div>
        
    <?php
      } else { // patient
    ?> 
      <br/>
      BMI: <?php echo round($bmi,2). " ($bmi_desc)"?> 


    <?php 
      }
    ?> 

    

  </div>  
<!-- /#page-content-wrapper -->
</div>

<?php 
include_once('../php-templates/admin-navigation-tail.php');
?>