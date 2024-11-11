<?php
include('../database/dbconnect.php');
session_start();

$selected_student_id = null; // Variable to hold selected student ID

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get the student_id from the form submission
  $student_id = $_POST['student_id'];
  $selected_student_id = $student_id;  // Retain the selected student ID

  // Check how many teachers are already assigned to this student
  $stmt = $conn->prepare("SELECT COUNT(*) AS teacher_count FROM tblstudent_teacher_subject WHERE student_id = ?");
  $stmt->bind_param("i", $student_id);
  $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();
  $teacher_count = $row['teacher_count'];
  $stmt->close();

  // If the student already has 8 teachers, display an alert and stop further execution
  if ($teacher_count >= 8) {
    echo "<script>alert('This student has already been assigned the maximum of 8 teachers.');</script>";
  } else {
    // Check if the subject is already assigned to the student
    $stmt = $conn->prepare("SELECT COUNT(*) AS already_assigned FROM tblstudent_teacher_subject WHERE student_id = ? AND teacher_id = ? AND subject_id = ?");
    $stmt->bind_param("iii", $student_id, $_POST['teacher_id'], $_POST['subject_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $already_assigned = $row['already_assigned'];
    $stmt->close();

    // If the subject is already assigned, display an alert and stop further execution
    if ($already_assigned > 0) {
      echo "<script>alert('This subject has already been assigned to this student.');</script>";
    } else {
      // Prepare and bind the statement for inserting into tblstudent_teacher_subject
      $stmt = $conn->prepare("INSERT INTO tblstudent_teacher_subject (student_id, teacher_id, subject_id) VALUES (?, ?, ?)");
      $stmt->bind_param("iii", $_POST['student_id'], $_POST['teacher_id'], $_POST['subject_id']);

      // Execute the statement
      if ($stmt->execute()) {
        echo "<script>alert('Teacher and subject successfully assigned to student!');</script>";
      } else {
        echo "<script>alert('Error in assignment: " . $stmt->error . "');</script>";
      }
      $stmt->close();
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Assign Teacher and Subject to Student</title>
</head>

<body>
  <h2>Assign Teacher and Subject to Student</h2>
  <form action="" method="POST">
    <!-- Student Selection -->
    <label for="student">Select Student:</label>
    <select name="student_id" id="student" required>
      <?php
      // Fetch students from the database
      $query = $conn->query("SELECT student_id, name FROM tblstudent");
      while ($row = $query->fetch_assoc()) {
        // Check if the current student is the selected one
        $selected = ($row['student_id'] == $selected_student_id) ? "selected" : "";
        echo "<option value='" . htmlspecialchars($row['student_id']) . "' $selected>" . htmlspecialchars($row['name']) . "</option>";
      }
      ?>
    </select><br><br>

    <!-- Teacher Selection -->
    <label for="teacher">Select Teacher:</label>
    <select name="teacher_id" id="teacher" required>
      <?php
      // Fetch teachers from the database
      $query = $conn->query("SELECT teacher_id, name FROM tblteacher");
      while ($row = $query->fetch_assoc()) {
        echo "<option value='" . htmlspecialchars($row['teacher_id']) . "'>" . htmlspecialchars($row['name']) . "</option>";
      }
      ?>
    </select><br><br>

    <!-- Subject Selection -->
    <label for="subject">Select Subject:</label>
    <select name="subject_id" id="subject" required>
      <?php
      // Fetch subjects from the database
      $query = $conn->query("SELECT subject_id, subject_name FROM tblsubject");
      while ($row = $query->fetch_assoc()) {
        echo "<option value='" . htmlspecialchars($row['subject_id']) . "'>" . htmlspecialchars($row['subject_name']) . "</option>";
      }
      ?>
    </select><br><br>

    <button type="submit">Assign Teacher and Subject</button>
  </form>
</body>

</html>

<?php
$conn->close();
?> if ($already_assigned > 0) {
echo "<script>
  alert('This subject has already been assigned to this student.');
</script>";
} else {
// Proceed with the assignment for irregular students
$stmt = $conn->prepare("INSERT INTO tblstudent_teacher_subject (student_id, teacher_id, subject_id) VALUES (?, ?, ?)");
$stmt->bind_param("iii", $_POST['student_id'], $_POST['teacher_id'], $_POST['subject_id']);
if ($stmt->execute()) {
echo "<script>
  alert('Teacher and subject successfully assigned to student!');
</script>";
} else {
echo "<script>
  alert('Error in assignment: " . $stmt->error . "');
</script>";
}
$stmt->close();
}
}


<?php
// Fetch teachers from the database
$query = $conn->query("SELECT teacher_id, name FROM tblteacher");
while ($row = $query->fetch_assoc()) {
  echo "<option value='" . htmlspecialchars($row['teacher_id']) . "'>" . htmlspecialchars($row['name']) . "</option>";
}
?>