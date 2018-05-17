<?php

  /*
  Database credentials. Assuming that the server is running MySQL for the database.
  */

  define('DB_SERVER', 'localhost'); // Database location
  define('DB_NAME', 'lmrapp');            // Database name
  define('DB_USERNAME', 'mattbehnke');        // Database Username
  define('DB_PASSWORD', 'E7eFla9XRV90PU1g');        // Database pass

  // Attempt to connect to the MySQL database withthe given credentials.

  $database = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

  // Check conection 

  if($database === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
  }
?>