<?php
/*
    This PHP script facilitates user authentication for a web application.
    It checks submitted credentials against a database and updates the user's status if the login is successful.
*/

// Session Initialization
// Begins a new session or resumes an existing one.
session_start();

// Database Configuration
// Includes the database configuration file to establish a database connection.
include_once "config.php";

// Input Sanitization
// Sanitizes the email and password inputs to prevent SQL injection.
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

// Validation and Authentication
// Checks if email and password fields are not empty.
if (!empty($email) && !empty($password)) {
    // SQL query to check if the email exists in the database.
    $stmt = mysqli_prepare($conn, "SELECT unique_id, email, password FROM users WHERE email = ?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $enc_pass = $row['password'];

        // Verifies if the submitted password matches the stored hashed password.
        if (password_verify($password, $enc_pass)) {
            // User Status Update
            $status = "Active now";

            // If authentication is successful, updates the user's status in the database to "Active now".
            $stmt2 = mysqli_prepare($conn, "UPDATE users SET status = ? WHERE unique_id = ?");
            mysqli_stmt_bind_param($stmt2, "si", $status, $row['unique_id']);
            mysqli_stmt_execute($stmt2);

            // Session Management
            if ($stmt2) {
                // Sets a session variable unique_id with the user's identifier from the database.
                $_SESSION['unique_id'] = $row['unique_id'];

                // Response
                // Returns "success" if login and status update are successful.
                echo "success";
            } else {
                // Provides an error message if something goes wrong during the status update.
                echo "Something went wrong. Please try again!";
            }
        } else {
            // Provides an error message if the email or password is incorrect.
            echo "Email or Password is Incorrect!";
        }
    } else {
        // Provides an error message if the email does not exist in the database.
        echo "$email - This email does not Exist!";
    }
} else {
    // Provides an error message if input fields are empty.
    echo "All input fields are required!";
}
