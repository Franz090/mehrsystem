<div class="navigation_nu">  
  <ul> 
    <li>
      <a href='href="../dashboard"'>
          <span><img class="logo_nu" src="../img/rhu-logo.png" alt="logo"></a><span>
      </a>
    </li>
    <li <?php echo $page == 'dashboard' ? "class='hovered'":""?>>
      <a <?php echo $page == 'dashboard' ? "type='button'":"href='../dashboard'"?>>
          <span class="icon"><ion-icon name="home"></ion-icon></span>
          <span class="title">Dashboard</span>
      </a>
    </li>
    <li <?php echo $page == ($current_user_is_a_patient ? 'demo_profile':'update_account') ? "class='hovered'":""?>>
      <a <?php echo $page == ($current_user_is_a_patient ? 'demo_profile':'update_account') 
        ? "type='button'":(
          "href='../profile/".($current_user_is_a_patient ? "demographic-profile":"update-account").".php'"
        );?>>
          <span class="icon"><ion-icon name="person-outline"></ion-icon></span>
          <span class="title">Profile</span>
      </a>
    </li>
    <?php 
      if($current_user_is_an_admin) { // admin 
    ?>
      <li <?php echo $page == 'view_midwife' ? "class='hovered'":""?>>
        <a <?php echo $page == 'view_midwife' ? "type='button'":'href="../midwife/view-midwife.php"'?>>
            <span class="icon"><ion-icon name="people-outline"></ion-icon></span>
            <span class="title">Midwife</span>
        </a>
      </li>
      <li <?php echo $page == 'view_barangay' ? "class='hovered'":""?>>
        <a <?php echo $page == 'view_barangay' ? "type='button'":'href="../health-center/view-barangay.php"'?>>
            <span class="icon"><ion-icon name="people-outline"></ion-icon></span>
            <span class="title">Health Center</span>
        </a>
      </li>
      
    <?php 
 
      } else { // midwife/patient 
    ?>   
      <li <?php echo (
        $page == 'view_appointment' ||
        $page == 'approved_appointment' ||
        $page == 'pending_appointment'
      ) ? "class='hovered'":""?>>
        <a <?php echo $page == 'view_appointment' ? "type='button'":'href="../appointment/view-appointment.php"'?>>
            <span class="icon"><ion-icon name="people-outline"></ion-icon></span>
            <span class="title">Appointments</span>
        </a>
      </li>
      <li <?php echo $page == 'view_consultations' ? "class='hovered'":""?>>
        <a <?php echo $page == 'view_consultations' ? "type='button'":'href="../consultations/view-consultations.php"'?>>
            <span class="icon"><ion-icon name="people-outline"></ion-icon></span>
            <span class="title">Consultations</span>
        </a>
      </li>
 

    <?php 
      }
      if (!$current_user_is_a_patient) { // admin/midwife 
    ?>  
      <li <?php echo $page == 'view_patient' ? "class='hovered'":""?>>
        <a <?php echo $page == 'view_patient' ? "type='button'":'href="../patients/view-patients.php"'?>>
            <span class="icon"><ion-icon name="people-outline"></ion-icon></span>
            <span class="title">Patients</span>
        </a>
      </li>
    <?php  
      } 
    ?>
    <hr/>
    <li>
       <a href="../logout.php">
            <span class="icon"><ion-icon name="log-out-outline"></ion-icon></span>
            <span class="title">Log-Out</span>
        </a>
    </li>
  </ul>
</div>

<?php 
include_once('../php-templates/admin-navigation-head.php');
?>
