<?php
include('../database/dbconnect.php');
session_start();

if (!isset($_SESSION['username']) && !isset($_SESSION['school_year']) && !isset($_SESSION['semester']) && !isset($_SESSION['is_status'])) {
  // Redirect to login page or display an error message
  header("Location: ../login.php");
  exit();
}

// Query to get the active academic year and semester if set to 'Started'
$schoolyear_query = $conn->query("SELECT school_year, semester, is_status FROM tblschoolyear WHERE is_status = 'Started'");
$schoolyear = $schoolyear_query->fetch_assoc();

// Set session variables only if there is an active academic year
if ($schoolyear) {
  $_SESSION['school_year'] = $schoolyear['school_year'];
  $_SESSION['semester'] = $schoolyear['semester'];
  $_SESSION['is_status'] = $schoolyear['is_status'];
} else {
  // Set default values if no academic year is active
  $_SESSION['school_year'] = "Not Set";
  $_SESSION['semester'] = "Not Yet Started";
  $_SESSION['is_status'] = "Inactive";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
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
          <div class="flex justify-center item-center gap-2 hover:bg-gray-400 py-2 hover:text-black cursor-pointer">
            <div class="h-10 w-10">
              <img src="../admin/img_side/student_side.svg" alt="student_sidebar">
            </div>
            <div class="mt-2 text-lg">
              <a href="../admin/student_view.php">Manage Student</a>
            </div>
          </div>
          <div class="flex justify-center item-center gap-2 hover:bg-gray-400 py-2 hover:text-black cursor-pointer">
            <div class="h-10 w-10">
              <img src="../admin/img_side/teacher-svgrepo-com.svg" alt="teacher_sidebar">
            </div>
            <div class="mt-2 text-lg">
              <a href="../admin/teacher_view.php">Manage Teacher</a>
            </div>
          </div>
          <div class="flex justify-center item-center gap-2 hover:bg-gray-400 py-2 hover:text-black cursor-pointer ms-[-25px]">
            <div class="h-10 w-10">
              <img src="../admin/img_side/user_side.svg" alt="user_sidebar">
            </div>
            <div class="mt-2 text-lg">
              <a href="">Manage User</a>
            </div>
          </div>
          <div class="flex justify-center item-center gap-2  hover:bg-gray-400 py-2 hover:text-black cursor-pointer ms-[18px]">
            <div class="h-10 w-10">
              <img src="../admin/img_side/academic_side.svg" alt="academic_sidebar">
            </div>
            <div class="mt-2 text-lg">
              <a href="../admin/academic_create.php">Manage Academic</a>
            </div>
          </div>
          <div class="flex justify-center item-center gap-2 hover:bg-gray-400 
            py-2 hover:text-black cursor-pointer ms-[35px]">
            <div class="h-10 w-10">
              <img src="../admin/img_side/department_side.svg" alt="department_sidebar">
            </div>
            <div class="mt-2 text-lg">
              <a href="../admin/department_create.php">Manage Department</a>
            </div>
          </div>
          <div class="flex justify-center item-center gap-2 hover:bg-gray-400 py-2 hover:text-black cursor-pointer">
            <div class="h-10 w-10">
              <img src="../admin/img_side/section_side.svg" alt="section_sidebar">
            </div>
            <div class="mt-2 text-lg">
              <a href="../admin/section_create.php">Manage Section</a>
            </div>
          </div>
          <div class="flex justify-center item-center gap-2 hover:bg-gray-400 py-2 hover:text-black cursor-pointer">
            <div class="h-10 w-10">
              <img src="../admin/img_side/criteria_side.svg" alt="criteria_sidebar">
            </div>
            <div class="mt-2 text-lg">
              <a href="../admin/criteria_create.php">Manage Criteria</a>
            </div>
          </div>
          <div class="flex justify-center item-center gap-2 hover:bg-gray-400 py-2 hover:text-black cursor-pointer">
            <div class="h-10 w-10">
              <img src="../admin/img_side/subject_side.svg" alt="subject_sidebar">
            </div>
            <div class="mt-2 text-lg">
              <a href="../admin/subject_create.php">Manage Subject</a>
            </div>
          </div>
          <div class="flex justify-center item-center gap-2 hover:bg-gray-400 py-2 hover:text-black cursor-pointer">
            <div class="h-10 w-10 ms-[-63px]">
              <img src="../admin/img_side/archive_side.svg" alt="archive_sidebar">
            </div>
            <div class="mt-2 text-lg mx-1">
              <a href="">Archive</a>
            </div>
          </div>
          <div class="flex justify-center 
            item-center gap-2 hover:bg-gray-400 
              py-2 hover:text-black ms-[-73px]">
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
  <main>
    <div class="fixed bottom-0 left-0 right-0 top-0 z-10 mx-[260px] w-5/6 p-10">
      <?php if (isset($_SESSION['username'])): ?>
        <div class="container mx-auto h-[700px] p-4">
          <div class="p-4 border">
            <h2 class="text-6xl mb-4">Welcome, Admin <?= htmlspecialchars($_SESSION['username']) ?></h2>

            <!-- Display academic year or default "Not Set" message -->
            <p class="text-4xl m-1">Academic Year:
              <?= htmlspecialchars($_SESSION['school_year'] === "Not Set" ? "Not Set" : $_SESSION['school_year']) ?>
            </p>

            <!-- Display semester information -->
            <p class="text-3xl m-1">Semester:
              <?= $_SESSION['semester'] == '1' ? 'First Semester' : ($_SESSION['semester'] == '2' ? 'Second Semester' : 'Not Yet Started') ?>
            </p>

            <!-- Display status -->
            <p class="text-3xl m-1 relative">Status: <?= htmlspecialchars($_SESSION['is_status']) ?></p>
          <?php else: ?>
            <p>Academic year and semester not set. Please set the active semester.</p>
          <?php endif; ?>
          </div>

          <div class="flex justify-evenly items-center gap-3 mt-20">
            <div class="relative h-[150px] w-[350px] border-s-4 border-b-2 border-blue-900 rounded-md shadow-md shadow-blue-200">
              <div class="p-3">
                <h1 class="text-2xl">Teacher</h1>
              </div>
              <div class="absolute bottom-[30px] left-5 h-10 w-10 rounded-full bg-blue-900"></div>
              <div class="absolute bottom-[30px] left-20 text-4xl">
                <span>
                  <?php
                  $count = 0;
                  $sql = "SELECT COUNT(*) AS total FROM tblteacher";
                  $result = mysqli_query($conn, $sql);

                  if ($result) {
                    $row = mysqli_fetch_assoc($result);
                    $count = $row['total'];
                  }
                  echo $count;
                  ?>

                </span>
              </div>
            </div>
            <div class="relative h-[150px] w-[350px] border-s-4 border-b-2 border-red-900 rounded-md shadow-md shadow-red-200">
              <div class="p-3">
                <h1 class="text-4xl">Student</h1>
              </div>
              <div class="absolute bottom-[30px] left-5 h-10 w-10 rounded-full bg-red-900"></div>
              <div class="absolute bottom-[30px] left-12 text-4xl">
                <span class="badge bg-dark rounded-full fs-1" style="padding: 0.5em 1em;">
                  <?php
                  $count = 0;
                  $sql = "SELECT COUNT(*) AS total FROM tblstudent";
                  $result = mysqli_query($conn, $sql);

                  if ($result) {
                    $row = mysqli_fetch_assoc($result);
                    $count = $row['total'];
                  }
                  echo $count;
                  ?>

                </span>
              </div>
            </div>
            <div class="relative h-[150px] w-[350px] border-s-4 border-b-2 border-green-900 rounded-md shadow-md shadow-green-200">
              <div class="p-3">
                <h1 class="text-2xl">Admin</h1>
              </div>
              <div class="absolute bottom-[30px] left-5 h-10 w-10 rounded-full bg-green-900"></div>
              <div class="absolute bottom-[30px] left-16 text-4xl">
                <!-- <span class="badge bg-dark rounded-full fs-1" style="padding: 0.5em 1em;">
                  <?php
                  $count = 0;
                  $sql = "SELECT COUNT(*) AS total FROM tbladmin";
                  $result = mysqli_query($conn, $sql);

                  if ($result) {
                    $row = mysqli_fetch_assoc($result);
                    $count = $row['total'];
                  }
                  echo $count;
                  ?>

                </span>-->
              </div>
            </div>
          </div>
        </div>

    </div>
  </main>
</body>

</html>