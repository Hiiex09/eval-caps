
<?php
include("../database/dbconnect.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['schoolyear_id']) && isset($_POST['status'])) {
  $schoolyear_id = $_POST['schoolyear_id'];
  $status = $_POST['status'];

  if (isset($_POST['set_single_active']) && $status === 'Yes') {
    // Begin a transaction to ensure data consistency
    $conn->begin_transaction();

    try {
      // Set all other records to 'No' and their status to 'Not Yet Started'
      $stmt = $conn->prepare("UPDATE tblschoolyear SET is_default = 'No', is_status = 'Not Yet Started' WHERE schoolyear_id != ?");
      $stmt->bind_param("i", $schoolyear_id);
      $stmt->execute();
      $stmt->close();

      // Set the selected record as 'Yes' (active)
      $stmt = $conn->prepare("UPDATE tblschoolyear SET is_default = 'Yes', is_status = 'Started' WHERE schoolyear_id = ?");
      $stmt->bind_param("i", $schoolyear_id);
      $stmt->execute();

      // Update the session status in real-time
      $_SESSION['semester_status'] = 'Started';

      $conn->commit();
      echo "Status updated successfully.";
    } catch (Exception $e) {
      // Roll back if there's an error
      $conn->rollback();
      echo "Error updating status: " . $e->getMessage();
    }
  } elseif (isset($_POST['reset_status']) && $status === 'No') {
    // Set the selected record to 'No' and reset the status to 'Not Yet Started'
    $stmt = $conn->prepare("UPDATE tblschoolyear SET is_default = 'No', is_status = 'Not Yet Started' WHERE schoolyear_id = ?");
    $stmt->bind_param("i", $schoolyear_id);
    if ($stmt->execute()) {
      echo "Status reset successfully.";
    } else {
      echo "Error updating status: " . $stmt->error;
    }
    $stmt->close();
  }
}

$conn->close();
?>
