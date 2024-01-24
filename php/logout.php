<?php
/*
    This PHP script handles the logout functionality for users. It updates the user's status in the database to "Offline now",
    unsets and destroys the session, and redirects the user to the login page upon logout.
*/

// Start a new session or resume the existing one.
session_start();

// Checks if the unique_id session variable is set. If it is not, the user is redirected to the login page.
if (isset($_SESSION['unique_id'])) {
    // Includes the configuration file with the database connection settings.
    include_once "config.php";

    // User Identification
    // Retrieves the logout_id from the GET request and escapes it to prevent SQL injection.
    $logout_id = mysqli_real_escape_string($conn, $_GET['logout_id']);

    // Status Update and Session Destruction
    // If logout_id is set, the script updates the user's status in the database to "Offline now".
    if (isset($logout_id)) {
        $status = "Offline now";

        // Prepared statement to update the status.
        $stmt = mysqli_prepare($conn, "UPDATE users SET status = ? WHERE unique_id = ?");
        mysqli_stmt_bind_param($stmt, "si", $status, $logout_id);
        mysqli_stmt_execute($stmt);

        // If the query is successful, it unsets and destroys the session and redirects the user to the login page.
        if ($stmt) {
            session_unset();
            session_destroy();
            header("location: ../login.php");
        }
    } else {
        // If logout_id is not set, it redirects to the users.php page.
        header("location: ../users.php");
    }
} else {
    // Redirect for Unauthenticated Users
    // If the unique_id session variable is not set, indicating the user is not logged in, the script redirects to the login page.
    header("location: ../login.php");
}
