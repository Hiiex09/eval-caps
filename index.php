<?php
include('./database/dbconnect.php');
include('./admin/secure.php');
session_start();

if (!isset($_SESSION['username'])) {
  header('location: login.php');
  exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f9;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .container {
      width: 100%;
      max-width: 400px;
      background-color: white;
      padding: 2rem;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .login form {
      display: flex;
      flex-direction: column;
    }

    .login header {
      font-size: 24px;
      font-weight: bold;
      text-align: center;
      margin-bottom: 2rem;
      color: #091057;
    }

    input[type="text"],
    input[type="password"] {
      padding: 0.8rem;
      margin-bottom: 1rem;
      border: 1px solid #ddd;
      border-radius: 4px;
      font-size: 16px;
    }

    input[type="text"]:focus,
    input[type="password"]:focus {
      border-color: #091057;
      outline: none;
    }

    .button {
      background-color: #091057;
      color: white;
      padding: 0.8rem;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 16px;
      margin-top: 1rem;
    }

    .button:hover {
      background-color: #0b126c;
    }

    a {
      text-align: right;
      color: #091057;
      text-decoration: none;
      margin-bottom: 1rem;
      font-size: 14px;
    }

    a:hover {
      text-decoration: underline;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="login form">
      <header>Login</header>
      <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <input type="text" name="username" placeholder="Enter your username or school ID">
        <input type="password" name="password" placeholder="Enter your password">
        <a href="#">Forgot password?</a>
        <input type="submit" class="button" name="submit" value="Login">
      </form>
    </div>
  </div>


</body>

</html>