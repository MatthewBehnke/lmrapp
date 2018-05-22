<?php

require_once '../database.php';

session_start();

// If session variable is not set it will redirect to login page

if(!isset($_SESSION['userid']) || empty($_SESSION['userid'])){
  header("location: index.php");
  exit;
} elseif($_SESSION['level'] != 7){
  header("location: ../index.php");
  exit;
}

$sql="SELECT  * from users WHERE level = 0";
$result=mysqli_query($database,$sql);
$num_users = mysqli_num_rows($result);
$resultset=array();
// Associative array
while($row=mysqli_fetch_assoc($result))
{
  $resultset[]=$row;
}

// Define varables and initialize with empty values
$userid = $firstname = $lastname = $email = $password = $confirm_password = "";

// Define varables errors and initialize with empty values
$userid_err = $firstname_err = $lastname_err = $email_err = $password_err = $confirm_password_err = "";

// Precessing from data when form is submitted and check if there is already a user with the userid the new user wants
if($_SERVER["REQUEST_METHOD"] == "POST"){
  // Validate userid
  if(empty(trim($_POST["userid"]))){
    $userid_err = "Please enter a userid.";
  } else{
    // Prepare a select statment
    $sql_userid_lookup = "SELECT id FROM users WHERE userid = ?";
    if($stmt_userid_lookup = mysqli_prepare($database, $sql_userid_lookup)){
      // Bind varables to the prepared statment as parameters
      mysqli_stmt_bind_param($stmt_userid_lookup, "s", $param_userid);
      // Set parameters
      $param_userid = trim($_POST["userid"]);
      // Attempt to execute the prepared statment
      if(mysqli_stmt_execute($stmt_userid_lookup)){
        // Store result
        mysqli_stmt_store_result($stmt_userid_lookup);
        if(mysqli_stmt_num_rows($stmt_userid_lookup) == 1){
          $userid_err = "This userid is already taken.";
        } else{
          $userid = trim($_POST["userid"]);
        }
      } else{
        echo "Oops! Something went wrong. Please try again later.";
      }
    }
    // close statment
    mysqli_stmt_close($stmt_userid_lookup);
  }

  // Validate First Name
  if(empty(trim($_POST["firstname"]))){
    $firstname_err = "Please enter a first name.";
  } else{
    $firstname = trim($_POST['firstname']);
  }
  
  // Validate Last Name
  if(empty(trim($_POST["lastname"]))){
    $lastname_err = "Please enter a last name.";
  } else{
    $lastname = trim($_POST['lastname']);
  }
  
  // Validate Email 
  if(empty(trim($_POST['email']))){
    $email_err = "Please enter an email";
  } else{
      // Prepare a select statment
      $sql_email_lookup = "SELECT id FROM users WHERE email = ?";
      if($stmt_email_lookup = mysqli_prepare($database, $sql_email_lookup)){
        // Bind varables to the prepared statment as parameters
        mysqli_stmt_bind_param($stmt_email_lookup, "s", $param_email);
        // Set parameters
        $param_email = trim($_POST["email"]);
        // Attempt to execute the prepared statment
        if(mysqli_stmt_execute($stmt_email_lookup)){
          // Store result
          mysqli_stmt_store_result($stmt_email_lookup);
          if(mysqli_stmt_num_rows($stmt_email_lookup) == 1){
            $email_err = "This email is already taken.";
          } else{
          if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
            $email_err = "Please enter a valid email.";
          } else{
            $email = trim($_POST['email']);
          }
          }
        } else{
          echo "Oops! Something went wrong. Please try again later.";
        }
      }
      // close statment
      mysqli_stmt_close($stmt_email_lookup);
  }

  // Validate password
  if(empty(trim($_POST['password']))){
    $password_err = "Please enter a password.";     
  } elseif(strlen(trim($_POST['password'])) < 6){
    $password_err = "Password must have atleast 6 characters.";
  } else{
    $password = trim($_POST['password']);
  }
  // Validate confirm password
  if(empty(trim($_POST["confirm_password"]))){
    $confirm_password_err = 'Please confirm password.';     
  } else{
    $confirm_password = trim($_POST['confirm_password']);
    if($password != $confirm_password){
        $confirm_password_err = 'Password did not match.';
    }
  }

  // Check for errors before instering data into database
  if(empty($userid_err) && empty($firstname_err) && empty($lastname_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)){
    // prepare an insert statment
    $sql_newuser = "INSERT INTO users (userid, firstname , lastname , email, password) VALUES (?, ? , ? , ?, ?)";
    if($stmt_newuser = mysqli_prepare($database, $sql_newuser)){
      // Bind variables to the prepared statement as parameters
      mysqli_stmt_bind_param($stmt_newuser, "sssss", $param_userid, $param_firstname ,$param_lastname, $param_email, $param_password);
      // Set parameters
      $param_userid = $userid;
      $param_firstname = $firstname;
      $param_lastname = $lastname;
      $param_email = $email;
      $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
      // Attempt to execute the prepared statement
      if(mysqli_stmt_execute($stmt_newuser)){
          // Redirect to login page
          header("location: index.php");
      } else{
          echo "Something went wrong. Please try again later.";
      }
    }
  // Close statement
  mysqli_stmt_close($stmt_newuser);
  }
