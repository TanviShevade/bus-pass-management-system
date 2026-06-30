<?php
require_once __DIR__ . '/../tcpdf/tcpdf.php'; // Adjust the path as needed
include "../config.php"; // Ensure database connection
session_start();

// Ensure admin is logged in
if (!isset($_SESSION["admin_logged_in"]) || $_SESSION["admin_logged_in"] !== true) {
    die("Unauthorized access!");
}

// Fetch all users with active bus passes
$query = "SELECT u.id, u.name, u.email, u.user_type, u.photo, 
                 b.source_stop, b.destination_stop, b.pass_type, b.valid_until, 
                 b.total_fare, b.discount_percent, b.discount_amount, 
                 b.final_paid_amount, b.payment_status 
          FROM users u
          JOIN bus_pass b ON u.id = b.user_id
          ORDER BY u.id ASC";
$result = $conn->query($query);

if ($result->num_rows == 0) {
    die("No records found!");
}

// Initialize PDF
$pdf = new TCPDF();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor("Admin");
$pdf->SetTitle("Bus Pass Report");
$pdf->SetMargins(10, 10, 10);
$pdf->AddPage();

// Set header
$pdf->SetFont('dejavusans', 'B', 16);
$pdf->Cell(0, 10, "🚌 Bus Pass Report", 0, 1, 'C');
$pdf->SetFont('dejavusans', '', 12);
$pdf->Ln(5);

// Table Header
$html = '
<table border="1" cellpadding="5">
    <tr style="background-color: #f2f2f2; font-weight: bold;">
        <th>#</th>
        <th>User</th>
        <th>Email</th>
        <th>Type</th>
        <th>Route</th>
        <th>Pass Type</th>
        <th>Valid Until</th>
        <th>Total Fare</th>
        <th>Discount</th>
        <th>Final Paid</th>
        <th>Status</th>
    </tr>';

// Fetch data and append rows
$counter = 1;
while ($row = $result->fetch_assoc()) {
    $html .= '<tr>
        <td>' . $counter . '</td>
        <td>' . htmlspecialchars($row["name"]) . '</td>
        <td>' . htmlspecialchars($row["email"]) . '</td>
        <td>' . ucfirst(htmlspecialchars($row["user_type"])) . '</td>
        <td>' . htmlspecialchars($row["source_stop"]) . ' → ' . htmlspecialchars($row["destination_stop"]) . '</td>
        <td>' . htmlspecialchars($row["pass_type"]) . ' Months</td>
        <td>' . date("d M Y", strtotime($row["valid_until"])) . '</td>
        <td>₹' . number_format($row["total_fare"], 2) . '</td>
        <td>' . $row["discount_percent"] . '% (-₹' . number_format($row["discount_amount"], 2) . ')</td>
        <td>₹' . number_format($row["final_paid_amount"], 2) . '</td>
        <td><b>' . ucfirst($row["payment_status"]) . '</b></td>
    </tr>';
    $counter++;
}

$html .= '</table>';

// Write to PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Output the PDF
$pdf->Output("Bus_Pass_Report.pdf", "D");

?>
