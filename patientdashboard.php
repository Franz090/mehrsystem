<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="css/dashboard.css">
   <link rel="stylesheet" href="fullcalendar/lib/main.min.css">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <script src="./fullcalendar/lib/main.min.js"></script>
   
</head>
<body>
    
<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div id="sidebar-wrapper" style="background-color:#0abe97;">
            <div style="background-color:#0abe97;"><i
                    class="logo" href="#"><img src = "../mehrsystem/image/rhu-logo.png" width="150" height="150" style="position=absolute; margin-top:10px; margin-left:45px;"></i></div>
            <div class="list-group list-group-flush my-3" style="background-color:#0abe97;">
            <a href="#" class="h6 text-light list-group-item list-group-item-action bg-transparent second-text active"><i
                        class="fas fa-solid fa-house-user"></i>Home</a>
            <a href="#" class="h6 text-light list-group-item list-group-item-action bg-transparent second-text active"><i
                        class="fas fa-solid fa-calendar-check fa-sm"></i>My Appointment</a>
            <a href="#" class="h6 text-light list-group-item list-group-item-action bg-transparent second-text active"><i
                        class="fas fa-solid fa-file"></i>My Consultation</a>
            <a href="#" class="h6 text-light list-group-item list-group-item-action bg-transparent second-text active"><i
                        class="fas fa-solid fa-baby"></i>Infant Tracking</a>
            </div>
            <hr style="color:white; margin-top: 100px" ></hr>
            <div class="list-group list-group-flush my-3" style="background-color:#0abe97;">
            <a href="#" class="h6 text-light list-group-item list-group-item-action bg-transparent second-text active mt-5"><i
                        class="fas fa-solid fa-wrench"></i>Account Settings</a>
            <a href="#" class="h6 text-light list-group-item list-group-item-action bg-transparent second-text active"><i
                        class="fas fa-solid fa-door-open"></i>Logout</a>
            </div>
        </div>
        
        <!-- /#sidebar-wrapper -->
        <!-- Page Content -->
        <div id="page-content-wrapper" style="background-color: #0abe97;">
            <nav class="navbar navbar-expand-lg navbar-light py-2 px-4" style="padding: 40px 5px 4px 4px;" >
                <div class="d-flex align-items-center ">
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
                                role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color:white;">
                                <i class="fas fa-user me-2"></i>Hello, User 
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
            
            <div class="container"><div class="row bg-light m-3 con1" ></div>
                    <iframe src="https://calendar.google.com/calendar/embed?height=600&wkst=1&bgcolor=%23ffffff&ctz=UTC&showNav=1&showDate=1&showPrint=0&showTz=1&showCalendars=0&showTabs=1&title=Appointment&src=ZW4ucGhpbGlwcGluZXMjaG9saWRheUBncm91cC52LmNhbGVuZGFyLmdvb2dsZS5jb20&color=%230B8043" style="border-width:0" width="800" height="600" frameborder="0" scrolling="no"></iframe>
                    </div>
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