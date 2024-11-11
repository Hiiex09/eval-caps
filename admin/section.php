
<?php
include("../database/dbconnect.php");


function createSection($section, $year)
{
  global $conn; // Access the $conn variable from the global scope
  try {

    $csql = "SELECT * FROM tblsection WHERE section_name =?, year_level = ?";
    $stmtc = $conn->prepare($csql);
    $stmtc->bind_param("ss", $section, $year);
    $stmtc->execute();
    $stmtc->store_result();

    if ($stmtc->num_rows() > 0) {
      echo "<script>
              alert('section already exists.');
              window.location.href='section_create.php';
            </script>";
    } else {
      $sql = "INSERT INTO tblsection (section_name, year_level) VALUES (?, ?)";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("ss", $section, $year);
      if ($stmt->execute()) {
        // Success message
        echo "<script>
             alert('section successfully created.');
              window.location.href='section_create.php';
            </script>";
      } else {
        // Handle the failure
        echo "Error: Unable to insert section.";
      }
      // Close the statement
      $stmt->close();
    }
    $stmtc->close();
  } catch (mysqli_sql_exception $e) {
    // Log error and display a generic message
    error_log("Insert Failed: " . $e->getMessage());
    echo "Error during section creation.";
  }
}


function displaySection()
{
  global $conn; // Access the $conn variable from the global scope
  try {
    $sql = "SELECT section_id, section_name FROM tblsection";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    $sectionList = [];

    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $sectionList[] = $row; // Assuming 'section' is the column name
      }
    }
    return $sectionList;
  } catch (mysqli_sql_exception $e) {
    error_log("Error fetching section: " . $e->getMessage());
    return [];
  }
}

function updateSection($deptId, $newDept)
{
  global $conn;

  $stmt = $conn->prepare("UPDATE tblsection SET section_name = ? WHERE section_id = ?");
  $stmt->bind_param("si", $newDept, $deptId); // "si" means string and integer types

  if ($stmt->execute()) {
    return true; // Update was successful
  } else {
    return false; // Update failed
  }
}

function deleteSection($deptId)
{
  global $conn;

  $stmt = $conn->prepare("DELETE FROM tblsection WHERE section_id = ?");
  $stmt->bind_param("i", $deptId); // "i" means integer type

  if ($stmt->execute()) {
    return true; // Deletion was successful
  } else {
    return false; // Deletion failed
  }
}

?>

