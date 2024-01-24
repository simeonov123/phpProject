<?php
/*
  This PHP script establishes a connection to a MySQL database.
  It connects to a database 'chat' on a MySQL server running on the localhost with default credentials.
*/

// Database connection parameters
$hostname = "localhost"; // Hostname or IP address of the MySQL server
$username = "root";      // MySQL username
$password = "";          // MySQL password (empty for default)
$dbname = "chat";        // Name of the database to connect to

// Establish a MySQL database connection
$conn = mysqli_connect($hostname, $username, $password, $dbname);

// Check if the connection was successful
if (!$conn) {
  echo "Database connection error: " . mysqli_connect_error();
}
