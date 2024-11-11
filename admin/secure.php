
<?php
include('./database/dbconnect.php');
include('./admin/adminLogin.php');
include('./student/studentLogin.php');


if ($_SERVER['REQUEST_METHOD'] == "POST") {
  if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the input is a valid student school ID (exactly 7 characters)
    if (strlen($username) == 7 && is_numeric($username)) {
      if (empty($username)) {
        die('School ID is required');
      }
      if (empty($password)) {
        die('Password is required');
      }
      // Call the student login function
      studentLogin($username, $password);
    } else {
      if (empty($username)) {
        die('Username or Email is required');
      }
      if (empty($password)) {
        die('Password is required');
      }
      // Call the admin login function
      adminLogin($username, $password);
    }
  }
}
?>