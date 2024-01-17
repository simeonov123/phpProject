<?php
/*
  This PHP script establishes a connection to a MySQL database. 
  It connects to a database 'chat' on a MySQL server running on the localhost with default credentials.
*/
  $hostname = "localhost";
  $username = "root";
  $password = "";
  $dbname = "chat";

  $conn = mysqli_connect($hostname, $username, $password, $dbname);
  if(!$conn){
    echo "Database connection error".mysqli_connect_error();
  }
?>
