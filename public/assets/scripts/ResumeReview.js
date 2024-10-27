// document.getElementById('quickUploadBtn').onclick = function() {
//     // Hide the first div
//     document.getElementById('firstDiv').style.display = 'none';
//     // Show the second div
//     document.getElementById('secondDiv').style.display = 'block';
// };

function showUploadView() {
    document.getElementById('initialView').style.display = 'none';
    document.getElementById('uploadView').style.display = 'block';

    document.getElementById('prev-btn').disabled = false;
    document.getElementById('next-btn').disabled = false;
}

function showInitialView() {
    document.getElementById('initialView').style.display = 'grid';
    document.getElementById('uploadView').style.display = 'none';

    document.getElementById('prev-btn').disabled = true;
    document.getElementById('next-btn').disabled = true;
}

document.getElementById('fileInput').addEventListener('change', function(event) {
    var file = event.target.files[0];
    if (file) {
        alert('File selected: ' + file.name);
        var fileUploadedElement = document.getElementById('fileUploaded');
        fileUploadedElement.style.display = 'block';
        fileUploadedElement.textContent = 'Selected file: ' + file.name;
        // Here you can add code to handle the file, like uploading it to a server
    }
});
function redirectToResumeBuilder() {
    window.location.href = 'ResumeBuilder.php'; // Replace with your actual page URL
}


