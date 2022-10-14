<?php
// this page is only for patients and midwife accounts 
if($_SESSION['role']==1) 
  header('location: ../'); 