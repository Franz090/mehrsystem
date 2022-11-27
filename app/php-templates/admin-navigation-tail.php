
<!-- TODO: DELETE THIS AFTER FIXING DELETING 
CONDITIONS AND ADDING A MODAL TO DELETE FUNCTION -->
<script>
  function temp_func() {
    alert('Delete Click - Temporary Lang')
  }
</script>
<!-- END TODO  -->

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
<?php if ($current_user_is_a_patient) {?> 
  <script>
      var scheds = $.parseJSON('<?= json_encode($sched_res) ?>')
  </script>
  <script src="../calendar/js/script.js"></script>
<?php }?>

<!-- icon frameworks go to https://ionic.io/ionicons -->
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>



</body>

</html>