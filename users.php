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
  header("location: login.php");
  exit(); // Terminate script to prevent further execution
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
          $sql = "SELECT * FROM users WHERE unique_id = ?";
          // Prepare a statement to avoid SQL injection
          $stmt = mysqli_prepare($conn, $sql);
          mysqli_stmt_bind_param($stmt, "i", $_SESSION['unique_id']);
          mysqli_stmt_execute($stmt);
          $result = mysqli_stmt_get_result($stmt);

          if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
          }
          ?>
          <!-- Displays the user's image, full name, and status -->
          <img src="php/images/<?php echo htmlspecialchars($row['img']); ?>" alt="">
          <div class="details">
            <span><?php echo htmlspecialchars($row['fname'] . " " . $row['lname']); ?></span>
            <p><?php echo htmlspecialchars($row['status']); ?></p>
          </div>
        </div>
        <!-- Logout Functionality -->
        <!-- Provides a logout link that passes the user's unique_id to logout.php via a query string. -->
        <a href="php/logout.php?logout_id=<?php echo htmlspecialchars($row['unique_id']); ?>" class="logout">Logout</a>
      </header>
      <!-- User Search Feature -->
      <!-- Includes a text field and button for searching other users by name. -->
      <div class="search">
        <span class="text">Select a user to start a chat</span>
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