<?php
session_start();
include "config.php";  // Ensure correct database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password']; // No hashing here; we use password_verify later

    // Fetch user from the database
    $query = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify hashed password
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_logged_in'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_type'] = $user['user_type']; // Store user type if needed

            header("Location: dashboard.php"); // Redirect after login
            exit();
        } else {
            echo "<script>alert('Invalid Email or Password!');</script>";
        }
    } else {
        echo "<script>alert('User not found!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Login</title>
 <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
   <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/bac9b8082a.js" crossorigin="anonymous"></script>
   
</head>

    <body style="background-image: url('bus3.jpg'); background-size: cover; background-repeat: no-repeat; background-position: center; height: 100vh;">
    
  <!-- Navigation Bar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid"style="height:10vh;">
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

    <div class="container h-100">
        <div class="row justify-content-center align-items-center h-100">
            <div class="col-md-8">
                <div class="card shadow-lg" style="border-top: 5px ; border-radius: 10px; background-color: rgba(255, 255, 255, 0.9);">
                    <div class="row g-0">
                        
                        <div class="col-md-6 d-none d-md-block">
                            <img src="bus4.jpg" alt="bus4" class="img-fluid rounded-start" >
                        </div>

                        
                        <div class="col-md-6">
                            <div class="card-body">
                                <h5 class="card-title text-center mb-4" style="color:indianred;font-size: 200%;font-family: candara;">Welcome back!</h5>

 <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

    <div class="container mt-5">
        
        <form method="post">
            <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" placeholder="Enter your Email" require>
</div>
<div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" placeholder="Enter your password"required>
            </div>
            <button type="submit" class="btn btn- w-100" style="background-color:indianred;color: white;">Login</button><br>
            <center><p class="text-left mt-3" style="font-size:17px;"><a href="forgot_password.php" >Forgot Password?</a></p></center>

           <p class="text-center mt-2">Don't have an account? <a 
href="register.php">Register</a></p> 
  <!-- Terms and Conditions -->
                                <p class="text-center mt-3 small">
                                    <a href="#">Terms and Conditions</a> | <a href="#">Privacy Policy</a>
                                </p>
        </form>
    </div>

    <script>
    function validateLoginForm() {
        const email = document.querySelector("input[name='email']").value.trim();
        const password = document.querySelector("input[name='password']").value.trim();

        // Email validation using regex
        const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        if (!emailPattern.test(email)) {
            alert("Please enter a valid email address.");
            return false;
        }

        // Password length validation
        if (password.length < 6) {
            alert("Password must be at least 6 characters long.");
            return false;
        }

        return true; // Form submits only if all validations pass
    }
</script>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
