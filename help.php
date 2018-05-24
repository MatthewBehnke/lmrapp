<?php

session_start();

// If session variable is not set it will redirect to login page

if(!isset($_SESSION['userid']) || empty($_SESSION['userid'])){
    header("location: index.php");
    exit;
} elseif($_SESSION['level']  = 0){
  header("location: index.php");
    exit;
}


include 'head.php';
?>
<h3 class = "text-center">Help is coming soon to a theatre near you. </h3>