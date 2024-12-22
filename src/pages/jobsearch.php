<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Egyptian Job Search</title>
    <style>
        .job-listing { border: 1px solid #ddd; padding: 10px; margin: 10px 0; border-radius: 5px; }
        .job-listing h3 { margin: 0; color: #3949ab; }
        .job-listing p { margin: 5px 0; }
    </style>
</head>
<body>
    <h1>Search for Jobs in Egypt</h1>
    <form action="../api/fetchJobs.php" method="GET">
        <input type="text" name="query" placeholder="Job title, keywords" required>
        <input type="text" name="location" placeholder="Location (e.g., Cairo)">
        <button type="submit">Search</button>
    </form>
</body>
</html>
