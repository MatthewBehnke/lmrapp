<?php

session_start();

// If session variable is not set it will redirect to login page

if(!isset($_SESSION['userid']) || empty($_SESSION['userid'])){
    header("location: index.php");
    exit;
} 

include 'head.php';

?>


<h1>Management Tool</h1>

<?php include 'foot.php' ?>