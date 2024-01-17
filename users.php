<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Realtime Chat App | CodingNepal</title>
    <link rel="stylesheet" href="style.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"
    />
  </head>

  <body>
    <div class="wrapper">
      <section class="users">
        <header>
          <div class="content">
            <img src="" alt="" />
            <div class="details">
              <span>Coding Moni</span>
              <p>Active now</p>
            </div>
          </div>
          <a href="#" class="logout">logout</a>
        </header>

        <div class="search">
          <span class="text">Select a user to start chat</span>
          <input type="text" placeholder="Enter name to search..." />
          <button><i class="fas fa-search"></i></button>
        </div>

        <div class="users-list">
          <a href="#">
            <div class="content">
              <img src="#" alt="" />
              <div class="details">
                <span>Coding Joji</span>
                <p>This is test message</p>
              </div>
            </div>
            <div class="status-dot"><i class="fas fa-circle"></i></div>
          </a>
        </div>
      </section>
    </div>

    <script src="javascript/users.js"></script>

  </body>
</html>
