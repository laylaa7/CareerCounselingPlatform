<?php
// Include the database connection file
require 'dp.php';

// Fetch total reports for each discussion
$totalReportsQuery = "
    SELECT discussion_id, SUM(counter) AS total_reports 
    FROM reports 
    GROUP BY discussion_id";
$totalStmt = $pdo->prepare($totalReportsQuery);
$totalStmt->execute();
$totalReports = $totalStmt->fetchAll(PDO::FETCH_ASSOC);

$publicDiscussionsQuery = "SELECT id, title, user_id FROM discussions";
$publicStmt = $pdo->prepare($publicDiscussionsQuery);
$publicStmt->execute();
$publicDiscussions = $publicStmt->fetchAll(PDO::FETCH_ASSOC);
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['id'])) {
    $discussionId = intval($_GET['id']);
    
    // Validate ID
    if ($discussionId <= 0) {
        echo "Invalid discussion ID.";
        exit;
    }

    try {
        // Delete query
        $deleteQuery = "DELETE FROM discussions WHERE id = ?";
        $stmt = $pdo->prepare($deleteQuery);

        if ($stmt->execute([$discussionId])) {
            echo "Discussion deleted successfully.";
        } else {
            echo "Error: Unable to delete discussion. Query may have failed.";
        }
    } catch (PDOException $e) {
        echo "Database Error: " . $e->getMessage();
    }
    exit;
}

// Fetch total reports for each discussion
$totalReportsQuery = "
    SELECT discussion_id, SUM(counter) AS total_reports 
    FROM reports 
    GROUP BY discussion_id";
$totalStmt = $pdo->prepare($totalReportsQuery);
$totalStmt->execute();
$totalReports = $totalStmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch all public discussions
$publicDiscussionsQuery = "SELECT id, title, user_id FROM discussions";
$publicStmt = $pdo->prepare($publicDiscussionsQuery);
$publicStmt->execute();
$publicDiscussions = $publicStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discussion Reports</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<nav class="navbar">
    <?php include "../../tests/Navbar.php"; ?>
</nav>
<div class="public-discussions-container" style="margin-top:10%;">
            <h3 class="public-discussions">Public Discussions</h3>

        </div>
        <hr class="divider">
    <!-- Public Discussions Section -->
    <div class="squares-container" id="squares-container"></div>

    <div class="modal" id="commentModal">
        <div class="modal-content">
            <!-- Close Button -->
            <span class="close-btn" id="closeModal">&times;</span>

            <!-- Reports Button and Count -->
            <div class="report-container">
    <button class="report-count-btn" id="showReports">
        Reports: <span id="reportCount">0</span>
    </button>
    <div id="reportDetails" class="report-dropdown-menu" style="display: none;">
        <ul id="reportReasons"></ul>
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
            <button class="delete-button" id="deleteDiscussion" style="background-color: red; color: white; border: none; padding: 10px; margin-top: 10px;">Delete Discussion</button>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const commentModal = document.getElementById('commentModal');
            const closeModalButton = document.getElementById('closeModal');
            const commentsSection = document.getElementById('commentsSection');
            const modalTitle = document.getElementById('modalTitle');
            const modalDescription = document.getElementById('modalDescription');
            const modalUsername = document.getElementById('modalUsername');
            const modalCircle = document.getElementById('modalUserImage');
            const reportCount = document.getElementById('reportCount');
            const showReportsButton = document.getElementById('showReports');
            const reportDetails = document.getElementById('reportDetails');
            const reportReasons = document.getElementById('reportReasons');
            const deleteDiscussionButton = document.getElementById('deleteDiscussion');
        let currentDiscussionId;


            // Fetch discussions and populate the squares
            fetch("fetch_discussions.php")
            .then(response => response.json())
            .then(data => {
                const squaresContainer = document.getElementById('squares-container');

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
                        currentDiscussionId = discussion.id; // Store discussion ID
                        document.getElementById('modalTitle').textContent = discussion.title;
                        document.getElementById('modalDescription').textContent = discussion.description;
                        document.getElementById('modalUsername').textContent = `User ${discussion.user_id}`;
                        document.getElementById('modalUserImage').textContent = userInitial;

                        fetch(`report_details.php?discussion_id=${discussion.id}`)
                            .then(response => response.json())
                            .then(reportData => {
                                document.getElementById('reportCount').textContent = reportData.total_reports || 0;
                                const reportReasons = document.getElementById('reportReasons');
                                reportReasons.innerHTML = "";
                                if (reportData.reasons && reportData.reasons.length > 0) {
                                    reportData.reasons.forEach(reason => {
                                        const listItem = document.createElement('li');
                                        listItem.textContent = `${reason.reason}: Reported ${reason.counter} times`;
                                        reportReasons.appendChild(listItem);
                                    });
                                } else {
                                    reportReasons.innerHTML = "<li>No reports found.</li>";
                                }
                            });
                        commentModal.style.display = "flex";
                    });

                    squaresContainer.appendChild(newSquare);
                });
            })
            .catch(error => console.error("Error fetching discussions:", error));

        // Delete discussion logic
     // Delete discussion logic
     deleteDiscussionButton.addEventListener('click', function () {
            if (currentDiscussionId && confirm("Are you sure you want to delete this discussion?")) {
                fetch(`fetch_reports.php?id=${currentDiscussionId}`, { method: "POST" })
                    .then(response => response.text())
                    .then(data => {
                        alert(data); // Alert the user with the response from the server
                        commentModal.style.display = "none"; // Close the modal
                        location.reload(); // Reload the page to reflect the deletion
                    })
                    .catch(error => console.error("Error deleting discussion:", error));
   }
});

            showReportsButton.addEventListener('click', function () {
                reportDetails.style.display =
                    reportDetails.style.display === 'none' || reportDetails.style.display === ''
                        ? 'block'
                        : 'none';
            });


            // Close modal on outside click
            window.addEventListener('click', function (event) {
                if (event.target === commentModal) {
                    commentModal.style.display = 'none';
                }
            });

            // Close modal button
            closeModalButton.addEventListener('click', function () {
                commentModal.style.display = 'none';
            });
        });
    </script>
</body>
</html>


<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discussion Reports</title>
</head>
<body>
    <h1>Discussion Reports</h1>
    <div class="discussion-container">
        <?php foreach ($totalReports as $report): ?>
            <div class="discussion-card">
                <p>Discussion ID: <?php echo $report['discussion_id']; ?></p>
                <p>
                    Reports: 
                    <a href="report_details.php?discussion_id=<?php echo $report['discussion_id']; ?>">
                        <?php echo $report['total_reports']; ?>
                    </a>
                </p>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>  -->
