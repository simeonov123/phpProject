<?php
/*
  Session Start and Redirect
*/
// Start or resume a session.
session_start();

// Check if the session variable unique_id is set.
if (isset($_SESSION['unique_id'])) {
  // Redirect the user to users.php if already logged in.
  header("location: users.php");
  exit(); // Terminate script execution to prevent further processing.
}
?>

<?php include_once "header.php"; ?>

<body>
  <div class="wrapper">
    <section class="form signup">
      <header>Realtime Chat App</header>
      <form action="#" method="POST" enctype="multipart/form-data" autocomplete="off">
        <div class="error-text"></div>
        <div class="name-details">
          <div class="field input">
            <label>First Name</label>
            <input type="text" name="fname" placeholder="First name" required>
          </div>
          <div class="field input">
            <label>Last Name</label>
            <input type="text" name="lname" placeholder="Last name" required>
          </div>
        </div>
        <div class="field input">
          <label>Email Address</label>
          <input type="text" name="email" placeholder="Enter your email" required>
        </div>
        <div class="field input">
          <label>Password</label>
          <input type="password" name="password" placeholder="Enter new password" required>
          <i class="fas fa-eye"></i>
        </div>
        <div class="field image">
          <label>Select Image</label>
          <input type="file" name="image" accept="image/x-png,image/gif,image/jpeg,image/jpg" required>
        </div>
        <div class="field button">
          <input type="submit" name="submit" value="Continue to Chat">
        </div>
      </form>
      <div class="link">Already signed up? <a href="login.php">Login now</a></div>
    </section>
  </div>

  <!-- Manages the show/hide functionality of the password field. -->
  <script src="javascript/pass-show-hide.js"></script>
  <!-- Handles the client-side logic of the signup process. -->
  <script src="javascript/signup.js"></script>
</body>

</html>