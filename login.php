<?php
/*
  Session Start and Redirect
*/
//This function starts a new session or resumes an existing session
session_start();
//This checks if a session variable unique_id is set. If it is, the script redirects the user to users.php
if (isset($_SESSION['unique_id'])) {
  header("location: users.php");
}
?>

<?php include_once "header.php"; ?>

<body>
  <div class="wrapper">
    <section class="form login">
      <header>Realtime Chat App</header>
      <form action="#" method="POST" enctype="multipart/form-data" autocomplete="off">
        <div class="error-text"></div>
        <div class="field input">
          <label>Email Address</label>
          <input type="text" name="email" placeholder="Enter your email" required>
        </div>
        <div class="field input">
          <label>Password</label>
          <input type="password" name="password" placeholder="Enter your password" required>
          <i class="fas fa-eye"></i>
        </div>
        <div class="field button">
          <input type="submit" name="submit" value="Continue to Chat">
        </div>
      </form>
      <div class="link">Not yet signed up? <a href="index.php">Signup now</a></div>
    </section>
  </div>
  <!-- handles the functionality to show or hide the password. -->
  <script src="javascript/pass-show-hide.js"></script>
  <!-- handles the login process of sending it to the server. -->
  <script src="javascript/login.js"></script>

</body>

</html>