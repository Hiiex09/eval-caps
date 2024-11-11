<?php
include('../database/dbconnect.php');
session_start();

if (!isset($_SESSION['name']) && !isset($_SESSION['school_year']) && !isset($_SESSION['semester']) && !isset($_SESSION['is_status'])) {
  header("Location: ../login.php");
  exit();
}

$schoolyear_query = $conn->query("SELECT school_year, semester, is_status FROM tblschoolyear WHERE is_status = 'Started'");
$schoolyear = $schoolyear_query->fetch_assoc();

if ($schoolyear) {
  $_SESSION['school_year'] = $schoolyear['school_year'];
  $_SESSION['semester'] = $schoolyear['semester'];
  $_SESSION['is_status'] = $schoolyear['is_status'];
} else {
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

  <aside class="fixed top-0 left-0 h-full w-64">
    <div class="p-5">


      <hr class="border-2 border-black mb-4">

      <div class="mb-4 flex items-center hover:bg-gray-400 cursor-pointer">
        <img src="pic/dashboard.svg" class="w-6 mr-2">
        <a href="#" class="text-2xl">Dashboard</a>
      </div>

      <div>
        <div class="mb-4 flex items-center hover:bg-gray-400 cursor-pointer">
          <img src="pic/user.svg" class="w-6 mr-2">
          <a href="../student/sad.php" class="text-2xl">Evaluate</a>
        </div>
        <div class="mb-4 flex items-center hover:bg-gray-400 cursor-pointer">
          <img src="pic/inbox.svg" class="w-6 mr-2">
          <a href="#" class="text-2xl">Join Class</a>
        </div>
        <div class="mb-4 flex items-center hover:bg-gray-400 cursor-pointer">
          <img src="pic/inbox.svg" class="w-6 mr-2">
          <a href="../logout.php" class="text-2xl">Logout</a>
        </div>
      </div>
    </div>
  </aside>

  <main class="ml-64 p-5">
    <div class="text-gray-800">
      <?php if (isset($_SESSION['name'])): ?>
        <div class="m-1">
          <h2 class="text-5xl">Welcome, Admin: <?= htmlspecialchars($_SESSION['name']) ?></h2>
        </div>
        <div class="m-4">
          <p class="text-3xl">Academic Year:
            <?= htmlspecialchars($_SESSION['school_year'] === "Not Set" ? "Not Set" : $_SESSION['school_year']) ?>
          </p>
        </div>
        <div class="m-4">
          <p class="text-3xl">Semester:
            <?= $_SESSION['semester'] == '1' ? 'First Semester' : ($_SESSION['semester'] == '2' ? 'Second Semester' : 'Not Yet Started') ?>
          </p>
        </div>
        <div class="m-4">
          <p class="text-3xl">Status: <?= htmlspecialchars($_SESSION['is_status']) ?></p>
        <?php else: ?>
        </div>
        <div class="m-4">
          <p class="text-3xl">Academic year and semester not set. Please set the active semester.</p>
        <?php endif; ?>
        </div>



    </div>
  </main>

</body>

</html>