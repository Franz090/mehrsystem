<?php
// this page is only for nurse accounts 
if($_SESSION['admin']!=1) 
  header('location: ../'); 