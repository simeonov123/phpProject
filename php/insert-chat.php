<?php
/*
    This PHP script handles the process of sending a message between users in a chat application.
    It inserts the message into the database and ensures that the user is logged in.
*/

// Initiates or resumes a session which is necessary for accessing session variables.
session_start();

// Checks if a session variable named unique_id is set, indicating that the user is logged in.
// If it's not set, the user is redirected to the login page.
if (isset($_SESSION['unique_id'])) {
    // Includes the configuration file with the database connection settings.
    include_once "config.php";

    // Retrieves the unique ID of the logged-in user from the session.
    $outgoing_id = $_SESSION['unique_id'];

    // Sanitizes the incoming user's ID received via POST.
    $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);

    // Sanitizes the message text received via POST and uses prepared statements to prevent SQL injection.
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    // Checks if the message is not empty.
    if (!empty($message)) {
        // SQL query to insert the message into the messages table with the incoming and outgoing user IDs and the message text.
        // Use prepared statements to prevent SQL injection.
        $stmt = mysqli_prepare($conn, "INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "iis", $incoming_id, $outgoing_id, $message);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
} else {
    // Redirect for Unauthenticated Users
    header("location: ../login.php");
    exit; // Exit to prevent further execution
}
