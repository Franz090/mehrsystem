
<script src="../js/active.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  var el = document.getElementById("wrapper");
  var toggleButton = document.getElementById("menu-toggle");

  toggleButton.onclick = function () {
    el.classList.toggle("toggled");
  };
</script>
<script src="../js/script.js"></script>
<script>
  /* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - 
  This allows the user to have multiple dropdowns without any conflict */
  var dropdown = document.getElementsByClassName("dropdown-btn");
  var i;

  for (i = 0; i < dropdown.length; i++) {
    dropdown[i].addEventListener("click", function () {
      this.classList.toggle("active");
      var dropdownContent = this.nextElementSibling;
      if (dropdownContent.style.display === "block") {
        dropdownContent.style.display = "none";
      } else {
        dropdownContent.style.display = "block";
      }
    });
  }

  // Menu Toggle
  const toggle = document.querySelector('.toggle');
  const navigation = document.querySelector('.navigation_nu');
  const main = document.querySelector('.main_nu');

  toggle.onclick = function(){
      navigation.classList.toggle('active');
      main.classList.toggle('active');
  }
</script>

<!-- calendar  -->
<?php if (!$current_user_is_an_admin) {?> 
  <!-- <script>
      var scheds = $.parseJSON('<?= json_encode($sched_res) ?>')
  </script> -->
  <script src="../calendar/js/script.js"></script>
<?php }?>

<!-- icon frameworks go to https://ionic.io/ionicons -->
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

<!-- searchable select js  -->
<?php 
  if (
    ($page === "dashboard" || $page === "pending_appointment" ||
     $page === "approved_appointment" || $page === "add_infant" ||
     $page === "view_consultations")
     && $current_user_is_a_midwife
  ) { 
?>
<script>
  const wrapper = document.querySelector(".wrapper_ss"),
    selectBtn = wrapper.querySelector(".select-btn_ss"),
    hidden_input = wrapper.querySelector(".patient_id_trimester"),
    searchInp = wrapper.querySelector(".ss"),
    options = wrapper.querySelector(".options_ss");
  const patients = {
    <?php 
        if (count($patient_list)>0)
          foreach ($patient_list as $value) {
            if ($page == "add_infant") {
              echo '"'.$value['name'].'": "'.$value['id'].'", ';
            } else { 
              echo '"'.$value['name'].'": "' 
              . $value['id'] . 'AND'.$value['trimester'].'", ';
            }
          }
    ?>
  }

  let patient_keys = Object.keys(patients) || [];

  function addOption(selected_patient) {
      options.innerHTML = "";
      patient_keys.forEach(patient => {
          let isSelected = patient == selected_patient ? "selected" : "";
          let li = `<li onclick="updateName(this)" class="${isSelected}">${patient}</li>`;
          options.insertAdjacentHTML("beforeend", li);
      });
  }
  addOption();

  function updateName(selectedLi) {
    searchInp.value = "";
    hidden_input.value = patients[selectedLi.innerText];
    addOption(selectedLi.innerText);
    wrapper.classList.remove("active");
    selectBtn.firstElementChild.innerText = selectedLi.innerText;
  }

  searchInp.addEventListener("keyup", () => {
      let arr = [];
      let searchWord = searchInp.value.toLowerCase();
      arr = patient_keys.filter(data => {
          return data.toLowerCase().includes(searchWord);
      }).map(data => {
          let isSelected = data == selectBtn.firstElementChild.innerText ? "selected" : "";
          return `<li onclick="updateName(this)" class="${isSelected}">${data}</li>`;
      }).join("");
      options.innerHTML = arr ? arr : `<p style="margin-top: 10px;">Oops! Not found</p>`;
  });

  selectBtn.addEventListener("click", () => wrapper.classList.toggle("active"));
</script>
<?php
  }
?>
<!-- end searchable select js  -->

<!-- SWEET ALERT -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>
<!-- axios -->
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script type="text/javascript" src="../js/system-script.js"></script>

