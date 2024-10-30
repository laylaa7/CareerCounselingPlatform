
<?php
session_start();
$_SESSION['name'] = isset($_POST['name']) ? $_POST['name'] : 'Nour B';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Career Counselling Forum</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="../../public/assets/styles/userDashboard.css">
</head>
<body>
<nav class="navbar">
    <?php include "../../tests/Navbar.php"; ?>
</nav>

<div class="dashboard-container">
    <div class="sidebar">
        <div class="pos-sidebar">
            <a href="userDashboard.php" class="dash">Dashboard</a>
            <a href="progress.php" class="dash2">Progress</a>
            <a href="bookCounselors.php">Book with Counsellors</a>
            <a href="InterviewSimulator.php">Interview Guide</a>
            <a href="ResumeReview.php">Submit CV for Review</a>
            <a href="forum.php" class="active">Discussion Forum</a>
        </div>
    </div>

    <div class="forum-container">
        <h2>Career Counselling and Guidance</h2>
        <p>No matter where you are on your career journey, let us help you define a path towards professional fulfillment with our career counseling appointments. Our mission is to empower you with the confidence and clarity to make informed decisions, unlock your true potential, and achieve long-term success and satisfaction in your career.</p>
        <button class="forum-btn">Book Now!</button>
    </div>
</div>

<!-- Public Discussions Section -->
<div class="public-discussions-container">
    <h3 class="public-discussions">Public Discussions</h3>
    <div class="search-container">
        <input type="text" id="search-bar" placeholder="Search Discussions" class="search-input">
        <button class="add-btn" id="add-square">+ Add</button>
    </div>
</div>
<hr class="divider">

<!-- Form for Adding New Discussion -->
<div id="add-square-form" class="discussion-form" style="display: none;">
    <h4>Add New Discussion</h4>
    <input type="text" id="post-title" placeholder="Title" required class="input-field">
    <textarea id="post-description" placeholder="Description" required class="input-field"></textarea>
    <button id="submit-post" class="forum-btn">Submit</button>
</div>

<!-- Squares for Public Discussions -->
<div class="squares-container" id="squares-container">
    <div class="square">
        <div class="circle">
            <img src="https://via.placeholder.com/80" alt="User Image">
        </div>
        <div class="title">Title of the Post</div>
        <div class="username">Username</div>
        <button class="view-comments-btn">View Comments</button>
    </div>
</div>

<!-- Start Private Discussion Button -->
<div class="private-discussion-container">
    <span class="private-discussion-help">Didn't find what you're looking for?</span>
    <button class="forum-btn" id="start-private-discussion">Start Private Discussion</button>
</div>

