<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "trial#1";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id , StudentName , description , Interview From Interviews";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interview Prep Preview</title>
    <link rel="stylesheet" href="../../public/assets/styles/ResumePreview.css"> 

</head>
<header>
    <div>
        <nav class="navbar">
        <?php include "../../tests/Navbar.php"; ?>
         </nav>
         
        
    </div>
    
 </header>
 
 <body>
    <main>
    <!-- <a href="#" class="back-arrow">&#8592;</a> -->
</main>
 
    <main>
        <a href="#" >&#8592;</a>
        <h1>Interview Prep Preview</h1>
        <p class="subtitle">Students who provided their interview assesment for feedback </p>
        <div id="student-list">
            <?php 
            if($result->num_rows > 0){
                while($student = $result->fetch_assoc()) {
                    echo '
                    <div class="student-card">
                        <div class="student-image"></div>
                        <div class="student-info">
                            <div class="student-name">' . htmlspecialchars($student['StudentName']) . '</div>
                            <div class="student-description">' . htmlspecialchars($student['description']) . '</div>
                            <button class="review-button" onclick="reviewStudent(' . $student['id'] . ')">Review</button>
                        </div>
                    </div>';
                }
            } else{
                echo "<p>No Students found </p>";
            }
            $conn->close();
            ?>
        </div>
    </main>
    
    <script>
       function reviewStudent(id) {
            console.log(`Reviewing student ${id}`);
            // Implement review logic here
        }
    </script>
</body>
</html>