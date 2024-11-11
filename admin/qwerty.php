<?php
include("../database/dbconnect.php");
include("../admin/subject.php");
// include('./admin/aside.php');
session_start();

// Assign teacher to student based on regular/irregular status
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $teacher_id = $_POST['teacher_id'];
  $subject_id = $_POST['subject_id'];
  $section_id = $_POST['section_id'];
  $student_id = $_POST['student_id']; // Assume student_id is selected in the form

  // Check if the student is regular or irregular
  $query = "SELECT is_regular FROM tblstudent_section WHERE student_id = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("i", $student_id);
  $stmt->execute();
  $stmt->bind_result($is_regular);
  $stmt->fetch();
  $stmt->close();

  if ($is_regular) {
    // Regular student: assign by section
    $stmt = $conn->prepare("INSERT INTO tblsection_teacher_subject (teacher_id, subject_id, section_id) VALUES (?, ?, ?)");
    $stmt->bind_param("iii", $teacher_id, $subject_id, $section_id);
  } else {
    // Irregular student: assign directly to student
    $stmt = $conn->prepare("INSERT INTO tblstudent_teacher_subject (student_id, teacher_id, subject_id) VALUES (?, ?, ?)");
    $stmt->bind_param("iii", $student_id, $teacher_id, $subject_id);
  }

  // Execute and check for success
  if ($stmt->execute()) {
    echo "<div>Assignment successful.</div>";
  } else {
    echo "<div>Error: " . $stmt->error . "</div>";
  }

  $stmt->close();
}

// Get data for dropdowns
$teachers = $conn->query("SELECT teacher_id, name FROM tblteacher");
$subjects = $conn->query("SELECT subject_id, subject_name FROM tblsubject");
$sections = $conn->query("SELECT section_id, section_name FROM tblsection");
$students = $conn->query("SELECT student_id, name FROM tblstudent"); // Dropdown for students

$conn->close();
?>

<!-- HTML Form -->
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Head content (title, styles) -->
</head>

<body>
  <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
    <!-- Teacher, Subject, Section dropdowns -->
    <label for="student_id">Select Student:</label>
    <select id="student_id" name="student_id" required>
      <option value="" disabled selected>Select a student</option>
      <?php while ($row = $students->fetch_assoc()): ?>
        <option value="<?php echo $row['student_id']; ?>"><?php echo $row['name']; ?></option>
      <?php endwhile; ?>
    </select>

    <button type="submit">Assign</button>
  </form>
</body>

</html>