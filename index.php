<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus Pass Management System</title>
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
            <div class="container d-flex align-items-center">
                <img src="buslogo-removebg-preview (1).png" alt="MSRTC Logo" height="140" width="150">
                <div>
                    <h1 class="h5 mb-0" style="font-size: 26px;">Maharashtra State Road Transport Corporation</h1>
                    <small style="font-size: 19px;">महाराष्ट्र राज्य मार्ग परिवहन महामंडळ</small>
                </div>
            </div>
        </div>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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
                    <a class="nav-link dropdown-toggle" href="login.php" id="loginDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">Login</a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                    <ul class="dropdown-menu" aria-labelledby="loginDropdown">
                        <li><a class="dropdown-item" href="/bus_pass_system/login.php">User Login</a></li>
                        <li><a class="dropdown-item" href="/bus_pass_system/admin/admin_login.php">Admin Login</a></li>

                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="helpDropdown" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">Help/Support</a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                    <ul class="dropdown-menu" aria-labelledby="helpDropdown">
                        <li><a class="dropdown-item" href="faqs.php">FAQs</a></li>
                        <li><a class="dropdown-item" href="contact_form.php">Contact Us</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Hero Section with Background Image -->
    <div class="container-fluid" style="position: relative; height: 98vh; background: url('bus1.jpg') no-repeat center center/cover;">
        <div class="d-flex flex-column justify-content-center align-items-center h-100 text-center text-white">
            <div class="text-black" style="margin-top: -170px;">
                <h1 class="display-4" style="font-family: candara">Bus Pass Management System</h1>
                <p class="lead" style="font-size: 200%;font-family: candara">Now finding bus passes is easier.<br/>
                    Effortless application, renewal, and management of bus passes.</p>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <section class="features py-5 bg-light">
        <div class="container text-center">
            <h3 class="mb-4">Why Choose Us?</h3>
            <div class="row">
                <div class="col-md-4 col-sm-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <i class="bi bi-speedometer2 display-4 text-primary"></i>
                            <h5 class="card-title mt-3">Fast Applications</h5>
                            <p class="card-text">Get your bus pass in no time with our streamlined process.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <i class="bi bi-repeat display-4 text-success"></i>
                            <h5 class="card-title mt-3">Easy Renewals</h5>
                            <p class="card-text">Renew your pass with just a few clicks <br>online.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <i class="bi bi-bell display-4 text-warning"></i>
                            <h5 class="card-title mt-3">Notifications</h5>
                            <p class="card-text">Receive updates and reminders about your pass status.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call-to-Action Section -->
    <section class="cta text-black bg- py-5">
        <div class="container text-center">
            <h2>Ready to Get Started?</h2>
            <p class="lead" style="font-family:Candara">Join thousands of users who rely on us for bus pass management.</p>
            <a href="register.php" class="btn btn-success btn-lg mt-3">Register Now</a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center text-md-start">
        <div class="container p-4">
            <div class="row">
                <div class="col-md-4 mb-4 mb-md-0">
                    <h5 class="text-uppercase">Location</h5>
                    <p>&copy; 2023 Bus Pass Management System</p>
                    <p>
                        <a href="contact_form.php" class="text-white text-decoration-underline">Contact Us</a> |
                        <a href="#" class="text-white text-decoration-underline">Privacy Policy</a>
                    </p>
                </div>
                <div class="col-md-4 mb-4 mb-md-0">
                    <h5 class="text-uppercase">Hours</h5>
                    <p>Monday - Sunday<br>7:00 a.m - 6:00 p.m.<br></p>
                </div>
                <div class="col-md-4 mb-4 mb-md-0">
                    <h5 class="text-uppercase">Contact</h5>
                    <p>Email: <a href="mailto:msrtchelpdest@gmail.com" class="text-white">msrtchelpdest@gmail.com</a></p>
                    <p>Phone: <a href="tel:1800221250" class="text-white">1800 22 1250</a></p>
                    <p>Fax: <a href="fax:1800221250" class="text-white">1800 22 1250</a></p>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col text-center">
                    <p>Follow our news, updates, and activities on:</p>
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





                            