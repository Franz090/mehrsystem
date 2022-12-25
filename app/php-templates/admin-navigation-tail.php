
<script src="../active.js"></script>
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

</body>

</html>