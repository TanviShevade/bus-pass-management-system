<?php 
session_start(); 
if (!isset($_SESSION["user_id"])) { 
    header("Location: login.php"); 
    exit(); 
} 
 
include "config.php"; 
$user_id = $_SESSION["user_id"]; 
$pass = $conn->query("SELECT * FROM bus_pass WHERE user_id='$user_id' ORDER BY id 
DESC LIMIT 1")->fetch_assoc(); 
?> 
<!DOCTYPE html> 
<html lang="en"> 
<head> 
<title>My Bus Pass</title> 
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" 
rel="stylesheet"> 
</head> 
<body class="bg-light"> 
<div class="container mt-5"> 
<h2>My Bus Pass Details</h2> 
<?php if ($pass): ?> 
<table class="table table-bordered"> 
<tr> 
<th>Pass ID</th> 
<td><?= $pass['id'] ?></td> 
</tr> 
<tr> 
<th>Pass Type</th> 
<td><?= ucfirst($pass['pass_type']) ?> Months</td> 
</tr> 
<tr> 
<th>Valid Until</th> 
<td><?= $pass['valid_until'] ?></td> 
</tr> 
<tr> 
<th>Status</th> 
<td> 
<span class="badge bg-<?= ($pass['status'] == 'approved') ? 'success' : 
(($pass['status'] == 'pending') ? 'warning' : 'danger') ?>"> 
<?= ucfirst($pass['status']) ?> 
</span> 
</td> 
</tr> 
</table> 
<?php if ($pass['status'] == 'approved'): ?> 
<a href="generate_pass.php" class="btn btn-success">Download Pass (PDF)</a> 
<?php endif; ?> 
<?php else: ?> 
<div class="alert alert-warning text-center">No pass found. Please apply for a bus 
pass.</div> 
<?php endif; ?> 
</div> 
</body> 
</html> 