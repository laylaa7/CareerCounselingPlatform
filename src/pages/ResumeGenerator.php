<?php
// Clear any previous output
ob_clean();
ob_start();

// Strict error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Verify TCPDF library
if (!file_exists('../../vendor/tecnickcom/tcpdf/tcpdf.php')) {
    die("TCPDF library not found. Please download and place in 'tcpdf' directory.");
}

// Include TCPDF
require '../../vendor/tecnickcom/tcpdf/tcpdf.php';

class ResumeGenerator extends TCPDF {
    // Color Scheme
    private $headerColor = [41, 128, 185];    // Flat Blue
    private $textColor = [44, 62, 80];        // Dark Blue-Gray
    private $lightTextColor = [127, 140, 141]; // Gray

    public function Header() {
        // Optional: Custom header (left blank for clean design)
    }

    public function Footer() {
        // Page number in footer
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
        $this->SetTextColor(100, 100, 100);
        $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . ' of ' . $this->getAliasNbPages(), 0, false, 'C');
    }

    private function setSectionStyle($title) {
        $this->SetTextColor($this->headerColor[0], $this->headerColor[1], $this->headerColor[2]);
        $this->SetFont('helvetica', 'B', 14);
        $this->Cell(0, 10, $title, 'B', 1, 'L');
        $this->SetTextColor($this->textColor[0], $this->textColor[1], $this->textColor[2]);
    }

    public function generateResume($data) {
        // Ensure data is valid
        if (empty($data['fullName'])) {
            throw new Exception("Invalid resume data");
        }

        $this->AddPage();
        
        // Personal Information Header
        $this->SetFillColor($this->headerColor[0], $this->headerColor[1], $this->headerColor[2]);
        $this->SetTextColor(255, 255, 255);
        $this->SetFont('helvetica', 'B', 20);
        $this->Cell(0, 15, strtoupper($data['fullName']), 0, 1, 'C', true);

        // Contact Information
        $this->SetTextColor($this->textColor[0], $this->textColor[1], $this->textColor[2]);
        $this->SetFont('helvetica', '', 10);
        $contactInfo = [];
        if (!empty($data['email'])) $contactInfo[] = $data['email'];
        if (!empty($data['phone'])) $contactInfo[] = $data['phone'];
        if (!empty($data['address'])) $contactInfo[] = $data['address'];
        
        $this->Cell(0, 10, implode(' | ', $contactInfo), 0, 1, 'C');
        $this->Ln(5);

        // Education Section
        $this->setSectionStyle('EDUCATION');
        $this->SetFont('helvetica', '', 10);

        if (!empty($data['education'])) {
            foreach ($data['education'] as $edu) {
                $this->SetFont('helvetica', 'B', 11);
                $this->Cell(0, 7, 
                    ($edu['degree'] ?? '') . ' - ' . 
                    ($edu['institution'] ?? ''), 
                    0, 1, 'L'
                );
                $this->SetFont('helvetica', 'I', 10);
                $this->SetTextColor($this->lightTextColor[0], $this->lightTextColor[1], $this->lightTextColor[2]);
                $this->Cell(0, 7, 'Graduation Year: ' . ($edu['gradYear'] ?? 'N/A'), 0, 1, 'L');
                $this->SetTextColor($this->textColor[0], $this->textColor[1], $this->textColor[2]);
            }
        }

        $this->Ln(5);

        // Work Experience Section
        $this->setSectionStyle('PROFESSIONAL EXPERIENCE');
        $this->SetFont('helvetica', '', 10);

        if (!empty($data['workExperience'])) {
            foreach ($data['workExperience'] as $work) {
                $this->SetFont('helvetica', 'B', 11);
                $this->Cell(0, 7, 
                    ($work['jobTitle'] ?? '') . ' at ' . 
                    ($work['company'] ?? ''), 
                    0, 1, 'L'
                );
                $this->SetFont('helvetica', 'I', 10);
                $this->SetTextColor($this->lightTextColor[0], $this->lightTextColor[1], $this->lightTextColor[2]);
                $this->Cell(0, 7, 
                    ($work['startDate'] ?? '') . ' - ' . 
                    ($work['endDate'] ?? 'Present'), 
                    0, 1, 'L'
                );
                $this->SetTextColor($this->textColor[0], $this->textColor[1], $this->textColor[2]);
                $this->SetFont('helvetica', '', 10);
                $this->MultiCell(0, 7, $work['jobDescription'] ?? '', 0, 'L');
            }
        }

        $this->Ln(5);

        // Skills Section
        $this->setSectionStyle('SKILLS');
        $this->SetFont('helvetica', '', 10);

        if (!empty($data['skills'])) {
            $skillList = [];
            foreach ($data['skills'] as $skill) {
                $skillList[] = 
                    ($skill['skill'] ?? '') . 
                    ' (' . ($skill['skillLevel'] ?? 'N/A') . ')';
            }
            $this->Cell(0, 7, implode(' • ', $skillList), 0, 1, 'L');
        }
    }
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Clear any output before PDF generation
        ob_clean();
        
        // Sanitization function
        function sanitizeInput($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        // Collect resume data with null coalescing
        $resumeData = [
            'fullName' => sanitizeInput($_POST['fullName'] ?? ''),
            'email' => sanitizeInput($_POST['email'] ?? ''),
            'phone' => sanitizeInput($_POST['phone'] ?? ''),
            'address' => sanitizeInput($_POST['address'] ?? ''),
            'education' => [],
            'workExperience' => [],
            'skills' => []
        ];

        // Collect education
        if (isset($_POST['degree'])) {
            foreach ($_POST['degree'] as $i => $degree) {
                if (!empty($degree)) {
                    $resumeData['education'][] = [
                        'degree' => sanitizeInput($degree),
                        'institution' => sanitizeInput($_POST['institution'][$i] ?? ''),
                        'gradYear' => sanitizeInput($_POST['gradYear'][$i] ?? '')
                    ];
                }
            }
        }

        // Collect work experience
        if (isset($_POST['jobTitle'])) {
            foreach ($_POST['jobTitle'] as $i => $jobTitle) {
                if (!empty($jobTitle)) {
                    $resumeData['workExperience'][] = [
                        'jobTitle' => sanitizeInput($jobTitle),
                        'company' => sanitizeInput($_POST['company'][$i] ?? ''),
                        'startDate' => sanitizeInput($_POST['startDate'][$i] ?? ''),
                        'endDate' => sanitizeInput($_POST['endDate'][$i] ?? ''),
                        'jobDescription' => sanitizeInput($_POST['jobDescription'][$i] ?? '')
                    ];
                }
            }
        }

        // Collect skills
        if (isset($_POST['skill'])) {
            foreach ($_POST['skill'] as $i => $skill) {
                if (!empty($skill)) {
                    $resumeData['skills'][] = [
                        'skill' => sanitizeInput($skill),
                        'skillLevel' => sanitizeInput($_POST['skillLevel'][$i] ?? '')
                    ];
                }
            }
        }

        // Create and generate PDF
        $pdf = new ResumeGenerator();
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(true);

        // Generate the resume
        $pdf->generateResume($resumeData);

        // Output the PDF
        $pdf->Output($resumeData['fullName'] . '_Resume.pdf', 'D');
        exit();

    } catch (Exception $e) {
        // Log error
        error_log("PDF Generation Error: " . $e->getMessage());
        
        // Display user-friendly error
        die("Error generating PDF. Please check your input and try again.");
    }
}
?>