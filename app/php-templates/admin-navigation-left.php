<div class="navigation_nu">  
  <ul> 
    <li>
      <a href='href="../dashboard"'>
          <span><img class="logo_nu" src="../img/rhu-logo.png" alt="logo"></a><span>
      </a>
    </li>
    <li>
      <a <?php echo $page == 'dashboard' ? "type='button'":"href='../dashboard'"?>>
          <span class="icon"><ion-icon name="home"></ion-icon></span>
          <span class="title">Dashboard</span>
      </a>
    </li>
    <li>
      <a <?php echo $page == 'update_account' ? "type='button'":"href='../profile/update-account.php'"?>>
          <span class="icon"><ion-icon name="person-outline"></ion-icon></span>
          <span class="title">Profile</span>
      </a>
    </li>
    <?php 
      if($admin==1) { // admin 
    ?>
      <li>
        <a <?php echo $page == 'view_midwife' ? "type='button'":'href="../midwife/view-midwife.php"'?>>
            <span class="icon"><ion-icon name="people-outline"></ion-icon></span>
            <span class="title">Midwife</span>
        </a>
      </li>
      <li>
        <a <?php echo $page == 'view_barangay' ? "type='button'":'href="../health-center/view-barangay.php"'?>>
            <span class="icon"><ion-icon name="people-outline"></ion-icon></span>
            <span class="title">Health Center</span>
        </a>
      </li>
      
    <?php 
 
      } else { // midwife/patient 
    ?>   
      <li>
        <a <?php echo $page == 'view_appointment' ? "type='button'":'href="../appointment/view-appointment.php"'?>>
            <span class="icon"><ion-icon name="people-outline"></ion-icon></span>
            <span class="title">Appointments</span>
        </a>
      </li>
      <li>
        <a <?php echo $page == 'view_consultations' ? "type='button'":'href="../consultations/view-consultations.php"'?>>
            <span class="icon"><ion-icon name="people-outline"></ion-icon></span>
            <span class="title">Consultations</span>
        </a>
      </li>
 

    <?php 
      }
      if ($admin!=-1) { // admin/midwife 
    ?>  
      <li>
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
