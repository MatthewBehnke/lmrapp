<?php // Initialize the session
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

<main role="main">

<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
  <div class="container">
    <h1 class="display-3">Hello, <?php echo $_SESSION['username'] ?></h1>
    <p>This is the Linn-Mar Robotics App for all things that should not be public </p>
    <!-- <p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more &raquo;</a></p> -->
  </div>
</div>

<div class="container">
  <!-- Example row of columns -->
  <div class="row">
    <div class="col-md-4">
      <h2>Time Clock</h2>
      <p>The Linn-Mar Robotics timeclock is a tool used by the linnmar robotics teams for time tracking</p>
      <p><a class="btn btn-secondary" href="timeclock.php" role="button">Go to The Timeclock</a></p>
    </div>
    <div class="col-md-4">
      <h2>Scouting Tool</h2>
      <p>The Linn-Mar Robotics scouting tool is used currently by the iron lions frc team #967 with development towards an ftc version as well. </p>
      <p><a class="btn btn-secondary" href="scouting.php" role="button">Go to The Scouting Tool</a></p>
    </div>
    <div class="col-md-4">
      <h2>Managment Tool</h2>
      <p>The Linn-Mar Robotics managment tool is used to track the users forms and simmilar items</p>
      <p><a class="btn btn-secondary" href="management.php" role="button">Go to The Managment Tool</a></p>
    </div>
  </div>

  <hr>

</div> <!-- /container -->

</main>


<?php include 'foot.php' ?>
