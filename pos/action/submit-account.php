<?php
// Include database connection
include "connection/connection.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form inputs
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Hash the password for security

    // Prepare and execute the insert query using MySQLi
    $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");

    if ($stmt) {
        $stmt->bind_param("ss", $email, $password);

        if ($stmt->execute()) {
            $_SESSION['success'] = 'Account created successfully!';
            header("Location: ../view/create-account.php");
            exit;
        } else {
            $_SESSION['failed'] = 'Account creation failed!';
            header("Location: ../view/create-account.php");
            exit;
        }
    } else {
        // Error preparing the statement
        $_SESSION['failed'] = 'Database error!';
        header("Location: ../view/create-account.php");
        exit;
    }
}
?>
