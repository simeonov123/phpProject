<?php
//Initiates or resumes a session which is necessary for accessing session variables.
session_start();
//Confirms the user is logged in by checking if the unique_id session variable is set.
if (isset($_SESSION['unique_id'])) {
    //Includes the configuration file with the db connection settings
    include_once "config.php";
    //Retrieves the logged-in user's unique ID from the session.
    $outgoing_id = $_SESSION['unique_id'];
    //Sanitizes the incoming user ID received via POST to prevent SQL injection.
    $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
    $output = "";
    //Message Retrieval and Formatting
    //SQL query to select messages from the messages table, joining with the users table to get details of the user who sent each message.
    //Filters messages to only those exchanged between the logged-in user (outgoing_id) and the other user (incoming_id).
    //Uses a LEFT JOIN to combine user details with their messages and orders by msg_id to maintain the conversation's chronological order.
    $sql = "SELECT * FROM messages LEFT JOIN users ON users.unique_id = messages.outgoing_msg_id
                WHERE (outgoing_msg_id = {$outgoing_id} AND incoming_msg_id = {$incoming_id})
                OR (outgoing_msg_id = {$incoming_id} AND incoming_msg_id = {$outgoing_id}) ORDER BY msg_id";
    $query = mysqli_query($conn, $sql);

    //Processes the query results
    if (mysqli_num_rows($query) > 0) {
        //Formats outgoing messages differently from incoming messages.
        while ($row = mysqli_fetch_assoc($query)) {
            if ($row['outgoing_msg_id'] === $outgoing_id) {
                $output .= '<div class="chat outgoing">
                                <div class="details">
                                    <p>' . $row['msg'] . '</p>
                                </div>
                                </div>';
            } else {
                //Includes user images in incoming messages.
                $output .= '<div class="chat incoming">
                                <img src="php/images/' . $row['img'] . '" alt="">
                                <div class="details">
                                    <p>' . $row['msg'] . '</p>
                                </div>
                                </div>';
            }
        }
    } else {
        //Outputs a default message if no messages are found in the chat.
        $output .= '<div class="text">No messages are available. Once you send message they will appear here.</div>';
    }
    echo $output;
} else {
    //Redirect for Unauthenticated Users
    header("location: ../login.php");
}
