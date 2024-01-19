<?php
//Initializes a new session or resumes the existing one.
session_start();
//Includes the configuration file with the db connection.
include_once "php/config.php";

//Session Check and Redirect
//checks if the unique_id session variable is not set, indicating the user is not logged in, and redirects them to the login page.
if (!isset($_SESSION['unique_id'])) {
  header("location: login.php");
}
?>
<?php include_once "header.php"; ?>
<!-- Chat Area Section -->

<body>
  <div class="wrapper">
    <section class="chat-area">
      <header>
        <?php
        //User Information Retrieval
        //Fetches the user_id from the GET request and performs a SQL query to retrieve the user's details from the database.
        $user_id = mysqli_real_escape_string($conn, $_GET['user_id']);
        $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$user_id}");
        //If the user is found, their details are stored in $row; otherwise, the user is redirected to users.php.
        if (mysqli_num_rows($sql) > 0) {
          $row = mysqli_fetch_assoc($sql);
        } else {
          header("location: users.php");
        }
        ?>
        <!-- Displays the back icon, user's image, name, and status (the image, names and status are dynamically loaded)-->
        <a href="users.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
        <img src="php/images/<?php echo $row['img']; ?>" alt="">
        <div class="details">
          <span><?php echo $row['fname'] . " " . $row['lname'] ?></span>
          <p><?php echo $row['status']; ?></p>
        </div>
      </header>
      <!-- This is the chat box where data is dynamically loaded from the database-->
      <div class="chat-box">

      </div>
      <!-- Message Typing Area: A form for sending messages, with an input field for the message and a send button.
         Includes a hidden field (incoming_id) that holds the user ID of the chat partner. -->
      <form action="#" class="typing-area">
        <input type="text" class="incoming_id" name="incoming_id" value="<?php echo $user_id; ?>" hidden>
        <input type="text" name="message" class="input-field" placeholder="Type a message here..." autocomplete="off">
        <button><i class="fab fa-telegram-plane"></i></button>
      </form>
    </section>
  </div>
  <!-- Responsible for handling real-time chat functionalities, such as sending messages, receiving messages, and updating the chat box.-->
  <script src="javascript/chat.js"></script>

</body>

</html>