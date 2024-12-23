document.addEventListener('DOMContentLoaded', function() {
    const containers = document.querySelectorAll('.question-container');
    const prevButton = document.getElementById('prev-button');
    const nextButton = document.getElementById('next-button');
    const submitButton = document.getElementById('submit-button');
    const progressBar = document.getElementById('progress');
    let currentQuestion = 0;
    const totalQuestions = containers.length;

    function updateProgress() {
        const progress = ((currentQuestion + 1) / totalQuestions) * 100;
        progressBar.style.width = `${progress}%`;
    }

    function showQuestion(index) {
        containers.forEach(container => container.classList.remove('active'));
        containers[index].classList.add('active');

        prevButton.disabled = index === 0;
        nextButton.style.display = index === totalQuestions - 1 ? 'none' : 'block';
        submitButton.style.display = index === totalQuestions - 1 ? 'block' : 'none';

        updateProgress();
    }

    prevButton.addEventListener('click', () => {
        if (currentQuestion > 0) {
            currentQuestion--;
            showQuestion(currentQuestion);
        }
    });

    nextButton.addEventListener('click', () => {
        if (currentQuestion < totalQuestions - 1) {
            currentQuestion++;
            showQuestion(currentQuestion);
        }
    });

    updateProgress();
});