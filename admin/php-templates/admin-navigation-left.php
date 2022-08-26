<div class="bg-dark" id="sidebar-wrapper"> 
  <div class="sidebar-heading text-center py-2 primary-text fs-4 fw-bold text-uppercase border-bottom"
    style="color:whitesmoke;"><i class="fas fa-solid fa-prescription me-2" href="patientdashboard.php"></i>MEHr
  </div>
  <div class="list-group list-group-flush my-3" style="color:whitesmoke;">
    <a <?php echo $page == 'dashboard'? "type='button'":"href='../dashboard'"?> class="h6 text-light list-group-item list-group-item-action bg-transparent second-text active"><i
        class="fas fa-solid fa-box "></i>Dashboard</a>
    <button
      class="dropdown-btn h6  text-light list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
        class="fas fa-user me"></i>Profile<i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-container">
      <div class="merge">
        <i class="fas fa-light fa-minus"></i><a 

        <?php echo $page == 'change_password'? "type='button'":'href="../profile/change-password.php"'?>
          class="drop bg-transparent second-text active ">Change
          Password</a>
        <i class="fas fa-light fa-minus"></i>
          <a 
            <?php echo $page == 'add_nurse'? "type='button'":'href="../profile/add-nurse.php"'?>
            class="drop bg-transparent second-text active ">Add
          Nurse</a><br>
        <i class="fas fa-light fa-minus"></i><a 
          <?php echo $page == 'view_nurse'? "type='button'":'href="../profile/view-nurse.php"'?>
        class="drop bg-transparent second-text active ">View
          Nurse</a>
      </div>
    </div>
    <button   
      class="dropdown-btn h6 text-light list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
        class="fas fa-thin fa-baby"></i>Midwife<i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-container">
      <i class="fas fa-light fa-minus"></i><a 
        <?php echo $page == 'add_midwife'? "type='button'":'href="../midwife/add-midwife.php"'?>
        class="drop">Add Midwife</a><br>
      <i class="fas fa-light fa-minus"></i><a 
        <?php echo $page == 'view_midwife'? "type='button'":'href="../midwife/view-midwife.php"'?>
        class="drop">View Midwife</a>
    </div>
    <button  
      class="dropdown-btn h6 text-light list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
        class="fas fa-regular fa-briefcase-medical"></i>Health Center<i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-container">
      <i class="fas fa-light fa-minus"></i><a 
        <?php echo $page == 'add_barangay'? "type='button'":'href="../health-center/add-barangay.php"'?>
        class="drop">Add Barangay</a><br>
      <i class="fas fa-light fa-minus"></i><a 
        <?php echo $page == 'view_barangay'? "type='button'":'href="../health-center/view-barangay.php"'?>
        class="drop">View Barangay</a>
    </div>
  </div>
</div>