<?php
require_once __DIR__ . '/tcpdf/tcpdf.php';
include "config.php"; 
session_start();

if (!isset($_SESSION["user_id"])) {
    die("Unauthorized access!");
}

$user_id = $_SESSION["user_id"];

// Fetch user details
$query = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Fetch bus pass details
$query_pass = "SELECT * FROM bus_pass WHERE user_id = ? ORDER BY id DESC LIMIT 1";
$stmt_pass = $conn->prepare($query_pass);
$stmt_pass->bind_param("i", $user_id);
$stmt_pass->execute();
$result_pass = $stmt_pass->get_result();
$pass = $result_pass->fetch_assoc();

if (!$pass) {
    die("No bus pass found!");
}

// Set user photo path
$photo_url = (!empty($user["photo"])) ? __DIR__ . "/" . $user["photo"] : __DIR__ . "/uploads/default.png";
if (!file_exists($photo_url)) {
    $photo_url = __DIR__ . "/uploads/default.png"; // Fallback to default image
}

// Generate QR Code Content (Encoded Data)
$qrData = "Bus Pass Verification:\n" .
          "Name: " . $user["name"] . "\n" .
          "Email: " . $user["email"] . "\n" .
          "Route: " . $pass["source_stop"] . " → " . $pass["destination_stop"] . "\n" .
          "Valid Until: " . date("d M Y", strtotime($pass["valid_until"])) . "\n" .
          "Status: " . ucfirst($pass["payment_status"]);

// Create PDF
$pdf = new TCPDF();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor($user["name"]);
$pdf->SetTitle("Bus Pass");
$pdf->SetMargins(10, 10, 10);
$pdf->AddPage();

// Set UTF-8 font
$pdf->SetFont('dejavusans', '', 12);

// Generate HTML
$html = '
<style>
    .table-header { font-weight: bold; background-color: #f2f2f2; }
    .pass-status { font-weight: bold; color: green; }
    .user-photo { border: 1px solid #000; padding: 3px; }
</style>

<h2 style="text-align:center;">🚌 Bus Pass</h2>
<hr>

<!-- User Details with Photo -->
<table border="1" cellpadding="5">
    <tr>
        <td width="70%">
            <h3>👤 User Details</h3>
            <table border="1" cellpadding="5">
                <tr><th class="table-header">Name</th><td>' . htmlspecialchars($user["name"], ENT_QUOTES, 'UTF-8') . '</td></tr>
                <tr><th class="table-header">Email</th><td>' . htmlspecialchars($user["email"], ENT_QUOTES, 'UTF-8') . '</td></tr>
                <tr><th class="table-header">User Type</th><td>' . ucfirst(htmlspecialchars($user["user_type"], ENT_QUOTES, 'UTF-8')) . '</td></tr>';

if ($user["user_type"] == "student") {
    $html .= '<tr><th class="table-header">Institution</th><td>' . htmlspecialchars($user["institution_name"], ENT_QUOTES, 'UTF-8') . '</td></tr>';
} elseif ($user["user_type"] == "kamgar") {
    $html .= '<tr><th class="table-header">Company</th><td>' . htmlspecialchars($user["company_name"], ENT_QUOTES, 'UTF-8') . '</td></tr>';
}

$html .= '
            </table>
        </td>
        <td width="30%" align="center">
            <img src="' . $photo_url . '" width="100" height="100" class="user-photo">
        </td>
    </tr>
</table>

<!-- Bus Pass Details -->
<h3>🚌 Bus Pass Details</h3>
<table border="1" cellpadding="5">
    <tr><th class="table-header">Route</th><td>' . htmlspecialchars($pass["source_stop"], ENT_QUOTES, 'UTF-8') . ' → ' . htmlspecialchars($pass["destination_stop"], ENT_QUOTES, 'UTF-8') . '</td></tr>
    <tr><th class="table-header">Pass Type</th><td>' . htmlspecialchars($pass["pass_type"], ENT_QUOTES, 'UTF-8') . ' Months</td></tr>
    <tr><th class="table-header">Valid Until</th><td>' . date("d M Y", strtotime($pass["valid_until"])) . '</td></tr>
    <tr><th class="table-header">Total Fare</th><td>₹' . number_format($pass["total_fare"], 2) . '</td></tr>
    <tr><th class="table-header">Discount</th><td>' . $pass["discount_percent"] . '% (-₹' . number_format($pass["discount_amount"], 2) . ')</td></tr>
    <tr><th class="table-header">Final Amount Paid</th><td>₹' . number_format($pass["final_paid_amount"], 2) . '</td></tr>
    <tr><th class="table-header">Pass Status</th><td class="pass-status">' . ucfirst($pass["payment_status"]) . '</td></tr>
</table>

<!-- QR Code -->
<h3>🔍 Scan to Verify</h3>
<table >
    <tr>
        <td align="center"><img src="@QR_CODE@" /></td>
    </tr>
</table>
';

// Replace QR Code Placeholder
$pdf->writeHTML(str_replace('@QR_CODE@', '', $html), true, false, true, false, '');

// Generate & Add QR Code
$style = ['border' => false, 'vpadding' => 'auto', 'hpadding' => 'auto', 'fgcolor' => [0, 0, 0], 'bgcolor' => false];
$pdf->write2DBarcode($qrData, 'QRCODE,H', 80, 180, 40, 40, $style, 'N');
// Output PDF
$pdf->Output("Bus_Pass.pdf", "D");
?>
