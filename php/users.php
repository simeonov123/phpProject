<?php
/*
    This PHP script retrieves and displays a list of all registered users except the one who is currently logged in.
*/
//session_start(): Initializes a new session or resumes an existing one to access session variables.
session_start();
//include_once "config.php": Includes the database configuration file, which contains the database connection settings.
include_once "config.php";
//Retrieve Current User ID
$outgoing_id = $_SESSION['unique_id'];

//Constructs an SQL query to select all users from the database except the current user, ordered by their user ID in descending order.
$sql = "SELECT * FROM users WHERE NOT unique_id = {$outgoing_id} ORDER BY user_id DESC";
// Executes the SQL query on the database.
$query = mysqli_query($conn, $sql);

//Output Generation
$output = "";
//Checks if the query returned zero rows, indicating no other users are available to chat.
if (mysqli_num_rows($query) == 0) {
    //Appends a message to the output string if no users are found.
    $output .= "No users are available to chat";
} elseif (mysqli_num_rows($query) > 0) {
    //Includes the data.php file, which is responsible for formatting the user data into a presentable format
    //if there are one or more users found in the database.
    include_once "data.php";
}
//Outputs the generated string, which contains either a message indicating no available users or the formatted list of users.
echo $output;
