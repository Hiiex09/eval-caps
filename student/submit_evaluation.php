<?php
// Include your database connection and start the session
include('../database/dbconnect.php');
session_start();

// Check if the student is logged in and session variables are set
if (!isset($_SESSION['student_id']) || !isset($_SESSION['teacher_id']) || !isset($_SESSION['schoolyear_id'])) {
  echo "Session variables are missing. Please log in again.";
  exit;
}

// Get session variables
$student_id = $_SESSION['student_id']; // Get the student_id from session
$teacher_id = $_SESSION['teacher_id']; // Get the teacher_id from session
$school_year_id = $_SESSION['schoolyear_id']; // Get the school_year_id from session

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Get the rating and comment from the form submission

  // Insert the evaluation data into the tblevaluate table
  $sql = "INSERT INTO tblevaluate (student_id, teacher_id, schoolyear_id)
            VALUES (?, ?, ?, ?, ?)";

  // Prepare and execute the query
  if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("iiiss", $student_id, $teacher_id, $school_year_id);

    if ($stmt->execute()) {
      echo "Evaluation submitted successfully!";
    } else {
      echo "Error submitting evaluation: " . $stmt->error;
    }

    $stmt->close();
  } else {
    echo "Error preparing the statement: " . $conn->error;
  }
}
