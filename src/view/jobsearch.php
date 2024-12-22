<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Search</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .job-listing {
            border: 1px solid #ccc;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .job-listing h3 {
            margin: 0 0 10px;
            font-size: 18px;
        }
        .job-listing p {
            margin: 5px 0;
        }
        .job-listing a {
            color: #0073e6;
            text-decoration: none;
        }
        .job-listing a:hover {
            text-decoration: underline;
        }
        form {
            margin-bottom: 30px;
        }
        form label {
            font-weight: bold;
        }
        form input {
            margin: 5px 0 15px;
            padding: 8px;
            width: 100%;
            max-width: 400px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        form button {
            padding: 10px 20px;
            background-color: #0073e6;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        form button:hover {
            background-color: #005bb5;
        }
    </style>
</head>
<body>
    <h1>Job Search</h1>
    <form method="POST" action="../../src/api/fetchjobs.php">
        <label for="keywords">Keywords:</label>
        <input type="text" id="keywords" name="keywords" placeholder="e.g., Developer, Manager" required>
        <br>
        <label for="geo_code">Location Code:</label>
        <input type="number" id="geo_code" name="geo_code" placeholder="e.g., 101" required>
        <br>
        <button type="submit">Search Jobs</button>
    </form>

    <h2>Job Results:</h2>
    <div id="job-results">
        <?php
        // Safely include job results with error handling
        $fetchJobsPath = '../../src/api/fetchjobs.php';
        if (file_exists($fetchJobsPath)) {
            include $fetchJobsPath;
        } else {
            echo "<p style='color: red;'>Job results could not be loaded. Please check the API file path.</p>";
        }
        ?>
    </div>
</body>
</html>
