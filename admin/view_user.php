<?php
session_start();
if (!isset($_SESSION["admin_logged_in"]) || $_SESSION["admin_logged_in"] !== true) {
    header("Location: admin_login.php");
    exit();
}

include "../config.php";

// Fetch all users with their latest bus pass details
$query = "SELECT users.*, bus_pass.source_stop, bus_pass.destination_stop, 
                 bus_pass.pass_type, bus_pass.valid_until, bus_pass.total_fare, 
                 bus_pass.discount_percent, bus_pass.discount_amount, 
                 bus_pass.final_paid_amount, bus_pass.payment_status
          FROM users 
          LEFT JOIN bus_pass ON users.id = bus_pass.user_id 
          ORDER BY users.id DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - View Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
       <h2>Registered Users & Bus Passes</h2>
        <a href="admin_dashboard.php" class="btn btn-warning">Back to Dashboard</a>
    </div>
        <table class="table table-bordered">
            <thead class="table">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>User Type</th>
                    <th>Institution/Company</th>
                    <th>Pass Route</th>
                    <th>Valid Until</th>
                    <th>Fare</th>
                    <th>Discount</th>
                    <th>Final Paid</th>
                    <th>Payment Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $row["id"] ?></td>
                        <td><?= htmlspecialchars($row["name"]) ?></td>
                        <td><?= htmlspecialchars($row["email"]) ?></td>
                        <td><?= ucfirst(htmlspecialchars($row["user_type"])) ?></td>
                        <td><?= $row["user_type"] == "student" ? htmlspecialchars($row["institution_name"]) : htmlspecialchars($row["company_name"]) ?></td>
                        <td><?= htmlspecialchars($row["source_stop"]) ?> → <?= htmlspecialchars($row["destination_stop"]) ?></td>
                        <td><?= $row["valid_until"] ? date("d M Y", strtotime($row["valid_until"])) : "N/A" ?></td>
                        <td>₹<?= number_format($row["total_fare"], 2) ?></td>
                        <td><?= $row["discount_percent"] ?>% (-₹<?= number_format($row["discount_amount"], 2) ?>)</td>
                        <td>₹<?= number_format($row["final_paid_amount"], 2) ?></td>
                        <td><span class="badge bg-success"><?= ucfirst($row["payment_status"]) ?></span></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <center><a href="admin_report.php" class="btn btn-primary">Download PDF Report</a></center>

    </div>
</body>
</html>