// Close connection
mysqli_close($database);
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
    <link href="../css/dashboard.css" rel="stylesheet">
  </head>

  <body>
    <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
      <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Linn-Mar Robotics Admin</a>
      <!--<input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search"> -->
      <ul class="navbar-nav px-3"> 
        <li class="nav-item text-nowrap">
          <a class="nav-link" href="../logout.php">Log Out</a>
        </li>
      </ul>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
          <div class="sidebar-sticky">
            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link" href="../admin/index.php">
                  <span data-feather="home"></span>
                  Dashboard
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../home.php">
                  <span data-feather="home"></span>
                  Student Side
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" href="../admin/unapprovedusers.php">
                  <span data-feather="users"></span>
                  Unapproved Users <span class="sr-only">(current)</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../admin/students.php">
                  <span data-feather="users"></span>
                  Students 
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../admin/mentors.php">
                  <span data-feather="users"></span>
                  Mentors
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../admin/coaches.php">
                  <span data-feather="users"></span>
                  Coaches
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../admin/reports.php">
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
                <a class="nav-link" href="#">
                  <span data-feather="file-text"></span>
                  Students loged In
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

          <h2 class= "text-center">Unapproved Users</h2>
          <div class="table-responsive">
            <table class="table table-striped table-sm">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Userid</th>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Email</th>
                  <th>Edit</th>
                </tr>
              </thead>
              <tbody>
              <?php
              // echo $num_users;
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
                        <td><button type='button' class='btn btn-primary' data-toggle='modal' data-target='#exampleModal'>
                        Edit 
                      </button></td>
                      </tr>";
                }
              }
                ?>
              </tbody>
            </table>
          </div>
          <!-- Modal -->
          <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                      <div class="form-group <?php echo (!empty($userid_err)) ? 'has-error' : ''; ?>">
                          <label>userid</label>
                          <input type="text" name="userid"class="form-control" value="<?php echo $userid; ?>">
                          <span class="help-block"><?php echo $userid_err; ?></span>
                      </div>
                      <div class="form-group">
                          <input type="submit" class="btn btn-primary" value="Submit">
                          <input type="reset" class="btn btn-default" value="Reset">
                      </div>
                  </form>
                  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                      <div class="form-group <?php echo (!empty($firstname_err)) ? 'has-error' : ''; ?>">
                          <label>First Name</label>
                          <input type="text" name="firstname"class="form-control" value="<?php echo $firstname; ?>">
                          <span class="help-block"><?php echo $firstname_err; ?></span>
                      </div>
                      <div class="form-group">
                          <input type="submit" class="btn btn-primary" value="Update">
                          <input type="reset" class="btn btn-default" value="Reset">
                      </div>
                  </form>
                  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                      <div class="form-group <?php echo (!empty($lastname_err)) ? 'has-error' : ''; ?>">
                          <label>Last Name</label>
                          <input type="text" name="lastname"class="form-control" value="<?php echo $lastname; ?>">
                          <span class="help-block"><?php echo $lastname_err; ?></span>
                      </div>
                      <div class="form-group">
                          <input type="submit" class="btn btn-primary" value="Update">
                          <input type="reset" class="btn btn-default" value="Reset">
                      </div>
                  </form>
                  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                      <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                          <label>Email</label>
                          <input type="text" name="email"class="form-control" value="<?php echo $email; ?>">
                          <span class="help-block"><?php echo $email_err; ?></span>
                      </div>
                      <div class="form-group">
                          <input type="submit" class="btn btn-primary" value="Update">
                          <input type="reset" class="btn btn-default" value="Reset">
                      </div>
                  </form>
                  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                      <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                          <label>Password</label>
                          <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                          <span class="help-block"><?php echo $password_err; ?></span>
                      </div>
                      <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                          <label>Confirm Password</label>
                          <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                          <span class="help-block"><?php echo $confirm_password_err; ?></span>
                      </div>
                      <div class="form-group">
                          <input type="submit" class="btn btn-primary" value="Update">
                          <input type="reset" class="btn btn-default" value="Reset">
                      </div>
                  </form>
              </div> 
                </div>
              </div>
            </div>
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

<?php include '../foot.php'  ?>