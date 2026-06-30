<?php
session_start();
if (!isset($_SESSION["admin_logged_in"]) || $_SESSION["admin_logged_in"] !== true) {
    header("Location: admin_login.php");
    exit();
}

include "../config.php"; // Database connection

// Handle feedback deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_feedback"])) {
    $feedback_id = $_POST["feedback_id"];
    $delete_sql = "DELETE FROM feedback WHERE id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $feedback_id);

    if ($stmt->execute()) {
        $message = "<div class='alert alert-success'>Feedback deleted successfully.</div>";
    } else {
        $message = "<div class='alert alert-danger'>Error deleting feedback: " . $conn->error . "</div>";
    }
}

// Search functionality
$search_query = "";
if (isset($_GET['search'])) {
    $search_query = $conn->real_escape_string($_GET['search']);
}

// Fetch feedback messages
$sql = "SELECT id, name, email, message, created_at
        FROM feedback
        WHERE name LIKE '%$search_query%' 
        OR email LIKE '%$search_query%' 
        OR message LIKE '%$search_query%'
        ORDER BY created_at DESC";

$result = $conn->query($sql);

if (!$result) {
    die("Error fetching feedback: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Feedback</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
       <h2>User Feedback</h2>
        <a href="admin_dashboard.php" class="btn btn-warning">Back to Dashboard</a>
    </div>

   

    <?php if (isset($message)) echo $message; ?>

    <table class="table table-bordered bg-white shadow-sm">
        <thead class="table-danger">
            <tr>
                <th>ID</th>
                <th>User Name</th>
                <th>Email</th>
                <th>Feedback Message</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row["id"]; ?></td>
                        <td><?php echo htmlspecialchars($row["name"]); ?></td>
                        <td><?php echo htmlspecialchars($row["email"]); ?></td>
                        <td><?php echo htmlspecialchars($row["message"]); ?></td>
                        <td><?php echo $row["created_at"]; ?></td>
                        <td>
                            <form method="post" onsubmit="return confirm('Are you sure you want to delete this feedback?');">
                                <input type="hidden" name="feedback_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="delete_feedback" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">No feedback available.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