<!-- Modal for Private Discussion -->
<div id="private-discussion-modal" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close-btn" id="close-modal">&times;</span>
        <h4>Start a Private Discussion</h4>

        <!-- Counselor options -->
        <div class="counselor-options">
            <div class="counselor-option">
                <img src="https://via.placeholder.com/80" alt="Counselor 1">
                <div class="counselor-username">Counselor 1</div>
            </div>
            <div class="counselor-option">
                <img src="https://via.placeholder.com/80" alt="Counselor 2">
                <div class="counselor-username">Counselor 2</div>
            </div>
            <div class="counselor-option">
                <img src="https://via.placeholder.com/80" alt="Counselor 3">
                <div class="counselor-username">Counselor 3</div>
            </div>
        </div>

        <input type="text" id="private-discussion-title" placeholder="Discussion Title" required class="input-field">
        <textarea id="private-discussion-description" placeholder="Description" required class="input-field"></textarea>
        <button id="submit-private-discussion" class="forum-btn">Send</button>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addSquareButton = document.getElementById('add-square');
        const addSquareForm = document.getElementById('add-square-form');
        const submitPostButton = document.getElementById('submit-post');
        const startPrivateDiscussionButton = document.getElementById('start-private-discussion');
        const privateDiscussionModal = document.getElementById('private-discussion-modal');
        const closeModalButton = document.getElementById('close-modal');
        const submitPrivateDiscussionButton = document.getElementById('submit-private-discussion');
        const searchBar = document.getElementById('search-bar');
        const squaresContainer = document.getElementById('squares-container');

        // Toggle form visibility for adding a public discussion
        addSquareButton.addEventListener('click', function() {
            addSquareForm.style.display = addSquareForm.style.display === 'none' ? 'block' : 'none';
        });

        // Show private discussion modal
        startPrivateDiscussionButton.addEventListener('click', function() {
            privateDiscussionModal.style.display = 'flex';
        });

        // Close private discussion modal
        closeModalButton.addEventListener('click', function() {
            privateDiscussionModal.style.display = 'none';
        });

        // Close modal on outside click
        window.addEventListener('click', function(event) {
            if (event.target === privateDiscussionModal) {
                privateDiscussionModal.style.display = 'none';
            }
        });

        // Submit private discussion
        submitPrivateDiscussionButton.addEventListener('click', function() {
            const title = document.getElementById('private-discussion-title').value;
            if (title) {
                console.log("Private Discussion Topic:", title);
                privateDiscussionModal.style.display = 'none';
                document.getElementById('private-discussion-title').value = ''; // Clear input
            }
        });

        // Search functionality
        searchBar.addEventListener('input', function() {
            const query = searchBar.value.toLowerCase();
            const squares = squaresContainer.getElementsByClassName('square');
            Array.from(squares).forEach(square => {
                const titleText = square.getElementsByClassName('title')[0].textContent.toLowerCase();
                square.style.display = titleText.includes(query) ? 'flex' : 'none'; // Hide squares that don't match
            });
        });

        // Submit new discussion
        submitPostButton.addEventListener('click', function() {
            const title = document.getElementById('post-title').value;
            const description = document.getElementById('post-description').value;

            if (title && description) {
                // Send data to add_discussions.php using AJAX
                fetch('add_discussions.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        'title': title,
                        'description': description,
                        'user_id': 1  // Temporarily set a static user_id for now
                    })
                })
                .then(response => response.text())
                .then(data => {
                    console.log("Server Response:", data); // Log the response for debugging
                    // Check if the response indicates success
                    if (data.includes("New discussion added successfully")) {
                        const newSquare = document.createElement('div');
                        newSquare.classList.add('square');

                        const circle = document.createElement('div');
                        circle.classList.add('circle');
                        const img = document.createElement('img');
                        img.src = 'https://via.placeholder.com/80';
                        img.alt = 'User Image';
                        circle.appendChild(img);

                        const titleElement = document.createElement('div');
                        titleElement.classList.add('title');
                        titleElement.textContent = title;

                        const username = document.createElement('div');
                        username.classList.add('username');
                        username.textContent = 'Username';

                        const viewCommentsBtn = document.createElement('button');
                        viewCommentsBtn.classList.add('view-comments-btn');
                        viewCommentsBtn.textContent = 'View Comments';

                        newSquare.appendChild(circle);
                        newSquare.appendChild(titleElement);
                        newSquare.appendChild(username);
                        newSquare.appendChild(viewCommentsBtn);
                        squaresContainer.appendChild(newSquare);

                        // Clear the form fields
                        document.getElementById('post-title').value = '';
                        document.getElementById('post-description').value = '';
                        addSquareForm.style.display = 'none';
                    } else {
                        console.error("Failed to add discussion:", data);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            }
        });

        fetch('fetch_discussions.php')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                console.log("Fetched Discussions:", data); // Log fetched discussions
                data.forEach(discussion => {
                    const newSquare = document.createElement('div');
                    newSquare.classList.add('square');

                    const circle = document.createElement('div');
                    circle.classList.add('circle');
                    const img = document.createElement('img');
                    img.src = 'https://via.placeholder.com/80';
                    img.alt = 'User Image';
                    circle.appendChild(img);

                    const titleElement = document.createElement('div');
                    titleElement.classList.add('title');
                    titleElement.textContent = discussion.title;

                    const username = document.createElement('div');
                    username.classList.add('username');
                    username.textContent = discussion.username;

                    const viewCommentsBtn = document.createElement('button');
                    viewCommentsBtn.classList.add('view-comments-btn');
                    viewCommentsBtn.textContent = 'View Comments';

                    newSquare.appendChild(circle);
                    newSquare.appendChild(titleElement);
                    newSquare.appendChild(username);
                    newSquare.appendChild(viewCommentsBtn);
                    squaresContainer.appendChild(newSquare);
                });
            })
            .catch(error => {
                console.error('Error fetching discussions:', error);
            });
    });
</script>
<script src="../../public/assets/scripts/navbar.js"></script> <!-- Ensure this includes your navbar JS -->

</body>
</html>
