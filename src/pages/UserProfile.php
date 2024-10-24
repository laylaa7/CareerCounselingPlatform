

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Nav Bar with PHP</title>
    <link rel="stylesheet" href="../../public/assets/styles/UserProfile.css"> 
    
</head>
<body>

    <!-- Navigation Bar -->
    <nav class="navbar">
        <ul>
            <!-- <li><a href="index.php">Home</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Services</a></li>
            <li><a href="#">Contact</a></li> -->
        </ul>
    </nav>
    

    <!-- Main content of the page -->
    <div class="profile-container">
    
        <!-- Left Sidebar -->
        <div class="sidebar">
            <!-- <img src="../../public/assets/images/BackButton.png" > -->
            <div class="profile-pic">
                
                <img src="../../public/assets/images/default-avatar.png" alt="Profile Picture">
            </div>
            <h2> Mohamed</h2>

            <hr>

            <ul class="profile-links">
                <li><a href="#" data-target="personal-info">Personal info</a></li>
                <li><a href="#" data-target="academic-background">Academic background</a></li>
                <li><a href="#" data-target="resume">Resume</a></li>
                <li><a href="#" data-target="career-interests">Career interests</a></li>
            </ul>
            <hr>


            <div class="logout">
                <a href="#">Log out</a>
            </div>
        </div>

        <!-- Main Profile Content -->
<div class="profile-content">
    <div id="personal-info" class="profile-section">
        <div class="info-header">
        <h2>Personal information</h2>
        <button class="edit-button" >
            <svg class="edit-svgIcon" viewBox="0 0 512 512">
                    <path d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z"></path>
                  </svg>
                </button>
            </div>
    <hr>
    <div  class="info-content edit-mode" id="personal-info-edit">
        <div class="grid-container">
            <div class="coolinput">
                <label for="name" class="text">Name:</label>
                <input type="text" id="name" placeholder="Write here..." name="name" class="input">
            </div>
            <div class="coolinput">
                <label for="email" class="text">Email address:</label>
                <input type="text" id="email" placeholder="Write here..." name="email" class="input">
            </div>
            <div class="coolinput">
                <label for="phone" class="text">Phone:</label>
                <input type="text" id="phone" placeholder="Write here..." name="phone" class="input">
            </div>
            <div class="coolinput">
                <label for="birthdate" class="text">Birthdate:</label>
                <input type="text" id="birthdate" placeholder="Write here..." name="birthdate" class="input">
            </div>
            <div class="coolinput">
                <label for="location" class="text">Location:</label>
                <input type="text" id="location" placeholder="Write here..." name="location" class="input">
            </div>
        </div>
        <button>
            <div class="svg-wrapper-1">
    <div class="svg-wrapper">
      <svg
        xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 24 24"
        width="30"
        height="30"
        class="icon"
      >
        <path
          d="M22,15.04C22,17.23 20.24,19 18.07,19H5.93C3.76,19 2,17.23 2,15.04C2,13.07 3.43,11.44 5.31,11.14C5.28,11 5.27,10.86 5.27,10.71C5.27,9.33 6.38,8.2 7.76,8.2C8.37,8.2 8.94,8.43 9.37,8.8C10.14,7.05 11.13,5.44 13.91,5.44C17.28,5.44 18.87,8.06 18.87,10.83C18.87,10.94 18.87,11.06 18.86,11.17C20.65,11.54 22,13.13 22,15.04Z"
        ></path>
      </svg>
    </div>
  </div>
  
</button>

    </div>
</div>


    <div id="academic-background" class="profile-section" style="display:none;">
        <div class="info-header">
            <h2>Academic Background</h2>
            <button class="edit-button">
            <svg class="edit-svgIcon" viewBox="0 0 512 512">
                    <path d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z"></path>
                  </svg>
                </button>
        </div>
        <hr>
        <div class="info-content">
        <div class="grid-container">
            <div class="coolinput">
                <label for="name" class="text">Name:</label>
                <p>layla</p>
            </div>
            <div class="coolinput">
                <label for="email" class="text">Email address:</label>
                <p>layla</p>
            </div>
            <div class="coolinput">
                <label for="phone" class="text">Phone:</label>
                <p>layla</p>
            </div>
            
        </div>
    </div>
    </div>

    <div id="resume" class="profile-section" style="display:none;">
    <div class="info-header">
            <h2>Resume</h2>
            <button class="edit-button">
            <svg class="edit-svgIcon" viewBox="0 0 512 512">
                    <path d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z"></path>
                  </svg>
                </button>
        </div>
        <hr>
        <p>Resume information here...</p>
    </div>

    <div id="career-interests" class="profile-section" style="display:none;">
    <div class="info-header">
            <h2>Career interests</h2>
            <a href="#" class="edit-icon">
                <img  alt="Edit">
            </a>
        </div>
        <hr>
        <p>Information about career interests here...</p>
    </div>
</div>


       
        

    </div>

    <script src="../../public/assets/scripts/UserProfile.js"></script>

</body>

</html>
