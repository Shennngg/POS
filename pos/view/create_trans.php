<?php
include("../action/connection/connection.php");

// Fetch students and cashiers for dropdowns
$students = $conn->query("SELECT student_id, full_name FROM students");
$cashiers = $conn->query("SELECT user_id, username FROM users WHERE role='cashier'");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];
    $cashier_id = $_POST['cashier_id'];
    $amount     = $_POST['amount'];
    $status     = $_POST['status'];

    $stmt = $conn->prepare("INSERT INTO transactions (student_id, cashier_id, amount, payment_status) 
                            VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iids", $student_id, $cashier_id, $amount, $status);

    if ($stmt->execute()) {
        header("Location: trans.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Transaction</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: linear-gradient(to bottom, #6a0dad, #ffcc00);
      height: 100vh;
      margin: 0;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .card {
      background: #fff;
      border-radius: 20px;
      box-shadow: 0 6px 15px rgba(0,0,0,0.2);
      padding: 30px;
      width: 400px;
      text-align: center;
    }
    .card h2 {
      color: #6a0dad;
      margin-bottom: 20px;
    }
    select, input, button {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border-radius: 8px;
      border: 1px solid #ccc;
      font-size: 16px;
    }
    button {
      background: #ffcc00;
      color: #000;
      font-weight: bold;
      cursor: pointer;
      transition: 0.3s;
    }
    button:hover {
      background: #6a0dad;
      color: #fff;
    }
    label {
      font-weight: bold;
      display: block;
      text-align: left;
      margin-top: 10px;
      color: #333;
    }
  </style>
</head>
<body>
  <div class="card">
    <h2>Add Transaction</h2>
    <form method="post">
      <label for="student">Student</label>
      <select name="student_id" required>
        <?php while($s = $students->fetch_assoc()) { ?>
          <option value="<?= $s['student_id'] ?>"><?= $s['full_name'] ?></option>
        <?php } ?>
      </select>

      <label for="cashier">Cashier</label>
      <select name="cashier_id" required>
        <?php while($c = $cashiers->fetch_assoc()) { ?>
          <option value="<?= $c['user_id'] ?>"><?= $c['username'] ?></option>
        <?php } ?>
      </select>

      <label for="amount">Amount</label>
      <input type="number" step="0.01" name="amount" required>

      <label for="status">Status</label>
      <select name="status">
        <option value="pending">Pending</option>
        <option value="paid">Paid</option>
        <option value="cancelled">Cancelled</option>
      </select>

      <button type="submit">💾 Save Transaction</button>
    </form>
  </div>
</body>
</html>
