<?php 
include "config.php"; // Ensure correct path

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST["name"]);
    $email = $conn->real_escape_string($_POST["email"]);
    $message = $conn->real_escape_string($_POST["message"]);

    $sql = "INSERT INTO contact (name, email, message) VALUES ('$name', '$email', '$message')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Message sent successfully!');</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
   <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/bac9b8082a.js" crossorigin="anonymous"></script>
   
</head>
<body>

<!-- Navigation Bar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid" style="height:10vh;">
             <div class="container d-flex align-items-center" style="margin-left: 7px;">
      <img src="buslogo-removebg-preview (1).png" alt="MSRTC Logo" height="140" width="150">
      <div>
        <h1 class="h5 mb-0" style="font-size: 26px;">Maharashtra State Road Transport Corporation</h1>
        <small style="font-size: 19px;">महाराष्ट्र राज्य मार्ग परिवहन महामंडळ</small>
        

      </div>
    </div>
  </div>
<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.php">Home</a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
          </li>
          <li class="nav-item">
            <a class="nav-link" href="register.php">Register</a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="login.php" id="loginDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Login
            </a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
            <ul class="dropdown-menu" aria-labelledby="loginDropdown">
              <li><a class="dropdown-item" href="/bus_pass_system/login.php">User Login</a></li>
                        <li><a class="dropdown-item" href="/bus_pass_system/admin/admin_login.php">Admin Login</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="helpDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Help/Support
            </a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
            <ul class="dropdown-menu" aria-labelledby="helpDropdown">
              <li><a class="dropdown-item" href="faqs.php">FAQs</a></li>
              <li><a class="dropdown-item" href="contact_form.php">Contact Us</a></li>
            </ul>
          </li>
        
      </div>
    </div>
  </nav>


<!-- Main content of the Contact Us page -->
<div class="container mt-5">
  
        <h2 class="text-center"style="color: indianred;font-family: candara;font-size: 40;">Contact Us!</h2>
        <h2 class="text-center" style="color: indianred;font-family: candara;font-size: 40;">Feel free to reach out to us with any questions or concerns.</h2>
        <div class="row mt-4">
            <div class="col-md-3">
                <div class="border rounded text-center py-3">
                    <i class="bi bi-geo-alt-fill fs-3"style="color:indianred;"></i>
                    <h5 style="color:indianred;">Locations</h5>
                    <p>Ratnagiri</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="border rounded text-center py-3">
                    <i class="bi bi-telephone-fill fs-3" style="color:indianred;"></i>
                    <h5 style="color:indianred;">Contact Us</h5>
                    <p>1800 22 1250</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="border rounded text-center py-3">
                    <i class="bi bi-envelope-fill fs-3"style="color:indianred;"></i>
                    <h5 style="color:indianred;">Mail Us</h5>
                    <p>msrtchelpdest@gmail.com</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="border rounded text-center py-3">
                    <i class="bi bi-clock-fill fs-3"style="color:indianred;"></i>
                    <h5 style="color:indianred;">Time Table</h5>
                    <p>Mon - Sun: 7:00 A.M to 06:00 P.M</p>
                </div>
            </div>
        </div>
        
        
    <!-- Form to submit user data -->
    <form action="" method="POST" class="p-4">
       <div class="container mt-5">
    
    <div class="row mt-4">
        <!-- Contact Form Section -->
        <div class="col-md-6">
            <div class="p-4 border rounded">
               
               
                    <div class="mb-3">
                        <label for="name" class="form-label">Your Name*</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Your Name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Your Email*</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter Your Email" required>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Your Message*</label>
                        <textarea class="form-control" id="message" name="message" rows="4" placeholder="Enter Your Message" required></textarea>
                    </div>
                    <center><button type="submit" class="btn" style="background-color: indianred; color: white;">Submit Now</button></center>
                </form>
            </div>
        </div>

        <!-- Google Map Section -->
        <div class="col-md-6">
            <div class="border rounded overflow-hidden">
                 <iframe
                         src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3815.6960774784475!2d73.3074663!3d16.9894935!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bea0dc076591ca3%3A0x31d264e04f67730a!2sMSRTC%20Ratnagiri%20Depot!5e0!3m2!1sen!2sin!4v1738499591797!5m2!1sen!2sin" width="600" height="410" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                         
                        width="100%">
                        height="400"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
            </div>
        </div>
    </div>
</div>
</form>
</div>

<br/>

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


    