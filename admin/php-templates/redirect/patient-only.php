<?php
// this page is only for patient accounts 
if($_SESSION['role']!=-1) 
  header('location: ../'); 