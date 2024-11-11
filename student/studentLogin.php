
<?php
include('./database/dbconnect.php');

function studentLogin($username, $password)
{
  global $conn; // Access the $conn variable from the global scope
  try {
    $sql = "SELECT * FROM tblstudent WHERE school_id = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      // If student login is successful
      // $student = $result->fetch_assoc();
      while ($row = $result->fetch_assoc()) {
        $_SESSION['fname'] . " " . $_SESSION['lname'] = $row['fname'] . " " . $row['lname'];
        header('location: ./student/studentDashboard.php');
        echo "Student login successful.";
        exit();
      }
    } else {
      echo "Invalid student credentials.";
    }
  } catch (mysqli_sql_exception $e) {
    error_log("Login Failed: " . $e->getMessage());
    echo "Error during student login.";
  }
}
?>
