<div class="topbar">
    <div class="toggle">
        <ion-icon name="menu-outline"></ion-icon>

    </div>
    <?php if (!$current_user_is_an_admin) {?>
       
      
    <div class="main">
      <div class="nav">
      
        <div class="ig">
          <img src="../php-templates/img/profile.jpg" id="navbar" alt="" />
        </div>
        <div class="float" id="flow">
          <div class="profile">
            <img src="../php-templates/img/profile.jpg" alt="" />
            <h4><span class="display_name" style="color: #352e35;font-size:17px;"><?php echo isset($_SESSION['name'])? 
                $_SESSION['name']:''; ?></span></h4>
          </div>
          <hr>
          
          <div class="ic"><i class="fa-sharp fa-solid fa-pen-to-square"></i>
             <a <?php echo $current_user_is_an_admin == ($current_user_is_a_patient ? 'demo_profile':'update_account') 
        ? "type='button'":(
          "href='../profile/".($current_user_is_a_patient ? "update-account":"update-account").".php'"
        );?>>
            <p>Edit Profile</p> 
        </a>
          </div>
          <div class="ic"><i class="fa-solid fa-sliders"></i>
            <a  href="../profile/change-password.php">
            
            <p>Account Setting</p>
            </a>
          </div>
         
           
          <div class="ic">
            <i class="fa-solid fa-arrow-right-from-bracket"></i>
            <a  href="../logout.php">
           
            <p>Logout</p>
            </a>
          </div>
        </div>
      </div>
    </div>
   <style>
    .logo h1{
    font-size: 38px;
    color: white;
}
.nav{
    display: flex;
    justify-content: center;
    align-items: center;
    position: relative;
}
.nav ul{
    display: flex;
    justify-content: center;
    align-items: center;
}
.nav ul li{
    color: white;
    margin: 0px 10px;
    list-style: none;
}
.ig{
    margin-left: 20px;

}
.ig img{
    width: 40px;
    height: 40px;
    border-radius: 50%;
    cursor: pointer;
}
.float{
    position: absolute;
    width: 230px;
    background-color: #fefefe;
    top: 53px;
    right: 0px;
   box-shadow: 0 7px 25px rgba(0, 0, 0, 0.08);
	border-radius: 20px;
    max-height: 0px;
   
  transition: 0.1s;
    overflow: hidden;
    z-index: 10;
}
/* Create one class not linked to html */
.fin{
    max-height: 290px;
}
.float> hr{
     position: relative;
        bottom: 4px;
        right: 15px;
        border: none;
        height: 12px;
        
        margin-bottom: 4px;
     
    
}
.profile{
    display: flex;
    align-items: center;
    padding: 15px 10px 5px 10px;
}
.profile h4{
    font-size: 14px;
    margin-left: 10px;
}
.profile img{
    width: 40px;
    height: 40px;
    border-radius: 50%;
}
.ic{
    padding: 7px 15px;
    margin-bottom: 4px 10px;
    display: flex;
    align-items: center;
}
.ic p{
    font-size: 14px;
    margin-left: 15px;
    padding-top:  1px;
    position: relative;
    bottom: 10px;
    cursor: pointer;
    transition:  1s;
    font-height: 15px;
}
.ic:hover p{
    font-weight: 500;
   
}
.ic i{
    font-size: 15px;
    position:relative;
    bottom: 20px;
    margin: 3px;
    padding-top: 5px;
    border-radius: 50%;
    color: #029670;
}


   </style>
    <script>
        let navBar = document.getElementById("navbar");
let flow = document.getElementById("flow");

navBar.addEventListener('click',() => flow.classList.toggle("fin"));
    </script>
    <?php }?>
    <!-- <div class="dropdown">
        <ion-icon name="caret-down-outline"></ion-icon>
    </div> -->
</div>