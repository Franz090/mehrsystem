// Method that will show modal of show appoinment
function showApt(date) {
  $.ajax({
    type: "POST",
    url: "../custom-calendar/get_appointment.php",
    data: {date: date},
    success: function(result) {
      $("#appointment_table tbody").html(result);
      $("#show_apt_modal").modal("show");
    }
  });
}

// Method that will show modal of add appoinment
function addApt(date) {
  $("#selected_date").val(date);
  $("#add_apt_modal").modal("show");
}

// Method for changing to next month
function nextMonth(active_year, active_month) {
  var d = new Date();
  d.setFullYear(parseInt(active_year)); // get and set year
  d.setMonth(parseInt(active_month) - 1); // get  and set month
  d.setDate(1);
  d.setMonth(d.getMonth() + 1); // increase month by 1
  var url = window.location.pathname + '?date=' + d.getFullYear() + '-' + (d.getMonth() + 1) + '-' + d.getDate(); // add uri on url about current selected date
  window.location.href = url;
}

// Method for changing to previous month
function prevMonth(active_year, active_month) {
  var d = new Date();
  d.setFullYear(parseInt(active_year)); // get and set year
  d.setMonth(parseInt(active_month) - 1 - 1); // get and set month and decrease month by 1
  d.setDate(1);
  var url = window.location.pathname + '?date=' + d.getFullYear() + '-' + (d.getMonth() + 1) + '-' + d.getDate(); // add uri on url about current selected date
  window.location.href = url;
}


