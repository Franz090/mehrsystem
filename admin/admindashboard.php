<?php

@include 'includes/config.php';

session_start();

if(!isset($_SESSION['usermail'])){
   header('location:adminlogin.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="css/dashboard.css">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>
<body>

    
<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-dark" id="sidebar-wrapper" >
     
            <div class="sidebar-heading text-center py-2 primary-text fs-4 fw-bold text-uppercase border-bottom" style="color:whitesmoke;"><i
                    class="fas fa-solid fa-prescription me-2" href="patientdashboard.php"></i>MEHr</div>
            <div class="list-group list-group-flush my-3" style="color:whitesmoke;">
            <a href="#" class="h6 text-light list-group-item list-group-item-action bg-transparent second-text active"><i
                        class="fas fa-solid fa-box " ></i>Dashboard</a>
                        <button class="dropdown-btn h6  text-light list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fas fa-user me"></i>Profile<i class="fa fa-caret-down"></i></button>
                        <div class="dropdown-container" >
                            <div class="merge">
                        <i class="fas fa-light fa-minus"></i><a href="#" class="drop bg-transparent second-text active ">Change Password</a>
                         <i class="fas fa-light fa-minus"></i><a href="#" class="drop bg-transparent second-text active ">Add Nurse</a><br>
                         <i class="fas fa-light fa-minus"></i><a href="#" class="drop bg-transparent second-text active ">View Nurse</a>
                    </div>
                </div>
                <button href="#" class="dropdown-btn h6 text-light list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fas fa-thin fa-baby"></i>Midwife<i class="fa fa-caret-down"></i></button>
                        <div class="dropdown-container" >
                        <i class="fas fa-light fa-minus"></i><a href="#" class="drop">Add Midwife</a><br>
                         <i class="fas fa-light fa-minus"></i><a href="#" class="drop">View Midwife</a>
                         
                        </div>
                <button href="#" class="dropdown-btn h6 text-light list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fas fa-regular fa-briefcase-medical"></i>Health Center<i class="fa fa-caret-down"></i></button>
                        <div class="dropdown-container" >
                        <i class="fas fa-light fa-minus"></i><a href="#" class="drop">Add Barangay</a><br>
                         <i class="fas fa-light fa-minus"></i><a href="#" class="drop">View Barangay</a>
                        </div>
              
            </div>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper" style="background-color: #f0cac4">
            <nav class="navbar navbar-expand-lg navbar-light bg-dark py-2 px-4" style="padding: 40px 5px 4px 4px;" >
                <div class="d-flex align-items-center ">
                    <i class="fas fa-align-left primary-text fs-4 me-3"  id="menu-toggle"></i>
                    <h2 class="fs-2 m-0"></h2>
                </div>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation" style="background-color:white;">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">

                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle second-text fw-bold" href="#" id="navbarDropdown"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-duotone fa-user-nurse"></i><strong style="color:white;">Cathy</strong>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#">Profile</a></li>
                                <li><a class="dropdown-item" href="#">Settings</a></li>
                                <li><a class="dropdown-item" href="logout.php" class="logout" >Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
            <div class="container">
              <div class="row">
                <div class="col-md-6 col-sm-12 d-flex justify-content-center">
                  <div id="piechart" style="width: 400px; height: 200px"></div>
                </div>
                <div class="col-md-6 col-sm-12 d-flex justify-content-center">
                  <div
                    id="columnchart_material"
                    style="width: 400px; height: 200px"
                  ></div>
                </div>
              </div>
              </div>
              <div class="container"><div class="row bg-light m-3 con1"></div></div>
            </div>

            </div>
            
        </div>
    </div>
    <!-- /#page-content-wrapper -->
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        var el = document.getElementById("wrapper");
        var toggleButton = document.getElementById("menu-toggle");

        toggleButton.onclick = function () {
            el.classList.toggle("toggled");
        };
    </script>
<script src="js/script.js"></script>
<script>
/* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
var dropdown = document.getElementsByClassName("dropdown-btn");
var i;

for (i = 0; i < dropdown.length; i++) {
  dropdown[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var dropdownContent = this.nextElementSibling;
    if (dropdownContent.style.display === "block") {
      dropdownContent.style.display = "none";
    } else {
      dropdownContent.style.display = "block";
    }
  });
}
</script>



</body>

</html>