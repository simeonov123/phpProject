<?php
/*
    This PHP script retrieves and displays a list of all registered users except the one who is currently logged in.
*/

// Initializes a new session or resumes an existing one to access session variables.
session_start();

// Include the database configuration file, which contains the database connection settings.
include_once "config.php";

// Retrieve the current user's unique_id (user ID).
$outgoing_id = $_SESSION['unique_id'];

// Construct an SQL query using prepared statements to select all users from the database except the current user.
$sql = "SELECT * FROM users WHERE NOT unique_id = ? ORDER BY user_id DESC";

// Prepare the mysql statement
$stmt = mysqli_prepare($conn, $sql);
if ($stmt) {
    // Bind the outgoing_id as a parameter
    mysqli_stmt_bind_param($stmt, "i", $outgoing_id);

    // Execute the statement
    mysqli_stmt_execute($stmt);

    // Get the result
    $query = mysqli_stmt_get_result($stmt);

    // Initialize an empty string for output.
    $output = "";

    if (mysqli_num_rows($query) == 0) {
        // Append a message to the output string if no users are found.
        $output .= "No users are available to chat";
    } elseif (mysqli_num_rows($query) > 0) {
        // Include the "data.php" file, which is responsible for formatting the user data into a presentable format
        // if there are one or more users found in the database.
        include_once "data.php";
    }

    // Output the generated string, which contains either a message indicating no available users or the formatted list of users.
    echo $output;
} else {
    // Handle SQL statement preparation error
    echo "Error preparing SQL statement";
}
