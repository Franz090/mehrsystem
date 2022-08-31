<nav class="navbar navbar-expand-lg navbar-light bg-dark py-2 px-4" style="padding: 40px 5px 4px 4px;">
    <div class="d-flex align-items-center ">
        <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i>
        <h2 class="fs-2 m-0"></h2>
    </div>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"
        style="background-color:white;">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle second-text fw-bold" style="color: white;" href="#" id="navbarDropdown"
            role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-duotone fa-user-nurse"></i>
            <strong style="color:white;">
                <?php echo isset($_SESSION['name'])? 
                    $_SESSION['name']:''; ?>
            </strong>
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <!-- <li><a class="dropdown-item" href="#">Profile</a></li>
            <li><a class="dropdown-item" href="#">Settings</a></li> -->
            <li><a class="dropdown-item" href="../logout.php" class="logout">Logout</a></li>
            </ul>
        </li>
        </ul>
    </div>
</nav>