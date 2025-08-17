<?php
include("../action/connection/connection.php");

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid transaction ID");
}

$id = (int) $_GET['id'];

// ✅ Fetch transaction safely
$stmt = $conn->prepare("SELECT * FROM transactions WHERE transaction_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$transaction = $result->fetch_assoc();

if (!$transaction) {
    die("Transaction not found");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $amount = $_POST['amount'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE transactions SET amount = ?, payment_status = ? WHERE transaction_id = ?");
    $stmt->bind_param("dsi", $amount, $status, $id);

    if ($stmt->execute()) {
        header("Location: trans.php");
        exit; // ✅ stop script after redirect
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Transaction</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #f4f6f9;
      font-family: Arial, sans-serif;
    }
    .container {
      margin-top: 60px;
      max-width: 600px;
    }
    .card {
      border-radius: 12px;
      box-shadow: 0px 4px 12px rgba(0,0,0,0.1);
    }
    .card-header {
      background: #004aad;
      color: white;
      font-weight: bold;
      text-align: center;
      border-radius: 12px 12px 0 0;
    }
    .btn-primary {
      background: #004aad;
      border: none;
      border-radius: 8px;
      font-weight: 500;
    }
    .btn-secondary {
      border-radius: 8px;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="card">
      <div class="card-header">
        ✏️ Edit Transaction #<?= $transaction['transaction_id'] ?>
      </div>
      <div class="card-body">
        <form method="post">
          <div class="mb-3">
            <label class="form-label">Amount</label>
            <input type="number" step="0.01" name="amount" value="<?= $transaction['amount'] ?>" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
              <option value="pending" <?= $transaction['payment_status']=='pending'?'selected':'' ?>>Pending</option>
              <option value="paid" <?= $transaction['payment_status']=='paid'?'selected':'' ?>>Paid</option>
              <option value="cancelled" <?= $transaction['payment_status']=='cancelled'?'selected':'' ?>>Cancelled</option>
            </select>
          </div>

          <div class="d-flex justify-content-between">
            <a href="trans.php" class="btn btn-secondary">⬅ Back</a>
            <button type="submit" class="btn btn-primary">💾 Update</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
