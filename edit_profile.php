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
$pass_query = "SELECT * FROM bus_pass WHERE user_id = ? ORDER BY valid_until DESC LIMIT 1";
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
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>edit profile</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/bac9b8082a.js" crossorigin="anonymous"></script>
   
</head>
<nav class="navbar navbar-expand-lg navbar-light bg-danger text-white">
    <div class="container-fluid" style="height:12vh;">
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


<body>
   <div class="container mt-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="dashboard.php"style="font-size: 20px;color: black;">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page"style="font-size: 20px;">Edit Profile</li>
        </ol>
    </nav>
  
  <div class="d-flex justify-content-center align-items-center" style="height: 35vh;">
    <div class="card shadow-lg border-0 text-center p-4" style="width: 350px; height: 220px; display: flex; align-items: center; justify-content: center;">
        <div class="card-body">
            <h5 class="mb-3"><?= htmlspecialchars($user['name']) ?></h5>
            <a href="update_profile.php" class="btn btn-outline-danger btn-sm w-100">Edit</a>
        </div>
    </div>
</div>
</div><br><br><br><br>


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


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


    
