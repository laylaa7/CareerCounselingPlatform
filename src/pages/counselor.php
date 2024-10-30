<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Counselor Page</title>
    <link rel="stylesheet" href="counselor.css">
</head>
<body>

<!-- Public Discussions Section -->
<div class="public-discussions-container">
    <h3 class="public-discussions">Public Discussions</h3>
</div>
<hr class="divider">

<!-- Squares for Public Discussions -->
<div class="squares-container" id="squares-container">
    <div class="square">
        <div class="circle">
            <img src="https://via.placeholder.com/80" alt="User Image">
        </div>
        <div class="title">Title of the Post</div>
        <div class="username">Username</div>
        <button class="view-comments-btn" data-post-id="1">View Comments</button>
        <button class="add-comment-btn">Add Comment</button>
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
        <button class="reply-btn">Reply</button>
    </div>
</div>

<!-- Modal Structure for Viewing Comments -->
<div class="modal" id="commentModal">
    <div class="modal-content">
        <span class="close-btn" id="closeModal">&times;</span>
        <div class="modal-header">
            <img src="https://via.placeholder.com/80" alt="User Image" id="modalUserImage" class="circle">
            <h3 id="modalTitle">Title of the Post</h3>
            <p id="modalUsername">Username</p>
        </div>
        <p id="modalDescription">Description text goes here.</p>
        <hr>
        <div class="comments-section" id="commentsSection">
        </div>
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

<!-- JavaScript for Modal and Event Handling -->
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const viewCommentsButtons = document.querySelectorAll(".view-comments-btn");
        const addCommentButtons = document.querySelectorAll(".add-comment-btn");
        const replyButtons = document.querySelectorAll(".reply-btn");
        const commentModal = document.getElementById("commentModal");
        const closeModal = document.getElementById("closeModal");
        const addCommentModal = document.getElementById("addCommentModal");
        const closeAddCommentModal = document.getElementById("closeAddCommentModal");
        const replyModal = document.getElementById("replyModal");
        const closeReplyModal = document.getElementById("closeReplyModal");
        
        // Modal elements to update dynamically for view comments
        const modalUserImage = document.getElementById("modalUserImage");
        const modalTitle = document.getElementById("modalTitle");
        const modalUsername = document.getElementById("modalUsername");
        const modalDescription = document.getElementById("modalDescription");
        const commentsSection = document.getElementById("commentsSection");

        // Sample comments data for demonstration
        const sampleComments = [
            { name: "Counselor1", comment: "Great advice on this topic!" },
            { name: "Counselor2", comment: "I would add more resources here." },
            { name: "Counselor3", comment: "Very helpful discussion!" }
        ];

        // Event listener for each "View Comments" button
        viewCommentsButtons.forEach((button) => {
            button.addEventListener("click", () => {
                // Populate modal with sample data
                modalUserImage.src = "https://via.placeholder.com/80"; // Example image
                modalTitle.textContent = "Sample Post Title";
                modalUsername.textContent = "SampleUsername";
                modalDescription.textContent = "This is a detailed description of the post.";

                // Clear previous comments and append new ones
                commentsSection.innerHTML = "";
                sampleComments.forEach(comment => {
                    const commentDiv = document.createElement("div");
                    commentDiv.classList.add("comment");
                    commentDiv.innerHTML = `<p class="counselor-name">${comment.name}:</p><p>${comment.comment}</p>`;
                    commentsSection.appendChild(commentDiv);
                });

                // Show the modal
                commentModal.style.display = "flex";
            });
        });

        // Event listener for each "Add Comment" button
        addCommentButtons.forEach((button) => {
            button.addEventListener("click", () => {
                // Populate add comment modal with sample data (you can adjust this)
                document.getElementById("addModalUserImage").src = "https://via.placeholder.com/80"; // Example image
                document.getElementById("addModalTitle").textContent = "Sample Post Title";
                document.getElementById("addModalUsername").textContent = "SampleUsername";
                document.getElementById("addModalDescription").textContent = "This is a detailed description of the post.";

                // Show the add comment modal
                addCommentModal.style.display = "flex";
            });
        });

        // Event listener for each "Reply" button
        replyButtons.forEach((button) => {
            button.addEventListener("click", () => {
                // Populate reply modal with sample data (you can adjust this)
                document.getElementById("replyModalUserImage").src = "https://via.placeholder.com/80"; // Example image
                document.getElementById("replyModalTitle").textContent = "Title of the Private Post";
                document.getElementById("replyModalUsername").textContent = "PrivateUser";

                // Show the reply modal
                replyModal.style.display = "flex";
            });
        });

        // Close the view comments modal when the "X" button is clicked
        closeModal.addEventListener("click", () => {
            commentModal.style.display = "none";
        });

        // Close the add comment modal when the "X" button is clicked
        closeAddCommentModal.addEventListener("click", () => {
            addCommentModal.style.display = "none";
        });

        // Close the reply modal when the "X" button is clicked
        closeReplyModal.addEventListener("click", () => {
            replyModal.style.display = "none";
        });

        // Close the modals if user clicks outside of them
        window.addEventListener("click", (event) => {
            if (event.target === commentModal) {
                commentModal.style.display = "none";
            }
            if (event.target === addCommentModal) {
                addCommentModal.style.display = "none";
            }
            if (event.target === replyModal) {
                replyModal.style.display = "none";
            }
        });
    });
    document.getElementById("submitComment").addEventListener("click", () => {
    const commentInput = document.getElementById("commentInput").value;
    const username = "SampleUsername";  // Replace with dynamic username if available
    const postId = 1;  // Replace with dynamic post ID if available

    if (!commentInput.trim()) {
        alert("Please enter a comment.");
        return;
    }

    fetch("add_comment.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
        body: `username=${encodeURIComponent(username)}&comment_text=${encodeURIComponent(commentInput)}&post_id=${postId}`,
    })
    .then(response => response.text())
    .then(data => {
        alert(data);  // Confirm success
        if (data.includes("successfully")) {
            document.getElementById("commentInput").value = "";  // Clear input
            addCommentModal.style.display = "none";  // Close modal
        }
    })
    .catch(error => console.error("Error:", error));
});
document.addEventListener("DOMContentLoaded", () => {
    const viewCommentsButtons = document.querySelectorAll(".view-comments-btn");
    const commentModal = document.getElementById("commentModal");
    const commentsSection = document.getElementById("commentsSection");

    viewCommentsButtons.forEach((button) => {
        button.addEventListener("click", (event) => {
            const postId = event.target.dataset.postId;

            fetch("fetch_comments.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                body: `post_id=${postId}`,
            })
            .then(response => response.json())
            .then(comments => {
                commentsSection.innerHTML = "";
                
                comments.forEach(comment => {
    const date = new Date(comment.created_at); // Replace 'created_at' with your timestamp field
    console.log("Comment Date:", date.toLocaleString()); // Display in local format

    const commentDiv = document.createElement("div");
    commentDiv.classList.add("comment");
    commentDiv.innerHTML = `
        <p class="counselor-name">${comment.username}</p>
        <p>${comment.comment_text}</p>
        <p class="timestamp">${date.toLocaleString()}</p>
    `;
    commentsSection.appendChild(commentDiv);
});
 
                commentModal.style.display = "flex";
            })
            .catch(error => console.error("Error fetching comments:", error));
        });
    });

    document.getElementById("closeModal").addEventListener("click", () => {
        commentModal.style.display = "none";
    });
    
});

</script>

</body>
</html>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "comment_system";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

