<?php
/*
  The user dashboard page is the main interface for logged-in users to interact with the chat application. 
  It displays the current user's information and provides a search feature to find other users to start a chat with.
*/
//Initializes a new session or resumes an existing one.
session_start();
//Includes the database configuration file.
include_once "php/config.php";
//Checks if the session variable for unique_id is set.
if (!isset($_SESSION['unique_id'])) {
  //Redirects to the login page if the session variable is not set.

  //Includes the common header HTML or PHP code for the page.
  header("location: login.php");
}
?>
<?php include_once "header.php"; ?>

<body>
  <div class="wrapper">
    <!-- User Information Display -->
    <section class="users">
      <header>
        <div class="content">
          <?php
          //Fetches the current logged-in user's details from the database.
          $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$_SESSION['unique_id']}");
          if (mysqli_num_rows($sql) > 0) {
            $row = mysqli_fetch_assoc($sql);
          }
          ?>
          <!-- Displays the user's image, full name, and status -->
          <img src="php/images/<?php echo $row['img']; ?>" alt="">
          <div class="details">
            <span><?php echo $row['fname'] . " " . $row['lname'] ?></span>
            <p><?php echo $row['status']; ?></p>
          </div>
        </div>
        <!-- Logout Functionality -->
        <!-- Provides a logout link that passes the user's unique_id to logout.php via a query string. -->
        <a href="php/logout.php?logout_id=<?php echo $row['unique_id']; ?>" class="logout">Logout</a>
      </header>
      <!-- User Search Feature -->
      <!-- Includes a text field and button for searching other users by name. -->
      <div class="search">
        <span class="text">Select an user to start chat</span>
        <input type="text" placeholder="Enter name to search...">
        <button><i class="fas fa-search"></i></button>
      </div>
      <!-- User List Container -->
      <div class="users-list">
          <!-- A container where the list of users will be dynamically inserted via JavaScript.-->
      </div>
    </section>
  </div>

  <!-- Links to the external JavaScript file users.js that handles the dynamic functionality of the page. -->
  <script src="javascript/users.js"></script>

</body>

</html>