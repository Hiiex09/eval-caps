<?php
include('../database/dbconnect.php');
session_start();

$selected_student = $selected_teacher = $selected_subject = ""; // Initialize selected values

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get the student_id from the form submission
  $student_id = $_POST['student_id'];
  $teacher_id = $_POST['teacher_id'];
  $subject_id = $_POST['subject_id'];

  // Store selected values to retain them
  $selected_student = $student_id;
  $selected_teacher = $teacher_id;
  $selected_subject = $subject_id;

  // Check if the student is irregular
  $stmt = $conn->prepare("SELECT is_regular FROM tblstudent_section WHERE student_id = ?");
  $stmt->bind_param("i", $student_id);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($row = $result->fetch_assoc()) {
    $is_regular = $row['is_regular'];
  } else {
    echo "<script>alert('No data found for this student.');</script>";
    exit; // Stop further processing
  }
  $stmt->close();

  // If the student is regular, don't allow the assignment
  if ($is_regular == 1) {
    echo "<script>alert('This student is regular. Assignments must be handled through sections.');</script>";
  } else {
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
      // Check if the teacher is already assigned to the subject
      $stmt = $conn->prepare("SELECT COUNT(*) AS teacher_subject_count FROM tblstudent_teacher_subject WHERE subject_id = ? AND teacher_id != ?");
      $stmt->bind_param("ii", $subject_id, $teacher_id);
      $stmt->execute();
      $result = $stmt->get_result();
      $row = $result->fetch_assoc();
      $teacher_subject_count = $row['teacher_subject_count'];
      $stmt->close();

      // If the subject is already assigned to another teacher, prevent the assignment
      if ($teacher_subject_count > 0) {
        echo "<script>alert('This subject is already assigned to another teacher.');</script>";
      } else {
        // Check if the student is already assigned to this teacher for the subject
        $stmt = $conn->prepare("SELECT COUNT(*) AS assignment_count FROM tblstudent_teacher_subject WHERE student_id = ? AND teacher_id = ? AND subject_id = ?");
        $stmt->bind_param("iii", $student_id, $teacher_id, $subject_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $assignment_count = $row['assignment_count'];
        $stmt->close();

        // If the assignment already exists, show an alert
        if ($assignment_count > 0) {
          echo "<script>alert('This student is already assigned to this teacher for the selected subject.');</script>";
        } else {
          // Prepare and bind the statement for inserting into tblstudent_teacher_subject
          $stmt = $conn->prepare("INSERT INTO tblstudent_teacher_subject (student_id, teacher_id, subject_id) VALUES (?, ?, ?)");
          $stmt->bind_param("iii", $student_id, $teacher_id, $subject_id);

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
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Assign Teacher and Subject to Student</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
  <aside>
    <div class="container">
      <div class="menu">

      </div>
      <hr>
      <div class="fixed bottom-0 left-0 top-0 z-50 w-[260px] border shadow">
        <div class=" text-2xl text-center hover:bg-blue-900 hover:text-white py-1 rounded-sm cursor-pointer">
          <a href="adminDashboard.php" class="cursor-pointer">Dashboard</a>
        </div>
        <div class="flex flex-col justify-evenly item-center text-center gap-2 mt-5">
          <div class="flex justify-center item-center gap-2 hover:bg-gray-400 py-2 cursor-pointer">
            <div class="h-10 w-10">
              <img src="../admin/img_side/student_side.svg" alt="student_sidebar">
            </div>
            <div class="mt-2 text-lg">
              <a href="../admin/student_view.php">Manage Student</a>
            </div>
          </div>
          <div class="flex justify-center item-center gap-2 hover:bg-gray-400 py-2  cursor-pointer">
            <div class="h-10 w-10">
              <img src="../admin/img_side/teacher-svgrepo-com.svg" alt="teacher_sidebar">
            </div>
            <div class="mt-2 text-lg">
              <a href="../admin/teacher_view.php">Manage Teacher</a>
            </div>
          </div>
          <div class="flex justify-center item-center gap-2 hover:bg-gray-400 py-2  cursor-pointer ms-[-25px]">
            <div class="h-10 w-10">
              <img src="../admin/img_side/user_side.svg" alt="user_sidebar">
            </div>
            <div class="mt-2 text-lg">
              <a href="">Manage User</a>
            </div>
          </div>
          <div class="flex justify-center item-center gap-2  hover:bg-gray-400 py-2  cursor-pointer ms-[18px]">
            <div class="h-10 w-10">
              <img src="../admin/img_side/academic_side.svg" alt="academic_sidebar">
            </div>
            <div class="mt-2 text-lg">
              <a href="../admin/academic_create.php">Manage Academic</a>
            </div>
          </div>
          <div class="flex justify-center item-center gap-2 hover:bg-gray-400 
            py-2  cursor-pointer ms-[35px]">
            <div class="h-10 w-10">
              <img src="../admin/img_side/department_side.svg" alt="department_sidebar">
            </div>
            <div class="mt-2 text-lg">
              <a href="../admin/department_create.php">Manage Department</a>
            </div>
          </div>
          <div class="flex justify-center item-center gap-2 hover:bg-gray-400 py-2  cursor-pointer">
            <div class="h-10 w-10">
              <img src="../admin/img_side/section_side.svg" alt="section_sidebar">
            </div>
            <div class="mt-2 text-lg">
              <a href="../admin/section_create.php">Manage Section</a>
            </div>
          </div>
          <div class="flex justify-center item-center gap-2 hover:bg-gray-400 py-2  cursor-pointer">
            <div class="h-10 w-10">
              <img src="../admin/img_side/criteria_side.svg" alt="criteria_sidebar">
            </div>
            <div class="mt-2 text-lg">
              <a href="../admin/criteria_create.php">Manage Criteria</a>
            </div>
          </div>
          <div class="flex justify-center item-center gap-2 hover:bg-gray-400 py-2  cursor-pointer">
            <div class="h-10 w-10">
              <img src="../admin/img_side/subject_side.svg" alt="subject_sidebar">
            </div>
            <div class="mt-2 text-lg">
              <a href="../admin/subject_create.php">Manage Subject</a>
            </div>
          </div>
          <div class="flex justify-center item-center gap-2 hover:bg-gray-400 py-2  cursor-pointer">
            <div class="h-10 w-10 ms-[-63px]">
              <img src="../admin/img_side/archive_side.svg" alt="archive_sidebar">
            </div>
            <div class="mt-2 text-lg mx-1">
              <a href="">Archive</a>
            </div>
          </div>
          <div class="flex justify-center 
            item-center gap-2 hover:bg-gray-400 
              py-2  ms-[-73px]">
            <div class="h-10 w-10">
              <img src="../admin/img_side/logout_side.svg" alt="logout_sidebar">
            </div>
            <div class="mt-2 text-lg">
              <a href="../logout.php">Logout</a>
            </div>
          </div>
        </div>

      </div>
    </div>
  </aside>
  <div class="fixed bottom-0 left-0 right-0 top-0 z-10 mx-[260px] w-5/6 p-10 ">
    <h2 class="text-4xl m-1 ">Assign Teacher and Subject to Student For Irregular Student</h2>
    <form action="" method="POST">
      <div class="flex justify-start items-start">
        <!-- Student Selection -->
        <div class="m-4">
          <div>
            <label for="student" class="text-3xl m-1">Select Student</label>
          </div>
          <div class="m-1">
            <select
              name="student_id"
              id="student"
              required
              class="border-2 rounded-md text-blackpy-3 py-3 px-3 w-[300px]">
              <?php
              // Fetch only irregular students from the database
              $query = $conn->query("SELECT s.student_id, s.name FROM tblstudent s JOIN tblstudent_section ss ON s.student_id = ss.student_id WHERE ss.is_regular = 0");
              while ($row = $query->fetch_assoc()) {
                // Retain the previously selected student
                $selected = ($row['student_id'] == $selected_student) ? "selected" : "";
                echo "<option value='" . htmlspecialchars($row['student_id']) . "' $selected>" . htmlspecialchars($row['name']) . "</option>";
              }
              ?>
            </select>
          </div>
        </div>
        <!-- Teacher Selection -->
        <div class="m-4">
          <div>
            <label for="teacher" class="text-3xl m-1">Select Teacher</label>
          </div>
          <div class="m-1">
            <select
              name="teacher_id"
              id="teacher"
              required
              class="border-2 rounded-md text-black py-3 px-3 w-[300px]">
              <?php
              // Fetch teachers from the database
              $query = $conn->query("SELECT teacher_id, name FROM tblteacher");
              while ($row = $query->fetch_assoc()) {
                // Retain the previously selected teacher
                $selected = ($row['teacher_id'] == $selected_teacher) ? "selected" : "";
                echo "<option value='" . htmlspecialchars($row['teacher_id']) . "' $selected>" . htmlspecialchars($row['name']) . "</option>";
              }
              ?>
            </select>
          </div>
        </div>
        <!-- Subject Selection -->
        <div class="m-4">
          <div>
            <label for="subject" class="text-3xl m-1">Select Subject:</label>
          </div>
          <div class="m-1">
            <select
              name="subject_id"
              id="subject"
              required
              class="border-2 rounded-md text-black py-3 px-3 w-[300px]">
              <?php
              // Fetch subjects from the database
              $query = $conn->query("SELECT subject_id, subject_name FROM tblsubject");
              while ($row = $query->fetch_assoc()) {
                // Retain the previously selected subject
                $selected = ($row['subject_id'] == $selected_subject) ? "selected" : "";
                echo "<option value='" . htmlspecialchars($row['subject_id']) . "' $selected>" . htmlspecialchars($row['subject_name']) . "</option>";
              }
              ?>
            </select>
          </div>
        </div>
      </div>
      <div class="m-4 flex justify-start items-start ">
        <div class="relative z-10">
          <button type="submit"
            class="px-12 py-3 bg-blue-900 hover:bg-blue-500 rounded-md text-white">
            Deploy Assignation
            <img
              src="../admin/Images/assign.svg"
              alt="assign-icon"
              class="h-8 w-8 absolute top-2 left-3">
          </button>
        </div>
      </div>
    </form>
  </div>

</body>

</html>

<?php
$conn->close();
?>