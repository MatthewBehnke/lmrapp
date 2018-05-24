<?php

require_once "../database.php";

session_start();

if(!isset($_SESSION['userid']) || empty($_SESSION['userid'])){
  header("location: ../index.php");
  exit;
} elseif($_SESSION['level'] != 7){
header("location: ../index.php");
  exit;
}

$user = $_GET['id'];

$_sql = "DELETE FROM users WHERE ID = $user";
if(mysqli_query($database,$_sql)){
  header("location: unapprovedusers.php");
} else{
  echo "error removing user!";
}

?>

<a href="./index.php"></a>