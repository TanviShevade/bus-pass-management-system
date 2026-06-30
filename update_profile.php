<?php
session_start();
include "config.php"; // Database connection

if (!isset($_SESSION["user_id"])) {
    die("Unauthorized access!");
}

$user_id = $_SESSION["user_id"];

// Fetch user data
$query = "SELECT name, email, photo FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_email = $_POST["email"];
    $photo_name = $user["photo"];

    // Handle Profile Picture Upload
    if (!empty($_FILES["photo"]["name"])) {
        $target_dir = "uploads/";
        $photo_name = time() . "_" . basename($_FILES["photo"]["name"]);
        $target_file = $target_dir . $photo_name;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check file type
        if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
            die("Error: Only JPG, JPEG, PNG, and GIF files are allowed.");
        }

        // Move uploaded file
        if (!move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
            die("Error uploading the file.");
        }
    }

    // Update User Info
    $update_query = "UPDATE users SET email = ?, photo = ? WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("ssi", $new_email, $photo_name, $user_id);

    if ($stmt->execute()) {
        echo "<script>alert('Profile updated successfully!'); window.location.href='update_profile.php';</script>";
    } else {
        echo "<script>alert('Error updating profile.');</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Update profile</title>
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
      <li class="breadcrumb-item  " style="font-size: 20px;color: black;"><a href="edit_profile.php" style="color: black;">Edit Profile</a></li>
        <li class="breadcrumb-item active " aria-current="page" style="font-size: 20px;">Profile</li>
      </ol>
    </nav>
  </div>

<div class="container mt-5">
    <div class="card shadow-lg p-4" style="max-width: 500px; margin: auto;">
        <h3 class="text-center mb-2">Update Profile</h3>
        <hr>
        <!-- Profile Image -->
        <div class="text-center mb-3">
            <img src="uploads/<?php echo $user['photo'] ?: 'default.png'; ?>" 
                 alt="Profile Photo" 
                 class="rounded-circle border" 
                 width="120" height="120">
        </div>

        <!-- Form -->
        <form action="update_profile.php" method="POST" enctype="multipart/form-data">
             <!-- Name Field -->
                <div class="mb-3">
                    <label class="form-label">Name:</label>
                    <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" class="form-control" required>
                </div>
            <div class="mb-3">
                <label class="form-label">Email:</label>
                <input type="email" name="email" class="form-control" 
                       value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Change Profile Photo:</label>
                <input type="file" name="photo" class="form-control" accept="image/*">
            </div>

            <button type="submit" class="btn btn- w-100" style="background-color: indianred;color: white;">Update Profile</button>
        </form>
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



 