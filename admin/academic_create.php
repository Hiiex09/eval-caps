<?php
include("../database/dbconnect.php");
// include('../admin/aside.php');
session_start();

// Define variables
$edit_id = null;
$edit_year = '';
$edit_semester = '';

// Handle form submission for adding or updating
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save'])) {
  $year = $_POST['year'];
  $semester = $_POST['semester'];
  $years = (strpos($year, '-') === false) ? $year . ' - ' . ($year + 1) : $year;

  if (isset($_POST['edit_id']) && !empty($_POST['edit_id'])) {
    // Update existing school year
    $edit_id = $_POST['edit_id'];
    $stmt = $conn->prepare("UPDATE tblschoolyear SET school_year = ?, semester = ? WHERE schoolyear_id = ?");
    $stmt->bind_param("ssi", $years, $semester, $edit_id);
    if ($stmt->execute()) {
      echo "<script>alert('School year updated successfully!'); window.location.href='academic_create.php';</script>";
    } else {
      echo "<script>alert('Error updating school year.');</script>";
    }
    $stmt->close();
  } else {
    // Insert new school year
    $sc = $conn->prepare("SELECT COUNT(*) AS COUNT FROM tblschoolyear WHERE school_year = ?");
    $sc->bind_param('s', $years);
    $sc->execute();
    $rs = $sc->get_result();
    $r = $rs->fetch_assoc();
    $cs = $r['COUNT'];

    if ($cs < 2) {
      $stmt = $conn->prepare("INSERT INTO tblschoolyear (school_year, semester, is_status) VALUES (?, ?, 'Not Yet Started')");
      $stmt->bind_param("ss", $years, $semester);
      if ($stmt->execute()) {
        echo "<script>window.location.href='academic_create.php'; alert('School year saved successfully!'); </script>";
      } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
      }
      $stmt->close();
    } else {
      echo "<script>alert('The School year \"$years\" has already been added twice.');</script>";
    }
    $sc->close();
  }
}

// Handle delete operation
if (isset($_GET['delete_id'])) {
  $delete_id = $_GET['delete_id'];
  $stmt = $conn->prepare("DELETE FROM tblschoolyear WHERE schoolyear_id = ?");
  $stmt->bind_param("i", $delete_id);
  if ($stmt->execute()) {
    echo "<script>window.location.href='academic_create.php'; alert('School year deleted successfully!'); </script>";
  } else {
    echo "<script>alert('Error deleting school year.');</script>";
  }
  $stmt->close();
}

// Fetch record for editing
if (isset($_GET['editid'])) {
  $edit_id = $_GET['editid'];
  $result = $conn->query("SELECT * FROM tblschoolyear WHERE schoolyear_id = $edit_id");
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $edit_year = $row['school_year'];
    $edit_semester = $row['semester'];
  }
}

