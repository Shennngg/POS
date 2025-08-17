<?php 
include "connection/connection.php";
session_start();

  if (isset($_SESSION['login_error'])) {
        echo '<div class="message error">';
        if ($_SESSION['login_error'] === 'invalid_password') echo 'Incorrect password!';
        if ($_SESSION['login_error'] === 'user_not_found') echo 'User not found!';
        echo '</div>';
        unset($_SESSION['login_error']);
    }

    if (isset($_SESSION['login_success'])) {
        echo '<div class="message success">'.$_SESSION['login_success'].'</div>';
        unset($_SESSION['login_success']);
    }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
     $email = $_POST["email"];
    $password = $_POST["password"];

    // Build query
    $query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";

    // Run query
    $result = mysqli_query($conn, $query);

   
    // ✅ Now check number of rows
    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        $hashed_password = $row['password'];
        $role = $row['role'];

        if ($password === $hashed_password) { // Not secure for production
            $_SESSION["loggedin"] = true;
            $_SESSION["role"] = $role;
            $_SESSION['login_success'] = 'Login successful!';
            $_SESSION["email"] = $email;
         
            // Dashboard
            if ($role === 'admin') {
                header("Location: ../view/dashboard.php");
            } else {
                header("Location: ../view/user.php");
            }
            exit;
         
            header("Location: ../index.php");
            exit;
        } else {
                    $_SESSION['login_error'] = 'invalid_password';
                    header("Location: ../index.php");
                    exit;
        }
    } else {
         $_SESSION['login_error'] = 'user_not_found';
    header("Location: ../index.php");
    exit;
    }

    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login | My System</title>
<style>
    /* Reset */
    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
        font-family: 'Poppins', sans-serif;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        background: linear-gradient(to right, #ffecd2, #fcb69f);
    }

    .login-container {
        background: #fff;
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        width: 350px;
        text-align: center;
    }

    .login-container h2 {
        color: #ff6f61;
        margin-bottom: 25px;
        font-size: 28px;
    }

    .login-container input {
        width: 100%;
        padding: 12px 15px;
        margin: 10px 0;
        border-radius: 12px;
        border: 1px solid #ccc;
        outline: none;
        transition: all 0.3s;
    }

    .login-container input:focus {
        border-color: #ff6f61;
        box-shadow: 0 0 5px #ff6f61;
    }

    .login-container button {
        width: 100%;
        padding: 12px;
        margin-top: 15px;
        background: #ff6f61;
        border: none;
        color: #fff;
        border-radius: 12px;
        font-size: 16px;
        cursor: pointer;
        transition: background 0.3s;
    }

    .login-container button:hover {
        background: #ff3b2e;
    }

    .message {
        margin: 15px 0;
        padding: 10px;
        border-radius: 10px;
        font-size: 14px;
    }

    .error {
        background: #ffe5e5;
        color: #ff3b2e;
    }

    .success {
        background: #e5ffe5;
        color: #28a745;
    }

    .login-container p {
        margin-top: 20px;
        font-size: 14px;
        color: #555;
    }

    .login-container p a {
        color: #ff6f61;
        text-decoration: none;
        font-weight: 500;
    }

    .login-container p a:hover {
        text-decoration: underline;
    }
</style>
</head>
<body>

<div class="login-container">
    <h2>Welcome Back!</h2>

    <!-- Display session messages -->

    <!-- Login Form -->
    <form action="registrar_records.php" method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>

    <p>Don't have an account? <a href="registrar_records.php">Sign Up</a></p>
</div>

</body>
</html>
