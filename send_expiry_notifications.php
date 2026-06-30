<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

include "config.php";
$user_id = $_SESSION["user_id"];
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require __DIR__ . '/vendor/autoload.php';

// Fetch expiring bus passes and user emails
$expiring_passes_query = $conn->query("
    SELECT u.email, u.name, bp.valid_until 
    FROM bus_pass bp
    JOIN users u ON bp.user_id = u.id
    WHERE bp.status = 'approved'
    AND bp.valid_until <= DATE_ADD(CURDATE(), INTERVAL 5 DAY)
");

while ($row = $expiring_passes_query->fetch_assoc()) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'tanvishevade25@gmail.com';  // Replace with your email
        $mail->Password = 'uwrw fxiv wvbv pets';  // Replace with App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('tanvishevade25@gmail..com', 'Bus Pass System');
        $mail->addAddress($row["email"], $row["name"]);

        $mail->isHTML(true);
        $mail->Subject = 'Bus Pass Expiry Reminder';
        $mail->Body = "
            <h3>Dear {$row['name']},</h3>
            <p>Your bus pass will expire on <strong>{$row['valid_until']}</strong>.</p>
            <p>Please renew your pass soon to avoid any inconvenience.</p>
            <p><a href='http://yourwebsite.com/renew_pass.php'>Renew Now</a></p>
        ";

        $mail->send();
    } catch (Exception $e) {
        echo "Failed to send email: {$mail->ErrorInfo}";
    }
}
?>