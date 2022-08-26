<?php

@include '../includes/config.php';

session_start();

if(!isset($_SESSION['usermail'])) 
  header('location:../index.php');
 
$conn->close(); 

$page = 'dashbaord';
include_once('../php-templates/admin-navigation-head.php');
?> 

<!-- Pie chart script ito-->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
  google.charts.load("current", { packages: ["corechart"] });
  google.charts.setOnLoadCallback(drawChart);

  function drawChart() {
    var data = google.visualization.arrayToDataTable([
      ["Task", "Patient Vaccine Monitoring Chart"],
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
      title: "Patient Vaccine Monitoring Chart",
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

<div class="d-flex" id="wrapper">
  <!-- Sidebar -->
  

  <?php include_once('../php-templates/admin-navigation-left.php'); ?>
  <!-- /#sidebar-wrapper -->

  <!-- Page Content -->
  <div id="page-content-wrapper" style="background-color: #f0cac4">
    
    <?php include_once('../php-templates/admin-navigation-right.php'); ?>

    <div class="container default">
      <div class="row mt-5">
        <div class="col-md-6 col-sm-12 d-flex justify-content-center">
          <div id="piechart" class="chart"
            style="position:relative;right: 90px;bottom:200px;width: 400px;height 200px;"></div>
        </div>
        <div class="col-md-6 col-sm-12 d-flex justify-content-center">
          <div id="columnchart_material" class="columnchart">
          </div>
        </div>
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
  </div>  
<!-- /#page-content-wrapper -->
</div>

<?php 
include_once('../php-templates/admin-navigation-tail.php');
?>