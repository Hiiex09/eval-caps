<?php
session_start();
include('database/dbconnect.php'); // Include database connection

// Check if the student is logged in
if (!isset($_SESSION['school_id'])) {
  echo "Please log in as a student to view your teachers.";
  exit;
}

// Fetch student ID from the session
$school_id = $_SESSION['school_id'];

// Query to fetch assigned teachers and subjects for the logged-in student
$sql = "
    SELECT tblteacher.name AS teacher_name, tblsubject.subject_name
    FROM tblstudent_teacher_subject
    INNER JOIN tblteacher ON tblstudent_teacher_subject.teacher_id = tblteacher.teacher_id
    INNER JOIN tblsubject ON tblstudent_teacher_subject.subject_id = tblsubject.subject_id
    WHERE tblstudent_teacher_subject.student_id = (SELECT student_id FROM tblstudent WHERE school_id = ?)
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $school_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Your Assigned Teachers</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 20px;
    }

    .container {
      max-width: 90%;
      margin: 0 auto;
      background-color: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
      text-align: center;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    table,
    th,
    td {
      border: 1px solid #ddd;
    }

    th,
    td {
      padding: 10px;
      text-align: left;
    }

    th {
      background-color: #f2f2f2;
    }

    .no-teachers {
      text-align: center;
      font-size: 18px;
      color: #888;
    }
  </style>
</head>

<body>
  <div class="container">
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?></h1>
    <h2>Your Assigned Teachers and Subjects</h2>

    <?php if ($result->num_rows > 0): ?>
      <table>
        <thead>
          <tr>
            <th>Teacher Name</th>
            <th>Subject</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?php echo htmlspecialchars($row['teacher_name']); ?></td>
              <td><?php echo htmlspecialchars($row['subject_name']); ?></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    <?php else: ?>
      <p class="no-teachers">You have no assigned teachers yet.</p>
    <?php endif; ?>
  </div>
</body>

</html>

<?php
$stmt->close();
$conn->close();
?>