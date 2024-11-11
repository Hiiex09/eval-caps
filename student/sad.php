<?php
session_start();
include('../database/dbconnect.php'); // Include database connection
include("../admin/criteria.php");

// Check if the student is logged in
if (!isset($_SESSION['school_id']) || !isset($_SESSION['name'])) {
  echo "Please log in as a student to view your teachers.";
  exit;
}

$school_id = $_SESSION['school_id']; // Get the school_id from the session
$fname = $_SESSION['name']; // Get the student name from the session

// Query to fetch assigned teachers and subjects for the logged-in student
$sql = "
    SELECT tblteacher.name AS teacher_name, tblsubject.subject_name, tblteacher.image
    FROM tblstudent_teacher_subject
    INNER JOIN tblteacher ON tblstudent_teacher_subject.teacher_id = tblteacher.teacher_id
    INNER JOIN tblsubject ON tblstudent_teacher_subject.subject_id = tblsubject.subject_id
    WHERE tblstudent_teacher_subject.student_id = (SELECT student_id FROM tblstudent WHERE school_id = ?)
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $school_id);
$stmt->execute();
$result = $stmt->get_result();

// Fetch teachers and subjects
$teachers = [];
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $teachers[] = $row;
  }
}

// Close prepared statement
$stmt->close();

$criteriaList = displayCriteria();

$currentTeacherIndex = isset($_SESSION['current_teacher_index']) ? $_SESSION['current_teacher_index'] : 0;

// Check if all teachers have been evaluated
if ($currentTeacherIndex >= count($teachers)) {
  // Reset index if all teachers have been evaluated
  unset($_SESSION['current_teacher_index']);
  echo "<h2>All teachers have been evaluated. Thank you!</h2>";
  exit;
}

