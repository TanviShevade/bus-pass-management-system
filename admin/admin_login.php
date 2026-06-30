<?php
session_start();
include "../config.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    
    // Hash the entered password using SHA1 (to match your DB format)
    $hashed_password = sha1($password);

    $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $hashed_password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();

        $_SESSION["admin_id"] = $admin["id"];
        $_SESSION["admin_username"] = $admin["username"];
        $_SESSION["admin_logged_in"] = true; // Set session flag
        
        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo "<script>alert('Incorrect username or password!'); window.location='admin_login.php';</script>";
    }

    $stmt->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script>
    function validateAdminForm() {
        const username = document.querySelector("input[name='username']").value.trim();
        const password = document.querySelector("input[name='password']").value.trim();

        if (username === "") {
            alert("Username cannot be empty.");
            return false;
        }

        if (password.length < 6) {
            alert("Password must be at least 6 characters long.");
            return false;
        }

        return true; // Form submits only if validations pass
    }
  </script>
</head>
</head>

<body style="background-image: url('bus3.jpg'); background-size: cover; background-repeat: no-repeat; background-position: center; height: 100vh;">
  
  

  <div class="container h-100">
        <div class="row justify-content-center align-items-center h-100">
            <div class="col-md-8">
                <div class="card shadow-lg" style="border-top: 5px ; border-radius: 10px; background-color: rgba(255, 255, 255, 0.9);">
                    <div class="row g-0">
                        
                        <div class="col-md-6 d-none d-md-block">
                            <img src="bus8.jpg" alt="bus4" class="img-fluid rounded-start" style="height: 95%; ">
                        </div>

                        
                        <div class="col-md-6">
                            <div class="card-body">
                                <h5 class="card-title text-center mb-4" style="color:indianred;font-size: 200%;font-family: candara;">Admin Login</h5>
<div class="container mt-5">
 <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <form method="post">
            <div class="mb-3">
            <label>Username</label>
            <input type="text" name="username" class="form-control" placeholder="Enter Your Username"required>
</div>
<div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control"placeholder="Enter Your Password" required></div>

            <button type="submit" class="btn btn- w-100" style="background-color: indianred;color: white;" >Login</button>
        </form>
    </div>
</body>
</html>
