<?php
include('../database/dbconnect.php');
session_start();
function addTeacher($conn, $school_id, $fname, $lname, $department_id, $file)
{
  // Combine first and last names
  $name = $fname . " " . $lname;

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

  // Prepared statement to insert teacher data (without section assignment)
  $sql = "INSERT INTO tblteacher (school_id, name, department_id, image) 
            VALUES (?, ?, ?, ?)";

  if ($stmt = $conn->prepare($sql)) {
    // Bind parameters to the prepared statement
    $stmt->bind_param('ssss', $school_id, $name, $department_id, $newimg);

    // Execute the prepared statement
    if ($stmt->execute()) {

      echo "<script>alert('Teacher created successfully!');</script>";
    } else {
      echo "<script>alert('Error creating teacher: " . $stmt->error . "');</script>";
    }
    header('Location: teacher_view.php');
    // Close the statement
    $stmt->close();
  } else {
    echo "<script>alert('Error: Could not prepare query.');</script>";
  }
}


// Call the function with form data
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
  addTeacher(
    $conn,
    $_POST['school_id'],
    $_POST['fname'],
    $_POST['lname'],
    $_POST['department_id'],
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
  <link rel="stylesheet" href="style/create.css">
</head>

<body>
  <div class="header">
    <div class="main">
      <div class="head">
        <h2>Add Teacher</h2>
      </div>

      <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" enctype="multipart/form-data">
        <div class="con">

          <div class="group">
            <label>School Id:</label>
            <input class="control ctrl1"
              type="text" minlength="7" maxlength="7"
              name="school_id" autocomplete="off"
              placeholder="Enter your school id" value="<?php echo isset($schoolId); ?>">
          </div><br>

          <div class="group">
            <label>Name:</label>
            <input class="control" type="text" name="fname" autocomplete="off" placeholder="Enter your firstname">
            <input class="control ctrl" type="text" name="lname" autocomplete="off" placeholder="Enter your lastname">
          </div><br>

          <div class="group">
            <label>Department:</label>
            <select name="department_id" required>
              <option value="" disabled selected>Select Department</option>
              <?php
              $department = $conn->query("SELECT * FROM tbldepartment");
              while ($row = $department->fetch_assoc()):
              ?>
                <option value="<?php echo $row['department_id']; ?>"><?php echo htmlspecialchars($row['department_name']); ?></option>
              <?php endwhile; ?>
            </select>
          </div><br>


          <!-- <div class="group">
            <label>Section:</label>
            <select name="section_id">
              <option value="" disabled selected>Select Section (Optional)</option>
              <?php
              $department = $conn->query("SELECT * FROM tblsection");
              while ($row = $department->fetch_assoc()):
              ?>
                <option value="<?php echo $row['section_id']; ?>"><?php echo htmlspecialchars($row['section_name']); ?></option>
              <?php endwhile; ?>
            </select>
          </div><br> -->


          <div class="group">
            <img src="evaluation/pic/" id="imgss">
            <input type="file" name="hen" id="hen" value="" accept=".jpeg, .jpg, .png, .svg" style="display: none;">
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
  </script>
</body>

</html>