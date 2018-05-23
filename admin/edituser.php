<?php

// Include database file

require_once '../database.php';

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
    $sql_newuser = "UPDATE users SET userid, firstname , lastname , email, password VALUES (?, ? , ? , ?, ?) WHERE ID = {$_GET['id']} ";
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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <!-- <link rel="stylesheet" href="./css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/signin.css">

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
</head>
<body>    
    <section id="main">    
      <form id="login" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="well">
      <div class="form-group <?php echo (!empty($userid_err)) ? 'has-error' : ''; ?>">
          <label>userid</label>
          <input type="text" name="userid"class="form-control" value="<?php echo $userid; ?>">
          <span class="help-block"><?php echo $userid_err; ?></span>
      </div>
      <div class="form-group <?php echo (!empty($userid_err)) ? 'has-error' : ''; ?>">
          <label>firstname</label>
          <input type="text" name="userid"class="form-control" value="<?php echo $userid; ?>">
          <span class="help-block"><?php echo $userid_err; ?></span>
      </div>
      <div class="form-group <?php echo (!empty($userid_err)) ? 'has-error' : ''; ?>">
          <label>lastname</label>
          <input type="text" name="userid"class="form-control" value="<?php echo $userid; ?>">
          <span class="help-block"><?php echo $userid_err; ?></span>
      </div>    
      <div class="form-group <?php echo (!empty($userid_err)) ? 'has-error' : ''; ?>">
          <label>email</label>
          <input type="text" name="userid"class="form-control" value="<?php echo $userid; ?>">
          <span class="help-block"><?php echo $userid_err; ?></span>
      </div>
      <div class="form-group <?php echo (!empty($userid_err)) ? 'has-error' : ''; ?>">
          <label>level</label>
          <input type="numbers" name="userid"class="form-control" value="<?php echo $userid; ?>">
          <span class="help-block"><?php echo $userid_err; ?></span>
      </div>
      <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
          <label>Password</label>
          <input type="password" name="password" class="form-control">
          <span class="help-block"><?php echo $password_err; ?></span>
      </div>
      <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
      </div>
      <div class="form-group">
          <input type="submit" class="btn btn-lg btn-primary btn-block" value="Update">
      </div>
      </form>
    </section>

</body>
</html>