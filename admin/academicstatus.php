
<?php
include("../database/dbconnect.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['schoolyear_id']) && isset($_POST['status'])) {
  $schoolyear_id = $_POST['schoolyear_id'];
  $status = $_POST['status'];

  // Prepare the SQL statement to update the status
  $stmt = $conn->prepare("UPDATE tblschoolyear SET is_status = ? WHERE schoolyear_id = ?");
  $stmt->bind_param("si", $status, $schoolyear_id);

  // Execute the update and check for errors
  if ($stmt->execute()) {
    echo "Status updated successfully.";
  } else {
    echo "Error updating status: " . $stmt->error;
  }

  // Close the statement
  $stmt->close();
} else {
  echo "Invalid request or missing parameters.";
}

// Close the database connection
$conn->close();
?>
