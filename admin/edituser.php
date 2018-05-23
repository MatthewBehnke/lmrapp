<?php

// Include database file

require_once '../database.php';

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
          <input type="text" name="userid"class="form-control" value="<?php echo $userid; ?>">
          <span class="help-block"><?php echo $userid_err; ?></span>
      </div>
      <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
          <label>Password</label>
          <input type="password" name="password" class="form-control">
          <span class="help-block"><?php echo $password_err; ?></span>
      </div>
      <div class="form-group">
          <input type="submit" class="btn btn-lg btn-primary btn-block" value="Update">
      </div>
      </form>
    </section>

</body>
</html>