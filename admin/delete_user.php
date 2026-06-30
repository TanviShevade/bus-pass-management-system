<?php
session_start();
if (!isset($_SESSION["admin_logged_in"]) || $_SESSION["admin_logged_in"] !== true) {
    header("Location: admin_login.php");
    exit();
}

include "../config.php"; // Database connection

// Ensure the 'id' parameter is present
if (isset($_GET["id"])) {
    $user_id = intval($_GET["id"]); // Sanitize input

    // Step 1: Delete related records in dependent tables (if any)
    $delete_payments_query = "DELETE FROM payments WHERE user_id = ?";
    $stmt1 = $conn->prepare($delete_payments_query);
    $stmt1->bind_param("i", $user_id);
    $stmt1->execute();
    $stmt1->close();

    // Step 2: Delete the user record
    $delete_user_query = "DELETE FROM users WHERE id = ?";
    $stmt2 = $conn->prepare($delete_user_query);

    if (!$stmt2) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt2->bind_param("i", $user_id);
    if ($stmt2->execute()) {
        echo "<script>alert('User deleted successfully.'); window.location.href='admin_users.php';</script>";
    } else {
        echo "<script>alert('Error deleting user: " . $stmt2->error . "');</script>";
    }

    $stmt2->close();
} else {
    echo "<script>alert('Invalid request.'); window.location.href='admin_users.php';</script>";
}
?>
