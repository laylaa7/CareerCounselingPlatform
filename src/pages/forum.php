<?php
require 'dp.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'submit_private_discussion') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $userId = $_POST['user_id']; // Replace with dynamic user ID if needed
    $counselorId = $_POST['counselor_id']; // New parameter

    try {
        $stmt = $pdo->prepare("INSERT INTO private_discussions (title, description, user_id, counselor_id, created_at) VALUES (?, ?, ?, ?, NOW())");
        $stmt->execute([$title, $description, $userId, $counselorId]);
        echo "Private discussion added successfully.";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
    exit;
}

?>
<?php
require 'dp.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'submit_private_discussion') {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $userId = $_POST['user_id'];
        $counselorId = $_POST['counselor_id'];

        try {
            $stmt = $pdo->prepare("INSERT INTO private_discussions (title, description, user_id, counselor_id, created_at) VALUES (?, ?, ?, ?, NOW())");
            $stmt->execute([$title, $description, $userId, $counselorId]);
            echo "Private discussion added successfully.";
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    } elseif ($_POST['action'] === 'submit_report') {
        $discussionId = $_POST['discussion_id'];
        $reason = $_POST['reason'];

        try {
            // Check if the report already exists
            $stmt = $pdo->prepare("SELECT id, counter FROM reports WHERE discussion_id = ? AND reason = ?");
            $stmt->execute([$discussionId, $reason]);
            $report = $stmt->fetch();

            if ($report) {
                // Update counter if the report exists
                $updateStmt = $pdo->prepare("UPDATE reports SET counter = counter + 1 WHERE id = ?");
                $updateStmt->execute([$report['id']]);
            } else {
                // Insert a new report
                $insertStmt = $pdo->prepare("INSERT INTO reports (discussion_id, reason, counter) VALUES (?, ?, 1)");
                $insertStmt->execute([$discussionId, $reason]);
            }
            echo "Report submitted successfully.";
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Career Counselling Forum</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="counselor.css">

    <link rel="stylesheet" href="../../public/assets/styles/userDashboard.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script> <!-- Added FontAwesome for icons -->


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
        <div class="content">
<!-- <div class="forum-container">
    <h2>Career Counselling and Guidance</h2>
    <p>No matter where you are on your career journey, let us help you define a path towards professional fulfillment with our career counseling appointments. Our mission is to empower you with the confidence and clarity to make informed decisions, unlock your true potential, and achieve long-term success and satisfaction in your career.</p>
    <button class="forum-btn">Book Now!</button>
</div> -->

<!-- Public Discussions Section -->
<div class="content">
        <!-- Public Discussions Section -->
        <div class="public-discussions-container">
            <h3 class="public-discussions">Public Discussions</h3>

            <div class="search-container">
    <button id="search-icon" class="search-icon">
        <img src="https://cdn-icons-png.flaticon.com/512/622/622669.png" alt="Search" class="icon-img"> <!-- Search icon image -->
    </button>
    <input type="text" id="search-bar" placeholder="Search Discussions" class="search-input hidden">
    <button class="add-btn" id="add-square">+ Add</button>
</div>


        </div>
        <hr class="divider">
<!-- Form for Adding New Discussion -->
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
        <!-- Close Button -->
        <span class="close-btn" id="closeModal">&times;</span>

        <!-- Report Button and Dropdown -->
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
    </div>
</div>

                
   
                <div class="private-discussions-container" >
    <h3 class="private-discussions" >Private Discussions</h3>
    <hr class="divider" >
    <div class="private-discussion-container" style="margin-left: 30%;">
        <span class="private-discussion-help">
            <!-- Didn't find what you're looking for? Start a private discussion with a counselor. -->
        </span>
    </div>
</div>
<button class="forum-btn" id="start-private-discussion">Start Private Discussion</button>




<!-- Modal for Private Discussions -->
<div id="private-discussion-modal" class="modal">
    <div class="modal-content">
        <span class="close-btn" id="close-modal">&times;</span>
        <h4>Start a Private Discussion</h4>
        <div class="counselor-options">
            <div class="counselor-option">
                <img src="https://via.placeholder.com/80" alt="Counselor 1">
                <div class="counselor-username">Counselor 1</div>
            </div>
            <div class="counselor-option">
                <img src="https://via.placeholder.com/80" alt="Counselor 2">
                <div class="counselor-username">Counselor 2</div>
            </div>
        </div>
        <input type="text" id="private-discussion-title" placeholder="Discussion Title" required class="input-field">
        <textarea id="private-discussion-description" placeholder="Description" required class="input-field"></textarea>
        
        <button id="submit-private-discussion" class="forum-btn">Send</button>
    </div>
</div>
</div>


</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchIcon = document.getElementById('search-icon');
        const searchInput = document.getElementById('search-bar');
        const privateContainer = document.querySelector('.private-discussion-container');

        const addSquareButton = document.getElementById('add-square');
        const addSquareForm = document.getElementById('add-square-form');
        const submitPostButton = document.getElementById('submit-post');
        const squaresContainer = document.getElementById('squares-container');
    const squares = Array.from(squaresContainer.children);
    const fadeEffect = document.createElement('div');
    const continueReadingButton = document.createElement('button');
        const commentModal = document.getElementById('commentModal');
        const closeModalButton = document.getElementById('closeModal');
        const commentsSection = document.getElementById('commentsSection');
        const modalTitle = document.getElementById('modalTitle');
        const modalDescription = document.getElementById('modalDescription');
        const modalUsername = document.getElementById('modalUsername');
        const reportDropdown = document.getElementById("report-select");
        const toggleReportMenu = document.getElementById('toggleReportMenu');
        const reportMenu = document.getElementById('reportMenu');
        const startPrivateDiscussionButton = document.getElementById('start-private-discussion');
    const privateDiscussionModal = document.getElementById('private-discussion-modal');
    const closePrivateModalButton = document.getElementById('close-modal');
    const submitPrivateDiscussionButton = document.getElementById('submit-private-discussion');
    const counselorOptionsContainer = document.querySelector('.counselor-options');
   
    const counselorDetailsDiv = document.createElement('div'); 
    let selectedCounselorId = null;

    console.log("Squares found:", squares.length); // Log the number of squares
    fadeEffect.className = 'fade-effect';
    continueReadingButton.className = 'continue-reading';
    continueReadingButton.textContent = 'Continue Reading';

    if (squares.length > 6) {
        console.log("More than 6 squares - Adding button and fade effect");
        squaresContainer.appendChild(fadeEffect);
        squaresContainer.appendChild(continueReadingButton);

        // Hide excess squares
        squares.slice(6).forEach(square => (square.style.display = 'none'));

        continueReadingButton.addEventListener('click', () => {
            console.log("Continue Reading clicked");
            squaresContainer.classList.remove('more-than-six');
            squares.slice(6).forEach(square => (square.style.display = 'flex'));
            fadeEffect.style.display = 'none';
            continueReadingButton.style.display = 'none';
        });
    } else {
        console.log("Less than or equal to 6 squares - Skipping button");
    }
     counselorDetailsDiv.style.marginTop = '20px';
    privateDiscussionModal.querySelector('.modal-content').appendChild(counselorDetailsDiv);

    function fetchCounselorOptions() {
    fetch('fetch_counselors.php', {
        method: 'POST',
    })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error(data.error);
                counselorOptionsContainer.innerHTML = '<p>No counselors available.</p>';
                return;
            }

            counselorOptionsContainer.innerHTML = ''; // Clear existing options
            data.forEach(counselor => {
                const optionDiv = document.createElement('div');
                optionDiv.classList.add('counselor-option');
                optionDiv.dataset.counselorId = counselor.CounselorID;
                optionDiv.innerHTML = `
                    <img src="${counselor.image_url || 'https://via.placeholder.com/80'}" alt="${counselor.specialization}">
                    <div class="counselor-username">${counselor.specialization}</div>
                `;
                counselorOptionsContainer.appendChild(optionDiv);
            });
        })
        .catch(error => console.error('Error fetching counselors:', error));
}


    // Display counselor details on click
   // Attach event listener for counselor selection
