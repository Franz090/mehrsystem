<nav class="navbar navbar-expand-lg navbar-light py-2 px-4" style="padding: 40px 5px 4px 4px;background-color: #fdf8fc; ">
    <div class="d-flex">
        <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle" style="color:#352e35;"></i>
    </div>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"
        style="background-color:white;">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <?php if ($admin!=1) { ?>
            <img class="ms-auto" style="width:35px;height:35px;border-radius:50%;position:relative;bottom: 5px;" 
                src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png"/>
        <?php } ?>
        <ul class="navbar-nav mb-2 mb-lg-0 <?php echo ($admin==1)? 
                    'ms-auto':''; ?>">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle second-text fw-bold" style="color: white;" href="#" id="navbarDropdown"
            role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <!-- <i class="fas fa-duotone fa-user-nurse"></i> -->
            <strong style="color:#352e35;">
                <?php echo isset($_SESSION['name'])? 
                    $_SESSION['name']:''; ?>
            </strong>
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <!-- <li><a class="dropdown-item" href="#">Profile</a></li>
            <li><a class="dropdown-item" href="#">Settings</a></li> -->
            <li><a class="dropdown-item" href="../logout.php" class="logout">Logout</a></li>
            <style>
                .dropdown-item{
                    font-family: Arial, Helvetica, sans-serif;
                    color: black;
                    background: whitesmoke;
                    padding: 1px;
                }
                .dropdown-item:hover{
                    background-color: #0275d8;
                }
            </style>
            </ul>
        </li>
        </ul>
    </div>
</nav>