<?php
session_start();
if (!isset($_SESSION["admin_logged_in"]) || $_SESSION["admin_logged_in"] !== true) {
    header("Location: admin_login.php");
    exit();
}

include "../config.php"; // Database connection

// Fetch total users
$total_users = $conn->query("SELECT COUNT(*) AS total FROM users")->fetch_assoc()["total"];

// Fetch total bus passes
$total_passes = $conn->query("SELECT COUNT(*) AS total FROM bus_pass")->fetch_assoc()["total"];

// Fetch total approved bus passes
$total_approved = $conn->query("SELECT COUNT(*) AS total FROM bus_pass WHERE status='approved'")->fetch_assoc()["total"];

// Fetch total pending bus passes
$total_pending = $conn->query("SELECT COUNT(*) AS total FROM bus_pass WHERE status='pending'")->fetch_assoc()["total"];

// Fetch total rejected bus passes
$total_rejected = $conn->query("SELECT COUNT(*) AS total FROM bus_pass WHERE status='rejected'")->fetch_assoc()["total"];

// Fetch total payment amount
$total_payments_query = $conn->query("SELECT SUM(amount) AS total FROM payments");
$total_payments = $total_payments_query->fetch_assoc()["total"];
$total_payments = $total_payments ? $total_payments : 0; // If NULL, set to 0

// Fetch total renewed bus passes
$total_renewals_query = $conn->query("SELECT COUNT(*) AS total FROM bus_pass WHERE status='renewed'");
$total_renewals = $total_renewals_query->fetch_assoc()["total"];

// Fetch bus passes expiring in 5 days
$expiry_alert_query = $conn->query("
    SELECT COUNT(*) AS total FROM bus_pass 
    WHERE status = 'approved' 
    AND valid_until <= DATE_ADD(CURDATE(), INTERVAL 5 DAY)
");
$expiring_passes = $expiry_alert_query->fetch_assoc()["total"];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Dashboard - Bus Pass System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-light">

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-3 col-lg-2 d-md-block bg-dark text-white sidebar vh-100 p-3">
            <h4 class="text-center">Admin Panel</h4>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item"><a href="admin_users.php" class="nav-link text-white">📂 Manage Users</a></li>
                <li class="nav-item"><a href="admin_passes.php" class="nav-link text-white">🚌 Manage Bus Passes</a></li>
                <li class="nav-item"><a href="view_user.php" class="nav-link text-white">📋Users pass records</a></li>
                <li class="nav-item"><a href="admin_payments.php" class="nav-link text-white">💰 View Payments</a></li>
                <li class="nav-item"><a href="admin_contact.php" class="nav-link text-white">📢 View Contacts</a></li>
                <li class="nav-item"><a href="admin_feedback.php" class="nav-link text-white"> 🗨️ View Feedback</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" id="settingsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        📊 Generate Report
                    </a>
                    <ul class="dropdown-menu bg-dark text-white" aria-labelledby="settingsDropdown">
                        <li><a class="dropdown-item text-white" href="generate_report.php">📄 Registered Users Report</a></li>
                        <li><a class="dropdown-item text-white" href="admin_report.php">🚌 Bus Pass Report</a></li>
                    </ul>
                </li>
            </ul>

 <a href="admin_logout.php" class="btn btn-danger w-100">Logout</a>

            
        </nav>

        <!-- Main Dashboard Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mt-4">
         
        
            <div class="row">
                <!-- Dashboard Cards -->
                <div class="col-md-4">
                    <div class="card bg-primary text-white mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Total Users</h5>
                            <p class="card-text"><?php echo $total_users; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-info text-white mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Total Bus Passes</h5>
                            <p class="card-text"><?php echo $total_passes; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-success text-white mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Approved Passes</h5>
                            <p class="card-text"><?php echo $total_approved; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-warning text-dark mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Pending Passes</h5>
                            <p class="card-text"><?php echo $total_pending; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-danger text-white mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Rejected Passes</h5>
                            <p class="card-text"><?php echo $total_rejected; ?></p>
                        </div>
                    </div>
                </div>
               


                <div class="col-md-4">
                    <div class="card bg-secondary text-white mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Total Payments</h5>
                            <p class="card-text">₹<?php echo number_format($total_payments, 2); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
    <div class="card bg- text-dark mb-3" style="background-color: yellowgreen;">
        <div class="card-body">
            <h5 class="card-title">Expiring Soon</h5>
            <p class="card-text"><?php echo $expiring_passes; ?> passes</p>
            <small>Renew soon to avoid disruption!</small>
        </div>
    </div>
</div>
 </div><br><br><br>


 <!-- Charts Row -->
<div class="row d-flex justify-content-center">
    <div class="col-md-4 d-flex justify-content-center">
        <canvas id="busPassChart" style="max-width: 400px; max-height: 400px;"></canvas>
    </div>
    <div class="col-md-4 d-flex justify-content-center">
        <canvas id="paymentChart" style="max-width: 400px; max-height: 400px;"></canvas>
    </div>
    <div class="col-md-4 d-flex justify-content-center mt-4">
        <canvas id="expiryChart" style="max-width: 400px; max-height: 400px;"></canvas>
    </div>
</div>

<script>
// Bus Pass Status Pie Chart
const busPassCtx = document.getElementById('busPassChart').getContext('2d');
new Chart(busPassCtx, {
    type: 'pie',
    data: {
        labels: ['Approved', 'Pending', 'Rejected', 'Renewed'],
        datasets: [{
            data: [<?php echo "$total_approved, $total_pending, $total_rejected, $total_renewals"; ?>],
            backgroundColor: ['#28a745', '#ffc107', '#dc3545', '#6c757d']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            title: {
                display: true,
                text: 'Bus Pass Approval Status'
            }
        }
    }
});

// Payments Overview Bar Chart
const paymentCtx = document.getElementById('paymentChart').getContext('2d');
new Chart(paymentCtx, {
    type: 'bar',
    data: {
        labels: ['Total Payments'],
        datasets: [{
            label: 'Amount (₹)',
            data: [<?php echo $total_payments; ?>],
            backgroundColor: '#007bff'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true
            }
        },
        plugins: {
            title: {
                display: true,
                text: 'Total Payments'
            }
        }
    }
});

// Expiring Bus Passes Line Chart
const expiryCtx = document.getElementById('expiryChart').getContext('2d');
new Chart(expiryCtx, {
    type: 'line',
    data: {
        labels: ['Expiring Soon'],
        datasets: [{
            label: 'Expiring in 5 Days',
            data: [<?php echo $expiring_passes; ?>],
            borderColor: '#ff6384',
            fill: false
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            title: {
                display: true,
                text: 'Expiring Bus Passes'
            }
        }
    }
});
</script>

  </main>

 </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