counselorOptionsContainer.addEventListener('click', function (event) {
    const counselorOption = event.target.closest('.counselor-option');
    if (counselorOption) {
        const counselorId = counselorOption.dataset.counselorId; // Ensure this matches the data attribute
        selectedCounselorId = counselorId;

        // Fetch counselor details dynamically
        fetch('fetch_counselors.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({ counselor_id: counselorId }),
        })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert(data.error); // Display the error
                    counselorDetailsDiv.innerHTML = ''; // Clear previous details
                } else {
                    counselorDetailsDiv.innerHTML = `
                        <h4>Counselor Details</h4>
                        <p><strong>Specialization:</strong> ${data.specialization}</p>
                        <p><strong>Location:</strong> ${data.location}</p>
                        <p><strong>Status:</strong> ${data.status}</p>
                    `;
                }
            })
            .catch(error => console.error('Error fetching counselor details:', error));
    }
});

    // Fetch counselor options on page load
    fetchCounselorOptions();
    // Show private discussion modal and fetch counselors
    startPrivateDiscussionButton.addEventListener('click', function () {
        fetchCounselorOptions();
        privateDiscussionModal.style.display = 'flex';
    });
    window.addEventListener('click', function (event) {
        if (event.target === privateDiscussionModal) {
            privateDiscussionModal.style.display = 'none';
        }
    });

    // Close private discussion modal
    closePrivateModalButton.addEventListener('click', function () {
        privateDiscussionModal.style.display = 'none';
        selectedCounselorId = null; // Reset selected counselor
        counselorDetailsDiv.innerHTML = ''; // Clear displayed details
    });

    // Submit private discussion
    submitPrivateDiscussionButton.addEventListener('click', function () {
        const title = document.getElementById('private-discussion-title').value;
        const description = document.getElementById('private-discussion-description').value;

        if (title && description && selectedCounselorId) {
            fetch('forum.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({
                    action: 'submit_private_discussion',
                    title: title,
                    description: description,
                    user_id: 1, // Replace with dynamic user ID if needed
                    counselor_id: selectedCounselorId, // Attach the selected counselor ID
                }),
            })
                .then(response => response.text())
                .then(data => {
                    alert('Private discussion added successfully!');
                    privateDiscussionModal.style.display = 'none';
                    selectedCounselorId = null; // Reset selection
                    counselorDetailsDiv.innerHTML = ''; // Clear details
                })
                .catch(error => console.error('Error submitting discussion:', error));
        } else {
            alert('Please fill out all fields and select a counselor.');
        }
    });

    // Close modals on outside click
    window.addEventListener('click', function (event) {
        if (event.target === privateDiscussionModal) {
            privateDiscussionModal.style.display = 'none';
        }
    });

        
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
    addSquareButton.addEventListener('click', function () {
        addSquareForm.classList.toggle('hidden');
    });

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
        addSquareButton.addEventListener('click', function () {
            addSquareForm.style.display = addSquareForm.style.display === 'none' ? 'block' : 'none';
        });

        // Submit new discussion
        submitPostButton.addEventListener('click', function () {
            const title = document.getElementById('post-title').value;
            const description = document.getElementById('post-description').value;

            if (title && description) {
                fetch('add_discussions.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        'title': title,
                        'description': description,
                        'user_id': 1 // Replace with dynamic user ID if needed
                    })
                })
                    .then(response => response.text())
                    .then(data => {
                        console.log("Server Response:", data);
                        if (data.includes("New discussion added successfully")) {
                            alert("Discussion added successfully!");
                            // Optionally reload discussions
                            location.reload();
                        } else {
                            alert("Failed to add discussion: " + data);
                        }
                    })
                    .catch(error => console.error('Error:', error));
            } else {
                alert("Please fill in both the title and description.");
            }
        });

        // Fetch discussions and comments
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
                        const modalCircle = document.getElementById('modalUserImage');
    const modalInitial = discussion.user_name ? discussion.user_name.charAt(0).toUpperCase() : 'U';
    modalCircle.textContent = modalInitial;
    modalCircle.style.backgroundColor = '#3366cc'; // Optional dynamic color


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
    function renderDiscussions(data, container) {
    console.log("Rendering discussions for container:", container, "Data:", data);
    container.innerHTML = ''; // Clear existing content

    if (!data || data.length === 0) {
        const noDiscussionsMessage = document.createElement('p');
        noDiscussionsMessage.textContent = "No discussions found.";
        container.appendChild(noDiscussionsMessage);
        return;
    }

    data.forEach(discussion => {
        const square = document.createElement('div');
        square.classList.add('square');

        const circle = document.createElement('div');
        circle.classList.add('circle');
        circle.textContent = discussion.title.charAt(0).toUpperCase();

        const titleElement = document.createElement('div');
        titleElement.classList.add('title');
        titleElement.textContent = discussion.title;

        const usernameElement = document.createElement('div');
        usernameElement.classList.add('username');
        usernameElement.textContent = `Counselor ${discussion.counselor_id}`;

        square.appendChild(circle);
        square.appendChild(titleElement);
        square.appendChild(usernameElement);

        square.addEventListener('click', function () {
            openDiscussionModal(discussion);
        });

        container.appendChild(square);
    });
}

    // Function to open discussion modal
    function openDiscussionModal(discussion, isPrivate = false) {
    const modal = document.getElementById('commentModal');
    const reportContainer = document.querySelector('.report-container');

    // Update modal content
    document.getElementById('modalTitle').textContent = discussion.title;
    document.getElementById('modalDescription').textContent = discussion.description;
    document.getElementById('modalUsername').textContent = discussion.user_id
        ? `User ${discussion.user_id}`
        : `Counselor ${discussion.counselor_id}`;

    // Toggle report button visibility
    if (isPrivate) {
        reportContainer.style.display = 'none'; // Hide report button for private discussions
    } else {
        reportContainer.style.display = 'block'; // Show report button for public discussions
    }

    // Show modal
    modal.style.display = 'flex';
}



    // Fetch private discussions
    function fetchPrivateDiscussions() {
    fetch('fetch_private_discussions.php')
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log("Private discussions fetched:", data); // Log the response
            if (data.error) {
                console.error("Error in response:", data.error);
                alert(data.error); // Notify the user
                return;
            }
            renderPrivateDiscussions(data);
        })
        .catch(error => {
            console.error("Error fetching private discussions:", error);
            alert("An error occurred while fetching private discussions. Please try again.");
        });
}

