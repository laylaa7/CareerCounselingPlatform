<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Counselor Page</title>
    <link rel="stylesheet" href="style.css">

</head>
<body>

<!-- Public Discussions Section -->
<div class="public-discussions-container">
            <h3 class="public-discussions">Public Discussions</h3>
            <div class="search-container">
    <button id="search-icon" class="search-icon">
        <img src="https://cdn-icons-png.flaticon.com/512/622/622669.png" alt="Search" class="icon-img"> <!-- Search icon image -->
    </button>
    <input type="text" id="search-bar" placeholder="Search Discussions" class="search-input hidden">
</div>
        </div>
        <hr class="divider">
<div id="add-square-form" class="discussion-form hidden">
    <h4>Add New Discussion</h4>
    <input type="text" id="post-title" placeholder="Title" required class="input-field">
    <textarea id="post-description" placeholder="Description" required class="input-field"></textarea>
    <button id="submit-post" class="forum-btn">Submit</button>
</div>

<!-- Squares for Public Discussions -->
<div class="squares-container" id="squares-container"></div>
<div class="modal" id="commentModal">
    <div class="modal-content">
        <span class="close-btn" id="closeModal">&times;</span>

        <div class="report-container">
            <button class="report-btn" id="toggleReportMenu">Report</button>
            <div id="reportMenu" class="report-dropdown-menu" style="display: none;">
                <ul>
                    <li><button class="report-option" data-value="spam">Spam</button></li>
                    <li><button class="report-option" data-value="harassment">Harassment or Bullying</button></li>
                    <li><button class="report-option" data-value="hate-speech">Hate Speech</button></li>
                    <li><button class="report-option" data-value="misinformation">Misinformation</button></li>
                    <li><button class="report-option" data-value="offensive-content">Offensive Content</button></li>
                    <li><button class="report-option" data-value="copyright">Copyright or Intellectual Property Violation</button></li>
                    <li><button class="report-option" data-value="privacy">Privacy Violation</button></li>
                </ul>
            </div>
        </div>

        <div class="modal-header">
            <div class="circle user-initial" id="modalUserImage"></div>
            <div class="modal-header-info">
                <h3 id="modalTitle">Title of the Post</h3>
                <p id="modalUsername">Username</p>
            </div>
        </div>
        <p id="modalDescription">Description text goes here.</p>
        <hr>
        <div class="comments-section" id="commentsSection"></div>
       <div> <button id="addCommentButton" class="add-btn">Add Comment</button></div>

    </div>
</div>
 </div>

<div class="submitted-private-discussions-container">
    <h3 class="submitted-private-discussions">Submitted Private Discussions</h3>
</div>
<hr class="divider">

<div class="squares-container" id="submitted-squares-container">
    <div class="square">
        <div class="circle">
            <img src="https://via.placeholder.com/80" alt="User Image">
        </div>
        <div class="title">Title of the Private Post</div>
        <div class="username">PrivateUser</div>
        <button class="report-btn">Reply</button>
    </div>
</div>



<div class="modal" id="addCommentModal">
    <div class="modal-content">
        <span class="close-btn" id="closeAddCommentModal">&times;</span>
        <div class="modal-header">
            <img src="https://via.placeholder.com/80" alt="User Image" id="addModalUserImage" class="circle">
            <h3 id="addModalTitle">Title of the Post</h3>
            <p id="addModalUsername">SampleUsername</p>
        </div>
        <p id="addModalDescription">This is a detailed description of the post.</p>
        <hr>
        <textarea id="commentInput" placeholder="Write your comment here..." rows="4" style="width: 100%; margin-top: 10px;"></textarea>
        <button id="submitComment" style="margin-top: 10px; background-color: #808bbf; color: white; border: none; padding: 10px 15px; border-radius: 15px; cursor: pointer;">Submit Comment</button>
    </div>
</div>


<div class="modal" id="replyModal">
    <div class="modal-content">
        <span class="close-btn" id="closeReplyModal">&times;</span>
        <div class="modal-header">
            <img src="https://via.placeholder.com/80" alt="User Image" id="replyModalUserImage" class="circle">
            <h3 id="replyModalTitle">Title of the Private Post</h3>
            <p id="replyModalUsername">PrivateUser</p>
        </div>
        <textarea id="replyInput" placeholder="Write your reply here..." rows="4" style="width: 100%; margin-top: 10px;"></textarea>
        <button id="submitReply" style="margin-top: 10px; background-color: #808bbf; color: white; border: none; padding: 10px 15px; border-radius: 15px; cursor: pointer;">Submit Reply</button>
    </div>
</div>
 
