<?php
include "config.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Track status</title>
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
        <li class="breadcrumb-item active " aria-current="page" style="font-size: 20px;">Track Status</li>
      </ol>
    </nav>
  </div>


<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card ">
                <div class="card-body">
                    <!-- Header -->
                    <h2 class="text-center fw-bold">Track Your Bus Pass Status</h2>
                    <p class="text-center text-muted">Enter your email to check your bus pass details.</p>

                    <!-- Form -->
                    <form method="GET" class="mt-3">
                        <label for="email" class="form-label fw-bold">Enter Your Email:</label>
                        <input type="email" name="email" class="form-control rounded-pill" placeholder="yourname@example.com" required>
                        <button type="submit" class="btn btn- w-100 mt-3 rounded-pill" style="background-color: indianred;color: white;">Check Status</button>
                    </form>

                    <!-- Status Display -->
                    <?php
                    if (isset($_GET['email'])) {
                        $email = $_GET['email'];

                        // Fetch user ID using email
                        $query = "SELECT id FROM users WHERE email = ?";
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param("s", $email);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            $user = $result->fetch_assoc();
                            $user_id = $user["id"];

                            // Fetch the latest bus pass details
                            $query_pass = "SELECT pass_type, status, valid_until FROM bus_pass WHERE user_id = ? ORDER BY id DESC LIMIT 1";
                            $stmt_pass = $conn->prepare($query_pass);
                            $stmt_pass->bind_param("i", $user_id);
                            $stmt_pass->execute();
                            $result_pass = $stmt_pass->get_result();

                            if ($result_pass->num_rows > 0) {
                                $bus_pass = $result_pass->fetch_assoc();
                                
                                // Convert pass_type to readable format
                                $pass_type_text = ($bus_pass["pass_type"] == 1) ? "Monthly" : 
                                                  (($bus_pass["pass_type"] == 3) ? "Quarterly" : 
                                                  (($bus_pass["pass_type"] == 6) ? "Half-Yearly" : "Yearly"));

                                // Calculate remaining days
                                $valid_until_date = new DateTime($bus_pass["valid_until"]);
                                $today = new DateTime();
                                $interval = $today->diff($valid_until_date);
                                $days_left = $interval->days;
                                $status_message = ($valid_until_date > $today) ? "$days_left days left" : "Expired";

                                echo "<div class='mt-4 p-3 alert alert-primary'>";
                                echo "<p><strong>Pass Type:</strong> " . $pass_type_text . "</p>";
                                echo "<p><strong>Status:</strong> " . ucfirst($bus_pass["status"]) . "</p>";
                                echo "<p><strong>Valid Until:</strong> " . $bus_pass["valid_until"] . "</p>";
                                echo "<p><strong>Remaining Time:</strong> " . $status_message . "</p>";
                                echo "</div>";

                                // Alert if pass is about to expire
                                if ($valid_until_date > $today && $days_left <= 5) {
                                    echo "<div class='mt-3 alert alert-warning text-center'><strong> Your pass is expiring soon!</strong> Only $days_left days left.</div>";
                                }
                            } else {
                                echo "<div class='mt-3 alert alert-warning text-center'>No active bus pass found for this email.</div>";
                            }
                        } else {
                            echo "<div class='mt-3 alert alert-danger text-center'>No user found with this email.</div>";
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div><br><br><br><br><br>
<!-- Include FontAwesome for Icons -->
<script src="https://kit.fontawesome.com/your-fontawesome-kit.js" crossorigin="anonymous"></script>
<br><br>

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
