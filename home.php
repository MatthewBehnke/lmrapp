<?php // Initialize the session
session_start();

// If session variable is not set it will redirect to login page

if(!isset($_SESSION['userid']) || empty($_SESSION['userid'])){
    header("location: index.php");
    exit;
} 


include 'head.php';

echo $_SESSION['id'] .'<br>';
echo $_SESSION['userid'].'<br>';
echo $_SESSION['username'].'<br>';
echo $_SESSION['firstname'].'<br>';
echo $_SESSION['lastname'].'<br>';
echo $_SESSION['email'].'<br>';
echo $_SESSION['level'].'<br>';

?>


<?php include 'foot.php' ?>