<script>
     document.addEventListener('DOMContentLoaded', function () {
        const searchIcon = document.getElementById('search-icon');
        const searchInput = document.getElementById('search-bar');

        const addSquareButton = document.getElementById('add-square');
        const addSquareForm = document.getElementById('add-square-form');
        const submitPostButton = document.getElementById('submit-post');
        const squaresContainer = document.getElementById('squares-container');
        const addCommentContainer = document.getElementById('addCommentContainer');

        const commentModal = document.getElementById('commentModal');
    const commentsSection = document.getElementById('commentsSection');
    const addCommentButton = document.getElementById('addCommentButton');
    const newCommentInput = document.getElementById('newCommentInput');
        const closeModalButton = document.getElementById('closeModal');
        const modalTitle = document.getElementById('modalTitle');
        const modalDescription = document.getElementById('modalDescription');
        const modalUsername = document.getElementById('modalUsername');
        const reportDropdown = document.getElementById("report-select");
        const toggleReportMenu = document.getElementById('toggleReportMenu');
        const reportMenu = document.getElementById('reportMenu');
        searchIcon.addEventListener('click', function () {
        searchInput.classList.toggle('visible');
        searchInput.focus(); // Automatically focus on the input
    });
    window.addEventListener('resize', function () {
        if (window.innerWidth > 768) {
            searchInput.classList.add('visible');
        } else {
            searchInput.classList.remove('visible');
        }
    });
// Add event listener to the search bar for filtering squares
searchInput.addEventListener('input', function () {
    const query = searchInput.value.toLowerCase();
    const squares = squaresContainer.getElementsByClassName('square');
    Array.from(squares).forEach(square => {
        const titleText = square.getElementsByClassName('title')[0].textContent.toLowerCase();
        square.style.display = titleText.includes(query) ? 'flex' : 'none'; 
    });
});

    
    // Toggle Add Discussion Form
    
// Close modal
closeModalButton.addEventListener('click', function () {
        commentModal.style.display = 'none';
    });
    window.addEventListener('click', function (event) {
            if (event.target === commentModal) {
                commentModal.style.display = "none";
            }
        });

        toggleReportMenu.addEventListener('click', function () {
            reportMenu.style.display = reportMenu.style.display === 'none' ? 'block' : 'none';
        });

        document.querySelectorAll('.report-option').forEach(button => {
            button.addEventListener('click', function () {
                const reportReason = this.getAttribute('data-value');
                alert(`You selected: ${reportReason}`);
                reportMenu.style.display = 'none';
                // Add logic to handle report submission here
            });
        });

        // Close the report menu if clicking outside
        window.addEventListener('click', function (event) {
            if (!reportMenu.contains(event.target) && event.target !== toggleReportMenu) {
                reportMenu.style.display = 'none';
            }
        });

        // Toggle form visibility for adding a public discussion
     
        fetch("fetch_discussions.php")
            .then(response => response.json())
            .then(data => {
                console.log("Fetched discussions:", data); // Log the fetched data

                data.forEach(discussion => {
                    const newSquare = document.createElement('div');
                    newSquare.classList.add('square');
                    newSquare.setAttribute("data-post-id", discussion.id);

                    const circle = document.createElement('div');
            circle.classList.add('circle');
            const userInitial = discussion.user_name ? discussion.user_name.charAt(0).toUpperCase() : 'U';
            circle.textContent = userInitial;

                    const titleElement = document.createElement('div');
                    titleElement.classList.add('title');
                    titleElement.textContent = discussion.title;

                    const username = document.createElement('div');
                    username.classList.add('username');
                    username.textContent = `User ${discussion.user_id}`;

                    newSquare.appendChild(circle);
                    newSquare.appendChild(titleElement);
                    newSquare.appendChild(username);

                    // Add event listener to open modal with discussion details
                    newSquare.addEventListener('click', function () {
                        // Populate modal with discussion data
                        modalTitle.textContent = discussion.title;
                        modalDescription.textContent = discussion.description;
                        modalUsername.textContent = `User ${discussion.user_id}`;
                        commentModal.setAttribute('data-discussion-id', discussion.id);

                        // Fetch comments for the discussion
                        fetch("fetch_comments.php", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/x-www-form-urlencoded",
                            },
                            body: `post_id=${discussion.id}`
                        })
                            .then(response => response.json())
                            .then(comments => {
                                commentsSection.innerHTML = ""; // Clear previous comments
                                comments.forEach(comment => {
                                    const commentDiv = document.createElement("div");
                                    commentDiv.classList.add("comment");
                                    commentDiv.innerHTML = `
                                        <p class="counselor-name">${comment.username}:</p>
                                        <p>${comment.comment_text}</p>
                                        <p class="timestamp">${new Date(comment.created_at).toLocaleString()}</p>
                                    `;
                                    commentsSection.appendChild(commentDiv);
                                });
                            })
                            .catch(error => console.error("Error fetching comments:", error));

                        commentModal.style.display = "flex";
                    });

                    squaresContainer.appendChild(newSquare);
                });
            })
            .catch(error => console.error("Error fetching discussions:", error));
        //     reportDropdown.addEventListener("change", function () {
        //     if (reportDropdown.value) {
        //         alert(`You selected: ${reportDropdown.options[reportDropdown.selectedIndex].text}`);
        //     }
        // });
        

       
    });
    document.querySelectorAll('.report-option').forEach(button => {
    button.addEventListener('click', function () {
        const reportReason = this.getAttribute('data-value'); // Get the selected reason
        const discussionId = commentModal.getAttribute('data-discussion-id'); // Get the discussion ID from the modal

        if (reportReason && discussionId) {
            fetch('forum.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action: 'submit_report',
                    discussion_id: discussionId,
                    reason: reportReason,
                }),
            })
                .then(response => response.text())
                .then(data => {
                    alert(data); // Notify the user of the submission status
                    reportMenu.style.display = 'none'; // Hide the dropdown menu
                })
                .catch(error => {
                    console.error('Error submitting report:', error);
                    alert('An error occurred while submitting the report. Please try again.');
                });
        } else {
            alert('Invalid report. Please ensure a discussion ID and reason are provided.');
        }
    });
     function fetchAndDisplayComments(postId) {
        fetch('fetch_comments.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `post_id=${postId}`,
        })
            .then((response) => response.json())
            .then((comments) => {
                commentsSection.innerHTML = ''; // Clear previous comments
                comments.forEach((comment) => {
                    const commentDiv = document.createElement('div');
                    commentDiv.classList.add('comment');
                    commentDiv.innerHTML = `
                        <p class="counselor-name">${comment.username}:</p>
                        <p>${comment.comment_text}</p>
                        <p class="timestamp">${new Date(comment.created_at).toLocaleString()}</p>
                    `;
                    commentsSection.appendChild(commentDiv);
                });
            })
            .catch((error) => console.error('Error fetching comments:', error));
    }


