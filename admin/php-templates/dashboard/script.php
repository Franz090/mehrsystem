<!-- Pie chart script ito-->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
  // google.charts.load("current", { packages: ["corechart"] });
  // google.charts.setOnLoadCallback(drawChart);

  // function drawChart() {
  //   var data = google.visualization.arrayToDataTable([
  //     ["Task", "<?php //echo $title; ?>"],
  //     ["Available Vaccine", <?php //echo $av_vaccine; ?>],
  //     ["Used Vaccine", <?php //echo $used_vaccine; ?>],
  //     ["Expired Vaccine", <?php //echo $exp_vaccine; ?>],
  //     ["Upcoming Vaccine", <?php //echo $up_vaccine; ?>],
  //   ]);

  //   var options = {

  //     backgroundColor: 'transparent',
  //     is3D: 'true',
  //     display: 'true',
  //     pieSliceTextStyle: {
  //       color: 'white',
  //     },
  //     legendTextStyle: { color: '#000000' },
  //     legend: { position: 'bottom' },
  //     title: "<?php //echo $title; ?>",
  //     titleTextStyle: {
  //       color: '#000000', fontSize: 17,
  //       bold: false, italic: false
  //     },
  //     hAxis: {
  //       color: '#000000'
  //     },
  //   };

  //   var chart = new google.visualization.PieChart(
  //     document.getElementById("piechart")
  //   );

  //   chart.draw(data, options);
  // }
</script>

<!-- Column chart script to-->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
  google.charts.load("current", { packages: ["bar"] });
  google.charts.setOnLoadCallback(drawChart);

  function drawChart() {
    var data = google.visualization.arrayToDataTable([
      <?php echo $labels;
        foreach ($bar_chart_data as $key => $value) { 
          echo "[`".$value[0]."`,".$value[1].",".$value[2].",".$value[3].",".$value[4]." ],";
        }
      ?>
      // ["April-22", 1000, 400, 200, 300],
      // ["May-22", 1170, 460, 250, 300],
      // ["June-22", 660, 1120, 300, 300],
      // ["July-22", 1030, 540, 350, 300],
    ]);

    var options = {
      title: '<?php echo $bar_chart_title; ?> (Last 6 months)',
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