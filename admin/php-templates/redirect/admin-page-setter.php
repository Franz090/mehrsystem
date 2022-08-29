<?php
    if(!isset($_SESSION['admin'])) 
        header('location: ../'); 
    else {
        $admin = $_SESSION['admin'];  
    } 
   