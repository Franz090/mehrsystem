<?php

if(!isset($_SESSION['admin'])) 
    header('location: ../'); 
else {
    $admin = $_SESSION['admin'];  
} 
// user is not a patient 
if ($_SESSION['admin']!=-1) {
    // if the account logged in is a nurse 
    // they will see add/view midwife 
    // else - meaning they are midwife, they ll see profile 
    $account_type_midwife = $admin == 1 ? "midwife":"profile";
    // echo $account_type_midwife;
} 