// Get current teacher
$currentTeacher = $teachers[$currentTeacherIndex];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Process ratings and comments for the current teacher
  // Here you would typically save the ratings and comments to the database
  // For example:
  // saveEvaluation($_POST['rating'], $_POST['comment'], $currentTeacher['name']);

  // Move to the next teacher
  $_SESSION['current_teacher_index'] = $currentTeacherIndex + 1;
  header("Location: " . $_SERVER['PHP_SELF']); // Redirect to the same page
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Your Assigned Teachers</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 20px;
    }

    .container {
      max-width: 90%;
      margin: 0 auto;
      background-color: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
      text-align: center;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    table,
    th,
    td {
      border: 1px solid #ddd;
    }

    th,
    td {
      padding: 10px;
      text-align: left;
    }

    th {
      background-color: #f2f2f2;
    }

    .teacher-list {
      margin-top: 20px;
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
      gap: 15px;
      justify-content: center;
    }

    .teacher-item {
      background-color: #e9ecef;
      padding: 15px;
      border-radius: 10px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      text-align: center;
    }

    .teacher-item img {
      width: 100px;
      height: 100px;
      object-fit: cover;
      border-radius: 50%;
    }

    .teacher-info p {
      margin: 5px 0;
      font-size: 16px;
    }

    .teacher-info span {
      font-weight: bold;
      display: inline-block;
    }

    .no-teachers {
      text-align: center;
      font-size: 18px;
      color: #888;
    }
  </style>
</head>

<body>
  <div class="container">
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?> - <?php echo htmlspecialchars($_SESSION['school_id']); ?></h1>
    <h2>Your Assigned Teachers and Subjects</h2>

    <?php if (!empty($teachers)): ?>
      <div class="teacher-list">
        <?php foreach ($teachers as $teacher): ?>
          <div class="teacher-item">
            <img src="../pic/pics/<?php echo htmlspecialchars($teacher['image']); ?>" alt="Teacher Profile">
            <div class="teacher-info">
              <p><span>Teacher Name:</span> <?php echo htmlspecialchars($teacher['teacher_name']); ?></p>
              <p><span>Subject:</span> <?php echo htmlspecialchars($teacher['subject_name']); ?></p>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <p class="no-teachers">You have no assigned teachers yet.</p>
    <?php endif; ?>


    <h1>Evaluating Teacher: <?php echo htmlspecialchars($currentTeacher['teacher_name']); ?></h1>



    <div class="teacher-item">
      <img src="../pic/pics/<?php echo htmlspecialchars($teacher['image']); ?>" alt="Teacher Profile">
      <div class="teacher-info">
        <p><span>Teacher Name:</span> <?php echo htmlspecialchars($currentTeacher['teacher_name']); ?></p>
        <p><span>Subject:</span> <?php echo htmlspecialchars($currentTeacher['subject_name']); ?></p>
      </div>
    </div>

    <main class="container">
      <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <div id="criterialist">
          <?php if (count($criteriaList) > 0): ?>
            <ol>
              <?php foreach ($criteriaList as $index => $listCriteria): ?>
                <li>
                  <div class="criteria-item">
                    <?php echo htmlspecialchars($listCriteria['criteria']); ?>
                    <div>
                      <?php for ($i = 1; $i <= 4; $i++): ?>
                        <label>
                          <input type="radio" name="rating[<?php echo $criteria; ?>][<?php echo $index; ?>]" value="<?php echo $i; ?>">
                          <?php echo $i; ?>
                        </label>
                      <?php endfor; ?>
                    </div>
                  </div>
                </li>
              <?php endforeach; ?>
            </ol>
          <?php else: ?>
            <div>No Criteria Available</div>
          <?php endif; ?>
        </div>
        <!-- Textarea for comments -->
        <textarea id="comment" name="comment[<?php echo $currentTeacher['teacher_name']; ?>]" rows="5" cols="50" placeholder="Type your comment here..."></textarea>
        <p id="letterCount">Letter Count: 0 / 50</p>
        <p id="charLimitWarning" style="display: none;">You have reached the maximum character limit!</p>
        <button id="submitComment" type="submit" name="submit">Submit Evaluation</button>
      </form>
    </main>
  </div>

  <script>
    const offensiveWords = ['badword1', 'badword2', 'badword3', 'b a d w o r d 1']; // Replace with actual offensive words
    const maxLetters = 50;

    const commentInput = document.getElementById('comment');
    const letterCountDisplay = document.getElementById('letterCount');
    const charLimitWarning = document.getElementById('charLimitWarning');
    const submitButton = document.getElementById('submitComment');
    const filteredCommentDisplay = document.getElementById('filteredComment');

    function sanitizeInput(input) {
      return input.replace(/[^a-zA-Z0-9\s.,]/g, ''); // Remove special characters but keep letters, numbers, and whitespace
    }

    commentInput.addEventListener('input', () => {
      let text = sanitizeInput(commentInput.value);
      const letterCount = text.length;
      letterCountDisplay.textContent = `Letter Count: ${letterCount} / ${maxLetters}`;

      // example
      if (letterCount <= maxLetters) {
        charLimitWarning.style.display = 'none';
        letterCountDisplay.style.color = 'black';

        commentInput.value = text.substring(0, maxLetters); // Trim text to maxLetters
        submitButton.disabled = null;
      } else {
        charLimitWarning.style.display = 'block';
        letterCountDisplay.style.color = 'red';
        // alert('You have reached the maximum character limit!');
        submitButton.disabled = true;
      }
    });

    submitButton.addEventListener('click', () => {
      let comment = commentInput.value;

      if (comment.length > maxLetters) {
        filteredCommentDisplay.textContent = `Comment is too long. Maximum allowed characters: ${maxLetters}`;
        return;
      }

      let isOffensive = offensiveWords.some(word => comment.toLowerCase().includes(word) || comment.toUpperCase().includes(word));
      if (isOffensive) {
        filteredCommentDisplay.textContent = 'Comment contains offensive words and cannot be displayed.';
      } else {
        filteredCommentDisplay.textContent = `Your comment: ${comment}`;
      }
    });
  </script>


</body>

</html>

<?php
// Close database connection
$conn->close();
?>