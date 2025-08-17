<?php
session_start();
include("../action/connection/connection.php");

// ✅ Protect page: only logged-in users can view
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../index.php");
    exit;
}

$sql = "SELECT t.transaction_id, s.full_name AS student, u.username AS cashier, 
               t.amount, t.payment_date, t.payment_status
        FROM transactions t
        JOIN students s ON t.student_id = s.student_id
        JOIN users u ON t.cashier_id = u.user_id";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Transactions</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      height: 100vh;
      background: url("2.png") no-repeat center center fixed;
      background-size: cover;
    }
    .container {
      max-width: 1000px;
      margin: 40px auto;
      background: rgba(255, 255, 255, 0.9);
      border-radius: 20px;
      box-shadow: 0 6px 15px rgba(0,0,0,0.3);
      padding: 30px;
    }
    .header {
      text-align: center;
      margin-bottom: 20px;
    }
    .header img {
      width: 120px;
      display: block;
      margin: 0 auto 10px;
    }
    .header h2 {
      margin: 0;
      color: #6a0dad;
    }
    .top-nav {
      text-align: right;
      margin-bottom: 15px;
    }
    .top-nav a {
      text-decoration: none;
      padding: 8px 15px;
      background: #6a0dad;
      color: white;
      border-radius: 6px;
      transition: 0.3s;
    }
    .top-nav a:hover {
      background: #4a0b8c;
    }
    a.add-btn {
      display: inline-block;
      background: #ffcc00;
      color: #000;
      font-weight: bold;
      padding: 10px 20px;
      border-radius: 8px;
      text-decoration: none;
      transition: 0.3s;
      margin-bottom: 15px;
    }
    a.add-btn:hover {
      background: #6a0dad;
      color: #fff;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
    }
    table th, table td {
      padding: 12px;
      text-align: center;
      border-bottom: 1px solid #ddd;
    }
    table th {
      background: #6a0dad;
      color: #fff;
    }
    table tr:hover {
      background: #f1f1f1;
    }
    .action-links a {
      text-decoration: none;
      padding: 6px 12px;
      border-radius: 6px;
      font-size: 14px;
      transition: 0.3s;
    }
    .action-links a:first-child {
      background: #4CAF50;
      color: white;
    }
    .action-links a:first-child:hover {
      background: #45a049;
    }
    .action-links a:last-child {
      background: #f44336;
      color: white;
    }
    .action-links a:last-child:hover {
      background: #d32f2f;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <!-- NCST logo on top -->
      <img src="logo.png" alt="NCST Logo">
      <h2>Transactions</h2>
    </div>

    <div class="top-nav">
      <a href="../view/dashboard.php">🏠 Dashboard</a>
      <a href="../index.php" class="text-danger">🚪 Logout</a>
    </div>

    <a href="create_trans.php" class="add-btn">➕ Add Transaction</a>

    <table>
      <tr>
        <th>ID</th>
        <th>Student</th>
        <th>Cashier</th>
        <th>Amount</th>
        <th>Date</th>
        <th>Status</th>
        <th>Action</th>
      </tr>


      <?php 
      if ($result && $result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) { ?>
            <tr>
              <td><?= $row['transaction_id']; ?></td>
              <td><?= $row['student']; ?></td>
              <td><?= $row['cashier']; ?></td>
              <td>₱<?= number_format($row['amount'], 2); ?></td>
              <td><?= $row['payment_date']; ?></td>
              <td><?= ucfirst($row['payment_status']); ?></td>
              <td class="action-links">
                <a href="edit_trans.php?id=<?= $row['transaction_id']; ?>">✏ Edit</a>
                <a href="clear_trans.php?id=<?= $row['transaction_id']; ?>" 
                   onclick="return confirm('Delete this transaction?')">🗑 Delete</a>
              </td>
            </tr>
      <?php 
          } 
      } else { ?>
          <tr><td colspan="7">No transactions found</td></tr>
      <?php } ?>
    </table>
  </div>
  
</body>
</html>
