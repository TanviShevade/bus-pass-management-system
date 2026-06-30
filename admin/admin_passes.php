<?php
session_start();
if (!isset($_SESSION["admin_logged_in"]) || $_SESSION["admin_logged_in"] !== true) {
    header("Location: admin_login.php");
    exit();
}

include "../config.php"; // Database connection

// Include PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../vendor/autoload.php'; // Ensure correct path to autoload.php


// Handle delete request
if (isset($_POST["delete_id"])) {
    $delete_id = intval($_POST["delete_id"]); // Sanitize input

    // Step 1: Delete related records from payments table first
    $delete_payments_query = "DELETE FROM payments WHERE bus_pass_id = ?";
    $stmt1 = $conn->prepare($delete_payments_query);
    
    if ($stmt1 === false) {
        die("Prepare failed (payments): " . $conn->error); // Debugging
    }

    $stmt1->bind_param("i", $delete_id);
    $stmt1->execute();
    $stmt1->close();

    // Step 2: Now delete the actual bus pass
    $delete_query = "DELETE FROM bus_pass WHERE id = ?";
    $stmt = $conn->prepare($delete_query);

    if ($stmt === false) {
        die("Prepare failed: " . $conn->error); // Debugging
    }

    $stmt->bind_param("i", $delete_id);
    if ($stmt->execute()) {
        echo "<script>alert('Bus pass deleted successfully.'); window.location.href='admin_passes.php';</script>";
    } else {
        echo "<script>alert('Error deleting bus pass: " . $stmt->error . "');</script>";
    }
    $stmt->close();
}

// Handle Approve Request
if (isset($_POST["approve_id"])) {
    $approve_id = intval($_POST["approve_id"]); // Sanitize input

    // Update bus pass status in the database
    $approve_query = "UPDATE bus_pass SET status = 'approved' WHERE id = ?";
    $stmt = $conn->prepare($approve_query);
    $stmt->bind_param("i", $approve_id);
    
    if ($stmt->execute()) {
        // Fetch User Email
        $user_query = "SELECT u.email, u.name FROM users u JOIN bus_pass bp ON u.id = bp.user_id WHERE bp.id = ?";
        $stmt_user = $conn->prepare($user_query);
        $stmt_user->bind_param("i", $approve_id);
        $stmt_user->execute();
        $stmt_user->bind_result($user_email, $user_name);
        $stmt_user->fetch();
        $stmt_user->close();

        // Send Email Notification
        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'tanvishevade25@gmail.com'; // Replace with your Gmail
            $mail->Password   = 'uwrw fxiv wvbv pets';    // Replace with App Password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            // Sender & Recipient
            $mail->setFrom('tanvishevade25@gmail.com', 'Bus Pass System');
            $mail->addAddress($user_email, $user_name);

            // Email Content
            $mail->isHTML(true);
            $mail->Subject = 'Bus Pass Approved!';
            $mail->Body    = "<h3>Dear $user_name,</h3><p>Your bus pass has been approved successfully!</p>";

            // Send Email
            $mail->send();
            echo "<script>alert('Bus pass approved and email sent successfully!'); window.location.href='admin_passes.php';</script>";
        } catch (Exception $e) {
            echo "<script>alert('Bus pass approved but email failed: {$mail->ErrorInfo}'); window.location.href='admin_passes.php';</script>";
        }
    } else {
        echo "<script>alert('Error approving bus pass.');</script>";
    }
    $stmt->close();
}



// Fetch bus pass applications along with user and stop details
$query = "
    SELECT 
        bp.id, bp.user_id, bp.pass_type, bp.valid_until, bp.status, 
        u.name AS full_name, u.email, u.user_type, 
        u.institution_name, u.company_name, 
        bp.source_stop, bp.destination_stop
    FROM bus_pass bp 
    JOIN users u ON bp.user_id = u.id;
";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Bus Passes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function confirmDelete(id) {
            if (confirm("Are you sure you want to delete this bus pass?")) {
                document.getElementById("delete_form_" + id).submit();
            }
        }
        
        function confirmApprove(id) {
            if (confirm("Are you sure you want to approve this bus pass?")) {
                document.getElementById("approve_form_" + id).submit();
            }
        }
    </script>
</head>
<body>
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
       <h2>Manage Bus Pass Applications</h2>
        <a href="admin_dashboard.php" class="btn btn-warning">Back to Dashboard</a>
    </div>
    
    <table class="table table-bordered">
        <thead> 
            <tr> 
                <th>ID</th>
                <th>User Name</th>
                <th>Email</th>
                <th>Type</th>
                <th>Source Stop</th>
                <th>Destination Stop</th>
                <th>Valid Until</th>
                <th>Status</th>
                <th>Action</th>
            </tr> 
        </thead> 
        <tbody> 
            <?php while ($row = $result->fetch_assoc()): ?> 
                <tr> 
                    <td><?= $row["id"] ?></td> 
                    <td><?= htmlspecialchars($row["full_name"]) ?></td> 
                    <td><?= htmlspecialchars($row["email"]) ?></td> 
                    <td><?= ucfirst(htmlspecialchars($row["pass_type"])) ?> Months</td> 
                    <td><?= htmlspecialchars($row["source_stop"]) ?></td> 
                    <td><?= htmlspecialchars($row["destination_stop"]) ?></td> 
                    <td><?= htmlspecialchars($row["valid_until"]) ?></td> 
                    <td>
                        <span class="badge bg-<?= ($row["status"] == "approved") ? "success" : "warning" ?>">
                            <?= ucfirst(htmlspecialchars($row["status"])) ?>
                        </span>
                    </td> 
                    <td> 
                        <?php if ($row["status"] !== "approved"): ?>
                        <form id="approve_form_<?= $row['id'] ?>" method="POST" style="display:inline;">
                            <input type="hidden" name="approve_id" value="<?= $row['id'] ?>">
                            <button type="button" class="btn btn-success btn-sm" onclick="confirmApprove(<?= $row['id'] ?>)">Approve</button>
                        </form>
                        <?php endif; ?>

                        <form id="delete_form_<?= $row['id'] ?>" method="POST" style="display:inline;">
                            <input type="hidden" name="delete_id" value="<?= $row['id'] ?>">
                            <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(<?= $row['id'] ?>)">Delete</button>
                        </form>
                    </td> 
                </tr> 
            <?php endwhile; ?> 
        </tbody> 
    </table>
</div>
</body>
</html>
