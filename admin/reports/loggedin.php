<?php

require_once '../../database.php';

session_start();

// If session variable is not set it will redirect to login page

if(!isset($_SESSION['userid']) || empty($_SESSION['userid'])){
  header("location: index.php");
  exit;
} elseif($_SESSION['level'] != 7){
  header("location: ../index.php");
  exit;
}


?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Admin</title>

  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">


    <!-- Custom styles for this template -->
    <link href="../../css/dashboard.css" rel="stylesheet">

    <link rel="icon" 
      type="image/png" 
      href="../img/logo_only.png">

  </head>

  <body>
    <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
      <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Linn-Mar Robotics Admin</a>
      <!--<input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search"> -->
      <ul class="navbar-nav px-3"> 
        <li class="nav-item text-nowrap">
          <a class="nav-link" href="../../logout.php">Log Out</a>
        </li>
      </ul>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
          <div class="sidebar-sticky">
            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link" href="../../home.php">
                  <span data-feather="home"></span>
                  Student Side
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../../admin/unapprovedusers.php">
                  <span data-feather="users"></span>
                  Unapproved Users 
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../../admin/students.php">
                  <span data-feather="users"></span>
                  Students
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../../admin/mentors.php">
                  <span data-feather="users"></span>
                  Mentors
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../../admin/coaches.php">
                  <span data-feather="users"></span>
                  Coaches
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../../admin/reports.php">
                  <span data-feather="bar-chart-2"></span>
                  Reports
                </a>
              </li>
            </ul>

            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
              <span>Common reports</span>
              <a class="d-flex align-items-center text-muted" href="#">
                <!-- <span data-feather="plus-circle"></span> -->
              </a>
            </h6>
            <ul class="nav flex-column mb-2">
              <li class="nav-item">
                <a class="nav-link" href="../../admin/reports/loggedin.php">
                  <span data-feather="file-text"></span>
                  Students logged In
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <span data-feather="file-text"></span>
                  Students Paperwork
                </a>
              </li>
            </ul>
          </div>
        </nav>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2 text-center">LM Robotics</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
            </div>
          </div>

          <h2 class = "text-center">Students logged in</h2>
          <h3>4150</h3>
          <div class="table-responsive">
            <table class="table table-striped table-sm">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Userid</th>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Email</th>
                </tr>
              </thead>
              <tbody>
              <?php

              $sql="SELECT * from users WHERE punched_in = 1 AND level = 2";
              $result=mysqli_query($database,$sql);
              $num_users = mysqli_num_rows($result);
              $resultset=array();
              // Associative array
              while($row=mysqli_fetch_assoc($result))
              {
                $resultset[]=$row;
              }
              if(!empty($num_users)){
                for($i = 0; $i < $num_users; $i++){
                  $num = $num_users - $i -1;
                  $id = $resultset[$num]['ID'];
                  $userid = $resultset[$num]['userid'];
                  $firstname = $resultset[$num]['firstname'];
                  $lastname = $resultset[$num]['lastname'];
                  $email = $resultset[$num]['email'];
                  echo "<tr>
                        <th>$id</th>
                        <th>$userid</th>
                        <th>$firstname</th>
                        <th>$lastname</th>
                        <th>$email</th>
                        ";
                }   
              }
                ?>
              </tbody>
            </table>

            <h3>4324</h3>
          <div class="table-responsive">
            <table class="table table-striped table-sm">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Userid</th>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Email</th>
                </tr>
              </thead>
              <tbody>
              <?php

              $sql="SELECT * from users WHERE punched_in = 1 AND level = 3";
              $result=mysqli_query($database,$sql);
              $num_users = mysqli_num_rows($result);
              $resultset=array();
              // Associative array
              while($row=mysqli_fetch_assoc($result))
              {
                $resultset[]=$row;
              }
              if(!empty($num_users)){
                for($i = 0; $i < $num_users; $i++){
                  $num = $num_users - $i -1;
                  $id = $resultset[$num]['ID'];
                  $userid = $resultset[$num]['userid'];
                  $firstname = $resultset[$num]['firstname'];
                  $lastname = $resultset[$num]['lastname'];
                  $email = $resultset[$num]['email'];
                  echo "<tr>
                        <th>$id</th>
                        <th>$userid</th>
                        <th>$firstname</th>
                        <th>$lastname</th>
                        <th>$email</th>
                        ";
                }   
              }
                ?>
              </tbody>
            </table>

            <h3>10107</h3>
            <div class="table-responsive">
            <table class="table table-striped table-sm">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Userid</th>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Email</th>
                </tr>
              </thead>
              <tbody>
              <?php

              $sql="SELECT * from users WHERE punched_in = 1 AND level = 3";
              $result=mysqli_query($database,$sql);
              $num_users = mysqli_num_rows($result);
              $resultset=array();
              // Associative array
              while($row=mysqli_fetch_assoc($result))
              {
                $resultset[]=$row;
              }
              if(!empty($num_users)){
                for($i = 0; $i < $num_users; $i++){
                  $num = $num_users - $i -1;
                  $id = $resultset[$num]['ID'];
                  $userid = $resultset[$num]['userid'];
                  $firstname = $resultset[$num]['firstname'];
                  $lastname = $resultset[$num]['lastname'];
                  $email = $resultset[$num]['email'];
                  echo "<tr>
                        <th>$id</th>
                        <th>$userid</th>
                        <th>$firstname</th>
                        <th>$lastname</th>
                        <th>$email</th>
                        ";
                }   
              }
                ?>
              </tbody>
            </table> 

              <h3>967</h3>
            <div class="table-responsive">
            <table class="table table-striped table-sm">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Userid</th>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Email</th>
                </tr>
              </thead>
              <tbody>
              <?php

              $sql="SELECT * from users WHERE punched_in = 1 AND level = 4";
              $result=mysqli_query($database,$sql);
              $num_users = mysqli_num_rows($result);
              $resultset=array();
              // Associative array
              while($row=mysqli_fetch_assoc($result))
              {
                $resultset[]=$row;
              }
              if(!empty($num_users)){
                for($i = 0; $i < $num_users; $i++){
                  $num = $num_users - $i -1;
                  $id = $resultset[$num]['ID'];
                  $userid = $resultset[$num]['userid'];
                  $firstname = $resultset[$num]['firstname'];
                  $lastname = $resultset[$num]['lastname'];
                  $email = $resultset[$num]['email'];
                  echo "<tr>
                        <th>$id</th>
                        <th>$userid</th>
                        <th>$firstname</th>
                        <th>$lastname</th>
                        <th>$email</th>
                        ";
                }   
              }
                ?>
              </tbody>
            </table>



          </div>
        </main>
      </div>
    </div>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="../../assets/js/vendor/popper.min.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>

    <!-- Icons -->
    <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
    <script>
      feather.replace()
    </script>
  </body>
</html>

<?php include '../../foot.php'?>