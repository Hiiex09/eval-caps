<?php
include('../database/dbconnect.php');
session_start();

// Assuming you are working with a form to assign a teacher and subject to a section
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Get the form data
  $section_id = $_POST['section_id'];
  $teacher_id = $_POST['teacher_id'];
  $subject_id = $_POST['subject_id'];

  // Call function to assign teacher and subject to section
  assignTeacherToSection($conn, $section_id, $teacher_id, $subject_id);
}

// Function to assign a teacher and subject to a section
function assignTeacherToSection($conn, $section_id, $teacher_id, $subject_id)
{
  // Check how many teachers are already assigned to the section
  $checkTeacherCount = $conn->prepare("SELECT COUNT(*) AS teacher_count FROM tblsection_teacher_subject WHERE section_id = ?");
  $checkTeacherCount->bind_param("i", $section_id);
  $checkTeacherCount->execute();
  $result = $checkTeacherCount->get_result();
  $row = $result->fetch_assoc();
  $teacher_count = $row['teacher_count'];

  if ($teacher_count >= 8) {
    echo "Cannot assign more than 8 teachers to this section.";
    return; // Stop further processing if the section already has 8 teachers
  }

  // Check if the teacher-subject assignment already exists for this section
  $checkAssignment = $conn->prepare("SELECT * FROM tblsection_teacher_subject WHERE section_id = ? AND teacher_id = ? AND subject_id = ?");
  $checkAssignment->bind_param("iii", $section_id, $teacher_id, $subject_id);
  $checkAssignment->execute();
  $result = $checkAssignment->get_result();

  if ($result->num_rows == 0) {
    // If not assigned, insert the teacher-subject assignment to the section
    $assignQuery = $conn->prepare("INSERT INTO tblsection_teacher_subject (section_id, teacher_id, subject_id) VALUES (?, ?, ?)");
    $assignQuery->bind_param("iii", $section_id, $teacher_id, $subject_id);

    if ($assignQuery->execute()) {
      echo "Teacher and subject assigned to section successfully!";
    } else {
      echo "Error: " . $assignQuery->error;
    }
  } else {
    echo "Teacher and subject are already assigned to this section.";
  }
}

