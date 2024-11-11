
<?php
include("../database/dbconnect.php");


function createDepartment($department)
{
  global $conn; // Access the $conn variable from the global scope
  try {

    $csql = "SELECT * FROM tbldepartment WHERE department_name =?";
    $stmtc = $conn->prepare($csql);
    $stmtc->bind_param("s", $department);
    $stmtc->execute();
    $stmtc->store_result();

    if ($stmtc->num_rows() > 0) {
      echo "<script>
              alert('Department already exists.');
              window.location.href='department_create.php';
            </script>";
    } else {
      $sql = "INSERT INTO tbldepartment (department_name) VALUES (?)";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("s", $department);
      if ($stmt->execute()) {
        // Success message
        echo "<script>
             alert('Department successfully created.');
              window.location.href='department_create.php';
            </script>";
      } else {
        // Handle the failure
        echo "Error: Unable to insert department.";
      }
      // Close the statement
      $stmt->close();
    }
    $stmtc->close();
  } catch (mysqli_sql_exception $e) {
    // Log error and display a generic message
    error_log("Insert Failed: " . $e->getMessage());
    echo "Error during department creation.";
  }
}


function displayDepartment()
{
  global $conn; // Access the $conn variable from the global scope
  try {
    $sql = "SELECT department_id, department_name FROM tbldepartment";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    $departmentList = [];

    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $departmentList[] = $row; // Assuming 'department' is the column name
      }
    }
    return $departmentList;
  } catch (mysqli_sql_exception $e) {
    error_log("Error fetching department: " . $e->getMessage());
    return [];
  }
}

function updateDepartment($deptId, $newDept)
{
  global $conn;

  $stmt = $conn->prepare("UPDATE tbldepartment SET department_name = ? WHERE department_id = ?");
  $stmt->bind_param("si", $newDept, $deptId); // "si" means string and integer types

  if ($stmt->execute()) {
    return true; // Update was successful
  } else {
    return false; // Update failed
  }
}

function deleteDepartment($deptId)
{
  global $conn;

  $stmt = $conn->prepare("DELETE FROM tbldepartment WHERE department_id = ?");
  $stmt->bind_param("i", $deptId); // "i" means integer type

  if ($stmt->execute()) {
    return true; // Deletion was successful
  } else {
    return false; // Deletion failed
  }
}

?>

