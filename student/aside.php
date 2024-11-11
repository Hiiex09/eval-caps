<?php
include('../database/dbconnect.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <style>
    /* General body styling */
    body {
      margin: 0;
      font-family: Arial, sans-serif;
    }

    /* Sidebar styling */
    aside {
      width: 250px;
      height: 100vh;
      background-color: #091057;
      /* Secondary color */
      color: white;
      position: fixed;
    }

    .sidebar {
      padding: 20px;
    }

    .sidebar img {
      width: 25px;
      margin-right: 10px;
    }

    /* Menu item styles */
    .menu {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 20px;
    }

    .item,
    .items {
      display: block;
      align-items: center;
      padding: 10px 0;
    }

    .item a {
      text-decoration: none;
      color: white;
      font-size: 16px;
      margin-left: 10px;
    }

    /* Hover effect on the sidebar items */
    .item:hover {
      background-color: #0b126c;
      /* Darker shade of the secondary color */
      cursor: pointer;
    }

    hr {
      border: 0;
      height: 1px;
      background-color: white;
      margin: 20px 0;
    }

    /* Main content styling */
    main {
      margin-left: 260px;
      /* Adjust to leave space for the sidebar */
      padding: 20px;
    }

    .gr1 img {
      height: 80px;
      width: 80px;
      justify-content: center;
      align-items: center;
      margin-left: 110px;
      margin-top: 20px;
    }
  </style>
</head>

<body>

  <aside>
    <div class="sidebar">
      <div class="menu">
        <img src="pic/hambuger.svg">
      </div>

      <hr>

      <div class="item">
        <img src="pic/dashboard.svg">
        <a href="#">Dashboard</a>
      </div>

      <div class="items">
        <div class="item js-item">
          <img src="pic/user.svg">
          <a href="../student/evaluateTeacher.php">Evaluate</a>
        </div>

        <div class="item">
          <img src="pic/inbox.svg">
          <a href="../logout.php">Logout</a>
        </div>



      </div>
    </div>
  </aside>

  <main>

  </main>



</body>

</html>