// Fetch existing school years
$school_years = $conn->query("SELECT * FROM tblschoolyear");
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage School Year</title>
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
  <div class="container">

    <main>
      <div class="fixed bottom-0 left-0 right-0 top-0 z-10 mx-[260px] w-5/6 p-10">
        <div class="flex justify-start items-center">
          <div class="mx-5">
            <img
              src="../admin/Images/school_year.svg"
              alt="school_year-image"
              class="h-14 w-14">
          </div>
          <div>
            <h1 class="text-5xl">Manage School Year</h1>
          </div>
        </div>
        <form action="" method="POST">
          <div class="mt-4 border-b-4 border-black p-2">
            <div>
              <input type="hidden" name="edit_id" value="<?php echo $edit_id; ?>">
              <label for="year" class="text-2xl">Academic Year :</label>
              <input
                type="text"
                id="year"
                name="year"
                required
                placeholder="Enter Academic Year (e.g., 2024 - 2025)"
                value="<?php echo $edit_year; ?>"
                class="px-2 py-1 border text-lg mx-2"><br>
            </div>
            <div class="mx-9">
              <label for="semester" class="text-2xl mx-5">Semester :</label>
              <select
                id="semester"
                name="semester"
                required
                class="px-2 py-1 border text-lg w-[220px] mx-[-12px] mt-1">
                <option value="1" <?php echo ($edit_semester == '1') ? 'selected' : ''; ?>>First Semester</option>
                <option value="2" <?php echo ($edit_semester == '2') ? 'selected' : ''; ?>>Second Semester</option>
              </select>
            </div>
            <div class="mx-44 mt-2 relative hover:border-s-4 border-yellow-400 bg-blue-900 hover:bg-blue-500 w-[219px] py-2 rounded-md text-center text-white">
              <button
                type="submit"
                name="save">
                <?php echo $edit_id ? 'Update' : 'Submit'; ?>
              </button>
              <img src="../admin/Images/send.svg" alt="School ID"
                class="w-7 h-7 absolute top-2 left-12">
            </div>

          </div>





        </form>

        <div class="mt-4">
          <h2 class="text-2xl">Existing School Years</h2>
        </div>

        <table class="table-auto w-full border shadow mt-3">
          <thead class="border bg-blue-900 text-white shadow">
            <tr>
              <th class="px-4 py-2 text-center">ID</th>
              <th class="px-4 py-2 text-center">Academic Year</th>
              <th class="px-4 py-2 text-center">Semester</th>
              <th class="px-4 py-2 text-center">Default</th>
              <th class="px-4 py-2 text-center">Status</th>
              <th class="px-4 py-2 text-center">Actions</th>
            </tr>
          </thead>

          <tbody>
            <?php
            $i = 1;
            while ($row = $school_years->fetch_assoc()):
              $active = $row['is_default'];
            ?>
              <tr>
                <th class="text-center"><?php echo $i++ ?></th>
                <td class="px-4 py-2 text-center border"><b><?php echo $row['school_year']; ?></b></td>
                <td class="px-4 py-2 text-center border"><b><?php echo $row['semester']; ?></b></td>
                <td class="px-4 py-2 text-center border">
                  <button onclick="toggleActive(<?php echo $row['schoolyear_id']; ?>, '<?php echo $active; ?>')">
                    <?php echo $active === 'Yes' ? 'Yes' : 'No'; ?>
                  </button>
                </td>
                <td class="px-4 py-2 text-center border">
                  <select id="status-<?php echo $row['schoolyear_id']; ?>" onchange="updateStatus(<?php echo $row['schoolyear_id']; ?>, this.value)" <?php echo $active === 'Yes' ? '' : 'disabled'; ?>>
                    <option value="Not Yet Started" <?php echo $row['is_status'] === 'Not Yet Started' ? 'selected' : ''; ?>>Not Yet Started</option>
                    <option value="Started" <?php echo $row['is_status'] === 'Started' ? 'selected' : ''; ?>>Started</option>
                    <option value="Closed" <?php echo $row['is_status'] === 'Closed' ? 'selected' : ''; ?>>Closed</option>
                  </select>
                </td>
                <td class="px-4 py-2 text-center border">
                  <div class="flex justify-center items-center">
                    <div class="mx-1 bg-blue-900 hover:bg-blue-500 rounded-md p-1 flex justify-center items-center">
                      <button class="btn1">
                        <a
                          href="?editid=<?php echo $row['schoolyear_id']; ?>">
                          <div>
                            <div>
                              <img src="../admin/Images/update.svg" alt="School ID"
                                class="w-6 h-6">
                            </div>
                          </div>
                        </a>
                      </button>
                    </div>
                    <div class="mx-1 bg-red-900 hover:bg-red-500 rounded-md p-1 flex justify-center items-center">
                      <a class="btn1" href="?delete_id=<?php echo $row['schoolyear_id']; ?>"
                        onclick="return confirm('Are you sure you want to delete this school year?')">
                        <div>
                          <div>
                            <img src="../admin/Images/delete.svg" alt="School ID"
                              class="w-6 h-6">
                          </div>
                        </div>
                      </a>
                    </div>
                  </div>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>

    </main>
  </div>


  <script>
    function toggleActive(id, currentStatus) {
      const newStatus = currentStatus === 'Yes' ? 'No' : 'Yes';
      const statusDropdown = document.getElementById('status-' + id);

      // Create the AJAX request
      const xhr = new XMLHttpRequest();
      xhr.open('POST', 'academic.php', true);
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

      xhr.onload = function() {
        if (this.status === 200) {
          // Refresh to reflect the changes after the request completes successfully
          location.reload();
        } else {
          console.error('Error toggling active status:', this.responseText);
        }
      };

      if (newStatus === 'Yes') {
        // Set this school year as active, reset others to inactive, and enable the dropdown
        xhr.send(`schoolyear_id=${id}&status=${newStatus}&set_single_active=1`);
        statusDropdown.disabled = false;
      } else {
        // Set this school year to inactive, reset status to 'Not Yet Started', and disable the dropdown
        xhr.send(`schoolyear_id=${id}&status=${newStatus}&reset_status=1`);
        statusDropdown.value = 'Not Yet Started';
        statusDropdown.disabled = true;
      }
    }

    function updateStatus(id, status) {
      // Create the AJAX request for updating only the status
      const xhr = new XMLHttpRequest();
      xhr.open('POST', 'academicstatus.php', true);
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

      xhr.onload = function() {
        if (this.status === 200) {
          console.log('Status updated successfully.');
          location.reload();
        } else {
          console.error('Error updating status:', this.responseText);
        }
      };

      xhr.send(`schoolyear_id=${id}&status=${status}`);
    }
  </script>


</body>

</html>