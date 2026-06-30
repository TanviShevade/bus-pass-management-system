<?php 
include "config.php"; 

if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    $name = trim($_POST["name"]); 
    $email = filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $user_type = $_POST["user_type"];
    $institution = $_POST["institution"] ?? NULL; 
    $company = $_POST["company"] ?? NULL; 
    $photo_path = NULL;

    // Validate required fields
    if (!$name || !$email || !$password || !$confirm_password || !$user_type) {
        echo "<script>alert('All fields are required!');</script>";
        exit;
    }

    // Password match validation
    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match!');</script>";
        exit;
    }

    // Password hashing
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // File upload handling
    if (!empty($_FILES["photo"]["name"])) {
        $target_dir = "uploads/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $allowed_types = ["jpg", "jpeg", "png"];
        $file_extension = strtolower(pathinfo($_FILES["photo"]["name"], PATHINFO_EXTENSION));

        if (!in_array($file_extension, $allowed_types)) {
            echo "<script>alert('Only JPG, JPEG, and PNG files are allowed.');</script>";
            exit;
        }

        if ($_FILES["photo"]["size"] > 2 * 1024 * 1024) { // 2MB limit
            echo "<script>alert('File size should not exceed 2MB.');</script>";
            exit;
        }

        $photo_name = time() . "_" . basename($_FILES["photo"]["name"]);
        $photo_path = $target_dir . $photo_name;

        if (!move_uploaded_file($_FILES["photo"]["tmp_name"], $photo_path)) {
            echo "<script>alert('Error uploading photo. Please try again!');</script>";
            exit;
        }
    }

    // Insert user into database
    $sql = "INSERT INTO users (name, email, password, user_type, institution_name, company_name, photo)  
            VALUES (?, ?, ?, ?, ?, ?, ?)"; 
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $name, $email, $hashed_password, $user_type, $institution, $company, $photo_path);

    if ($stmt->execute()) { 
        header("Location: login.php"); 
        exit();
    } else { 
        echo "<script>alert('Registration failed. Please try again.');</script>";
    }
} 
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
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
            <a class="nav-link" href="registration.php">Register</a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
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
<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="row bg-white rounded-3 shadow-lg p-3" style="max-width: 40rem; width: 100%;">
        <!-- Left Section -->
        <div class="col-md-6 d-flex flex-column justify-content-center align-items-center text-center border-end p-2">
            <h4 class="fw-bold mb-2" style="font-family: candara; font-size:150%; color:indianred;">Looks like you're new here!</h4>
            <p style="font-family: candara; color:indianred; font-size: 0.9rem;">Register for your bus pass today</p>
            <img src="bus6.jpg" alt="Placeholder Image" class="img-fluid" style="max-width: 250px;">
        </div>
        <!-- Right Section -->
       <div class="col-md-6 p-2">
    <form method="post" enctype="multipart/form-data" onsubmit="return validateForm();">
        <div class="mb-2">
            <label>Name</label>
            <input type="text" class="form-control form-control-sm" name="name" placeholder="Enter your full name" required>
        </div>
        <div class="mb-2">
            <label>Email</label>
            <input type="email" class="form-control form-control-sm" name="email" placeholder="Enter your Email" required>
        </div>
        <div class="mb-2">
            <label>Password</label>
            <input type="password" class="form-control form-control-sm" id="password" name="password" placeholder="Enter your password" required minlength="6">
            <small>Password must be at least 6 characters.</small>
        </div>
        <div class="mb-2">
            <label>Confirm Password</label>
            <input type="password" class="form-control form-control-sm" id="confirm_password" name="confirm_password" placeholder="Confirm password" required>
        </div>
        <div class="mb-2">
            <label>User Type</label>
            <select name="user_type" class="form-select form-select-sm" required>
                <option value="">Select User Type</option>
                <option value="student">Student</option>
                <option value="kamgar">Kamgar (Worker)</option>
            </select>
        </div>
        <div class="mb-2">
            <label>Institution (if Student)</label>
            <input type="text" class="form-control form-control-sm" placeholder="Enter Institution Name" name="institution">
        </div>
        <div class="mb-2">
            <label>Company (if Kamgar)</label>
            <input type="text" class="form-control form-control-sm" placeholder="Enter Company Name" name="company">
        </div>
        <div class="mb-2">
            <label>Upload Photo</label>
            <input type="file" class="form-control form-control-sm" id="photo" name="photo" accept="image/*" required>
            <small>Only JPG, JPEG, PNG. Max size: 2MB.</small>
        </div>
        <button type="submit" class="btn w-100 btn-sm" style="background-color: indianred; color: white;">Register</button>
        <p class="text-center mt-2" style="font-size: 0.85rem;">Already have an account? <a href="login.php">Login</a></p>
    </form>
</div>

<script>
    function validateForm() {
        const password = document.getElementById("password").value;
        const confirmPassword = document.getElementById("confirm_password").value;
        const email = document.querySelector("input[name='email']").value;
        const photo = document.getElementById("photo").files[0];

        // Validate password match
        if (password !== confirmPassword) {
            alert("Passwords do not match.");
            return false;
        }

        // Validate email format
        const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        if (!emailPattern.test(email)) {
            alert("Invalid email format.");
            return false;
        }

        // Validate password strength
        if (password.length < 6) {
            alert("Password must be at least 6 characters long.");
            return false;
        }

        // Validate file type and size
        if (photo) {
            const allowedTypes = ["image/jpeg", "image/jpg", "image/png"];
            if (!allowedTypes.includes(photo.type)) {
                alert("Only JPG, JPEG, and PNG files are allowed.");
                return false;
            }

            if (photo.size > 2 * 1024 * 1024) {
                alert("File size should not exceed 2MB.");
                return false;
            }
        }

        return true;
    }
</script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body> 
</html> 