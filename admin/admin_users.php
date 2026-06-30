<?php 
session_start();
if (!isset($_SESSION["admin_logged_in"]) || $_SESSION["admin_logged_in"] !== true) {
    header("Location: admin_login.php");
    exit();
}
include "../config.php"; // Ensure correct database connection 
$result = $conn->query("SELECT * FROM users"); 
?> 
<!DOCTYPE html> 
<html lang="en"> 
<head> 
<title>Manage Users</title> 
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" 
rel="stylesheet"> 
</head> 
<body>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
       <h2>Manage Users</h2>
        <a href="admin_dashboard.php" class="btn btn-warning">Back to Dashboard</a>
    </div>
<table class="table table-bordered"> 
<thead> 
<tr> 
<th>ID</th><th>Name</th><th>Email</th><th>User Type</th><th>Action</th> 
</tr> 
</thead> 
<tbody> 
<?php while ($row = $result->fetch_assoc()): ?> 
<tr> 
<td><?= $row["id"] ?></td> 
<td><?= $row["name"] ?></td> 
<td><?= $row["email"] ?></td> 
<td><?= ucfirst($row["user_type"]) ?></td> 
<td> 
<a href="delete_user.php?id=<?= $row['id'] ?>" class="btn btn-danger btn
sm">Delete</a> 

</td> 
</tr> 
<?php endwhile; ?> 
</tbody> 
</table> 
<center><a href="generate_report.php" class="btn btn-primary">Download PDF Report</a></center>

</div> 
</body> 
</html>