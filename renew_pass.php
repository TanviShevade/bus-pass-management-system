<?php 
session_start(); 
if (!isset($_SESSION["user_id"])) { 
    header("Location: login.php"); 
    exit(); 
} 
include "config.php"; 

$user_id = $_SESSION["user_id"]; 
$today = date("Y-m-d"); 

// Auto-update expired pass status
$conn->query("UPDATE bus_pass SET status='expired' WHERE valid_until < '$today' AND status='active'");

// Check if user has an expired or soon-to-expire pass
$stmt = $conn->prepare("SELECT * FROM bus_pass WHERE user_id=? AND valid_until <= ? ORDER BY valid_until DESC LIMIT 1");
$stmt->bind_param("is", $user_id, $today);
$stmt->execute();
$result = $stmt->get_result();
$pass = $result->fetch_assoc();

if (!$pass) { 
    echo "<div class='alert alert-warning text-center'>You don't have a pass that needs renewal.</div>"; 
    exit(); 
} 

if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    $pass_type = intval($_POST["pass_type"]);
    $new_valid_until = date("Y-m-d", strtotime("+" . $pass_type . " months")); 
    
    // Update pass validity and status
    $sql = "UPDATE bus_pass SET valid_until=?, renewed=1, status='active' WHERE id=?";
    $stmt_update = $conn->prepare($sql);
    $stmt_update->bind_param("si", $new_valid_until, $pass["id"]);
    
    if ($stmt_update->execute()) { 
        // Redirect to payment page
        header("Location: make_payment.php?renew_id=" . $pass["id"]);
        exit();
    } else { 
        echo "<div class='alert alert-danger'>Error updating pass: " . $conn->error . "</div>"; 
    } 
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Renew pass</title>
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
  </div><br><br>

<body> 
<div class="container mt-5"> 
    <h2 >Renew Your Bus Pass</h2> 
    <form method="post"> 
        <div class="mb-3"> 
            <label>Select Renewal Duration</label> 
            <select name="pass_type" class="form-select" required> 
                <option value="1">Monthly</option> 
                <option value="3">Three Months</option> 
                <option value="6">Six Months</option> 
                <option value="12">Yearly</option> 
            </select> 
        </div> 
        <button type="submit" class="btn btn-" style="background-color: indianred;color: white;">Proceed to Payment</button>
    </form> 
</div><br/><br><br><br><br/><br><br><br> 
<footer class="bg-dark text-white text-center text-md-start">
        <div class="container p-4">
            <div class="row">
                <div class="col-md-4 mb-4 mb-md-0">

                   <center> <h5 class="text-uppercase" style="margin-right:170px;">Location</h5></center>
                    <div class="container  text-center" style="margin-right:170px;">
            <p >&copy; 2023 Bus Pass Management System</p>
            <p style="margin-right:80px;">
                <a href="contact_form.php" class="text-white text-decoration-underline" >Contact Us</a> |
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



</body> 
</html>
