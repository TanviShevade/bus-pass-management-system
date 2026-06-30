<?php
include "config.php"; 
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
    
}

$user_id = $_SESSION["user_id"];

// Fetch user details
$query = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Fetch latest bus pass details
$query_pass = "SELECT * FROM bus_pass WHERE user_id = ? ORDER BY id DESC LIMIT 1";
$stmt_pass = $conn->prepare($query_pass);
$stmt_pass->bind_param("i", $user_id);
$stmt_pass->execute();
$result_pass = $stmt_pass->get_result();
$pass = $result_pass->fetch_assoc();

$photo_url = $user["photo"] ? $user["photo"] : "uploads/default.png"; // Default photo if not uploaded
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>view pass</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/bac9b8082a.js" crossorigin="anonymous"></script>
   
</head>
<nav class="navbar navbar-expand-lg navbar-light bg-danger text-white">
    <div class="container-fluid"style="height:12vh;">
       <div class="container d-flex align-items-center" style="margin-left: 7px;">
      <img src="buslogo-removebg-preview (1).png" alt="MSRTC Logo" height="140" width="150">
      <div>
        <h1 class="h5 mb-0" style="font-size: 28px;">Maharashtra State Road Transport Corporation</h1>
        <small style="font-size: 20px;">महाराष्ट्र राज्य मार्ग परिवहन महामंडळ</small>
        

      </div>
    </div>
    <div class="text-end">
     
      <p class="mb-0"><strong>(24/7 Customer Support)
        
      </strong></p>
      
    </div>
  </div>

</nav>
<!-- Breadcrumb Navigation -->
  <div class="container mt-3">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
     <li class="breadcrumb-item  " style="font-size: 20px;color: black;"><a href="dashboard.php" style="color: black;">Home</a></li>
        <li class="breadcrumb-item active " aria-current="page" style="font-size: 20px;">View Pass</li>
      </ol>
    </nav>
  </div>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card p-4">
                <div class="text-center">
                    
                   <img src="uploads/<?= htmlspecialchars(basename($user['photo'])) ?>" class="rounded-circle mb-3" width="120" height="120" alt="User Photo">


                    <h4 class="mb-0"><?= htmlspecialchars($user["name"]) ?></h4>
                    <p class="text-muted"><?= ucfirst(htmlspecialchars($user["user_type"])) ?></p>
                </div>

                <h5 class="mt-4"> User Details</h5>
                <table class="table table-bordered">
                    <tr><th>Email</th><td><?= htmlspecialchars($user["email"]) ?></td></tr>
                    <tr><th>User Type</th><td><?= ucfirst(htmlspecialchars($user["user_type"])) ?></td></tr>
                    <?php if ($user["user_type"] == "student") { ?>
                        <tr><th>Institution</th><td><?= htmlspecialchars($user["institution_name"]) ?></td></tr>
                    <?php } elseif ($user["user_type"] == "kamgar") { ?>
                        <tr><th>Company</th><td><?= htmlspecialchars($user["company_name"]) ?></td></tr>
                    <?php } ?>
                </table>

                <?php if ($pass) { ?>
                    <h5 class="mt-4"> Bus Pass Details</h5>
                    <table class="table table-bordered">
                        <tr><th>Route</th><td><?= htmlspecialchars($pass["source_stop"]) ?> → <?= htmlspecialchars($pass["destination_stop"]) ?></td></tr>
                        <tr><th>Pass Type</th><td><?= htmlspecialchars($pass["pass_type"]) ?> Months</td></tr>
                        <tr><th>Valid Until</th><td><?= date("d M Y", strtotime($pass["valid_until"])) ?></td></tr>
                        <tr><th>Total Fare</th><td>₹<?= number_format($pass["total_fare"], 2) ?></td></tr>
                        <tr><th>Discount</th><td><?= $pass["discount_percent"] ?>% (-₹<?= number_format($pass["discount_amount"], 2) ?>)</td></tr>
                        <tr><th>Final Amount Paid</th><td>₹<?= number_format($pass["final_paid_amount"], 2) ?></td></tr>
                        <tr><th>Pass Status</th><td><span class="badge bg-success"><?= ucfirst($pass["payment_status"]) ?></span></td></tr>
                    </table>

                    <a href="download_pass.php" class="btn btn- w-100" style="background-color: indianred;color: white;">📄 Download PDF</a>
                <?php } else { ?>
                    <p class="alert alert-warning text-center">⚠ No active bus pass found.</p>
                <?php } ?>
                
            </div>
        </div>
    </div>
</div><br>
<footer class="bg-dark text-white text-center text-md-start">
        <div class="container p-4">
            <div class="row">
                <div class="col-md-4 mb-4 mb-md-0">

                   <center> <h5 class="text-uppercase" style="margin-right:170px;">Location</h5></center>
                    <div class="container  text-center" style="margin-right:170px;">
            <p >&copy; 2023 Bus Pass Management System</p>
            <p style="margin-right:80px;">
                <a href="contact us.php" class="text-white text-decoration-underline" >Contact Us</a> |
                <a href="#" class="text-white text-decoration-underline">Privacy Policy</a>
            </p>
        </div>
                </div>
                 <div class="col-md-4 mb-4 mb-md-0">
                    <h5 class="text-uppercase">Hours</h5>
                    <p>Monday - Sunday<br>7:00 a.m - 6:00 p.m.<br></p>
                </div>

                <div class="col-md-4 mb-4 mb-md-0">
                    <h5 class="text-uppercase">Contact</h5>
                    <p>Email: <a href="msrtchelpdest@gmail.com" class="text-white">msrtchelpdest@gmail.com</a></p>
                    <p>Phone: <a href="tel:1800 22 1250" class="text-white">1800 22 1250</a></p>
                    <p>Fax: <a href="fax:1800 22 1250" class="text-white">1800 22 1250</a></p>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col text-center">
                    <p>Follow our news, updates and activities on:</p>
                     <a href="#" class="text-white me-2"><i class="bi bi-facebook"></i></a>
        <a href="#" class="text-white me-2"><i class="bi bi-twitter"></i></a>
        <a href="#" class="text-white me-2"><i class="bi bi-telegram"></i></a>
        <a href="#" class="text-white me-2"><i class="bi bi-youtube"></i></a>
        <a href="#" class="text-white"><i class="bi bi-instagram"></i></a>
                </div>
            </div>
        </div>
    </footer>
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
