<?php
include("../database/dbconnect.php");
session_start();

// Check if the student_id is set in the session
if (isset($_SESSION['student_id'])) {
  header("Location: login.php");
  exit();
}

// Get the sections, teachers, and subjects
$sections = [];
$teachers = [];
$subjects = [];

// Fetch sections
$sectionQuery = "SELECT section_id, section_name FROM tblsection";
$sectionResult = $conn->query($sectionQuery);
if ($sectionResult->num_rows > 0) {
  while ($row = $sectionResult->fetch_assoc()) {
    $sections[] = $row;
  }
}

// Fetch teachers
$teacherQuery = "SELECT teacher_id, name FROM tblteacher";
$teacherResult = $conn->query($teacherQuery);
if ($teacherResult->num_rows > 0) {
  while ($row = $teacherResult->fetch_assoc()) {
    $teachers[] = $row;
  }
}

// Fetch subjects
$subjectQuery = "SELECT subject_id, subject_name FROM tblsubject";
$subjectResult = $conn->query($subjectQuery);
if ($subjectResult->num_rows > 0) {
  while ($row = $subjectResult->fetch_assoc()) {
    $subjects[] = $row;
  }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $section_id = $_POST['section_id'];
  $teacher_id = $_POST['teacher_id'];
  $subject_id = $_POST['subject_id'];

  // Insert the assignment into the database
  $insertQuery = "INSERT INTO tblsection_teacher_subject (section_id, teacher_id, subject_id) VALUES (?, ?, ?)";
  $stmt = $conn->prepare($insertQuery);
  $stmt->bind_param("iii", $section_id, $teacher_id, $subject_id);

  if ($stmt->execute()) {
    echo "Teacher assigned to section successfully.";
  } else {
    echo "Error assigning teacher: " . $stmt->error;
  }

  $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Assign Teacher to Section</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
  <h1 class="text-5xl">Assign Teacher to Section</h1>
  <form method="POST" action="">
    <label for="section_id">Select Section:</label>
    <select name="section_id" id="section_id" required>
      <option value="">--Select Section--</option>
      <?php foreach ($sections as $section): ?>
        <option value="<?php echo $section['section_id']; ?>"><?php echo htmlspecialchars($section['section_name']); ?></option>
      <?php endforeach; ?>
    </select>

    <br><br>

    <label for="teacher_id">Select Teacher:</label>
    <select name="teacher_id" id="teacher_id" required>
      <option value="">--Select Teacher--</option>
      <?php foreach ($teachers as $teacher): ?>
        <option value="<?php echo $teacher['teacher_id']; ?>"><?php echo htmlspecialchars($teacher['name']); ?></option>
      <?php endforeach; ?>
    </select>

    <br><br>

    <label for="subject_id">Select Subject:</label>
    <select name="subject_id" id="subject_id" required>
      <option value="">--Select Subject--</option>
      <?php foreach ($subjects as $subject): ?>
        <option value="<?php echo $subject['subject_id']; ?>"><?php echo htmlspecialchars($subject['subject_name']); ?></option>
      <?php endforeach; ?>
    </select>

    <br><br>

    <button type="submit">Assign Teacher</button>
  </form>
</body>

</html>