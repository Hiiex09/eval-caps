<?php
include('../database/dbconnect.php');
session_start();

if (isset($_POST['section_id'])) {
  $section_id = $_POST['section_id'];
} else {
  // Handle the case where section_id is not set
  $section_id = null; // Or set to a default value, or handle the error
}

function addStudent($conn, $school_id, $fname, $lname, $email, $department_id, $year, $section_id, $is_regular, $password, $file)
{
  // Combine first and last names
  $name = $fname . " " . $lname;

  // Set default password as school_id
  $default_password = $school_id;

  // Password verification
  if ($password === $default_password) {
    echo 'Your password is ' . $default_password;
    return;
  }

  // Check if an image file is uploaded
  if ($file['error'] === 4) {
    echo "<script>alert('Image not exist');</script>";
    return;
  }

  // Handle file data
  $imgname = $file['name'];
  $imgsize = $file['size'];
  $imgtmp = $file['tmp_name'];

  // Validate image extension
  $imgvalid = ['jpeg', 'jpg', 'png', 'svg'];
  $imgEx = strtolower(pathinfo($imgname, PATHINFO_EXTENSION));

  // Validate extension and size
  if (!in_array($imgEx, $imgvalid)) {
    echo "<script>alert('Invalid extension');</script>";
    return;
  } elseif ($imgsize > 1000000) {
    echo "<script>alert('Image is too large');</script>";
    return;
  }

  // Create a unique filename and move the file
  $newimg = uniqid() . '.' . $imgEx;
  if (!move_uploaded_file($imgtmp, "../pic/pics/$newimg")) {
    echo "<script>alert('Image upload failed');</script>";
    return;
  }

  // Prepared statement to insert student data
  $sql = "INSERT INTO tblstudent (school_id, name, email, password, department_id, year_level, image) 
          VALUES (?, ?, ?, ?, ?, ?, ?)";

  if ($stmt = $conn->prepare($sql)) {
    // Bind parameters to the prepared statement
    $stmt->bind_param('sssssss', $school_id, $name, $email, $default_password, $department_id, $year, $newimg);

    // Execute the prepared statement
    if ($stmt->execute()) {
      // Get the student_id of the newly inserted student
      $student_id = $stmt->insert_id;

      // Handle irregular students (if no section)
      if ($is_regular) {
        // Insert into tblstudent_section if regular student and section is selected
        if (isset($section_id) && !empty($section_id)) {
          $stmt_section = $conn->prepare("INSERT INTO tblstudent_section (student_id, section_id, is_regular) VALUES (?, ?, ?)");
          $stmt_section->bind_param("iii", $student_id, $section_id, $is_regular);

          if ($stmt_section->execute()) {
            echo "Student and section information added successfully!";
          } else {
            echo "Error: " . $stmt_section->error;
          }

          // Close the stmt_section
          $stmt_section->close();
        } else {
          echo "<script>alert('Section is required for regular students.');</script>";
        }
      } else {
        // If the student is irregular, insert into tblstudent_section with section_id = 0 and is_regular = 0
        $section_id = 0;  // Irregular student doesn't have a section
        $stmt_section = $conn->prepare("INSERT INTO tblstudent_section (student_id, section_id, is_regular) VALUES (?, ?, ?)");
        $stmt_section->bind_param("iii", $student_id, $section_id, $is_regular);

        if ($stmt_section->execute()) {
          echo "Irregular student added successfully without section!";
        } else {
          echo "Error: " . $stmt_section->error;
        }

        // Close the stmt_section
        $stmt_section->close();
      }
    } else {
      echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
  } else {
    echo "<script>alert('Error: Could not prepare query.');</script>";
  }
}


// Call the function with form data
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
  $section_id = isset($_POST['section_id']) ? $_POST['section_id'] : null; // Check if section_id is provided
  addStudent(
    $conn,
    $_POST['school_id'],
    $_POST['fname'],
    $_POST['lname'],
    $_POST['email'],
    $_POST['department_id'],
    $_POST['year'],
    $section_id,
    isset($_POST['is_regular']) ? 1 : 0,
    $_POST['password'],
    $_FILES['hen']
  );
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
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
  <div class="fixed bottom-0 left-0 right-0 top-0 z-10 mx-[260px] w-[1200px] p-10 border">
    <div class="main">
      <div class="head">
        <h2>Add Student</h2>
      </div>

      <form 
        action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" 
        method="post" 
        enctype="multipart/form-data">
        <div class="con">

          <div class="group">
            <label>School Id:</label>
            <input class="control ctrl1" 
            type="text" minlength="7" maxlength="7" name="school_id" 
            autocomplete="off" placeholder="Enter your school id" 
            value="<?php echo isset($schoolId); ?>">
          </div><br>

          <div class="group">
            <label>Name:</label>
            <input class="control" type="text" name="fname" autocomplete="off" placeholder="Enter your firstname">
            <input class="control ctrl" type="text" name="lname" autocomplete="off" placeholder="Enter your lastname">
          </div><br>

          <div class="group">
            <label>E-mail:</label>
            <input class="control ctrl1" type="email" name="email" autocomplete="off" placeholder="Enter your email">
          </div><br>

          <div class="group">
            <label>Password:</label>
            <input class="control ctrl1" type="hidden" name="password" autocomplete="off" value="<?php echo isset($schoolId); ?>" readonly>
          </div><br>

          <div class="group">
            <label>Department:</label>
            <select name="department_id" required>
              <option value="" disabled selected>Select Department</option>
              <?php
              $department = $conn->query("SELECT * FROM tbldepartment");
              while ($row = $department->fetch_assoc()): ?>
                <option value="<?php echo $row['department_id']; ?>"><?php echo htmlspecialchars($row['department_name']); ?></option>
              <?php endwhile; ?>
            </select>
          </div><br>

          <div class="group">
            <label>Year:</label>
            <input class="control ctrl1" type="number" name="year" autocomplete="off" placeholder="Enter your year">
          </div><br>

          <div class="group">
            <label>Section:</label>
            <select name="section_id" id="section" required>
              <option value="" disabled selected>Select Section</option>
              <?php
              $section = $conn->query("SELECT * FROM tblsection");
              while ($row = $section->fetch_assoc()): ?>
                <option value="<?php echo $row['section_id']; ?>"><?php echo htmlspecialchars($row['section_name']); ?></option>
              <?php endwhile; ?>
            </select>
          </div><br>

          <div class="group">
            <label>Is Regular Student:</label>  
            <input type="checkbox" name="is_regular" value="1">
          </div>

          <div class="group">
            <img src="evaluation/pic/" id="imgss">
            <input type="file" name="hen" id="hen" 
            value="" accept=".jpeg, .jpg, .png, .svg" 
            >
            <label class="hen" for="hen">Upload</label>
          </div>

          <div class="group">
            <button class="btn" type="submit" name="submit">Submit</button>
            <button class="btn cancelBtn" type="reset" name="submit">Cancel</button>
          </div><br>
        </div>
      </form>
    </div>
  </div>

  <script>
    let image = document.querySelector('#imgss');
    let images = document.querySelector('#hen');
    images.addEventListener('change', function(e) {
      image.src = URL.createObjectURL(e.target.files[0]);
    });

    document.addEventListener("DOMContentLoaded", function() {
      const sectionSelect = document.getElementById("section");
      const isRegularCheckbox = document.querySelector('input[name="is_regular"]');

      // Hide the section dropdown if the student is irregular
      function toggleSectionVisibility() {
        if (isRegularCheckbox.checked) {
          sectionSelect.disabled = false; // Enable section selection if regular
        } else {
          sectionSelect.disabled = true; // Disable section selection if irregular
        }
      }

      // Initialize visibility based on the checkbox state
      toggleSectionVisibility();

      // Listen for changes to the checkbox
      isRegularCheckbox.addEventListener('change', toggleSectionVisibility);
    });
  </script>
</body>

</html>