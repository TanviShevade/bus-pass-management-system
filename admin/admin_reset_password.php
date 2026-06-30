<?php
session_start();
include "config.php";  // Ensure correct database connection
if (!isset($_SESSION["reset_otp"]) || !isset($_SESSION["reset_email"])) {
    header("Location: admin_forgot_password.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $otp = $_POST["otp"];
    $new_password = $_POST["password"];
    $email = $_SESSION["reset_email"];

    if ($otp == $_SESSION["reset_otp"]) {
        // Update password in the database
        $stmt = $conn->prepare("UPDATE users SET password=? WHERE email=?");
        $stmt->bind_param("ss", $new_password, $email);
        $stmt->execute();

        // Clear session variables
        unset($_SESSION["reset_otp"]);
        unset($_SESSION["reset_email"]);

        echo "<script>alert('Password reset successfully! Please login.'); window.location='login.php';</script>";
    } else {
        echo "<script>alert('Invalid OTP!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center text-success">Reset Your Password</h2>
        <form method="POST" class="shadow p-4 bg-white">
            <div class="mb-3">
                <label class="form-label">Enter OTP:</label>
                <input type="number" name="otp" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">New Password:</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success w-100">Reset Password</button>
        </form>
    </div>
</body>
</html>



