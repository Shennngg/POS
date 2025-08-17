<?php
// Handle only POST requests
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Invalid request method.");
}

// Validate input fields
$studentName = trim($_POST["studentName"] ?? '');
$paymentMethod = trim($_POST["paymentMethod"] ?? '');

if (empty($studentName) || empty($paymentMethod)) {
    die("<h3 style='color:red'>❌ Missing student name or payment method.</h3><a href='javascript:history.back()'>Go Back</a>");
}

// Validate file upload
if (!isset($_FILES["paymentProof"]) || $_FILES["paymentProof"]["error"] !== UPLOAD_ERR_OK) {
    die("<h3 style='color:red'>❌ Payment proof not uploaded or error occurred.</h3><a href='javascript:history.back()'>Go Back</a>");
}

// File handling
$allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
$fileType = mime_content_type($_FILES["paymentProof"]["tmp_name"]);
$fileName = basename($_FILES["paymentProof"]["name"]);
$uploadDir = "uploads/";
$targetPath = $uploadDir . time() . "_" . $fileName;

if (!in_array($fileType, $allowedTypes)) {
    die("<h3 style='color:red'>❌ Invalid file type. Only JPG, PNG, or PDF allowed.</h3><a href='javascript:history.back()'>Go Back</a>");
}

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

if (!move_uploaded_file($_FILES["paymentProof"]["tmp_name"], $targetPath)) {
    die("<h3 style='color:red'>❌ Failed to upload payment proof.</h3><a href='javascript:history.back()'>Go Back</a>");
}

// You can insert DB record here (optional)

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Payment Confirmation</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <div class="card shadow-lg p-4">
      <h2 class="text-success">✅ Payment Received!</h2>
      <p><strong>Student Name:</strong> <?= htmlspecialchars($studentName) ?></p>
      <p><strong>Payment Method:</strong> <?= htmlspecialchars($paymentMethod) ?></p>
      <p><strong>Proof Uploaded:</strong> <?= htmlspecialchars(basename($targetPath)) ?></p>
      <a href="index.php" class="btn btn-primary mt-3">Back to Home</a>
    </div>
  </div>
</body>
</html>