function renderPrivateDiscussions(data) {
    const container = document.querySelector('.private-discussion-container');
    container.innerHTML = ''; // Clear existing content

    if (!data || data.length === 0) {
        const noDiscussionsMessage = document.createElement('p');
        noDiscussionsMessage.textContent = "No private discussions found.";
        container.appendChild(noDiscussionsMessage);
        return;
    }

    data.forEach(discussion => {
        const square = document.createElement('div');
        square.classList.add('square');
        square.dataset.discussionId = discussion.id; // Store discussion ID in a data attribute

        const circle = document.createElement('div');
        circle.classList.add('circle');
        circle.textContent = discussion.title.charAt(0).toUpperCase();

        const titleElement = document.createElement('div');
        titleElement.classList.add('title');
        titleElement.textContent = discussion.title;

        const counselorElement = document.createElement('div');
        counselorElement.classList.add('username');
        counselorElement.textContent = `Counselor ${discussion.counselor_id}`;

        square.appendChild(circle);
        square.appendChild(titleElement);
        square.appendChild(counselorElement);

        // Add event listener to open modal with private discussion details
        square.addEventListener('click', function () {
            openDiscussionModal(discussion, true); // Pass 'true' for private discussions
        });

        container.appendChild(square);
    });
}

function openDiscussionModal(discussion) {
    const modal = document.getElementById('commentModal');
    document.getElementById('modalTitle').textContent = discussion.title;
    document.getElementById('modalDescription').textContent = discussion.description;
    document.getElementById('modalUsername').textContent = `Counselor ${discussion.counselor_id}`;

    // Display modal
    modal.style.display = 'flex';
}

// Close modal on outside click
window.addEventListener('click', function (event) {
    const modal = document.getElementById('commentModal');
    if (event.target === modal) {
        modal.style.display = 'none';
    }
});



        fetchPrivateDiscussions();

    // Close modal
    document.getElementById('closeModal').addEventListener('click', function () {
        document.getElementById('commentModal').style.display = 'none';
    });
    
    });

</script>

<script src="../../public/assets/scripts/navbar.js"></script> <!-- Ensure this includes your navbar JS -->

</body>
</html>
