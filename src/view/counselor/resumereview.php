<html>
<head>
    <title>Counselor Dashboard</title>
    <link rel="stylesheet" href="../../../public/assets/styles/ResumeReview.css">
</head>
<body>
    <div class="container">
        <h2>Pending Resumes</h2>
        <div class="resumes-grid">
            <?php foreach($resumes as $resume): ?>
                <div class="resume-card">
                    <h3>Student: <?php echo $resume['student_name']; ?></h3>
                    <p>Uploaded: <?php echo $resume['uploaded_at']; ?></p>
                    <a href="<?php echo $resume['file_path']; ?>" 
                       class="btn btn-primary" target="_blank">
                        View Resume
                    </a>
                    <button class="btn btn-secondary" 
                            onclick="openReviewModal(<?php echo $resume['id']; ?>)">
                        Submit Review
                    </button>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    
    <!-- Review Modal -->
    <div id="reviewModal" class="modal">
        <div class="modal-content">
            <h3>Submit Review</h3>
            <form action="../helpers/reviewresume.php" method="post">
                <input type="hidden" name="resume_id" id="resume_id">
                <textarea name="feedback" required></textarea>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
    
    <script src="../../../public/assets/scripts/ResumeReview.js"></script>
</body>
</html>