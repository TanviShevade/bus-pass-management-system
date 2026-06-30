<?php
session_start();
include "config.php"; // Database connection

// Load PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php'; // Load PHPMailer from Composer

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

// Validate form input
if (!isset($_POST["bus_pass_id"], $_POST["final_paid_amount"], $_POST["payment_method"])) {
    echo "<script>alert('Invalid request. Please try again.'); window.location.href='dashboard.php';</script>";
    exit();
}

$bus_pass_id = intval($_POST["bus_pass_id"]);
$final_paid_amount = floatval($_POST["final_paid_amount"]);
$payment_method = htmlspecialchars($_POST["payment_method"]);
$transaction_id = "TXN" . uniqid() . rand(1000, 9999);
$payment_status = "Completed";

// Fetch User Details
$query_user = "SELECT name, email FROM users WHERE id = ?";
$stmt_user = $conn->prepare($query_user);
$stmt_user->bind_param("i", $user_id);
$stmt_user->execute();
$result_user = $stmt_user->get_result();
$user = $result_user->fetch_assoc();

$name = $user["name"];
$email = $user["email"];

$conn->begin_transaction();

try {
    // Insert Payment Record
    $query = "INSERT INTO payments (user_id, bus_pass_id, amount, payment_method, transaction_id, payment_date, payment_status) 
              VALUES (?, ?, ?, ?, ?, NOW(), ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iidsss", $user_id, $bus_pass_id, $final_paid_amount, $payment_method, $transaction_id, $payment_status);
    
    if (!$stmt->execute()) {
        throw new Exception("Failed to insert payment record.");
    }

    // Update Bus Pass Status
    $update_query = "UPDATE bus_pass SET payment_status = 'Paid' WHERE id = ? AND user_id = ?";
    $stmt2 = $conn->prepare($update_query);
    $stmt2->bind_param("ii", $bus_pass_id, $user_id);

    if (!$stmt2->execute()) {
        throw new Exception("Failed to update bus pass status.");
    }

    // Send Email with Receipt
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // Your SMTP server
    $mail->SMTPAuth = true;
    $mail->Username = 'tanvishevade25@gmail.com'; // Use an App Password
    $mail->Password = 'uwrw fxiv wvbv pets'; // Replace with your App Password
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('tanvishevade25@gmail.com', 'Bus Pass System');
    $mail->addAddress($email);
    $mail->Subject = "Payment Receipt - Transaction ID: $transaction_id";
    $mail->Body = "Dear $name,\n\nYour payment of ₹$final_paid_amount has been successfully processed.\n\nTransaction ID: $transaction_id\n\nThank you!";

    if (!$mail->send()) {
        throw new Exception("Email could not be sent. Mailer Error: " . $mail->ErrorInfo);
    }

    // ✅ Commit transaction
    $conn->commit();
    echo "<script>alert('Payment Successful!'); window.location.href='dashboard.php';</script>";

} catch (Exception $e) {
    // ❌ Rollback on error
    $conn->rollback();
    echo "<script>alert('Payment failed: " . addslashes($e->getMessage()) . "'); window.location.href='make_payment.php';</script>";
}

?>
