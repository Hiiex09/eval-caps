
<?php
include("../database/dbconnect.php");

function createCriteria($criteria)
{
  global $conn; // Access the $conn variable from the global scope
  try {

    $csql = "SELECT * FROM tblcriteria WHERE criteria =?";
    $stmtc = $conn->prepare($csql);
    $stmtc->bind_param("s", $criteria);
    $stmtc->execute();
    $stmtc->store_result();

    if ($stmtc->num_rows() > 0) {
      echo "<script>
              alert('Criteria already exists.');
              window.location.href='criteria_create.php';
            </script>";
    } else {
      $sql = "INSERT INTO tblcriteria (criteria) VALUES (?)";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("s", $criteria);
      if ($stmt->execute()) {
        // Success message
        echo "<script>
             alert('Criteria successfully created.');
              window.location.href='criteria_create.php';
            </script>";
      } else {
        // Handle the failure
        echo "Error: Unable to insert criteria.";
      }
      // Close the statement
      $stmt->close();
    }
    $stmtc->close();
  } catch (mysqli_sql_exception $e) {
    // Log error and display a generic message
    error_log("Insert Failed: " . $e->getMessage());
    echo "Error during criteria creation.";
  }
}


function displayCriteria()
{
  global $conn; // Access the $conn variable from the global scope
  try {
    $sql = "SELECT criteria_id, criteria FROM tblcriteria";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    $criteriaList = [];

    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $criteriaList[] = $row; // Assuming 'criteria' is the column name
      }
    }
    return $criteriaList;
  } catch (mysqli_sql_exception $e) {
    error_log("Error fetching criteria: " . $e->getMessage());
    return [];
  }
}

function updateCriteria($criteriaId, $newCriteria)
{
  global $conn;

  $stmt = $conn->prepare("UPDATE tblcriteria SET criteria = ? WHERE criteria_id = ?");
  $stmt->bind_param("si", $newCriteria, $criteriaId); // "si" means string and integer types

  if ($stmt->execute()) {
    return true; // Update was successful
  } else {
    return false; // Update failed
  }
}

function deleteCriteria($criteriaId)
{
  global $conn;

  $stmt = $conn->prepare("DELETE FROM tblcriteria WHERE criteria_id = ?");
  $stmt->bind_param("i", $criteriaId); // "i" means integer type

  if ($stmt->execute()) {
    return true; // Deletion was successful
  } else {
    return false; // Deletion failed
  }
}

?>

