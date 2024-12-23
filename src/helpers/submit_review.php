
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $db = new PDO('mysql:host=localhost;dbname=CareerCompass', 'root', '');

        $simulatorId = $_POST['simulatorId'];
        $studentId = $_POST['studentId'];
        $counselorId = 1;
        $review = $_POST['review'];

        if (empty($review)) {
            throw new Exception('Review cannot be empty.');
        }

        $query = "INSERT INTO reviews (simulatorId, studentId, counselorId, review) 
                  VALUES (:simulatorId, :studentId, :counselorId, :review)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':simulatorId', $simulatorId, PDO::PARAM_INT);
        $stmt->bindParam(':studentId', $studentId, PDO::PARAM_INT);
        $stmt->bindParam(':counselorId', $counselorId, PDO::PARAM_INT);
        $stmt->bindParam(':review', $review, PDO::PARAM_STR);

        if ($stmt->execute()) {
            header('Location: ../view/simulationresults.php?success=1');
            exit;
        } else {
            throw new Exception('Failed to save the review. Please try again.');
        }
    } catch (Exception $e) {
        header('Location: ../view/simulationresults.ph?error=' . urlencode($e->getMessage()));
        exit;
    }
}

?>
