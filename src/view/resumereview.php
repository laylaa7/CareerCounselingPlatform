
<!DOCTYPE html>
<html>
<head>
    <title>Upload Resume</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <h2>Upload Your Resume</h2>
        <form action="../helpers/uploadresume.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>Student ID</label>
                <input type="number" name="student_id" required>
            </div>
            <div class="form-group">
                <label>Select Resume (PDF only)</label>
                <input type="file" name="resume" accept=".pdf" required>
            </div>
            <button type="submit" class="btn btn-primary">Upload</button>
        </form>
    </div>
</body>
</html>