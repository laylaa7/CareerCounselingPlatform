<?php
class ResumeModel {
    // Function to sanitize inputs
    public static function sanitizeInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Function to process and structure the resume data
    public static function processResumeData($postData) {
        $resumeData = [
            'fullName' => self::sanitizeInput($postData['fullName'] ?? ''),
            'email' => self::sanitizeInput($postData['email'] ?? ''),
            'phone' => self::sanitizeInput($postData['phone'] ?? ''),
            'address' => self::sanitizeInput($postData['address'] ?? ''),
            'education' => [],
            'workExperience' => [],
            'skills' => []
        ];

        // Process education
        if (isset($postData['degree'])) {
            foreach ($postData['degree'] as $i => $degree) {
                if (!empty($degree)) {
                    $resumeData['education'][] = [
                        'degree' => self::sanitizeInput($degree),
                        'institution' => self::sanitizeInput($postData['institution'][$i] ?? ''),
                        'gradYear' => self::sanitizeInput($postData['gradYear'][$i] ?? '')
                    ];
                }
            }
        }

        // Process work experience
        if (isset($postData['jobTitle'])) {
            foreach ($postData['jobTitle'] as $i => $jobTitle) {
                if (!empty($jobTitle)) {
                    $resumeData['workExperience'][] = [
                        'jobTitle' => self::sanitizeInput($jobTitle),
                        'company' => self::sanitizeInput($postData['company'][$i] ?? ''),
                        'startDate' => self::sanitizeInput($postData['startDate'][$i] ?? ''),
                        'endDate' => self::sanitizeInput($postData['endDate'][$i] ?? ''),
                        'jobDescription' => self::sanitizeInput($postData['jobDescription'][$i] ?? '')
                    ];
                }
            }
        }

        // Process skills
        if (isset($postData['skill'])) {
            foreach ($postData['skill'] as $i => $skill) {
                if (!empty($skill)) {
                    $resumeData['skills'][] = [
                        'skill' => self::sanitizeInput($skill),
                        'skillLevel' => self::sanitizeInput($postData['skillLevel'][$i] ?? '')
                    ];
                }
            }
        }

        return $resumeData;
    }
}
