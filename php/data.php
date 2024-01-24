<?php
/*
    Display a list of users along with the latest message exchanged with each user. 
    It dynamically generates a user interface element for each user, indicating their name, latest message, and online status.
*/

// Iterates through each user retrieved from a previously executed query (check search.php). $row contains the details of the current user in the loop.
while ($row = mysqli_fetch_assoc($query)) {
    // Latest Message Retrieval
    // For each user, a query ($sql2) retrieves the latest message exchanged with the logged-in user ($outgoing_id).
    // Considers both incoming and outgoing messages and orders the results by msg_id in descending order, limiting the result to the most recent message.
    $sql2 = mysqli_prepare($conn, "SELECT * FROM messages WHERE (incoming_msg_id = ? OR outgoing_msg_id = ?) AND (outgoing_msg_id = ? OR incoming_msg_id = ?) ORDER BY msg_id DESC LIMIT 1");
    mysqli_stmt_bind_param($sql2, "iiii", $row['unique_id'], $row['unique_id'], $outgoing_id, $outgoing_id);
    mysqli_stmt_execute($sql2);
    $result2 = mysqli_stmt_get_result($sql2);

    // Message Formatting and Status Check
    // Extracts and formats the latest message and checks if there is a latest message; if not, sets a default message ("No message available").
    $result = "No message available"; // Default value
    if (mysqli_num_rows($result2) > 0) {
        $row2 = mysqli_fetch_assoc($result2);
        $result = $row2['msg'];
    }
    // Truncates long messages to 28 characters for concise display, appending '...' if truncated.
    $msg = (strlen($result) > 28) ? substr($result, 0, 28) . '...' : $result;

    // Determines if the message was sent by the logged-in user and prefixes it with "You: " if so.
    $you = "";
    if (isset($row2['outgoing_msg_id']) && $row2['outgoing_msg_id'] === $outgoing_id) {
        $you = "You: ";
    }

    // User Status and Visibility Handling
    // Checks the user's status ($row['status']) and assigns a class (offline) for styling if the user is offline.
    $offline = ($row['status'] == "Offline now") ? "offline" : "";
    // Handles visibility of the current user in the list by setting a class (hide) if the user in the list is the logged-in user.
    $hid_me = ($outgoing_id == $row['unique_id']) ? "hide" : "";

    // Output Generation
    // HTML content includes: a link to the chat with the user, user's profile picture and name, 
    // the latest message or status message with a visual indication of the sender and an online/offline indicator.
    $output .= '<a href="chat.php?user_id=' . $row['unique_id'] . '">
                    <div class="content">
                    <img src="php/images/' . htmlspecialchars($row['img']) . '" alt="">
                    <div class="details">
                        <span>' . htmlspecialchars($row['fname'] . " " . $row['lname']) . '</span>
                        <p>' . htmlspecialchars($you . $msg) . '</p>
                    </div>
                    </div>
                    <div class="status-dot ' . $offline . '"><i class="fas fa-circle"></i></div>
                </a>';
}
