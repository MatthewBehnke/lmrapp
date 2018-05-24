<?php

require_once "../database.php";

for ($i = 0; $i < 20; $i++){
    $sql = "INSERT INTO users (userid, firstname, lastname, email, password) VALUES (?,?,?,?,?)";
    if($stmt_newuser = mysqli_prepare($database, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt_newuser, "sssss", $param_userid, $param_firstname ,$param_lastname, $param_email, $param_password);
        // Set parameters
        $param_userid = "user{$i}userid";
        $param_firstname = "user{$i}fn";
        $param_lastname = "user{$i}ln";
        $param_email = "user{$i}email@email.com";
        $param_password = password_hash("123456", PASSWORD_DEFAULT); // Creates a password hash
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt_newuser)){
    
        }
      }
    // Close statement
    mysqli_stmt_close($stmt_newuser);
    }
  // Close connection
  mysqli_close($database);
?>