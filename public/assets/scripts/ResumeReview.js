// Initialize buttons
const nextBtn = document.getElementById('next-btn');
nextBtn.disabled = true; // Initially disabled

// Function to show the upload view
function showUploadView() {
    document.getElementById('initialView').style.display = 'none';
    document.getElementById('uploadView').style.display = 'block';

    document.getElementById('prev-btn').disabled = false;
    // Keep nextBtn disabled until a file is uploaded
}

// Function to show the initial view
function showInitialView() {
    document.getElementById('initialView').style.display = 'grid';
    document.getElementById('uploadView').style.display = 'none';

    document.getElementById('prev-btn').disabled = true;
    nextBtn.disabled = true; // Disable next button in the initial view
}

// File input change event listener
document.getElementById('fileInput').addEventListener('change', function(event) {
    var file = event.target.files[0];
    var fileUploadedElement = document.getElementById('fileUploaded');
    
    if (file) {
        alert('File selected: ' + file.name);
        fileUploadedElement.style.display = 'block';
        fileUploadedElement.textContent = 'Selected file: ' + file.name;

        // Enable the Next button when a file is uploaded
        nextBtn.disabled = false; // Enable next button
    } else {
        fileUploadedElement.style.display = 'none';
        nextBtn.disabled = true; // Disable next button if no file is selected
    }
});

// Function to redirect to the resume builder
function redirectToResumeBuilder() {
    window.location.href = 'ResumeBuilder.php'; // Replace with your actual page URL
}

function reviewconfirmation() {
    showInitialView();// Replace with your actual page UR
    alert("document sent for review");
}