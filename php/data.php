<?php
/*
    display a list of users along with the latest message exchanged with each user. 
    It dynamically generates a user interface element for each user, indicating their name, latest message, and online status.
*/

//Iterates through each user retrieved from a previously executed query (check search.php). $row contains the details of the current user in the loop.
while ($row = mysqli_fetch_assoc($query)) {
    //Latest Message Retrieval
    //For each user, a query ($sql2) retrieves the latest message exchanged with the logged-in user ($outgoing_id).
    //Considers both incoming and outgoing messages and orders the results by msg_id in descending order, limiting the result to the most recent message.
    $sql2 = "SELECT * FROM messages WHERE (incoming_msg_id = {$row['unique_id']}
                OR outgoing_msg_id = {$row['unique_id']}) AND (outgoing_msg_id = {$outgoing_id} 
                OR incoming_msg_id = {$outgoing_id}) ORDER BY msg_id DESC LIMIT 1";
    $query2 = mysqli_query($conn, $sql2);
    $row2 = mysqli_fetch_assoc($query2);
    //Message Formatting and Status Check
    //Extracts and formats the latest message and checks if there is a latest message; if not, sets a default message ("No message available").
    (mysqli_num_rows($query2) > 0) ? $result = $row2['msg'] : $result = "No message available";
    //Truncates long messages to 28 characters for concise display, appending '...' if truncated.
    (strlen($result) > 28) ? $msg =  substr($result, 0, 28) . '...' : $msg = $result;
    //Determines if the message was sent by the logged-in user and prefixes it with "You: " if so.
    if (isset($row2['outgoing_msg_id'])) {
        ($outgoing_id == $row2['outgoing_msg_id']) ? $you = "You: " : $you = "";
    } else {
        $you = "";
    }
    //User Status and Visibility Handling
    //Checks the user's status ($row['status']) and assigns a class (offline) for styling if the user is offline.
    ($row['status'] == "Offline now") ? $offline = "offline" : $offline = "";
    //Handles visibility of the current user in the list by setting a class (hide) if the user in the list is the logged-in user.
    ($outgoing_id == $row['unique_id']) ? $hid_me = "hide" : $hid_me = "";

    //Output Generation
    //HTML content includes: a link to the chat with the user, user's profile picture and name, 
    //the latest message or status message with a visual indication of the sender and an online/offline indicator.
    $output .= '<a href="chat.php?user_id=' . $row['unique_id'] . '">
                    <div class="content">
                    <img src="php/images/' . $row['img'] . '" alt="">
                    <div class="details">
                        <span>' . $row['fname'] . " " . $row['lname'] . '</span>
                        <p>' . $you . $msg . '</p>
                    </div>
                    </div>
                    <div class="status-dot ' . $offline . '"><i class="fas fa-circle"></i></div>
                </a>';
}
