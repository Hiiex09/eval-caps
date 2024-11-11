
<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$config = include("configuration.php");

try {
  $conn = new mysqli($config['dbhost'], $config['dbserver'], $config['dbpass'], $config['dbname']);
} catch (mysqli_sql_exception $e) {
  error_log("Connection Failed: " . $e->getMessage());
  die("Database Connection Error"); // Display user-friendly message
}
?>