
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Nav Bar with PHP</title>
    <link rel="stylesheet" href="../../public/assets/styles/ResumeReview.css"> 
  
</head>
<body>

    <!-- Navigation Bar
    <nav class="navbar">
        <ul>
         <li><a href="index.php">Home</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Services</a></li>
            <li><a href="#">Contact</a></li> 
        </ul>
    </nav> -->
    <div>
    <nav class="navbar">
        <?php include "Navbar.php"; ?>
    </nav>
</div>
    <!-- Main content of the page -->
    <div class="profile-container">
    
        <!-- Left Sidebar -->
        <div class="sidebar">
       
            <!-- <img src="../../public/assets/images/BackButton.png" > -->
            <h2> Mohamed</h2>

            <hr>

            <ul class="profile-links">
                <li><a href="#" data-target="Book with our counselors">Book with our counselors</a></li>
                <li><a href="#" data-target="interview guide">interview guide</a></li>
                <li><a href="#" data-target="Discussions">Discussions</a></li>
                
            </ul>
            <hr>


            <div class="logout">
                <a href="#">Log out</a>
            </div>
        </div>
<!-- 
        <button class="back-button"> > </button> ←  -->

        <!-- Main Profile Content -->
        <div class="profile-content">
            <div class="container">
                <main>
                    <h1>Let us review your resume 👤</h1>
                    <div class="button-container" id="initialView">
                        <button class="button upload" id="quickUploadBtn"  onclick="showUploadView()">
                            <span class="icon" aria-hidden="true">↑</span>
                            Quick upload
                        </button>
                        <button class="button" onclick="redirectToResumeBuilder()">
                            Fill out your resume from scratch
                        </button>
                    </div>
                    <div class="button-container" id="uploadView">
                        <button class="button upload" onclick="document.getElementById('fileInput').click()">
                        <span class="icon" aria-hidden="true">↑</span>
                        Quick upload
                        </button>
                        <input type="file" id="fileInput" accept=".pdf,.doc,.docx">
                        <p id="fileUploaded" style="display: none; margin-top: 10px;"></p>
                    </div>
                    <div class="navigation-buttons ">
                    <button  class="nav-button" id="prev-btn" onclick="showInitialView()" disabled>←</button>
                    <button class="nav-button" id="next-btn" onclick="reviewconfirmation()" disabled>send to review</button>  
            </div>
                </main>

            </div>
           
                    
              
        </div>
    </div>


       
        

    </div>

    <script src="../../public/assets/scripts/ResumeReview.js"></script>

</body>

</html>

<!-- 

→
} -->