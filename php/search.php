<?php
/*
    This PHP script handles the search functionality for finding users within the application. 
    It allows users to search for other users by their first name or last name.
*/

// Initializes a new session or resumes the existing one.
session_start();

// Includes the configuration file, which contains the database connection settings.
include_once "config.php";

// Retrieves the unique ID of the current user from the session.
$outgoing_id = $_SESSION['unique_id'];

// Securely retrieve the search term received via POST request.
if (isset($_POST['searchTerm'])) {
    $searchTerm = $_POST['searchTerm'];

    // SQL query to find users in the database.
    // The query uses prepared statements to prevent SQL injection.
    $sql = "SELECT * FROM users WHERE NOT unique_id = ? AND (fname LIKE ? OR lname LIKE ?)";

    // Prepare the statement
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        // Bind parameters
        $searchTermWildcard = "%" . $searchTerm . "%";
        mysqli_stmt_bind_param($stmt, "iss", $outgoing_id, $searchTermWildcard, $searchTermWildcard);

        // Execute the statement
        mysqli_stmt_execute($stmt);

        // Get the result
        $query = mysqli_stmt_get_result($stmt);

        $output = "";

        if (mysqli_num_rows($query) > 0) {
            // If users are found, include data.php, which formats and displays the search results.
            include_once "data.php";
        } else {
            // If no users are found, set $output to a message indicating that no users were found related to the search term.
            $output .= 'No user found related to your search term';
        }

        echo $output;
    } else {
        // Handle SQL statement preparation error
        echo "Error preparing SQL statement";
    }
} else {
    // Handle missing search term
    echo "Search term not provided";
}
