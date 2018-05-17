<?php

// Include database file

require_once 'database.php';

// Define variables and initialize with empty values

$userid = $password = "";

$userid_err = $password_err = "";

// Processing form data when form is submitted

if($_SERVER["REQUEST_METHOD"] == "POST"){
 
  // Check if userid is empty

  if(empty(trim($_POST["userid"]))){
    $userid_err = 'Please enter userid.';
  } else{
    $userid = trim($_POST["userid"]);
  }

  // Check if password is empty

  if(empty(trim($_POST['password']))){
    $password_err = 'Please enter your password.';
  } else{
    $password = trim($_POST['password']);
  }

  // Validate credentials

  if(empty($userid_err) && empty($password_err)){

  // Prepare a select statement

    $sql = "SELECT userid, password, ID, firstname, lastname, email, level  FROM users WHERE userid = ?";

      if($stmt = mysqli_prepare($database, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_userid);
        // Set parameters
        $param_userid = $userid;
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
          // Store result
          mysqli_stmt_store_result($stmt);
          // Check if userid exists, if yes then verify password
          if(mysqli_stmt_num_rows($stmt) == 1){                    
            // Bind result variables
            mysqli_stmt_bind_result($stmt, $userid, $hashed_password, $ID, $firstname, $lastname, $email, $level);
            if(mysqli_stmt_fetch($stmt)){
              if(password_verify($password, $hashed_password)){
                /* Password is correct, so start a new session and
                save the userid to the session */
                session_start();
                $_SESSION['id'] = $ID; // setting the sessions id
                $_SESSION['userid'] = $userid; // setting the sessions user id
                $_SESSION['username'] = $firstname . $lastname; // setting the username
                $_SESSION['firstname'] = $firstname; // setting the users first name 
                $_SESSION['lastname'] = $lastname; // setting the users last name
                $_SESSION['email'] = $email; // settig the users email
                $_SESSION['level'] = $level; // setting the users 'level'
                header('location: home.php');
              } else{
                // Display an error message if password is not valid
                $password_err = 'The password you entered was not valid.';
              }
            }
          } else{
            // Display an error message if userid doesn't exist
            $userid_err = 'No account found with that userid.';
          }
        } else{
          echo "Oops! Something went wrong. Please try again later.";
        }
      }
      // Close statement
      mysqli_stmt_close($stmt);
    }
    // Close connection
    mysqli_close($database);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-117825027-1"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-117825027-1');
    </script>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <header id="header">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h1 class="text-center"> LRMApp <small>Login</small></h1>
          </div>
        </div>
      </div>
    </header>

    <section id="main">
      <div class="container">
        <div class="row">
          <div class="col-md-4 col-md-offset-4">
            <form id="login" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="well">
            <div class="form-group <?php echo (!empty($userid_err)) ? 'has-error' : ''; ?>">
                <label>userid</label>
                <input type="text" name="userid"class="form-control" value="<?php echo $userid; ?>">
                <span class="help-block"><?php echo $userid_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            </form>
            <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
          </div>
        </div>
      </div>
    </section>


    </div>
    <!-- <footer id="footer">
        <p>Copyright MattBehnke, &copy; 2018</p>
    </footer>     -->
</body>
</html>