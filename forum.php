<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Career Counselling Forum</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="forum-container">
    <h2>Career Counselling and Guidance</h2>
    <p>No matter where you are on your career journey, let us help you define a path towards professional fulfillment with our career counseling appointments. Our mission is to empower you with the confidence and clarity to make informed decisions, unlock your true potential, and achieve long-term success and satisfaction in your career.</p>
    <button class="forum-btn">Book Now!</button>
</div>

<!-- Public Discussions Section -->
<div class="public-discussions-container">
    <h3 class="public-discussions">Public Discussions</h3>
    <button class="add-btn" id="add-square">+ Add</button> 
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

        // Toggle form visibility for adding a public discussion
        addSquareButton.addEventListener('click', function() {
            addSquareForm.style.display = addSquareForm.style.display === 'none' ? 'block' : 'none';
        });

        // Submit public discussion
        submitPostButton.addEventListener('click', function() {
            const title = document.getElementById('post-title').value;
            const description = document.getElementById('post-description').value;

            if (title && description) {
                const squaresContainer = document.getElementById('squares-container');

                // Create a new square for public discussion
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

                document.getElementById('post-title').value = '';
                document.getElementById('post-description').value = '';
                addSquareForm.style.display = 'none';
            }
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
    });
</script>

</body>
</html>