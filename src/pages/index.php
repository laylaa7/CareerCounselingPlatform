<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Layout</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Navigation Bar -->
    <nav class="navbar">
    </nav>

    <!-- Side Dashboard -->
    <div class="dashboard">
        <ul>
            <li><a href="index.php?page=home">Home Page</a></li>
            <li><a href="index.php?page=forum">Discussion Forum</a></li>
            <li><a href="index.php?page=counselor">Counselor Forum</a></li>

        </ul>
    </div>

    <!-- Main Content Area -->
    <div class="content">
        <?php
            // PHP to load different pages based on the URL parameter
            if (isset($_GET['page'])) {
                $page = $_GET['page'];

                if ($page == 'home') {
                    include 'home.php';
                } elseif ($page == 'forum') {
                    include 'forum.php';
                } 
                elseif ($page == 'counselor') { 
                    include 'counselor.php';
                }
                else {
                    echo "<h2>Page not found</h2>";
                }
            } else {
                echo "<h2>Welcome to the Home Page</h2>";
            }
        ?>
    </div>

</body>
</html>
