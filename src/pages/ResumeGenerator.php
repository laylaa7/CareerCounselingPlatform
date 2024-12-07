<?php
require '../../vendor/setasign/fpdf/fpdf.php';

// Get the data from the POST request
$Fname = $_POST['first-name'];
$Surname = $_POST['surname'];
$title = $_POST['title'];
$City = $_POST['city'];
$Phone = $_POST['phone'];

$School = $_POST['school-name'];
$Degree = $_POST['degree'];
$Field = $_POST['field-of-study'];
$GraduationDate = $_POST['graduation-date'];

$JobTitle = $_POST['job-title'];
$Employer = $_POST['employer'];
$Location = $_POST['location'];
$Start = $_POST['start-date'];
$End = $_POST['end-date'];
$Skills = isset($_POST['skills']) ? implode(', ', $_POST['skills']) : ''; // Assuming skills are passed as an array

// Initialize PDF document
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Title of the document
$pdf->Cell(200, 10, 'Resume', 0, 1, 'C');

// Personal Information Section
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(200, 10, 'Personal Information', 0, 1, 'L');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(200, 10, "Name: $title $Fname $Surname", 0, 1, 'L');
$pdf->Cell(200, 10, "City: $City", 0, 1, 'L');
$pdf->Cell(200, 10, "Phone: $Phone", 0, 1, 'L');
$pdf->Ln(10); // Line break

// Education Section
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(200, 10, 'Education', 0, 1, 'L');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(200, 10, "School: $School", 0, 1, 'L');
$pdf->Cell(200, 10, "Degree: $Degree", 0, 1, 'L');
$pdf->Cell(200, 10, "Field of Study: $Field", 0, 1, 'L');
$pdf->Cell(200, 10, "Graduation Date: $GraduationDate", 0, 1, 'L');
$pdf->Ln(10); // Line break

// Work History Section
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(200, 10, 'Work History', 0, 1, 'L');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(200, 10, "Job Title: $JobTitle", 0, 1, 'L');
$pdf->Cell(200, 10, "Employer: $Employer", 0, 1, 'L');
$pdf->Cell(200, 10, "Location: $Location", 0, 1, 'L');
$pdf->Cell(200, 10, "Start Date: $Start", 0, 1, 'L');
$pdf->Cell(200, 10, "End Date: $End", 0, 1, 'L');
$pdf->Ln(10); // Line break

// Skills Section
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(200, 10, 'Skills', 0, 1, 'L');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(200, 10, "Skills: $Skills", 0, 1, 'L');
$pdf->Ln(10); // Line break

// Output PDF
$pdf->Output();
?>

