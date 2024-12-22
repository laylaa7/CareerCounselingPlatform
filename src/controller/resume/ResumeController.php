<?php
require_once '../../model/resume/ResumeModel.php';
require_once '../../../vendor/tecnickcom/tcpdf/tcpdf.php';

class ResumeController {
    private $headerColor = [41, 128, 185];    // Professional Blue
    private $textColor = [44, 62, 80];        // Dark Blue-Gray
    private $lightTextColor = [127, 140, 141]; // Subtle Gray
    private $accentColor = [52, 152, 219];    // Bright Blue for highlights
    private $sectionBgColor = [245, 247, 250]; // Light Blue-Gray background

    public function Header() {
        // Optional: Custom header (left blank for clean design)
    }

    public function Footer() {
        // Enhanced footer with line
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
        $this->SetDrawColor(...$this->lightTextColor);
        $this->Line(15, $this->GetY() - 2, 195, $this->GetY() - 2);
        $this->SetTextColor(...$this->lightTextColor);
        $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . ' of ' . $this->getAliasNbPages(), 0, false, 'C');
    }

    public static function generateResume() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            try {
                // Process the resume data
                $resumeData = ResumeModel::processResumeData($_POST);

                // Generate PDF using TCPDF
                $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
                $pdf->setPrintHeader(false);
                $pdf->setPrintFooter(true);
                $pdf->SetMargins(15, 15, 15); // Balanced margins
                $pdf->AddPage();

                // Set basic document properties
                $pdf->SetCreator('Resume Builder');
                $pdf->SetAuthor($resumeData['fullName']);
                $pdf->SetTitle($resumeData['fullName'] . ' - Resume');

                // Full Name Header with enhanced styling
                $pdf->SetFillColor(41, 128, 185); // Professional blue
                $pdf->SetTextColor(255, 255, 255);
                $pdf->SetFont('helvetica', 'B', 24);
                $pdf->Cell(0, 20, strtoupper($resumeData['fullName']), 0, 1, 'C', true);

                // Contact Information with icons and better spacing
                $pdf->SetTextColor(44, 62, 80);
                $pdf->SetFont('helvetica', '', 10);
                $pdf->Ln(2);
                $contactInfo = [];
                if (!empty($resumeData['email'])) {
                    $contactInfo[] =  $resumeData['email'];
                }
                if (!empty($resumeData['phone'])) {
                    $contactInfo[] =  $resumeData['phone'];  // Unicode telephone symbol
                }
                if (!empty($resumeData['address'])) {
                    $contactInfo[] =  $resumeData['address'];
                }
                $pdf->Cell(0, 10, implode(' | ', $contactInfo), 0, 1, 'C');
                $pdf->Ln(5);

                // Education Section with enhanced styling
                self::setSectionStyle($pdf, 'EDUCATION');
                if (!empty($resumeData['education'])) {
                    foreach ($resumeData['education'] as $edu) {
                        $pdf->SetFont('helvetica', 'B', 12);
                        $pdf->Cell(0, 8,'• '.($edu['degree'] ?? ''), 0, 1, 'L');
                        $pdf->SetFont('helvetica', '', 11);
                        $pdf->Cell(0, 7, ($edu['institution'] ?? ''), 0, 1, 'L');
                        $pdf->SetFont('helvetica', 'I', 10);
                        $pdf->SetTextColor(127, 140, 141);
                        $pdf->Cell(0, 7, 'Graduated: ' . ($edu['gradYear'] ?? 'N/A'), 0, 1, 'L');
                        $pdf->SetTextColor(44, 62, 80);
                        $pdf->Ln(2);
                    }
                }
                $pdf->Ln(3);

                // Work Experience Section with improved formatting
                self::setSectionStyle($pdf, 'PROFESSIONAL EXPERIENCE');
                if (!empty($resumeData['workExperience'])) {
                    foreach ($resumeData['workExperience'] as $work) {
                        // Company and Role on same line with different styling
                        $pdf->SetFont('helvetica', 'B', 12);
                        $pdf->Cell(0, 7, '• ' .($work['jobTitle'] ?? '') . ' at ' . ($work['company'] ?? ''), 0, 1, 'L');
                        
                        // Dates with italic styling
                        $pdf->SetFont('helvetica', 'I', 10);
                        $pdf->SetTextColor(127, 140, 141);
                        $pdf->Cell(0, 7, ($work['startDate'] ?? '') . ' - ' . ($work['endDate'] ?? 'Present'), 0, 1, 'L');
                        
                        // Job Description with proper spacing
                        $pdf->SetTextColor(44, 62, 80);
                        $pdf->SetFont('helvetica', '', 10);
                        $pdf->MultiCell(0, 7, $work['jobDescription'] ?? '', 0, 'L');
                        $pdf->Ln(3);
                    }
                }
                $pdf->Ln(3);

                // Skills Section with visual improvements
                self::setSectionStyle($pdf, 'SKILLS & EXPERTISE');
                if (!empty($resumeData['skills'])) {
                    $pdf->SetFont('helvetica', '', 10);
                    $skillGroups = array_chunk($resumeData['skills'], 3); // Group skills in sets of 3
                    foreach ($skillGroups as $group) {
                        $skillLine = [];
                        foreach ($group as $skill) {
                            $skillLine[] = '• ' . ($skill['skill'] ?? '') . ' (' . ($skill['skillLevel'] ?? 'N/A') . ')';
                        }
                        $pdf->Cell(0, 7, implode('    ', $skillLine), 0, 1, 'L');
                    }
                }

                // Output the PDF
                $pdf->Output($resumeData['fullName'] . '_Resume.pdf', 'D');
                exit();
            } catch (Exception $e) {
                error_log("Error generating resume: " . $e->getMessage());
                die("Error processing the request.");
            }
        }
    }

    private static function setSectionStyle($pdf, $title) {
        $pdf->SetFillColor(245, 247, 250); // Subtle blue-gray background
        $pdf->SetTextColor(41, 128, 185); // Professional blue text for headers
        $pdf->SetFont('helvetica', 'B', 16);
        $pdf->Cell(0, 12, $title, 0, 1, 'L', true);
        $pdf->SetTextColor(44, 62, 80); // Reset text color
        $pdf->Ln(2);
    }
}

// Trigger controller function
ResumeController::generateResume();