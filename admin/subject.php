
<?php
include("../database/dbconnect.php");


function createSubject($subject)
{
  global $conn; // Access the $conn variable from the global scope
  try {

    $csql = "SELECT * FROM tblsubject WHERE subject_name =?";
    $stmtc = $conn->prepare($csql);
    $stmtc->bind_param("s", $subject);
    $stmtc->execute();
    $stmtc->store_result();

    if ($stmtc->num_rows() > 0) {
      echo "<script>
              alert('subject already exists.');
              window.location.href='subject_create.php';
            </script>";
    } else {
      $sql = "INSERT INTO tblsubject (subject_name) VALUES (?)";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("s", $subject);
      if ($stmt->execute()) {
        // Success message
        echo "<script>
             alert('subject successfully created.');
              window.location.href='subject_create.php';
            </script>";
      } else {
        // Handle the failure
        echo "Error: Unable to insert subject.";
      }
      // Close the statement
      $stmt->close();
    }
    $stmtc->close();
  } catch (mysqli_sql_exception $e) {
    // Log error and display a generic message
    error_log("Insert Failed: " . $e->getMessage());
    echo "Error during subject creation.";
  }
}


function displaySubject()
{
  global $conn; // Access the $conn variable from the global scope
  try {
    $sql = "SELECT subject_id, subject_name FROM tblsubject";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    $subjectList = [];

    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $subjectList[] = $row; // Assuming 'subject' is the column name
      }
    }
    return $subjectList;
  } catch (mysqli_sql_exception $e) {
    error_log("Error fetching subject: " . $e->getMessage());
    return [];
  }
}

function updateSubject($deptId, $newDept)
{
  global $conn;

  $stmt = $conn->prepare("UPDATE tblsubject SET subject_name = ? WHERE subject_id = ?");
  $stmt->bind_param("si", $newDept, $deptId); // "si" means string and integer types

  if ($stmt->execute()) {
    return true; // Update was successful
  } else {
    return false; // Update failed
  }
}

function deleteSubject($deptId)
{
  global $conn;

  $stmt = $conn->prepare("DELETE FROM tblsubject WHERE subject_id = ?");
  $stmt->bind_param("i", $deptId); // "i" means integer type

  if ($stmt->execute()) {
    return true; // Deletion was successful
  } else {
    return false; // Deletion failed
  }
}

?>

