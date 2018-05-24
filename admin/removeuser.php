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

?> <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>abandon ship</title>
  <link rel="icon" 
      type="image/png" 
      href="../img/logo_only.png">
</head>
<body>
  
</body>
</html>

<a href="./index.php"></a>