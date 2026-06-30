<?php
session_start();
if (!isset($_SESSION["admin_logged_in"]) || $_SESSION["admin_logged_in"] !== true) {
    header("Location: admin_login.php");
    exit();
}

include "../config.php"; // Database connection

// Ensure 'id' is present
if (!isset($_GET["id"])) {
    echo "<script>alert('Invalid request. Please select a user to update.'); window.location.href='admin_users.php';</script>";
    exit();
}

$user_id = intval($_GET["id"]);

// Fetch user details
$query = "SELECT name, email, user_type, profile_photo FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "<script>alert('User not found!'); window.location.href='admin_users.php';</script>";
    exit();
}

$user = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $user_type = $_POST["user_type"];

    // Handle Profile Photo Upload
    if (!empty($_FILES["profile_photo"]["name"])) {
        $target_dir = "../uploads/";
        $file_name = basename($_FILES["profile_photo"]["name"]);
        $target_file = $target_dir . $file_name;

        // Validate File Type (Images Only)
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        $file_extension = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if (!in_array($file_extension, $allowed_types)) {
            echo "<script>alert('Only JPG, JPEG, PNG & GIF files are allowed.');</script>";
        } elseif (move_uploaded_file($_FILES["profile_photo"]["tmp_name"], $target_file)) {
            $profile_photo = $target_file;
        } else {
            echo "<script>alert('Error uploading the file. Please try again.');</script>";
        }
    } else {
        $profile_photo = $user['profile_photo']; // Retain the previous image
    }

    // Update SQL Query
    $sql = "UPDATE users SET name = ?, email = ?, user_type = ?, profile_photo = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("SQL Error: " . $conn->error);
    }

    $stmt->bind_param("ssssi", $name, $email, $user_type, $profile_photo, $user_id);

    if ($stmt->execute()) {
        echo "<script>alert('User profile updated successfully!'); window.location.href='admin_users.php';</script>";
    } else {
        echo "<script>alert('Error updating profile: " . $stmt->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin - Update User Profile</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">
    <div class="card shadow-lg border-0">
        <div class="card-header bg- text-white text-center" style="background-color: indianred;">
            <h4> Update User Profile</h4>
        </div>

        <div class="card-body">
            <form method="POST" action="admin_update_user.php?id=<?= $user_id ?>" enctype="multipart/form-data">

                <!-- Display Current Profile Photo -->
                <?php if (!empty($user['profile_photo'])): ?>
                    <div class="text-center mb-3">
                        <img src="<?= htmlspecialchars($user['profile_photo']) ?>" alt="Profile Photo" class="img-thumbnail" width="150">
                    </div>
                <?php endif; ?>

                <!-- Name Field -->
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" class="form-control" required>
                </div>

                <!-- Email Field -->
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" class="form-control" required>
                </div>

                <!-- User Type Field -->
                <div class="mb-3">
                    <label class="form-label">User Type</label>
                    <select name="user_type" class="form-select" required>
                        <option value="user" <?= $user['user_type'] === 'user' ? 'selected' : '' ?>>User</option>
                        <option value="admin" <?= $user['user_type'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                    </select>
                </div>

                <!-- Profile Photo Field -->
                <div class="mb-3">
                    <label class="form-label">Profile Photo</label>
                    <input type="file" name="profile_photo" class="form-control">
                </div>

                <!-- Submit Button -->
                <div class="d-grid">
                    <button type="submit" class="btn btn-lg" style="background-color:indianred; color: white;">
                        Update Profile
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
