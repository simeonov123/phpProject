<?php
//new session or resumes the existing one
session_start();
//Checks if the unique_id session variable is set. If it is not, the user is redirected to the login page.
if (isset($_SESSION['unique_id'])) {
    //Includes the configuration file, with the database connection settings
    include_once "config.php";

    //User Identification
    //Retrieves the logout_id from the GET request
    $logout_id = mysqli_real_escape_string($conn, $_GET['logout_id']);

    //Status Update and Session Destruction
    //If logout_id is set, the script updates the user's status in the database to "Offline now".
    if (isset($logout_id)) {
        $status = "Offline now";
        //SQL query to update the status.
        $sql = mysqli_query($conn, "UPDATE users SET status = '{$status}' WHERE unique_id={$_GET['logout_id']}");
        //If the query is successful, it unsets and destroys the session and redirects the user to the login page.
        if ($sql) {
            session_unset();
            session_destroy();
            header("location: ../login.php");
        }
    } else {
        //If logout_id is not set, redirects to the users.php page.
        header("location: ../users.php");
    }
} else {
    //Redirect for Unauthenticated Users
    //If the unique_id session variable is not set, indicating the user is not logged in, the script redirects to the login page.
    header("location: ../login.php");
}
