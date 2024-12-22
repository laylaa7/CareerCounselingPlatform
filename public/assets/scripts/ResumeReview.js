function openReviewModal(resumeId) {
    const modal = document.getElementById('reviewModal');
    document.getElementById('resume_id').value = resumeId;
    modal.style.display = 'block';
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    const modal = document.getElementById('reviewModal');
    if (event.target == modal) {
        modal.style.display = "none";
    }
}