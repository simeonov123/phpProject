<?php
/*
    This PHP script retrieves and formats chat messages between two users for display in a chat interface.
    It ensures that the user is logged in and retrieves messages from the database.
*/

// Initiates or resumes a session which is necessary for accessing session variables.
session_start();

// Confirms the user is logged in by checking if the unique_id session variable is set.
if (isset($_SESSION['unique_id'])) {
    // Includes the configuration file with the database connection settings.
    include_once "config.php";

    // Retrieves the logged-in user's unique ID from the session.
    $outgoing_id = $_SESSION['unique_id'];

    // Sanitizes the incoming user ID received via POST to prevent SQL injection.
    $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
    $output = "";

    // Message Retrieval and Formatting
    // SQL query to select messages from the messages table, joining with the users table to get details of the user who sent each message.
    // Filters messages to only those exchanged between the logged-in user (outgoing_id) and the other user (incoming_id).
    // Uses a LEFT JOIN to combine user details with their messages and orders by msg_id to maintain the conversation's chronological order.

    // Use prepared statements to prevent SQL injection
    $sql = "SELECT * FROM messages LEFT JOIN users ON users.unique_id = messages.outgoing_msg_id
                WHERE (outgoing_msg_id = ? AND incoming_msg_id = ?)
                OR (outgoing_msg_id = ? AND incoming_msg_id = ?) ORDER BY msg_id";

    $stmt = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, "iiii", $outgoing_id, $incoming_id, $incoming_id, $outgoing_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        // Processes the query results
        if (mysqli_num_rows($result) > 0) {
            // Formats outgoing messages differently from incoming messages.
            while ($row = mysqli_fetch_assoc($result)) {
                $message = htmlspecialchars($row['msg'], ENT_QUOTES, 'UTF-8');
                if ($row['outgoing_msg_id'] === $outgoing_id) {
                    $output .= '<div class="chat outgoing">
                                    <div class="details">
                                        <p>' . $message . '</p>
                                    </div>
                                </div>';
                } else {
                    // Includes user images in incoming messages.
                    $output .= '<div class="chat incoming">
                                    <img src="php/images/' . htmlspecialchars($row['img'], ENT_QUOTES, 'UTF-8') . '" alt="">
                                    <div class="details">
                                        <p>' . $message . '</p>
                                    </div>
                                </div>';
                }
            }
        } else {
            // Outputs a default message if no messages are found in the chat.
            $output .= '<div class="text">No messages are available. Once you send a message, it will appear here.</div>';
        }
        echo $output;
    } else {
        // Handle SQL error
        echo "Database query error";
    }
} else {
    // Redirect for Unauthenticated Users
    header("location: ../login.php");
    exit; // Exit to prevent further execution
}
