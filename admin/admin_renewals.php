<?php 
session_start(); 
include "config.php"; 
if (!isset($_SESSION["admin_id"])) { 
header("Location: admin_login.php"); 
exit(); 
} 
$result = $conn->query("SELECT * FROM bus_pass WHERE renewed=1"); 
?> 
<!DOCTYPE html> 
<html lang="en"> 
<head> 
<title>Manage Renewed Passes</title> 
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" 
rel="stylesheet"> 
</head> 
<body> 
<div class="container mt-4"> 
<h2>Manage Renewed Passes</h2> 
<table class="table table-bordered"> 
<thead> 
<tr> 
<th>ID</th><th>User ID</th><th>New Validity</th><th>Status</th> 
</tr> 
</thead> 
<tbody> 
<?php while ($row = $result->fetch_assoc()): ?> 
<tr> 
<td><?= $row["id"] ?></td> 
<td><?= $row["user_id"] ?></td> 
<td><?= $row["valid_until"] ?></td> 
<td><span class="badge bg-success">Renewed</span></td> 
</tr> 
<?php endwhile; ?> 
</tbody> 
</table> 
</div> 
</body> 
</html> 