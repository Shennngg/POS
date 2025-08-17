<?php
session_start();
$error = '';
if (isset($_SESSION['login_error'])) {
    $error = $_SESSION['login_error'];
    unset($_SESSION['login_error']);
}
$success = '';
if (isset($_SESSION['login_success'])) {
    $success = $_SESSION['login_success'];
    unset($_SESSION['login_success']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login Form</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: url('./3.png') no-repeat center center fixed;
      background-size: cover;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Poppins', sans-serif;
    }
    .login-form {
      background: rgba(255, 255, 255, 0.9);
      padding: 30px;
      border-radius: 20px;
      box-shadow: 0px 6px 20px rgba(0,0,0,0.1);
      width: 100%;
      max-width: 380px;
      text-align: center;
      animation: popIn 0.5s ease-in-out;
    }
    .login-form h2 {
      font-weight: 700;
      color: #002b5c;
      margin-bottom: 20px;
    }
    .form-control {
      border-radius: 10px;
      border: 1px solid #ccc;
    }
    .form-label {
      font-weight: 500;
      color: #333;
    }
    .btn-primary {
      background-color: #002b5c;
      border: none;
      border-radius: 15px;
      font-weight: bold;
      transition: all 0.3s ease;
    }
    .btn-primary:hover {
      background-color: #004080;
      transform: translateY(-2px);
    }
    a {
      color: #ffcc00;
      text-decoration: none;
    }
    a:hover {
      text-decoration: underline;
    }
    @keyframes popIn {
      from { opacity: 0; transform: scale(0.9); }
      to { opacity: 1; transform: scale(1); }
    }
  </style>
</head>
<body>
  <div class="login-form">
    <img src="view/logo.png" class="logo" alt="Logo">
    <h2>Welcome </h2>
    <form action="./action/login.php" method="post">
      <div class="mb-3 text-start">
        <label for="email" class="form-label">Email</label>
        <input type="text" class="form-control" name="email" id="email" required>
      </div>
      <div class="mb-3 text-start">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" name="password" id="password" minlength="8" required>
        <div class="form-text">Password must be at least 8 characters long.</div>
      </div>
      <p class="mt-2">Don't have an account? <a href="./view/create-account.php">Sign up</a></p>
      <div class="d-grid">
        <input type="submit" class="btn btn-primary">
      </div>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const error = <?php echo json_encode($error); ?>;
      const success = <?php echo json_encode($success); ?>;

      if (error === 'invalid_password') {
        alert('Invalid Password: Please check your password and try again.');
      }
      if (error === 'user_not_found') {
        alert('User Not Found: No account found with that email.');
      }
      if (success) {
        document.getElementById('successMessage').textContent = success;
        const successModal = new bootstrap.Modal(document.getElementById('successModal'));
        successModal.show();
        document.getElementById('proceedBtn').addEventListener('click', () => {
          window.location.href = '../pos/view/user.php';
        });
      }
    });
  </script>
</body>
</html>
