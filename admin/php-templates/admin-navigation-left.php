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
          <?php
            if($admin==1) {  
          ?>
            <i class="fas fa-light fa-minus"></i>
            <a 
              <?php echo $page == 'add_nurse'? "type='button'":'href="../profile/add-nurse.php"'?>
                class="drop bg-transparent second-text active ">Add
              Nurse</a><br>
            <i class="fas fa-light fa-minus"></i><a 
            <?php echo $page == 'view_nurse'? "type='button'":'href="../profile/view-nurse.php"'?>
              class="drop bg-transparent second-text active ">View
              Nurse</a>
          <?php
            } else if ($admin==0) {
          ?> 
            <i class="fas fa-light fa-minus"></i><a 
              <?php echo $page == 'view_midwife'? "type='button'":'href="../'.$account_type_midwife.'/view-midwife.php"'?>
              class="drop">View Midwife</a>
          <?php     
            } else { 
          ?>
           <i class="fas fa-light fa-minus"></i><a 
              <?php echo $page == 'demo_profile'? "type='button'":'href="../profile/demographic-profile.php"'?>
              class="drop">Demographic Profile</a>
          <?php     
            }  
          ?>
        </div>
      </div>
    <?php 
      if($admin==1) {  
    ?>
    <button   
      class="dropdown-btn h6 text-light list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
        class="fas fa-thin fa-baby"></i>Midwife<i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-container">
      <i class="fas fa-light fa-minus"></i><a 
        <?php echo $page == 'add_midwife'? "type='button'":'href="../'.$account_type_midwife.'/add-midwife.php"'?>
        class="drop">Add Midwife</a><br>
      <i class="fas fa-light fa-minus"></i><a 
        <?php echo $page == 'view_midwife'? "type='button'":'href="../'.$account_type_midwife.'/view-midwife.php"'?>
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
    <?php
      } else {
    ?>
      <button  
        class="dropdown-btn h6 text-light list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
          class="fas fa-regular fa-briefcase-medical"></i>Appointments<i class="fa fa-caret-down"></i>
      </button>
      <div class="dropdown-container">
        <i class="fas fa-light fa-minus"></i><a 
          <?php echo $page == 'add_appointment' ? "type='button'" : 'href="../appointment/new-appointment.php"'?>
          class="drop">Add Appointment</a><br/>
        <?php
          if ($admin==-1) {
        ?> 
        <i class="fas fa-light fa-minus"></i><a 
          <?php echo $page == 'view_appointment' ? "type='button'" : 'href="../appointment/view-appointment.php"'?>
          class="drop">View Appointments</a>
        <?php
          } else if ($admin==0) {
        ?> 
          <i class="fas fa-light fa-minus"></i><a 
            <?php echo $page == 'pending_appointment' ? "type='button'" : 'href="../appointment/pending-appointment.php"'?>
            class="drop">Pending Appointments</a><br/>
          <i class="fas fa-light fa-minus"></i><a 
            <?php echo $page == 'approved_appointment' ? "type='button'" : 'href="../appointment/approved-appointment.php"'?>
            class="drop">Approved Appointments</a>
        <?php
          }
        ?> 
      </div>
      <?php
        if ($admin==0) {
      ?> 
        <!-- <button  
          class="dropdown-btn h6 text-light list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
            class="fas fa-regular fa-briefcase-medical"></i>Medical Records<i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-container">
          <i class="fas fa-light fa-minus"></i><a 
            <?php //echo $page == 'add_medical_record' ? "type='button'" : 'href="../medical-history/add-medical-record.php"'?>
            class="drop">Add Medical Record</a><br>
          <i class="fas fa-light fa-minus"></i><a 
            <?php //echo $page == 'view_medical_record' ? "type='button'" : 'href="../medical-history/view-medical-records.php"'?>
            class="drop">View Medical Records</a>
        </div> -->
        <button  
          class="dropdown-btn h6 text-light list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
            class="fas fa-regular fa-briefcase-medical"></i>Patients<i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-container">
          <i class="fas fa-light fa-minus"></i><a 
            <?php echo $page == 'add_patient' ? "type='button'" : 'href="../patients/add-patient.php"'?>
            class="drop">Add Patient</a><br>
          <i class="fas fa-light fa-minus"></i><a 
            <?php echo $page == 'view_patient' ? "type='button'" : 'href="../patients/view-patients.php"'?>
            class="drop">View Patients</a>
        </div>
      <?php
        }  
      ?>

      <button  
        class="dropdown-btn h6 text-light list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
          class="fas fa-regular fa-briefcase-medical"></i>Treatments<i class="fa fa-caret-down"></i>
      </button>
      <div class="dropdown-container">
        <?php if ($admin == 0) {?>
          <i class="fas fa-light fa-minus"></i><a 
            <?php echo $page == 'add_treatment' ? "type='button'" : 'href="../treatment/add-treatment.php"'?>
            class="drop">Add Treatment</a><br>
          <i class="fas fa-light fa-minus"></i><a 
            <?php echo $page == 'view_treatment' ? "type='button'" : 'href="../treatment/view-treatment.php"'?>
            class="drop">View Treatments</a>
        <?php }?>  
        <?php if ($admin == -1) {?>
          <i class="fas fa-light fa-minus"></i><a 
            <?php echo $page == 'view_treatment_r' ? "type='button'" : 'href="../treatment/view-treatment-records.php"'?>
            class="drop">View Treatment Records</a>
        <?php }?>
      </div>
      <button  
        class="dropdown-btn h6 text-light list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
          class="fas fa-regular fa-briefcase-medical"></i>Prescriptions<i class="fa fa-caret-down"></i>
      </button>
      <div class="dropdown-container">
        <?php if ($admin == 0) {?>
          <i class="fas fa-light fa-minus"></i><a 
            <?php echo $page == 'add_medicine' ? "type='button'" : 'href="../prescription/add-medicine.php"'?>
            class="drop">Add Medicine</a><br>
          <i class="fas fa-light fa-minus"></i><a 
            <?php echo $page == 'view_medicine' ? "type='button'" : 'href="../prescription/view-medicine.php"'?>
            class="drop">View Medicine</a>
        <?php }?>
        <?php if ($admin == -1) {?>
          <i class="fas fa-light fa-minus"></i><a 
            <?php echo $page == 'view_medicine_r' ? "type='button'" : 'href="../prescription/view-medicine-records.php"'?>
            class="drop">View Medicine Records</a>
        <?php }?>
      </div> 
      
    <?php
      }
    ?>
    
  </div>
</div>