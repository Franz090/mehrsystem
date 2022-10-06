<div class=" sidebar d-flex flex-column" id="sidebar-wrapper" > 
  <div class="sidebar-heading text-center py-2 primary-text fs-4 fw-bold text-uppercase border-bottom"
    style="color:whitesmoke;">
     <a href="../dashboard"><img style="width: 110px;height:110px;" src="../img/rhu-logo.png" alt="logo"></a>
  </div>
  <div class="d-flex flex-column justify-content-between flex-grow-1">
    <!-- nav list  -->
    <div class="list-group list-group-flush my-3" >
    <a <?php echo $page == 'dashboard'? "type='button'":"href='../dashboard'"?> class="h6 list-group-item list-group-item-action bg-transparent second-text active"><i
        class="fas fa-solid fa-box fa-md" style="margin-right: 11px;"></i>Dashboard</a>
     
    <button
      class="dropdown-btn h6  list-group-item list-group-item-action bg-transparent ">
      <i class="fas fa-user me fa-md " style="margin-right: 13px;"></i>Profile<i class="fa fa-caret-down"></i>
    </button>

      <div class="dropdown-container default text-start">
         <div class="default " style="width: 210px;padding: 5px;display: block;">
          <i class="fas fa-minus-square fa-1x" aria-hidden="true"></i><a 

          <?php echo $page == 'update_account'? "type='button'":'href="../profile/update-account.php"'?>
            class="drop bg-transparent second-text active">Manage Account</a><br>
          <?php
            //if($admin==1) {  
          ?>
            <!-- <i class="fas fa-minus-square fa-1x" aria-hidden="true"></i>
            <a 
              <?php //echo $page == 'add_nurse'? "type='button'":'href="../profile/add-nurse.php"'?>
                class="drop bg-transparent second-text active ">Add
              Nurse</a><br>
            <i class="fas fa-minus-square fa-1x" aria-hidden="true"></i><a 
            <?php //echo $page == 'view_nurse'? "type='button'":'href="../profile/view-nurse.php"'?>
              class="drop bg-transparent second-text active ">View
              Nurse</a> -->
          <?php
            //} else if ($admin==0) {
          ?>  
            <!-- <i class="fas fa-light fa-minus"></i><a 
              <?php //echo $page == 'view_midwife'? "type='button'":'href="../'.$account_type_midwife.'/view-midwife.php"'?>
              class="drop">View Midwife</a> --> 
          <?php     
            // } else 
            if ($admin==-1) { 
          ?>
           <i class="fas fa-minus-square fa-1x"></i><a 
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
      class="dropdown-btn h6  list-group-item list-group-item-action bg-transparent "><i
        class="fas fa-md  fa-thin fa-baby" style="margin-right: 15px;"></i>Midwife<i class="fa fa-caret-down"></i>
    </button>
    
      <div class="dropdown-container default text-start">
        <div class="default " style="width: 210px;padding: 5px;display: block;">
        <!-- <i class="fas fa-minus-square fa-1x" aria-hidden="true"></i><a 
          <?php //echo $page == 'add_midwife'? "type='button'":'href="../'.$account_type_midwife.'/add-midwife.php"'?>
          class="drop ">Add Midwife</a><br> -->
        <i class="fas fa-minus-square fa-1x" aria-hidden="true"></i><a 
          <?php echo $page == 'view_midwife'? "type='button'":'href="../'.$account_type_midwife.'/view-midwife.php"'?>
          class="drop">View Midwife</a>
        </div>
      </div>
    <button  
      class="dropdown-btn h6  list-group-item list-group-item-action bg-transparent"><i
        class="fas fa-md fa-briefcase-medical" style="margin-right: 12px;"></i>Health Center<i class="fa fa-caret-down"></i>
    </button>
      <div class="dropdown-container default text-start">
        <div class="default " style="width: 210px;padding: 5px;display: block;">
          <i class="fas fa-minus-square fa-1x" aria-hidden="true"></i><a 
            <?php echo $page == 'add_barangay'? "type='button'":'href="../health-center/add-barangay.php"'?>
            class="drop">Add Barangay</a><br>
          <i class="fas fa-minus-square fa-1x" aria-hidden="true"></i><a 
            <?php echo $page == 'view_barangay'? "type='button'":'href="../health-center/view-barangay.php"'?>
            class="drop">View Barangay</a>
        </div>
      </div>  
      <a <?php echo $page == 'view_patient'? "type='button'":"href=\"../patients/view-patients.php\""?> 
        class="h6 list-group-item list-group-item-action bg-transparent ">
          <i class="fas fa-solid fa-box fa-md" style="margin-right: 11px;"></i>View Patients</a> 
      <a <?php echo $page == 'update_footer'? "type='button'":"href='../update-footer'"?> 
        class="h6 list-group-item list-group-item-action bg-transparent ">
          <i class="fas fa-solid fa-box fa-md" style="margin-right: 11px;"></i>Update Footer</a> 
    <?php
      } else {
        // if ($admin==0) { 
    ?>
      <!-- <button  
        class="dropdown-btn h6 text-light list-group-item list-group-item-action bg-transparent text-white fw-normal">
        <i class="fas fa-regular fa-briefcase-medical"></i>Treatment Record<i class="fa fa-caret-down"></i>
      </button>
        <div class="dropdown-container">
          <div class="default " style="width: 210px;padding: 5px;display: block;">
          <i class="fas fa-minus-square fa-1x"></i><a 
            <?php //echo $page == 'add_tr'? "type='button'":'href="../treatment-records/add-treatment-record.php"'?>
            class="drop">Add Records</a><br>
          <i class="fas fa-minus-square fa-1x"></i><a 
            <?php //echo $page == 'view_tr'? "type='button'":'href="../treatment-records/view-treatment-records.php"'?>
            class="drop">View Records</a>
        </div>
        </div>
      <button  
        class="dropdown-btn h6 text-light list-group-item list-group-item-action bg-transparent text-white fw-normal">
        <i class="fas fa-regular fa-briefcase-medical"></i>Prescription Record<i class="fa fa-caret-down"></i>
      </button>
        <div class="dropdown-container">
           <div class="default " style="width: 210px;padding: 5px;display: block;">
          <i class="fas fa-minus-square fa-1x"></i><a 
            <?php //echo $page == 'add_pr'? "type='button'":'href="../prescription-records/add-prescription-record.php"'?>
            class="drop">Add Records</a><br>
          <i class="fas fa-minus-square fa-1x"></i><a 
            <?php //echo $page == 'view_pr'? "type='button'":'href="../prescription-records/view-prescription-records.php"'?>
            class="drop">View Records</a>
        </div>
        </div> -->
    <?php 
        // }
    ?> 
      <button  
        class="dropdown-btn h6  list-group-item 
        list-group-item-action bg-transparent " ><i style="margin-right: 13px;"
         class="fa fa-calendar fa-md" aria-hidden="true"></i>Appointments<i class="fa fa-caret-down"></i>
      </button>
      <div class="dropdown-container default text-start">
        <div class="default " style="width: 210px;padding: 5px;display: block;">
            <i class="fas fa-minus-square fa-1x" aria-hidden="true"></i><a 
              <?php echo $page == 'add_appointment' ? "type='button'" : 'href="../appointment/new-appointment.php"'?>
              class="drop">Add Appointments</a><br/>
          <?php
            if ($admin==-1) {
          ?> 
            <i class="fas fa-minus-square fa-1x" aria-hidden="true"></i><a 
              <?php echo $page == 'view_appointment' ? "type='button'" : 'href="../appointment/view-appointment.php"'?>
              class="drop">View Appointment</a>
          <?php
            } else if ($admin==0) {
          ?> 
            <i class="fas fa-minus-square fa-1x" aria-hidden="true"></i><a 
              <?php echo $page == 'pending_appointment' ? "type='button'" : 'href="../appointment/pending-appointment.php"'?>
              class="drop">Pending Appointment</a><br/>
            <i class="fas fa-minus-square fa-1x" aria-hidden="true"></i><a 
              <?php echo $page == 'approved_appointment' ? "type='button'" : 'href="../appointment/approved-appointment.php"'?>
              class="drop">Approved Appointment</a>
          <?php
            }
          ?> 
        </div>
      </div>
      <?php
        if ($admin!=-1) {
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
        class="dropdown-btn h6  list-group-item list-group-item-action bg-transparent" ><i class="fas fa-sharp fa-solid fa-hospital-user fa-md " style="margin-right: 7px;"></i>Patients<i class="fa fa-caret-down"></i>
      </button>
        <div class="dropdown-container default text-start">
          <div class="default " style="width: 210px;padding: 5px;display: block;">
            <i class="fas fa-minus-square fa-1x" aria-hidden="true"></i><a 
              <?php echo $page == 'add_patient' ? "type='button'" : 'href="../patients/add-patient.php"'?>
              class="drop">Add Patient</a><br>
              
            <i class="fas fa-minus-square fa-1x" aria-hidden="true"></i><a 
              <?php echo $page == 'view_patient' ? "type='button'" : 'href="../patients/view-patients.php"'?>
              class="drop">View Patients</a>
          </div>
        </div>
      <?php
        }  
      ?>

      <button  
        class="dropdown-btn h6  list-group-item list-group-item-action bg-transparent "><i class="fas fa-file-medical-alt fa-md fa-solid" style="margin-right: 12px;"></i>Treatments<i class="fa fa-caret-down"></i>
      </button>
        <div class="dropdown-container default text-start">
          <div class="default " style="width: 210px;padding: 5px;display: block;">
          <?php if ($admin == 0) {?>
            <i class="fas fa-minus-square fa-1x" aria-hidden="true"></i><a 
              <?php echo $page == 'add_treatment' ? "type='button'" : 'href="../treatment/add-treatment.php"'?>
              class="drop">Add Treatment</a><br>
            <i class="fas fa-minus-square fa-1x" aria-hidden="true"></i><a 
              <?php echo $page == 'view_treatment' ? "type='button'" : 'href="../treatment/view-treatment.php"'?>
              class="drop">View Treatments</a>
          <?php }?>  
          <?php if ($admin == -1) {?>
            <i class="fas fa-minus-square fa-1x" aria-hidden="true"></i><a 
              <?php echo $page == 'view_treatment_r' ? "type='button'" : 'href="../treatment/view-treatment-records.php"'?>
              class="drop">View My Treatment</a>
          <?php }?>
          </div>
        </div>
      <button  
        class="dropdown-btn h6  list-group-item list-group-item-action bg-transparent  "><i class="fas fa-solid fa-file-prescription fa-md " style="margin-right: 13px;margin-left: 2px;"></i>Prescriptions<i class="fa fa-caret-down"></i>
      </button>
        <div class="dropdown-container">
          <div class="default " style="width: 210px;padding: 5px;display: block;">
            <?php if ($admin == 0) {?>
              <i class="fas fa-minus-square fa-1x" aria-hidden="true"></i><a 
                <?php echo $page == 'add_medicine' ? "type='button'" : 'href="../prescription/add-medicine.php"'?>
                class="drop">Add Medicine</a><br>
              <i class="fas fa-minus-square fa-1x" aria-hidden="true"></i><a 
                <?php echo $page == 'view_medicine' ? "type='button'" : 'href="../prescription/view-medicine.php"'?>
                class="drop">View Medicine</a>
            <?php }?>
            <?php if ($admin == -1) {?>
              <i class="fas fa-minus-square fa-1x" aria-hidden="true"></i><a 
                <?php echo $page == 'view_medicine_r' ? "type='button'" : 'href="../prescription/view-medicine-records.php"'?>
                class="drop">View My Treatment</a>
            <?php }?>
          </div> 
        </div> 

        <button  
        class="dropdown-btn h6  list-group-item list-group-item-action bg-transparent">
        <i class="fas fa-regular fa-briefcase-medical"></i>Consultations<i class="fa fa-caret-down"></i>
      </button>
        <div class="dropdown-container">
           <div class="default " style="width: 210px;padding: 5px;display: block;">
          <i class="fas fa-minus-square fa-1x"></i><a 
            <?php echo $page == 'add_consultation'? "type='button'":'href="../consultations/add-consultation.php"'?>
            class="drop">Add Consultation</a><br>
          <i class="fas fa-minus-square fa-1x"></i><a 
            <?php echo $page == 'view_consultations'? "type='button'":'href="../consultations/view-consultations.php"'?>
            class="drop">View Consultations</a>
        </div>
        </div>
    <?php
      }
    ?>   
  </div>   
  <!-- end nav list  -->
    <hr/>  
    <footer >
      <a href="../logout.php" class="h6 list-group-item list-group-item-action bg-transparent">
        <i class="fas fa-solid fa-box fa-md" 
        style="margin-right: 11px;"></i>Logout</a>  
      <div class='p-2 text-white'>
        <?php echo isset($footer_contacts)?'<em>Contact Us</em>:<br/>'.$footer_contacts.'<br/><br/>':'' ?>
        <?php echo isset($footer_address)?'<em>Address</em>:<br/>'.$footer_address.'<br/><br/>':'' ?>
        <?php echo isset($footer_availability)?'<em>Schedule</em>:<br/>'.$footer_availability.'<br/><br/>':'' ?>
        <?php echo isset($footer_fb)?'<em>Follow Us</em>:<br/><a href="'.$footer_fb.'" target="_blank">Facebook</a><br/><br/>':'' ?>
      </div>
    </footer> 
    
  

  </div> 
</div>

<?php 
include_once('../php-templates/admin-navigation-head.php');
?>