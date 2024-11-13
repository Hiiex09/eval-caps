<?php
include("../database/dbconnect.php");
include("./subject.php");
include('../admin/aside.php');
// session_start();

$selectedSubject = "";
$subjectId = "";

// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  // Check if the keys exist before accessing them
  $action = isset($_POST['action']) ? $_POST['action'] : '';
  $subject = isset($_POST['subject']) ? $_POST['subject'] : '';
  $subjectId = isset($_POST['id']) ? $_POST['id'] : '';

  // Create action
  if ($action == "create" && !empty($subject)) {
    createsubject($subject);
    header('Location: subject_create.php'); // Redirect to the same page after creation
    exit();
  }

  // Update action
  if ($action == "update" && !empty($subjectId) && !empty($subject)) {
    updatesubject($subjectId, $subject);
    header('Location: subject_create.php'); // Redirect to the same page after updating
    exit();
  }

  // Delete action
  if ($action == "delete" && !empty($subjectId)) {
    deleteCriteria($subjectId);
    header('Location: subject_create.php'); // Redirect to the same page after deletion
    exit();
  }
}

// Get subject list for display
$subjectList = displaysubject();

// Check if subject is selected for editing
if (isset($_GET['edit'])) {
  $subjectId = $_GET['edit'];
  // Assuming displaysubject returns an array with id and name
  foreach ($subjectList as $subjectItem) {
    if ($subjectItem['subject_id'] == $subjectId) {
      $selectedSubject = $subjectItem['subject_name'];
      break;
    }
  }
}

// Handle delete action via GET request
if (isset($_GET['delete'])) {
  $subjectId = $_GET['delete'];
  deletesubject($subjectId);
  header('Location: subject_create.php'); // Redirect to the same page after deletion
  exit();
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Display subject</title>

  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
  <div class="fixed bottom-0 left-0 right-0 top-0 z-10 mx-[260px] w-5/6 p-10">
    <div class="mt-5 mb-4">
      <h1 class="text-4xl">Create subject</h1>
    </div>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
      <input type="hidden" name="id" value="<?php echo htmlspecialchars($subjectId); ?>">
      <input type="hidden" name="action" value="<?php echo $subjectId ? 'update' : 'create'; ?>">
      <div>
        <div>
          <input
            type="text"
            name="subject"
            placeholder="Enter a subject"
            value="<?php echo htmlspecialchars($selectedSubject); ?>"
            class="border px-4 py-3 w-[400px] rounded-md text-lg"
            required>
          <input
            type="submit"
            value="Submit"
            class="px-4 py-3 rounded-md 
              text-white text-lg bg-blue-900 hover:bg-blue-500
              hover:border-s-4 border-yellow-300 cursor-pointer" /> <!-- Combined submit button -->
        </div>

      </div>
    </form>

    <!-- Where the subject will be displayed -->

    <div id="subjectlist" class="overflow-x-auto mt-4">
      <?php if (count($subjectList) > 0): ?>
        <table class="table-auto w-full border shadow">
          <thead class="border bg-blue-900">
            <tr class="bg-gray-100 text-left">
              <th class="px-4 py-2 text-start">Subject Name</th>
              <th class="px-4 py-2 text-start">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($subjectList as $index => $listsubject): ?>
              <tr class="border-b hover:bg-gray-50">
                <td class="px-4 py-2 text-start border"><?php echo htmlspecialchars($listsubject['subject_name']); ?></td>
                <td class="px-4 py-2 text-start border">
                  <div class="flex justify-start gap-4">
                    <div>
                      <!-- Edit Button -->
                      <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?edit=<?php echo $listsubject['subject_id']; ?>"
                        class="inline-flex items-center justify-center bg-blue-900 hover:bg-blue-500 text-white px-4 py-2 rounded-md">
                        <img src="../admin/Images/update.svg" alt="Update" class="w-5 h-5">
                      </a>
                    </div>
                    <div>
                      <!-- Delete Button -->
                      <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?delete=<?php echo $listsubject['subject_id']; ?>"
                        onclick="return confirm('Are you sure you want to delete this subject?');"
                        class="inline-flex items-center justify-center bg-red-900 hover:bg-red-500 text-white px-4 py-2 rounded-md">
                        <img src="../admin/Images/delete.svg" alt="Delete" class="w-5 h-5">
                      </a>
                    </div>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php else: ?>
        <div class="text-center text-lg text-gray-500 mt-6">No subject Available</div>
      <?php endif; ?>
    </div>


  </div>




  <!-- Input Form -->

</body>

</html>