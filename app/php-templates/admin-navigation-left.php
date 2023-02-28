
<?php 
  include_once "../controller/onLoadController.php";
  $onloadData = new onLoadController();
  $notifCount = $onloadData->getNotifCount();
?>
<div class="navigation_nu">  
  <ul> 
    <li>
      <a href='href="../dashboard"'>
          <span><img class="logo_nu" src="../img/rhu-logo.png" alt="logo"><span>
      </a>
    </li>
    <li <?php echo $page == 'dashboard' ? "class='hovered'":""?>>
      <a <?php echo $page == 'dashboard' ? "type='button'":"href='../dashboard'"?>>
          <span class="icon"><ion-icon name="home"></ion-icon></span>
          <span class="title">Dashboard</span>
      </a>
    </li>
    <li <?php echo $page == 'demo_profile' ? "class='hovered'":""?>>
        <a <?php echo $page == 'demo_profile' ? "type='button'":'href="../profile/demographic-profile.php"'?>>
         <?php
          if($current_user_is_a_patient){?>
            <span class="icon"><ion-icon name="person-outline"></ion-icon></span>
            <span class="title">Profile</span>
             <?php }?>
        </a>
      </li>
    <!-- <li <?php echo $page == ($current_user_is_a_patient ? 'demo_profile':'update_account') ? "class='hovered'":""?>>
      <a <?php echo $page == ($current_user_is_a_patient ? 'demo_profile':'update_account') 
        ? "type='button'":(
          "href='../profile/".($current_user_is_a_patient ? "demographic-profile":"update-account").".php'"
        );?>>
         <?php
          if(!$current_user_is_an_admin){?>
          <span class="icon"><ion-icon name="person-outline"></ion-icon></span>
          <span class='title'>Profile</span>
        <?php }?>
       
      </a>
    </li> -->
    <?php 
      if($current_user_is_an_admin) { // admin 
    ?>
      <li <?php echo $page == 'view_password' ? "class='hovered'":""?>>
        <a <?php echo $page == 'view_password' ? "type='button'":'href="../profile/change-password.php"'?>>
            <span class="icon"><ion-icon name="lock-open-outline"></ion-icon></span>
            <span class="title">Change Password</span>
        </a>
      </li>
      <li <?php echo $page == 'view_midwife' ? "class='hovered'":""?>>
        <a <?php echo $page == 'view_midwife' ? "type='button'":'href="../midwife/view-midwife.php"'?>>
            <span class="icon"><ion-icon name="people-outline"></ion-icon></span>
            <span class="title">Midwife</span>
        </a>
      </li>
      <li <?php echo $page == 'view_barangay' ? "class='hovered'":""?>>
        <a <?php echo $page == 'view_barangay' ? "type='button'":'href="../health-center/view-barangay.php"'?>>
            <span class="icon"><ion-icon name="medkit-outline"></ion-icon></span>
            <span class="title">Health Center</span>
        </a>
      </li>
      
    <?php 
 
      } else { // midwife/patient 
        $appointment_page_condition = 
          $page == 'view_appointment' ||
          $page == 'approved_appointment' ||
          $page == 'pending_appointment';
        $appointment_page_str = $current_user_is_a_midwife ? 'approved_appointment' : 'view_appointment';
        $appointment_file_str = $current_user_is_a_midwife ? 'approved-appointment' : 'view-appointment';
    ?>   
      <li <?php echo $appointment_page_condition ? "class='hovered'":""?>>
        <a <?php echo $page == $appointment_page_str ? "type='button'":'href="../appointment/'.$appointment_file_str.'.php"'?>>
            <span class="icon"><ion-icon name="calendar-outline"></ion-icon></span>
            <span class="title">Appointments</span>
        </a>
      </li>
      <li <?php echo $page == 'view_consultations' ? "class='hovered'":""?>>
        <a <?php echo $page == 'view_consultations' ? "type='button'":
          ($current_user_is_a_midwife? 'href="../consultations/view-consultations.php"': 'href="../consultations/list.php"')?>>
            <span class="icon"><ion-icon name="chatbubbles-outline"></ion-icon></span>
            <span class="title">Consultations</span>
        </a>
      </li>
      <li <?php echo $page == 'infant_vaccinations' ? "class='hovered'":""?>>
        <a <?php echo $page == 'infant_vaccinations' ? "type='button'":'href="../infant/infant-vaccinations.php"'?>>
            <span class="icon"><ion-icon name="footsteps-outline"></ion-icon></span>
            <span class="title">Infant Vaccinations</span>
        </a>
      </li>
 

    <?php 
      }
      if (!$current_user_is_a_patient) { 
    ?>  
      <li <?php echo $page == 'view_patient' ? "class='hovered'":""?>>
        <a <?php echo $page == 'view_patient' ? "type='button'":'href="../patients/view-patients.php"'?>>
            <span class="icon"><ion-icon name="woman-outline"></ion-icon></span>
            <span class="title">Patients</span>
        </a>
      </li>
    <?php  
      } 
      if ($current_user_is_an_admin) {?> 
      <li <?php echo $page == 'update_footer' ? "class='hovered'":""?>>
        <a <?php echo $page == 'update_footer' ? "type='button'":'href="../update-footer"'?>>
            <span class="icon"><ion-icon name="sync-outline"></ion-icon></span>
            <span class="title">Update Footer</span>
        </a>
      </li>
    <?php 
 
      } 
      
    if (!$current_user_is_an_admin) {?>

      <li <?php echo $page == 'notification' ? "class='hovered'":""?>>
        <a href="../notification">
              <span class="icon"><ion-icon name="notifications-outline"></ion-icon></span>
              <span class="title">Notification 
                <?php $notifCount ? print_r("<span style='font-size:10px;position:relative;bottom:8px;right:2px;font-family:'Arial,sans-serif;' class='badge bg-danger ml-1'>".$notifCount."</span>") : "";?>
              </span>
          </a>
      </li>
    <?php }?>
   
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