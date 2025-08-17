<?php
include "connection/connection.php";
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// Sanitize input
$student_id = trim($_POST['student_id'] ?? '');
$name       = trim($_POST['name'] ?? '');
$course     = trim($_POST['course'] ?? '');
$year_level = trim($_POST['year_level'] ?? '');

$messages = [];

if (empty($student_id) || empty($name) || empty($course) || empty($year_level)) {
    $messages[] = "❌ Please fill in all fields.";
} else {
    try {
        // Check if student already exists
        $stmt = $conn->prepare("SELECT eligibility FROM students WHERE student_id = ?");
        $stmt->bind_param("s", $student_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {  
            $row = $result->fetch_assoc();
            if ((int)$row['eligibility'] === 0) {
                $messages[] = "❌ Student is not eligible to enroll.";
            } else {
                // Update student info with year level
                $stmt = $conn->prepare("UPDATE students SET name=?, course=?, year_level=? WHERE student_id=?");
                $stmt->bind_param("ssss", $name, $course, $year_level, $student_id);
                $stmt->execute();
                $messages[] = "✅ Student information updated successfully.";
            }
        } else {
            // Insert new student
            $stmt = $conn->prepare("INSERT INTO students (student_id, name, course, year_level, eligibility) VALUES (?, ?, ?, ?, 1)");
            $stmt->bind_param("ssss", $student_id, $name, $course, $year_level);
            $stmt->execute();
            $messages[] = "✅ New student enrolled successfully.";
        }

    } catch (Exception $e) {
        $messages[] = "❌ Error: " . $e->getMessage();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Student Enrollment Form</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <style>
    body {
      background: #f8f9fa;
    }
    .card {
      border-radius: 1rem;
    }
  </style>
</head>
<body class="d-flex align-items-center justify-content-center vh-100">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card shadow-lg p-4">
          <h2 class="text-center mb-4">Student Enrollment</h2>
          <?php foreach ($messages as $msg): ?>
        <div class="alert alert-info"><?= htmlspecialchars($msg) ?></div>
      <?php endforeach; ?>
          <form action="../view/dashboard.php" method="POST">
            <!-- Student ID -->
            <div class="mb-3">
              <label for="student_id" class="form-label">Student ID</label>
              <input type="text" class="form-control" id="student_id" name="student_id" required>
            </div>

            <!-- Name -->
            <div class="mb-3">
              <label for="name" class="form-label">Full Name</label>
              <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <!-- Course -->
            <div class="mb-3">
              <label for="course" class="form-label">Course</label>
              <input type="text" class="form-control" id="course" name="course" required>
            </div>

            <!-- Year Level -->
            <div class="mb-3">
              <label for="year_level" class="form-label">Year Level</label>
              <select class="form-select" id="year_level" name="year_level" required>
                <option value="">Select year level</option>
                <option value="1st Year">1st Year</option>
                <option value="2nd Year">2nd Year</option>
                <option value="3rd Year">3rd Year</option>
                <option value="4th Year">4th Year</option>
              </select>
            </div>

            <!-- Submit -->
            <div class="d-grid">
              <button type="submit" class="btn btn-primary btn-lg">Enroll Student</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
