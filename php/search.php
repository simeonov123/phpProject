<?php
/*
    handle the search functionality for finding users within the application. 
    It allows users to search for other users by their first name or last name
*/
// Initializes a new session or resumes the existing one.
session_start();
// Includes the configuration file, which contains the database connection settings
include_once "config.php";

//Retrieves the unique ID of the current user from the session.
$outgoing_id = $_SESSION['unique_id'];
//Secures the search term received via POST request from SQL injection.
$searchTerm = mysqli_real_escape_string($conn, $_POST['searchTerm']);

//SQL query to find users in the database.
//The query excludes the current user and searches for users whose first name or last name contains the search term.
$sql = "SELECT * FROM users WHERE NOT unique_id = {$outgoing_id} AND (fname LIKE '%{$searchTerm}%' OR lname LIKE '%{$searchTerm}%') ";
$output = "";
//executes the SQL query and checks if any users were found.
$query = mysqli_query($conn, $sql);
if (mysqli_num_rows($query) > 0) {
    //If users are found, it includes data.php which formats and displays the search results.
    include_once "data.php";
} else {
    //If no users are found, it sets $output to a message indicating that no users were found related to the search term.
    $output .= 'No user found related to your search term';
}
echo $output;
