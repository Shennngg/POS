<?php
session_start();
$error = '';
if (isset($_SESSION['failed'])) {
    $error = $_SESSION['failed'];
    unset($_SESSION['failed']);
}
$success = '';
if (isset($_SESSION['success'])) {
    $success = $_SESSION['success'];
    unset($_SESSION['success']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Create Account</title>

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: url("3.png") no-repeat center center fixed;
      background-size: cover;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }
    .login-form {
      background: rgba(255, 255, 255, 0.92);
      padding: 2rem;
      border-radius: 20px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.2);
      width: 100%;
      max-width: 420px;
      animation: popIn 0.6s ease;
      text-align: center;
    }
    .login-form img {
      width: 120px;
      margin-bottom: 15px;
    }
    .login-form h2 {
      color: #004aad;
      margin-bottom: 1.5rem;
      font-weight: bold;
    }
    .form-control {
      border-radius: 12px;
      padding: 10px;
    }
    .btn-primary {
      background: #004aad;
      border: none;
      border-radius: 12px;
      transition: all 0.3s ease;
      font-weight: bold;
      padding: 10px;
    }
    .btn-primary:hover {
      background: #0077b6;
      transform: scale(1.05);
    }
    @keyframes popIn {
      0% { transform: scale(0.9); opacity: 0; }
      100% { transform: scale(1); opacity: 1; }
    }
  </style>
</head>
<body>

  <div class="login-form">
    <!-- NCST Logo -->
    <img src="logo.png" alt="NCST Logo">
    <h2>Create Account</h2>

    <form action="../action/submit-account.php" method="POST">
      <div class="mb-3 text-start">
        <label for="email" class="form-label">Email:</label>
        <input type="email" id="email" name="email" class="form-control" required />
      </div>

      <div class="mb-3 text-start">
        <label for="password" class="form-label">Password:</label>
        <input 
          type="password" 
          id="password" 
          name="password" 
          class="form-control" 
          minlength="8" 
          required 
          placeholder="At least 8 characters" 
        />
      </div>

      <button type="submit" class="btn btn-primary w-100">Submit</button>
    </form>
  </div>

  <!-- Bootstrap Bundle JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const error = "<?php echo $error; ?>";
    const success = "<?php echo $success; ?>";

    if (error === 'added not successful!') {
      Swal.fire({
        icon: 'error',
        title: 'Invalid Password',
        text: 'Please check your password and try again.'
      });
    }

    if (success) {
      Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: success,
        timer: 2000,
        showConfirmButton: false
      }).then(() => {
        window.location.href = '../index.php';
      });
    }
  });

  document.querySelector('form').addEventListener('submit', function(e) {
    const password = document.getElementById('password').value.trim();
    if (password.length < 8) {
      e.preventDefault();
      Swal.fire({
        icon: 'error',
        title: 'Password Too Short',
        text: 'Your password must be at least 8 characters long.'
      });
    }
  });
</script>

</body>
</html>
