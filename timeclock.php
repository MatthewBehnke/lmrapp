<?php

session_start();

// If session variable is not set it will redirect to login page

if(!isset($_SESSION['userid']) || empty($_SESSION['userid'])){
    header("location: index.php");
    exit;
} elseif($_SESSION['level'] = 0){
  header("location: index.php");
    exit;
}

include 'head.php';

?>
<h1 class = "text-center py-5">TimeClock</h1>

<main role="main">

<div class="container">
  <!-- Example row of columns -->
  <div class="row">
    <div class="col-md-4">
      <h2>Sign in for Shop</h2>
      <p>Used for tracking hours in the shop.</p>
      <p><a class="btn btn-secondary" href="punch.php?place=shop" role="button">Sign in</a></p>
    </div>
    <div class="col-md-4">
      <h2>Sign in for Outreach</h2>
      <p>Used for tracking Outreach hours.</p>
      <p><a class="btn btn-secondary" href="punch.php?place=outreach" role="button">Sign in</a></p>
    </div>
    <div class="col-md-4">
      <h2>Sign in for Home</h2>
      <p>Used for tracking hours at home.</p>
      <p><a class="btn btn-secondary" href="punch.php?place=home" role="button">Sign in</a></p>
    </div>
  </div>

  <hr>

</div> <!-- /container -->

</main>

<?php include 'foot.php' ?>