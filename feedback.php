<?php 
session_start(); 
if (!isset($_SESSION["user_id"])) { 
    header("Location: login.php"); 
    exit(); 
} 

include "config.php"; 

if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    $user_id = $_SESSION["user_id"]; 
    $name = $conn->real_escape_string($_POST["name"]);
    $email = $conn->real_escape_string($_POST["email"]);
    $message = $conn->real_escape_string($_POST["message"]);

    $sql = "INSERT INTO feedback (user_id, name, email, message) VALUES ('$user_id', '$name', '$email', '$message')";

    if ($conn->query($sql) === TRUE) { 
        echo "<div class='alert alert-success'>Feedback submitted successfully.</div>"; 
    } else { 
        echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>"; 
    } 
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Feedback/complaint</title>
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
            <li class="breadcrumb-item active" aria-current="page"style="font-size: 20px;">Feedback</li>
        </ol>
    </nav>

<div class="container mt-5">
  
        <h2 class="text-center"style="color: indianred;font-family: candara;font-size: 40;">Share Your Feedback Here!</h2><br/>
        <form action="" method="POST" class="p-4 border rounded">
    <div class="mb-3">
        <label for="name" class="form-label">Your Name*</label>
        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Your Full Name" required>
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Your Email*</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="Enter Your Email" required>
    </div>

    <div class="mb-3">
        <label for="message" class="form-label">Your Message*</label>
        <textarea class="form-control" id="message" name="message" rows="4" placeholder="Enter Your Feedback here" required></textarea>
    </div>

    <center>
        <button type="submit" class="btn btn" style="background-color: indianred; color: white;">
            Submit Feedback
        </button>
    </center>
</form>
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


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


    