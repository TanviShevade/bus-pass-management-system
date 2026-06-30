<?php
session_start();
if (!isset($_SESSION["admin_logged_in"]) || $_SESSION["admin_logged_in"] !== true) {
    header("Location: admin_login.php");
    exit();
}

require_once('../tcpdf/tcpdf.php'); // Include TCPDF
include "../config.php";

// Check if database connection exists
if (!$conn) {
    die("Database connection failed.");
}

// Fetch users from database
$result = $conn->query("SELECT * FROM users");

if (!$result) {
    die("Error fetching users: " . $conn->error);
}

// Create new PDF document
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Admin');
$pdf->SetTitle('Registered Users Report');
$pdf->SetHeaderData('', 0, 'Registered Users Report', 'Generated on: ' . date("d-m-Y"));
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetMargins(10, 20, 10);
$pdf->SetAutoPageBreak(TRUE, 10);
$pdf->SetFont('dejavusans', '', 10);
$pdf->AddPage();

// Create table header
$html = '<h2>Registered Users Report</h2>';
$html .= '<table border="1" cellpadding="5">
            <thead>
                <tr style="background-color:#f2f2f2;">
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>User Type</th>
                    <th>Institution</th>
                    <th>Company</th>
                </tr>
            </thead>
            <tbody>';

// Populate table with user data
while ($row = $result->fetch_assoc()) {
    $html .= '<tr>
                <td>' . htmlspecialchars($row['id']) . '</td>
                <td>' . htmlspecialchars($row['name']) . '</td>
                <td>' . htmlspecialchars($row['email']) . '</td>
                <td>' . htmlspecialchars($row['user_type']) . '</td>
                <td>' . htmlspecialchars($row['institution_name'] ?? 'N/A') . '</td>
                <td>' . htmlspecialchars($row['company_name'] ?? 'N/A') . '</td>
              </tr>';
}

$html .= '</tbody></table>';

// Write to PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Output the PDF (force download)
$pdf->Output('registered_users_report.pdf', 'D');
?>
