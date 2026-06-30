
<?php
session_start();
include "config.php"; // Database connection

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

// Validate bus_pass_id
if (!isset($_POST["bus_pass_id"])) {
    echo "<script>alert('Invalid request. Please try again.'); window.location.href='dashboard.php';</script>";
    exit();
}

$bus_pass_id = intval($_POST["bus_pass_id"]);

// Fetch bus pass details
$query = "SELECT * FROM bus_pass WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $bus_pass_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "<script>alert('Bus pass not found!'); window.location.href='dashboard.php';</script>";
    exit();
}

$bus_pass = $result->fetch_assoc();
$source_stop = htmlspecialchars($bus_pass["source_stop"]);
$destination_stop = htmlspecialchars($bus_pass["destination_stop"]);
$pass_type = htmlspecialchars($bus_pass["pass_type"]);
$valid_until = htmlspecialchars($bus_pass["valid_until"]);
$total_fare = floatval($bus_pass["total_fare"]);
$discount_amount = floatval($bus_pass["discount_amount"]);
$final_paid_amount = $total_fare - $discount_amount;

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>make_payment</title>
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
      <li class="breadcrumb-item  " style="font-size: 20px;color: black;"><a href="apply_pass.php" style="color: black;">Apply</a></li>
        <li class="breadcrumb-item active " aria-current="page" style="font-size: 20px;">Payment</li>
      </ol>
    </nav>
  </div>

<div class="container mt-4">
     <div class="card shadow-lg border-0">
                <div class="card-header bg- text-white text-center" style="background-color: indianred;">
                    <h4> Payment For Bus Pass</h4>
                </div>

    <div class="card shadow">
        <div class="card-body">
            <h4 class="card-title">Bus Pass Details</h4>
            <table class="table table-bordered">
                <tr><th>Route</th><td><?= $source_stop ?> → <?= $destination_stop ?></td></tr>
                <tr><th>Pass Type</th><td><?= $pass_type ?></td></tr>
                <tr><th>Valid Until</th><td><?= $valid_until ?></td></tr>
                <tr><th>Total Fare</th><td>₹<?= number_format($total_fare, 2) ?></td></tr>
                <tr><th>Discount Applied</th><td>- ₹<?= number_format($discount_amount, 2) ?></td></tr>
                <tr><th><strong>Final Amount Payable</strong></th><td><strong>₹<?= number_format($final_paid_amount, 2) ?></strong></td></tr>
            </table>

            <form action="process_payment.php" method="POST">
                <input type="hidden" name="bus_pass_id" value="<?= $bus_pass_id ?>">
                <input type="hidden" name="final_paid_amount" value="<?= $final_paid_amount ?>">  

                <div class="mb-3">
                    <label class="form-label">Choose Payment Method:</label>
                    <select name="payment_method" class="form-select" required>
                        <option value="Online">Online Payment</option>
                        <option value="UPI">UPI</option>
                        <option value="Card">Credit/Debit Card</option>
                    </select>
                </div>

                <button type="submit" class="btn btn- w-100" style="background-color: indianred;color: white;">Proceed to Payment</button>
            </form>
        </div>
    </div>
</div>
</div>
<br>

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