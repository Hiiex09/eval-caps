<?php
include("../database/dbconnect.php");
include("./department.php");
// include('../admin/aside.php');
session_start();

$selectedDept = "";
$deptId = "";

// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $action = $_POST['action'];
  $department = $_POST['department'];
  $deptId = $_POST['id'];

  // Create action
  if ($action == "create" && !empty($department)) {
    createDepartment($department);
    header('Location: department_create.php'); // Redirect to the same page after creation
    exit();
  }

  // Update action
  if ($action == "update" && !empty($deptId) && !empty($department)) {
    updateDepartment($deptId, $department);
    header('Location: department_create.php'); // Redirect to the same page after updating
    exit();
  }

  // Delete action
  if ($action == "delete" && !empty($deptId)) {
    deleteCriteria($deptId);
    header('Location: department_create.php'); // Redirect to the same page after deletion
    exit();
  }
}

// Get department list for display
$departmentList = displayDepartment();

// Check if department is selected for editing
if (isset($_GET['edit'])) {
  $deptId = $_GET['edit'];
  // Assuming displayDepartment returns an array with id and name
  foreach ($departmentList as $departmentItem) {
    if ($departmentItem['department_id'] == $deptId) {
      $selectedDept = $departmentItem['department_name'];
      break;
    }
  }
}

// Handle delete action via GET request
if (isset($_GET['delete'])) {
  $deptId = $_GET['delete'];
  deleteDepartment($deptId);
  header('Location: department_create.php'); // Redirect to the same page after deletion
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Display Department</title>
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
  <div class="fixed bottom-0 left-0 right-0 top-0 z-10 mx-[260px] w-5/6 p-10">
    <div class="flex justify-start items-center">
      <div class="mx-5">
        <img
          src="../admin/img_side/department_side.svg"
          alt="school_year-image"
          class="h-14 w-14">
      </div>
      <div class="mt-3">
        <h1 class="text-5xl mb-4">Create Department</h1>
      </div>
    </div>
    <div class="flex justify-end items-end">
      <form
        action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"
        method="post"
        class="mb-1">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($deptId); ?>">
        <input type="hidden" name="action" value="<?php echo $deptId ? 'update' : 'create'; ?>">
        <input
          type="text"
          name="department"
          placeholder="Enter a department"
          class="border-2 px-4 py-3 w-[400px] rounded-md"
          autocomplete="off"
          value="<?php echo htmlspecialchars($selectedDept); ?>" required>
        <input
          type="submit"
          value="Submit"
          class="px-5 py-3 bg-blue-900 text-white rounded-md cursor-pointer" /> <!-- Combined submit button -->
      </form>
    </div>


    <!-- Where the department will be displayed -->

    <div id="departmentlist">
      <?php if (count($departmentList) > 0): ?>
        <div class="grid grid-cols-4 gap-2 ">
          <?php foreach ($departmentList as $index => $listDepartment): ?>
            <div class="mt-5 p-8 h-[180px] border-2 hover:shadow-lg hover:shadow-blue-300 
               hover:border-s-blue-600 hover:border-s-8 rounded-md">
              <div class="text-lg font-semibold">
                <?php echo htmlspecialchars($listDepartment['department_name']); ?>
              </div>
              <!-- Using links to handle editing and deleting -->
              <div class="flex justify-start items-center gap-1 mt-3">
                <div class="bg-green-900 px-3 py-1 rounded-md">
                  <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?edit=<?php echo $listDepartment['department_id']; ?>">
                    <img src="../admin/Images/update.svg" alt="School ID"
                      class="w-5 h-5">
                  </a>
                </div>
                <div class="bg-red-900 px-3 py-1 rounded-md">
                  <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?delete=<?php echo $listDepartment['department_id']; ?>" onclick="return confirm(`Are you sure you want to delete this department ?`);">
                    <img src="../admin/Images/delete.svg" alt="School ID"
                      class="w-5 h-5">
                  </a>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <div class="no-department">No Department Available</div>
      <?php endif; ?>
    </div>

  </div>
  </div>


  <!-- Input Form -->

</body>

</html>