// Handle adding a regular student to a section (if needed)
function addRegularStudent($conn, $student_id, $section_id, $is_regular)
{
  if ($is_regular) {
    // If the student is regular, automatically assign the teacher and subject from the section
    // First, get the teacher and subject assigned to the section (make sure to fetch only one record)
    $getAssignment = $conn->prepare("SELECT teacher_id, subject_id FROM tblsection_teacher_subject WHERE section_id = ? LIMIT 1");
    $getAssignment->bind_param("i", $section_id);
    $getAssignment->execute();
    $result = $getAssignment->get_result();

    if ($result->num_rows > 0) {
      // Get the teacher and subject
      $assignment = $result->fetch_assoc();
      $teacher_id = $assignment['teacher_id'];
      $subject_id = $assignment['subject_id'];

      // Now assign the student to the section with the teacher and subject
      $assignStudent = $conn->prepare("INSERT INTO tblstudent_section (student_id, section_id, teacher_id, subject_id) VALUES (?, ?, ?, ?)");
      $assignStudent->bind_param("iiii", $student_id, $section_id, $teacher_id, $subject_id);

      if ($assignStudent->execute()) {
        echo "Regular student added to section with assigned teacher and subject.";
      } else {
        echo "Error: " . $assignStudent->error;
      }
    } else {
      echo "No teacher and subject assigned to this section.";
    }
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Assign Teacher and Subject to Section</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
  <aside>
    <div class="container">
      <div class="fixed bottom-0 left-0 top-0 z-50 w-[260px] border shadow">
        <div class=" text-2xl text-center hover:bg-blue-900 hover:text-white py-1 rounded-sm cursor-pointer">
          <a href="adminDashboard.php" class="cursor-pointer">Dashboard</a>
        </div>
        <div class="flex flex-col justify-evenly item-center text-center gap-2 mt-5">
          <div class="flex justify-center item-center gap-2 hover:bg-[#161D6F] py-2 hover:text-white cursor-pointer">
            <div class="h-10 w-10 border">
              <img src="#" alt="">
            </div>
            <div class="mt-2 text-lg">
              <a href="../admin/student_view.php">Manage Student</a>
            </div>
          </div>
          <div class="flex justify-center item-center gap-2 hover:bg-[#161D6F] py-2 hover:text-white cursor-pointer">
            <div class="h-10 w-10 border">
              <img src="#" alt="">
            </div>
            <div class="mt-2 text-lg">
              <a href="../admin/teacher_view.php">Manage Teacher</a>
            </div>
          </div>
          <div class="flex justify-center item-center gap-2 hover:bg-[#161D6F] py-2 hover:text-white cursor-pointer ms-[-25px]">
            <div class="h-10 w-10 border">
              <img src="#" alt="">
            </div>
            <div class="mt-2 text-lg">
              <a href="">Manage User</a>
            </div>
          </div>
          <div class="flex justify-center item-center gap-2  hover:bg-[#161D6F] py-2 hover:text-white cursor-pointer ms-[18px]">
            <div class="h-10 w-10 border">
              <img src="#" alt="">
            </div>
            <div class="mt-2 text-lg">
              <a href="../admin/academic_create.php">Manage Academic</a>
            </div>
          </div>
          <div class="flex justify-center item-center gap-2 hover:bg-[#161D6F] 
            py-2 hover:text-white cursor-pointer ms-[35px]">
            <div class="h-10 w-10 border">
              <img src="#" alt="">
            </div>
            <div class="mt-2 text-lg">
              <a href="../admin/department_create.php">Manage Department</a>
            </div>
          </div>
          <div class="flex justify-center item-center gap-2 hover:bg-[#161D6F] py-2 hover:text-white cursor-pointer">
            <div class="h-10 w-10 border">
              <img src="#" alt="">
            </div>
            <div class="mt-2 text-lg">
              <a href="../admin/section_create.php">Manage Section</a>
            </div>
          </div>
          <div class="flex justify-center item-center gap-2 hover:bg-[#161D6F] py-2 hover:text-white cursor-pointer">
            <div class="h-10 w-10 border">
              <img src="#" alt="">
            </div>
            <div class="mt-2 text-lg">
              <a href="../admin/criteria_create.php">Manage Criteria</a>
            </div>
          </div>
          <div class="flex justify-center item-center gap-2 hover:bg-[#161D6F] py-2 hover:text-white cursor-pointer">
            <div class="h-10 w-10 border">
              <img src="#" alt="">
            </div>
            <div class="mt-2 text-lg">
              <a href="../admin/subject_create.php">Manage Subject</a>
            </div>
          </div>
          <div class="flex justify-center item-center gap-2 hover:bg-[#161D6F] py-2 hover:text-white cursor-pointer">
            <div class="h-10 w-10 border ms-[-63px]">
              <img src="#" alt="">
            </div>
            <div class="mt-2 text-lg mx-1">
              <a href="">Archive</a>
            </div>
          </div>
          <div class="flex justify-center 
            item-center gap-2 hover:bg-[#161D6F] 
              py-2 hover:text-white ms-[-73px]">
            <div class="h-10 w-10 border">
              <img src="#" alt="">
            </div>
            <div class="mt-2 text-lg">
              <a href="../logout.php">Logout</a>
            </div>
          </div>
        </div>

      </div>
    </div>
  </aside>
  <div class="fixed bottom-0 left-0 right-0 top-0 z-10 mx-[260px] w-5/6 p-10">

    <h1 class="text-4xl">Assign Teacher and Subject to Section</h1>
    <form action="" method="POST">

      <div class="flex justify-start items-start">
        <!-- Section Selection -->
        <div class="m-4">
          <div class="mb-3">
            <label
              for="section_id"
              class="text-3xl m-1">Select Section</label>
          </div>
          <div>
            <select
              name="section_id"
              id="section_id"
              required
              class="border-2 rounded-md text-black py-3 px-4 w-[300px]">
              <?php
              // Fetch sections from the database
              $query = "SELECT * FROM tblsection";
              $result = $conn->query($query);

              while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['section_id'] . "'>" . $row['section_name'] . "</option>";
              }
              ?>
            </select>
          </div>
        </div>

        <!-- Teacher Selection -->
        <div class="m-4">
          <div class="mb-3">
            <label
              for="teacher_id"
              class="text-3xl m-1">Select Teacher</label>
          </div>
          <div>
            <select
              name="teacher_id"
              id="teacher_id"
              required
              class="border-2 rounded-md text-black py-3 px-4 w-[300px]">
              <?php
              // Fetch teachers from the database
              $query = "SELECT * FROM tblteacher";
              $result = $conn->query($query);

              while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['teacher_id'] . "'>" . $row['name'] . "</option>";
              }
              ?>
            </select>
          </div>
        </div>

        <!-- Subject Selection -->
        <div class="m-4">
          <div class="mb-3">
            <label
              for="subject_id"
              class="text-3xl m-1">Select Subject</label>
          </div>
          <div>
            <select
              name="subject_id"
              id="subject_id"
              required
              class="border-2 rounded-md text-black py-3 px-4 w-[300px]">
              <?php
              // Fetch subjects from the database
              $query = "SELECT * FROM tblsubject";
              $result = $conn->query($query);

              while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['subject_id'] . "'>" . $row['subject_name'] . "</option>";
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