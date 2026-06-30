<?php
session_start();
include "config.php"; // Database connection

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];


// Fetch user details
$user_query = "SELECT name, user_type FROM users WHERE id = ?";
$stmt_user = $conn->prepare($user_query);
$stmt_user->bind_param("i", $user_id);
$stmt_user->execute();
$user_result = $stmt_user->get_result();
$user = $user_result->fetch_assoc();

$user_name = $user ? htmlspecialchars($user["name"]) : "Guest";
$user_type = $user ? ucfirst($user["user_type"]) : "N/A";

// Fetch latest bus pass details
$pass_query = "SELECT * FROM bus_pass WHERE user_id = ? ORDER BY updated_at DESC, id DESC LIMIT 1";

$stmt_pass = $conn->prepare($pass_query);
$stmt_pass->bind_param("i", $user_id);
$stmt_pass->execute();
$pass_result = $stmt_pass->get_result();

$pass_exists = false;
if ($pass_result->num_rows > 0) {
    $bus_pass = $pass_result->fetch_assoc();
    $pass_exists = true;

    $pass_type = htmlspecialchars($bus_pass["pass_type"]);
    $valid_until = htmlspecialchars($bus_pass["valid_until"]);
    $payment_status = (!empty($bus_pass["payment_status"]) && strtolower($bus_pass["payment_status"]) == "paid") 
        ? "Paid" 
        : "Pending";
    $final_paid_amount = number_format($bus_pass["final_paid_amount"], 2);
    
    //Show Expiry Alerts on User Dashboard
    $user_id = $_SESSION['user_id'];
$user_expiry_query = $conn->query("
    SELECT valid_until FROM bus_pass 
    WHERE user_id = $user_id 
    AND status = 'approved' 
    AND valid_until <= DATE_ADD(CURDATE(), INTERVAL 5 DAY)
");

if ($user_expiry_query->num_rows > 0) {
    $expiry = $user_expiry_query->fetch_assoc()["valid_until"];
    echo "<script>alert('Your bus pass will expire on $expiry. Please renew soon!');</script>";

}
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://kit.fontawesome.com/bac9b8082a.js" crossorigin="anonymous"></script>
  
  <style>
      body {
          background-color: #f8f9fa;
      }
      .card-custom {
          border: none;
          border-radius: 15px;
          box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
          transition: transform 0.3s ease-in-out;
      }
      .card-custom:hover {
          transform: scale(1.05);
      }
      .btn-custom {
          background-color: indianred;
          color: white;
      }
      .btn-custom:hover {
          background-color: darkred;
      }
      .navbar {
          background-color: indianred;
      }
      .navbar .nav-link {
          color: #fff;
      }
  </style>
</head>

<body>
<nav class="navbar navbar-expand-lg  bg-danger " >
    <div class="container-fluid d-flex align-items-center" style="height: 12vh;">
        <img src="buslogo-removebg-preview (1).png" alt="MSRTC Logo" height="130">
        <div>
            <h1 class="h5 mb-0" style="font-size: 28px;color: white;">Maharashtra State Road Transport Corporation</h1>
            <small style="font-size: 20px;color: white;">महाराष्ट्र राज्य मार्ग परिवहन महामंडळ</small>
        </div>
        <div class="ms-auto">
            <a href="index.php" class="btn btn-outline-light me-3">Home</a>
            <a href="login.php" class="btn btn-warning">Logout</a>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h2 class="text-center mb-4">Welcome, <strong><?php echo $user_name; ?>!</strong></h2>
    <p class="text-center text-muted">You are logged in as <strong><?php echo $user_type; ?></strong>.</p>

    <?php if ($pass_exists): ?>
        <div class="card shadow-sm p-4 mb-4 card-custom">
            <h4 class="text-center" style="color: indianred;">Your Bus Pass Details</h4>
            <hr>
            <p><strong>Pass Type:</strong> <?php echo $pass_type; ?></p>
            <p><strong>Valid Until:</strong> <?php echo $valid_until; ?></p>
            <p><strong>Payment Status:</strong>
                <span class="badge <?php echo ($payment_status == 'Paid') ? 'bg-success' : 'bg-danger'; ?>">
                    <?php echo $payment_status; ?>
                </span>
            </p>
            <p><strong>Amount Payable:</strong> ₹<?php echo $final_paid_amount; ?></p>

            <div class="d-flex justify-content-center gap-3">
                <?php if ($payment_status == "Pending"): ?>
                    <form action="make_payment.php" method="POST">
                        <input type="hidden" name="bus_pass_id" value="<?php echo $bus_pass['id']; ?>">
                        <button type="submit" class="btn btn-custom">Proceed to Payment</button>
                    </form>
                <?php else: ?>
                    <form action="view_pass.php" method="POST">
                        <input type="hidden" name="bus_pass_id" value="<?php echo $bus_pass['id']; ?>">
                        <button type="submit" class="btn btn-custom">View Pass</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-warning text-center">
            No Bus Pass Found! You have not applied for a bus pass yet.
        </div>
    <?php endif; ?>

    <!-- Options Grid -->
   <div class="row row-cols-1 row-cols-md-5 g-4 text-center"> <!-- Changed to 5 columns -->

    <div class="col">
        <a href="apply_pass.php" class="text-decoration-none">
            <div class="card card-custom p-4">
                <img src="r13.jpg" class="mx-auto" width="150" alt="Apply Pass">
                <h5 class="mt-3 text-dark">Apply Bus Pass</h5>
            </div>
        </a>
    </div>

    <div class="col">
        <a href="renew_pass.php" class="text-decoration-none">
            <div class="card card-custom p-4">
                <img src="r8.jpg" class="mx-auto" width="150" alt="Renew Pass">
                <h5 class="mt-3 text-dark">Renew Bus Pass</h5>
            </div>
        </a>
    </div>

    <div class="col">
        <a href="edit_profile.php" class="text-decoration-none">
            <div class="card card-custom p-4">
                <img src="r6.jpg" class="mx-auto" width="150" alt="Update Profile">
                <h5 class="mt-3 text-dark">Update Profile</h5>
            </div>
        </a>
    </div>

 <!-- New Card: Track Application Status -->
    <div class="col">
        <a href="track_status.php" class="text-decoration-none">
            <div class="card card-custom p-4">
                <img src="r18.jpg" class="mx-auto" width="125" alt="Track Status">
                <h5 class="mt-3 text-dark">Track Application Status</h5>
            </div>
        </a>
    </div>
    
    <div class="col">
        <a href="feedback.php" class="text-decoration-none">
            <div class="card card-custom p-4">
                <img src="r11.jpg" class="mx-auto" width="150" alt="Feedback">
                <h5 class="mt-3 text-dark">Feedback</h5>
            </div>
        </a>
    </div>

   

</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

</div><br><br>

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



  
 