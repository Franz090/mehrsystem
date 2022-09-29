<?php
// this page is only for midwife accounts 
if($_SESSION['role']!=0) 
  header('location: ../'); 