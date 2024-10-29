const questions = [
    {
        question: "Tell me about yourself.",
        overview: "This question provides employers with an early preview of your core skills, personality and ability to respond to an unstructured question."
    },
    {
        question: "What is your greatest strength?",
        overview: "Your answer should highlight qualities that make you an excellent candidate for the position."
    },
    {
        question: "What is your greatest weakness?",
        overview: "Focus on a real weakness, but one that you're working on improving."
    },
    {
        question: "Why should we hire you?",
        overview: "This is your chance to sell yourself and your skills to the hiring manager."
    },
    {
        question: "Why do you want to work here?",
        overview: "Show that you've done your research about the company and are enthusiastic about the role."
    }
];

let currentQuestionIndex = 0;
const questionText = document.getElementById('question-text');
const answerInput = document.getElementById('answer-input');
const nextButton = document.getElementById('next-button');
const progressFill = document.getElementById('progress-fill');
const currentQuestionSpan = document.getElementById('current-question');
const totalQuestionsSpan = document.getElementById('total-questions');

function updateQuestion() {
    const question = questions[currentQuestionIndex];
    questionText.textContent = question.question;
    
    // Add overview if it exists
    const existingOverview = document.querySelector('.overview');
    if (existingOverview) {
        existingOverview.remove();
    }
    
    const overview = document.createElement('div');
    overview.className = 'overview';
    overview.textContent = question.overview;
    document.querySelector('.question-container').appendChild(overview);

    // Update progress
    const progress = ((currentQuestionIndex + 1) / questions.length) * 100;
    progressFill.style.width = `${progress}%`;
    currentQuestionSpan.textContent = currentQuestionIndex + 1;
    totalQuestionsSpan.textContent = questions.length;

    // Clear previous answer
    answerInput.value = '';

    // Update button text for last question
    if (currentQuestionIndex === questions.length - 1) {
        nextButton.textContent = 'Finish';
    }
}

nextButton.addEventListener('click', () => {
    if (answerInput.value.trim() === '') {
        alert('Please provide an answer before continuing.');
        return;
    }

    if (currentQuestionIndex < questions.length - 1) {
        currentQuestionIndex++;
        updateQuestion();
    } else {
        alert('Interview completed! Thank you for your responses.');
        // Here you could add code to submit the answers or process them further
    }
});

// Initialize first question
updateQuestion();