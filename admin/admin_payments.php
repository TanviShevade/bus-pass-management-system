<?php
session_start(); // Ensure session is started

// Correct session variable check
if (!isset($_SESSION["admin_id"])) {
    header("Location: admin_login.php"); // Redirect if not logged in
    exit();
}

include "../config.php"; // Ensure correct database connection 

// Fetch payment records
$payments = $conn->query("SELECT * FROM payments ORDER BY payment_date DESC");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Payments - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
       <h2>Manage Payment</h2>
        <a href="admin_dashboard.php" class="btn btn-warning">Back to Dashboard</a>
    </div>
    <?php if ($payments->num_rows > 0): ?>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Transaction ID</th>
                    <th>User ID</th>
                    <th>Amount (₹)</th>
                    <th>Payment Status</th>
                    <th>Payment Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($payment = $payments->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($payment["transaction_id"]) ?></td>
                    <td><?= htmlspecialchars($payment["user_id"]) ?></td>
                    <td>₹<?= number_format($payment["amount"], 2) ?></td>
                    <td>
                        <span class="badge bg-<?= $payment["payment_status"] == "paid" ? "success" : "danger" ?>">
                            <?= ucfirst($payment["payment_status"]) ?>
                        </span>
                    </td>
                    <td><?= date("d M Y, H:i", strtotime($payment["payment_date"])) ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
        <div class="alert alert-warning text-center">No payments found.</div>
    <?php endif; ?>

</div>

</body>
</html>
