<?php
/*
    This PHP script facilitates user authentication for a web application. 
    It checks submitted credentials against a database and updates the user's status if the login is successful.
 */
//Session Initialization
//Begins a new session or resumes an existing one.
session_start();
//Database Configuration
//Includes the database configuration file to establish a database connection.
include_once "config.php";

//Input Sanitization
//Sanitizes the email and password inputs to prevent SQL injection.
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

//Validation and Authentication
//Checks if email and password fields are not empty.
if (!empty($email) && !empty($password)) {
    //SQL query to check if the email exists
    $sql = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
    if (mysqli_num_rows($sql) > 0) {
        $row = mysqli_fetch_assoc($sql);
        $user_pass = md5($password);
        $enc_pass = $row['password'];
        //Verifies if the submitted password matches the encrypted password in the database using MD5
        if ($user_pass === $enc_pass) {
            //User Status Update
            $status = "Active now";
            //If authentication is successful, updates the user's status in the database to "Active now".
            $sql2 = mysqli_query($conn, "UPDATE users SET status = '{$status}' WHERE unique_id = {$row['unique_id']}");

            //Session Management
            if ($sql2) {
                //Sets a session variable unique_id with the user's identifier from the database.
                $_SESSION['unique_id'] = $row['unique_id'];

                //Response
                //Returns "success" if login and status update are successful.
                echo "success";
                //or else provides an error message if the credentials are incorrect, the email does not exist, or input fields are empty.
            } else {
                echo "Something went wrong. Please try again!";
            }
        } else {
            echo "Email or Password is Incorrect!";
        }
    } else {
        echo "$email - This email not Exist!";
    }
} else {
    echo "All input fields are required!";
}
