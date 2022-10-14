<?php
// this page is only for nurse accounts 
if($_SESSION['role']!=1) 
  header('location: ../'); 