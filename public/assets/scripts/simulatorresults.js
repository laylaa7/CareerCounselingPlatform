function toggleAnswers(button) {
    const card = button.closest('.session-card');
    const answersContainer = card.querySelector('.answers-container');
    const icon = button.querySelector('.icon');
    
    if (answersContainer.style.display === 'none' || !answersContainer.style.display) {
        answersContainer.style.display = 'block';
        icon.classList.remove('fa-chevron-down');
        icon.classList.add('fa-chevron-up');
        button.innerHTML = '<i class="fas fa-chevron-up icon"></i> Hide Answers';
    } else {
        answersContainer.style.display = 'none';
        icon.classList.remove('fa-chevron-up');
        icon.classList.add('fa-chevron-down');
        button.innerHTML = '<i class="fas fa-chevron-down icon"></i> View Answers';
    }
}

function toggleReview(button) {
    const card = button.closest('.session-card');
    const reviewForm = card.querySelector('.review-form');
    reviewForm.style.display = reviewForm.style.display === 'none' || !reviewForm.style.display ? 'block' : 'none';
}

function submitReview(simulatorId) {
    // Add your review submission logic here
    alert('Review submitted for session #' + simulatorId);
    // You can add an AJAX call here to save the review to the database
}