<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

include "config.php";
$user_id = $_SESSION["user_id"];

// Fetch available bus stops
$stops_query = $conn->query("SELECT DISTINCT source FROM fares UNION SELECT DISTINCT destination FROM fares");
if (!$stops_query) {
    die("Query failed: " . $conn->error);
}
$stops = [];
while ($row = $stops_query->fetch_assoc()) {
    $stops[] = $row['source'];
}


// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pass_type = $_POST["pass_type"];
    $source = $_POST["source_stop"];
    $destination = $_POST["destination_stop"];
    $valid_until = date('Y-m-d', strtotime("+$pass_type months"));

    // Fetch Base Fare from `fares` Table
    $fare_query = $conn->query("SELECT fare FROM fares WHERE source='$source' AND destination='$destination' LIMIT 1");
    
    if ($fare_query->num_rows > 0) {
        $fare_data = $fare_query->fetch_assoc();
        $base_fare = $fare_data["fare"];
    } else {
        die("<div class='alert alert-danger'>Error: Fare for selected route not found!</div>");
    }

    // Calculate Total Monthly Fare (Base Fare * Days in Month)
    $days_in_month = date('t');
    $total_fare = $base_fare * $days_in_month;

    // Fetch User Type (Student / Kamgar)
    $user_query = $conn->query("SELECT user_type FROM users WHERE id='$user_id'");
    $user_data = $user_query->fetch_assoc();
    $user_type = $user_data['user_type'];

    // Apply Discount
    $discount_percent = ($user_type == 'student') ? 50 : (($user_type == 'kamgar') ? 25 : 0);
    $discount_amount = ($total_fare * $discount_percent) / 100;
    $final_paid_amount = $total_fare - $discount_amount;

    // Insert Bus Pass Data
    $conn->query("INSERT INTO bus_pass (user_id, pass_type, valid_until, status, source_stop, destination_stop, total_fare, discount_percent, discount_amount, final_paid_amount, payment_status) 
                  VALUES ('$user_id', '$pass_type', '$valid_until', 'pending', '$source', '$destination', '$total_fare', '$discount_percent', '$discount_amount', '$final_paid_amount', 'pending')");

    echo "<div class='alert alert-success'>Bus pass applied successfully!</div>";
      // Redirect after 2 seconds
    echo "<script>
        setTimeout(function() {
            window.location.href = 'dashboard.php';
        }, 1000);
    </script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>apply pass</title>
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
        <li class="breadcrumb-item active " aria-current="page" style="font-size: 20px;">Apply</li>
      </ol>
    </nav>
  </div>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg border-0">
                <div class="card-header bg- text-white text-center" style="background-color: indianred;">
                    <h4> Apply for a Bus Pass</h4>
                </div>
                <div class="card-body p-4">
                    <form method="post" action="apply_pass.php">
                        
                        <!-- Source Stop -->
                        <div class="mb-3">
                            <label class="form-label">Source Stop</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-map-marker-alt" style="color:indianred;"></i></span>
                                <select name="source_stop" class="form-control" required>
                                    <option value="">Select Source</option>
                                    <?php foreach ($stops as $stop) { ?>
                                        <option value="<?= htmlspecialchars($stop) ?>"><?= htmlspecialchars($stop) ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <!-- Destination Stop -->
                        <div class="mb-3">
                            <label class="form-label">Destination Stop</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-map-marker" style="color:indianred;"></i></span>
                                <select name="destination_stop" class="form-control" required>
                                    <option value="">Select Destination</option>
                                    <?php foreach ($stops as $stop) { ?>
                                        <option value="<?= htmlspecialchars($stop) ?>"><?= htmlspecialchars($stop) ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <!-- Pass Duration -->
                        <div class="mb-3">
                            <label class="form-label">Pass Duration</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-calendar-alt"style="color:indianred;"></i></span>
                                <select name="pass_type" class="form-control" required>
                                    <option value="1">1 Month</option>
                                    <option value="3">3 Months</option>
                                    <option value="6">6 Months</option>
                                    <option value="12">12 Months</option>
                                </select>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn- btn-lg" style="background-color:indianred;color: white;">
                                 Apply pass
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include FontAwesome for Icons -->
<script src="https://kit.fontawesome.com/your-fontawesome-kit.js" crossorigin="anonymous"></script>
<br><br>

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