addCommentButton.addEventListener('click', function () {
    // Check if the input field and submit button already exist
    let commentInput = document.getElementById('newCommentInput');
    let submitCommentButton = document.getElementById('submitNewComment');

    // If the input field does not exist, create it
    if (!commentInput) {
        commentInput = document.createElement('textarea');
        commentInput.id = 'newCommentInput';
        commentInput.placeholder = 'Write your comment here...';
        commentInput.rows = 4;
        commentInput.style.width = '100%';
        commentInput.style.marginTop = '10px';
        commentsSection.appendChild(commentInput); // Append input to the comments section
    }

    // If the submit button does not exist, create it
    if (!submitCommentButton) {
        submitCommentButton = document.createElement('button');
        submitCommentButton.id = 'submitNewComment';
        submitCommentButton.textContent = 'Submit';
        submitCommentButton.style.backgroundColor = '#3366cc';
        submitCommentButton.style.color = 'white';
        submitCommentButton.style.border = 'none';
        submitCommentButton.style.padding = '10px 15px';
        submitCommentButton.style.borderRadius = '5px';
        submitCommentButton.style.cursor = 'pointer';
        submitCommentButton.style.marginTop = '10px';
        commentsSection.appendChild(submitCommentButton); // Append button to the comments section

        // Add click event listener for the submit button
        submitCommentButton.addEventListener('click', function () {
            const commentText = commentInput.value.trim();
            if (!commentText) {
                alert('Please enter a comment.');
                return;
            }

            // Submit the comment to the server
            fetch('add_comment.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    post_id: commentModal.getAttribute('data-discussion-id'),
                    comment_text: commentText,
                }),
            })
                .then(response => response.text())
                .then(data => {
                    alert(data); // Notify the user of the result
                    commentInput.value = ''; // Clear the input field

                    // Refresh the comments section
                    fetchAndDisplayComments(commentModal.getAttribute('data-discussion-id'));
                })
                .catch(error => console.error('Error submitting comment:', error));
        });
    }
});

    // Example usage: Open modal and load comments
    const squaresContainer = document.getElementById('squares-container');
    squaresContainer.addEventListener('click', function (event) {
        const square = event.target.closest('.square');
        if (square) {
            const postId = square.getAttribute('data-post-id');
            commentModal.setAttribute('data-discussion-id', postId);
            fetchAndDisplayComments(postId); // Fetch and display comments for the clicked discussion
            commentModal.style.display = 'flex'; // Show the modal
        }
    });

    // Close modal functionality
    const closeModal = document.getElementById('closeModal');
    closeModal.addEventListener('click', function () {
        commentModal.style.display = 'none';
    });
});


</script>

</body>
</html>


























