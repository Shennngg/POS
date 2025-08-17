<?php
include("../action/connection/connection.php");

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid transaction ID.");
}

$id = (int)$_GET['id'];

$stmt = $conn->prepare("DELETE FROM transactions WHERE transaction_id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: trans.php?msg=deleted");
    exit;
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
