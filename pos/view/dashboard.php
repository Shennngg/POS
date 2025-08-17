<?php
session_start();

// ✅ Protect page (only allow logged-in admin)
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: url('1.png') no-repeat center center fixed;
      background-size: cover;
      color: white;
    }
    .sidebar {
      height: 100vh;
      background-color: rgba(52, 58, 64, 0.85);
      color: white;
      padding-top: 20px;
    }
    .sidebar a {
      color: white;
      display: block;
      padding: 10px 15px;
      text-decoration: none;
    }
    .sidebar a:hover {
      background-color: #495057;
      border-radius: 5px;
    }
    .content {
      padding: 20px;
      background-color: rgba(255, 255, 255, 0.85);
      color: #000;
      border-radius: 10px;
      margin: 20px;
    }
    .card {
      border-radius: 12px;
    }
    .logo {
      display: block;
      margin: 0 auto 20px auto;
      width: 100px;
    }
  </style>
</head>
<body>
<div class="container-fluid">
  <div class="row">
    <!-- Sidebar -->
    <nav class="col-md-2 sidebar text-center">
      <img src="logo.png" class="logo" alt="Logo">
      <h4>Admin Panel</h4>
      <a href="../view/trans.php" class="btn btn-primary">📦 Manage Transactions</a>
      <a href="#">👥 Manage Users</a>
      <a href="#">📦 Transactions</a>
      <a href="#">⚙️ Settings</a>
      <a href="../index.php" class="text-danger">🚪 Logout</a>
    </nav>

    <!-- Main Content -->
    <main class="col-md-10">
      <div class="content">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h2>Welcome, <?php echo $_SESSION['email']; ?> 👋</h2>
          <span class="badge bg-success">Admin</span>
        </div>

        <div class="row g-3">
          <div class="col-md-4">
            <div class="card text-white bg-primary p-3">
              <h5>Total Users</h5>
              <p class="fs-3">120</p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card text-white bg-success p-3">
              <h5>Transactions</h5>
              <p class="fs-3">350</p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card text-white bg-warning p-3">
              <h5>Revenue</h5>
              <p class="fs-3">$12,500</p>
            </div>
          </div>
        </div>

        <div class="mt-4">
          <div class="card">
            <div class="card-header">Recent Activity</div>
            <div class="card-body">
              <ul>
                <li>User John registered</li>
                <li>Transaction #102 completed</li>
                <li>Admin updated system settings</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</div>
</body>
</html>
