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

?>
<h1>TimeClock</h1>

<?php include 'foot.php' ?>