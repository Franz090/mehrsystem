<?php 

if ($admin==-1 && !(isset($_SESSION['status']) && $_SESSION['status'])) {
    header('location: ../'); 
}