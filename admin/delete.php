<?php
include('../database/dbconnect.php');

// Debugging: Check if 'deleteId' is set
if (isset($_GET['deleteId'])) {
  $teacher_id = $_GET['deleteId'];

  // Debugging: Output the received teacher_id
  echo "Teacher ID: " . $teacher_id;

  // Ensure $teacher_id is an integer to avoid any unexpected issues
  $teacher_id = intval($teacher_id);

  // Perform your database query to delete the record
  $sql = "DELETE FROM `tblteacher` WHERE teacher_id = ?";
  if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("i", $teacher_id); // 'i' for integer
    if ($stmt->execute()) {
      // Success message
      echo "Record deleted successfully.";
      // Redirect to the teachers list page after successful deletion
      header("Location:teacher_view.php"); // Redirect to another page, e.g., teachers list
      exit();
    } else {
      echo "Error deleting record: " . $stmt->error;
    }
    $stmt->close();
  } else {
    echo "Error preparing statement: " . $conn->error;
  }
} else {
  echo "No teacher ID specified.";
}