<script>
  $(document).ready(function(){

    var date_sched = $.parseJSON('<?= json_encode($date_sched_array) ?>');
    // console.log('fdsfsd',date_sched);
    $('#date').on('change', function() {
      var selected_date = $(this).val(),
          date = new Date(selected_date),
          dayOfWeek = date.getDay(),
          hours = date.getHours(),
          today = new Date();

      if(date < today) {
        dateErrorHandler(`Please Select future date.`);
      }
      else if(dayOfWeek === 6 || dayOfWeek === 0) {
        dateErrorHandler(`Weekend is not availble!`);
      }
      else if(hours < 8 || hours >= 17) {
        dateErrorHandler(`Choose time between 8am to 5pm`);
      } else {
        for(var i = 0; i < date_sched.length; i++) {
          var diff= Math.abs(date - new Date(date_sched[i]));
          var minutes = Math.floor((diff/1000)/60);
          // console.log(minutes);
          if(minutes < 30) {
            dateErrorHandler(`This schedule is not available!`);
          }
        }
      }    
    })

    
    $('.search_date').on('change', function() {
      var selected_date = $(this).val(),
          date = new Date(selected_date),
          dayOfWeek = date.getDay(),
          hours = date.getHours(),
          today = new Date();

      if (date < today && date.setHours(0,0,0,0) != today.setHours(0,0,0,0)) {
        dateErrorHandler(`Please Select future date.`);
      }
      else if(dayOfWeek === 6 || dayOfWeek === 0) {
        dateErrorHandler(`Please Select weekdays!`);
      }  
    });

    const dateErrorHandler = (message) => {
      $.SystemScript.swalAlertMessage('Error', message, 'error');
      $('.search_date').val('');
      $('#date').val('');
      return false;
    }


    var url = '../controller/appointmentController.php';
    $('.cancel-appointment').on('click', function() {
      const appointment_id = $( this ).data( "id" );
      const appointment_date = $( this ).data( "date" );
      const patient = $( this ).data( "patient" );
      $(this).prop('disabled', true);
      $(this).html('Please wait...');
      $.SystemScript.swalConfirmMessage('Are you sure', 
        'Do you want to cancel this appointment?', 'question').done(function(response) {
            if(response) {
                
                let path = url + `?command=deleteAppointment&appointment_id=${appointment_id}&appointment_date=${appointment_date}&patient=${patient}`;
                $.SystemScript.executeGet(path).done((res) => {
                  // console.log(res);
                  if(res.data.status == 'success') {
                    $.SystemScript.swalAlertMessage('Successfully',`${res.data.message}`, 'success');
                    $('.swal2-confirm').click(function(){
                        location.reload();
                    });
                  } else {
                      $.SystemScript.swalAlertMessage('Error',`${res.data.message}`, 'error');
                      $('.cancel-appointment').prop('disabled', false);
                      $('.cancel-appointment').html('Cancel');
                  }
                });
              
            } else {
              $('.cancel-appointment').prop('disabled', false);
              $('.cancel-appointment').html('Cancel');
            }
            
        });
        
    });


    $("#search_availability").submit(function(e) {
        e.preventDefault();
        $('.btn-submit').prop('disabled', true);
        $('.btn-submit').html('Searching...');
        var data = new FormData(this);
        let path = url + `?command=searchAvailableAppointment`;
        $.SystemScript.executePost(path, data).done((response) => {
          // console.log(response.data);
          if(response.data.status == 'success') {
            $( "#available_result" ).html( "" );
            var result = `
              <h4 style="text-align:right !important;">Available Slot  
                <span class="text-danger">${response.data.count}</span>/18
              </h4>
              <h5>Time Taken</h5>
              <div id="time-taken"></div>
            `;
            $( "#available_result" ).append(result);
            if(response.data.data.length != 0) {
              var date = $.each(response.data.data, function( index, value ) {
                $( "#time-taken" ).append(`<p>${value}</p><hr class="m-0"><br/>`);
              });
            } else {
              $( "#time-taken" ).append(`<p class="text-danger">All time are available.</p>`);
            }
          } else {
            $.SystemScript.swalAlertMessage('Error',`${response.data.message}`, 'error');
          }
          $('.btn-submit').prop('disabled', false);
          $('.btn-submit').html('Search');
        });
    });

    
  })
</script>




</body>

</html>